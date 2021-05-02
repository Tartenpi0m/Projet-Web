<?php session_start(); ?>

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
                <li ><a class="active" href="Accueil.php" >Home</a> </li>
                
                <li class="push"><a href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push"><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="container zone  ">
        <div class="regform"><h1>Formulaire d'inscription </h1><br><br>
            <div class="formulaire">
     
            <form class="forminscription" method="post">
                <label id="txt">Identifiant:</label>
                <input class="input" type="text" name="identifiant"><br><br>
                <label id="txt"> Créer mot de passe : </label>
                <input class="input" type="text" name="mdp1"><br><br>
                <label id="txt">Confirmer mot de passe : </label>
                <input class="input" type="text" name="mdp2" ><br><br>
                <input id="bouton" type="submit" name="confirmer" value="Confirmer"><br>
                <?php
                $connect = 0;
                if (empty($_POST["identifiant"]) or empty($_POST["mdp1"]) or empty($_POST["mdp2"])) { 
                    echo "Veuillez remplir tous les champs *";
                } else if ($_POST["mdp1"] !== $_POST["mdp2"]) {
                    echo "Les mots de passe ne correspondents pas";
                } else {
                    $connect = 1;
                }
                ?></p>
           
        <?php

    if ($connect == 1) {

        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp1"];
        
        
        //se connecter à la base de donnée
        $co = mysqli_connect("localhost", "root");
        mysqli_select_db($co,"projet-web");

        //formuler la requête
        $query = "INSERT INTO client (id, identifiant, pass) VALUES (NULL, \"$login\", \"$mdp\")";

        //faire la requête
        $response = mysqli_query($co, $query);

        if($response) {

            $_SESSION['identifiant'] = $login;
            $_SESSION['admin'] = "no";
            header("Location: Accueil.html");
        } else {
            echo "erreur: il se peut qu'un utilisateur avec le même identifiant existe déjà";
        }

    }
        ?>   </form>
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