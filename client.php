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
    $datarow = select_client($co, $identifiant);
    $id_client = id($datarow);
    $identifiant = identifiant($datarow);
    $pass = pass($datarow);

    $carte_num = carte_num($datarow);

    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Client</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    

</head>
<body>

    <nav class="nav sticky">
        <label class="ShopOn">ShopOn</label>
        <ul class="main-nav">
                <li ><a   href="Accueil.php" >Home</a> </li>
                
                <li class="push "><a href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push "><a class="active" href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="main-client ">
    <div class="user_account">
    <h2>Bienvenue à votre compte !</h2><br>
            <h3>Informations personnelles de votre compte </h3><br>
            
             <p>Identifiant : <?php echo $identifiant?></p><br>
             <p>Carte bleue : 
    
     <?php 
         if($carte_num == 0) {
              echo "aucune carte";
        }   else {
              echo $carte_num;
             }
    ?> </p><br>
    <p><form methode="POST"><input id="bouton" type="submit" value="Actualiser"></form></p>
    </div>


<div class="update_user">
    <h3>Modifiez vos Informations personnelles dans le formulaire ci-dessous</h3> 
    <div class="regform"><h1>Modifier Informations Personnelles </h1><br><br>
            <div class="formulaire">
     
             <form class="forminscription" method="post">
                <label id="txt">Identifiant:</label>
                <input class="input" type="text" name="identifiant"><br><br>
                <label id="txt"> Mot de passe : </label>
                <input class="input" type="password" name="pass1"><br><br>
                <label id="txt">Confirmer mot de passe : </label>
                <input class="input" type="password" name="pass2" ><br><br>
                <label id="txt">Numéro carte bancaire :</label>
                <input class="input" type="text" name="carte_num"><br><br>
                <label id="txt"> Cvv : </label>
                <input class="input" type="text" name="carte_cvv"><br><br>
                <label id="txt">Date d'expiration carte (mm/aaaa) : </label>
                <input class="input" type="text" name="carte_date" ><br><br>
                <p><input type="hidden" name="modif_info" value="modif_info"></p>
                <input id="bouton" type="submit"  value="Mettre à jour"><br>
                  
           
           
    <?php 
        if(isset($_POST["modif_info"])) {

            $ID = $_POST['identifiant'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            $carte_num = $_POST['carte_num'];
            $carte_cvv = $_POST['carte_cvv'];
            $carte_date = $_POST['carte_date'];


            //IDENTIFIANT
            if($ID !== "") {
                if(mysqli_query($co, "UPDATE client SET identifiant = \"$ID\"  WHERE client.identifiant = \"$identifiant\"")) {
                    echo '<p style="color: green;">Votre identifiant à été mis à jour<p>';
                    $_SESSION['identifiant'] = $ID;
                } else {
                    echo '<p style="color: red;">L\'identifiant choisis est déjà utilisé, votre identifiant n\'a pas été mis à jour<p>';
                }
            } 

            //PASSWORD
            if($pass1 !== "") {
                if($pass1 !== $pass2) {
                    echo '<p style="color: red;">Les deux mots de passe ne sont pas identiques</p>';
                } else {
                    if(mysqli_query($co, "UPDATE client SET pass = \"$pass1\"  WHERE client.identifiant = \"$identifiant\"")) {
                        echo '<p style="color: green;">Votre mot de passe à été mis à jour<p>';
                    } else {
                        echo '<p style="color: red;">Erreur, votre mot de passe n\'a pas été mis à jour<p>';
                    }
                }
            }

            //CARTE
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
    ?>

</form>
                </div>

            </div>
</div>   

<div class="updiv">
        <p>COMMANDES</p>
        <div class="downdiv">


            <?php
                $query = "SELECT commande.id FROM commande,client WHERE client.id = commande.id_client AND client.id = $id_client";
                $response_id_commande = mysqli_query($co, $query);

                while ($id_commande = $response_id_commande->fetch_array()) {

                    $id_commande = $id_commande[0];
                    $query2 = "SELECT produit_commande.id_produit FROM produit_commande WHERE produit_commande.id_commande = $id_commande";
                    $response_id_produit = mysqli_query($co, $query2);
                    
                    echo '<div class="commandediv">';
                    echo "Commande n#$id_commande<br>";

                    while($id_produit = $response_id_produit->fetch_array(MYSQLI_NUM)) {

                        echo '<div class="articlediv">';

                        $id_produit = $id_produit[0];
                        $query3 = "SELECT id, nom, prix, categorie FROM produit WHERE id = $id_produit";
                        $response_produit_info = mysqli_query($co, $query3);
                        $array_produit_info = $response_produit_info->fetch_array(MYSQLI_NUM);

                        $id = $array_produit_info[0];
                        $nom = $array_produit_info[1];
                        $prix = $array_produit_info[2];

                        $categorieINT = $array_produit_info[3];
                        $response = mysqli_query($co, "SELECT categorie.nom FROM categorie WHERE categorie.id = $categorieINT");
                        $categorie = ($response->fetch_array(MYSQLI_NUM))[0];

                        echo "Article#$id $nom $categorie $prix euro";

                        echo "</div>";

                    }
                    echo "</div>";

                }
            ?>


         </div>
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

<script>
        ladate=new Date()
        document.write(ladate.getDate()+"/"+(ladate.getMonth()+1)+"/"+ladate.getFullYear()+"<br />"+ladate.getHours()+":"+ladate.getMinutes()+":"+ladate.getSeconds())
    </script>
</html>




