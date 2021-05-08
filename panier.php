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
           
           echo  "<br><br><br>";
           $nbr_produits = 0;
           foreach($_SESSION['panier'] as $id_produit) {
               $nbr_produits ++;
               $query3 = "SELECT id, nom, prix, categorie FROM produit WHERE id = $id_produit";
               $response_produit_info = mysqli_query($co, $query3);
               $array_produit_info = $response_produit_info->fetch_array(MYSQLI_NUM);
               
               $id = $array_produit_info[0];
               $nom = $array_produit_info[1];
               $prix = $array_produit_info[2];
               
               $categorieINT = $array_produit_info[3];
               $response = mysqli_query($co, "SELECT categorie.nom FROM categorie WHERE categorie.id = $categorieINT");
               $categorie = ($response->fetch_array(MYSQLI_NUM))[0];

                echo "Article#$id $nom $categorie $prix euro<br>";
                
            }
            ?>
        </div>

        <div style='color: red;'>
        <h1>paiement</h1>

        <form action="#" method='POST'>
        <input type="hidden" name="paiement" value="paiement">
        <input type="submit" value="acheter">
        </form>


        <?php
        if(isset($_POST['paiement'])) {
            
            $querycarte = "SELECT carte_num FROM client WHERE id=$id_client";
            $carte_num = mysqli_fetch_array($responsecarte)[0];
            //->Check cards
            if(!preg_match("#^[0-9]{16}$#",$carte_num)) { //si pas de carte
                echo "
                <form class='forminscription' method='post'>
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


                if(mysqli_query($co, "UPDATE client SET carte_num = \"$carte_num\", carte_cvv = \"$carte_cvv\", carte_date = \"$carte_cvv\" WHERE client.identifiant = \"$identifiant\";")) {
                    echo '<p style="color: green;">Votre carte de paiment à été mise à jour<p>';
                }
               //invalide
            } 


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