<?php 
    session_start();
    if(empty($_SESSION['identifiant'])) {
        header("Location: authentificationUser.php");
    }
    if( isset($_SESSION['identifiant']) and $_SESSION['admin'] == "no") {
        $identifiant = $_SESSION['identifiant'];
    } else if($_SESSION['admin'] == "yes") {
        header("Location: admin.php");
    }  else {
        header("Location: authentificationUser.php");
    }
    
    include("include\\bddfonction.php");  
   

    $co = connection_bdd();
    $datarow = select_client($co, $login);
    
        


    $_SESSION['panier'] = array();
    array_push( $_SESSION['panier'], 14,18,20);

    

    //trouver l'id client (à déplacer)
    $queryid = "SELECT id FROM client WHERE identifiant LIKE '$identifiant'";
    $responseid = mysqli_query($co, $queryid);
    if($responseid) {
        $id_client = mysqli_fetch_array($responseid, MYSQLI_NUM);
        $id_client = $id_client[0];
    
    }

    ?>
   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
    <nav class="nav sticky">
        <label class="ShopOn">ShopOn</label>
        <ul class="main-nav">
                <li ><a  href="Accueil.php" >Home</a> </li>
                
                <li class="push"><a class="active" href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push"><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="container zone  ">

        <div>
        <?php 
           //AFFICHAGE DU PANIER
           echo  "<br><br><br>";
           $nbr_produits = 0;
           $prix_totale = 0;
           foreach($_SESSION['panier'] as $id_produit) {
               $nbr_produits ++;
               $query3 = "SELECT id, nom, prix, categorie FROM produit WHERE id = $id_produit";
               $response_produit_info = mysqli_query($co, $query3);
               $array_produit_info = $response_produit_info->fetch_array(MYSQLI_NUM);
               
               $id = $array_produit_info[0];
               $nom = $array_produit_info[1];
               $prix = $array_produit_info[2];
               
               $prix_totale += $prix;

               $categorieINT = $array_produit_info[3];
               $response = mysqli_query($co, "SELECT categorie.nom FROM categorie WHERE categorie.id = $categorieINT");
               $categorie = ($response->fetch_array(MYSQLI_NUM))[0];

                echo "Article#$id $nom $categorie $prix euro<br>";
                
            }


            echo "prix totale : $prix_totale";
            ?>
        </div>

        <div>
        <h1>paiement</h1>

        <form action="#" method='POST'>
        <input type="hidden" name="paiement" value="paiement">
        <input type="submit" value="acheter">
        </form>


        <?php
        //vérficiation de la carte de paiement
        $querycarte = "SELECT carte_num FROM client WHERE id=$id_client";
        $responsecarte = mysqli_query($co, $querycarte);
        $carte_num = mysqli_fetch_array($responsecarte)[0];


        if(isset($_POST['paiement']) or isset($_POST['add_carte']) ) {
            
           
            
            

            if(isset($_POST['add_carte'])) { //Si formulaire d'ajout de carte est validé

                $carte_num = $_POST['carte_num'];
                $carte_cvv = $_POST['carte_cvv'];
                $carte_date = $_POST['carte_date'];

                //vérification que la carte est valide
                if($carte_num !== "" or $carte_cvv !== "" or $carte_date !== "") {
                    if($carte_num == "" or $carte_cvv == "" or $carte_date == "") {
                        echo '<p style="color: red;">Tous les champs de la carte de paiment ne sont pas remplis, aucune modification n\'a été apportée sur la carte</p>';
                    } else {
                        $valide = 1;
                        if(!preg_match("#^[0-9]{16}$#",$carte_num)) {
                            $valide = 0;
                            echo '<p style="color: red;">Numéro de carte invalide<p>';
                        }
                        if(!preg_match("#^[0-9]{3}$# ", $carte_cvv)) {
                            $valide = 0;
                            echo '<p style="color: red;">Cryptogramme visuel invalide<p>';
                        }
                        if(!preg_match("#^[0-9]{2}/[0-9]{4}$#",$carte_date)) {
                            $valide = 0;
                            echo '<p style="color: red;">Mauvais format de date, veuillez respectez mm/aaaa<p>';
                        }
    
                        if($valide == 1) {
                            if(mysqli_query($co, "UPDATE client SET carte_num = \"$carte_num\", carte_cvv = \"$carte_cvv\", carte_date = \"$carte_cvv\" WHERE client.identifiant = \"$identifiant\";")) {
                                echo '<p style="color: green;">Votre carte de paiment à été mise à jour<p>';
                            }
                            else {
                                echo '<p style="color: red;">Erreur, votre votre carte de paiement n\'a pas été mise à jour<p>';
                            }
                        }
    
                    }
                } 

            } 
            if(!preg_match("#^[0-9]{16}$#",$carte_num)) { //Si pas de carte pré-enregistrée
                
                //Affiche formulaire d'ajout de carte de paiement
                echo "
                <form action='#' class='forminscription' method='post'>
                <label id='txt'>Numéro carte bancaire :</label>
                <input class='input' type='text' name='carte_num'><br><br>
                <label id='txt'> Cvv : </label>
                <input class='input' type='text' name='carte_cvv'><br><br>
                <label id='txt'>Date d'expiration carte (mm/aaaa) : </label>
                <input class='input' type='text' name='carte_date' ><br><br>
                <p><input type='hidden' name='add_carte' value='add_carte'></p>
                <input id='bouton' type='submit'  value='Ajouter carte'><br>
                </form>
                ";
            } 

            if(preg_match("#^[0-9]{16}$#",$carte_num))  { //Si une carte de paiement est enregistrée
                    
                //CREATION DE LA COMMANDE

                //creer table commande id client et $nbr produit
                $querycommande = "INSERT INTO commande (id, id_client, quantite) VALUES (NULL,$id_client ,$nbr_produits)";
                $response1 = mysqli_query($co, $querycommande);
                if($response1) {

                } else {
                    echo "Creation de la commande non réusssi";
                }

                //choper id commande
                $id_commande = mysqli_insert_id($co);

                //creer produit_commande avec id_produit et id_commande
                foreach($_SESSION['panier'] as $id_produit) {
                    $queryproduit_commande = "INSERT INTO produit_commande (id, id_produit, id_commande) VALUES (NULL, $id_produit, $id_commande)";
                    mysqli_query($co, $queryproduit_commande);
                }

                echo "Achat effectué";
                unset($_SESSION['panier']);
                header("Location: achat.php");
            }
        }

        ?> 
        </div>
        





    </div>
        

    </div>
    <footer class="footer">
        <div class="main-footer">
        <div class="row">
        <div class="footer-col">
            <h4>Company</h4>
            <ul>
                <li><a href="#">A propos de nous</a></li>
                <li><a href="#">Nos services</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Get Help</h4>
            <ul>
                <li><a href="#">Options paiment</a></li>
                <li><a href="#"> Retours Articles</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Online shop</h4>
            <ul>
                <li><a href="#">Categories articles</a></li>
                <li><a href="#"> tous les articles</a></li>
            </ul>
        </div>
        

        <div class="footer-col">
            <h4>follow us</h4>
            <div class="social-links">
            
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                
                
            </div>
        </div>   
        </div>
    </div>
        
    </footer>

    
</body>
</html>