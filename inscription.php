<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
</head>
<body>

    <div style="border:ridge 5px black; margin: 0 auto; width:max-content; padding: 1em; padding-top: 0;">
        <p style="font-size: xx-large; text-align: center; margin-top:10px;">User Inscription</p>

        <div>
            <form method="post">
                <p style="text-align:end;">Identifiant: <input type="text" name="identifiant"/></p>
                <p style="text-align:end;">Mot de passe: <input type="text" name="mdp1"></p>
                <p style="text-align:end;">Mot de passe: <input type="text" name="mdp2"></p>
                <p style="margin-left: 1em;"><input type="submit" value="Confirmer"></p>
                <p style="color: red; text-align: center"><?php 

                $connect = 0;
                if (empty($_POST["identifiant"]) or empty($_POST["mdp1"]) or empty($_POST["mdp2"])) { 
                    echo "Veuillez remplir tous les champs";
                } else if ($_POST["mdp1"] !== $_POST["mdp2"]) {
                    echo "Les mots de passe ne correspondents pas";
                } else {
                    $connect = 1;
                }
                ?></p>
            </form>
        </div>
    </div>

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
    ?>    
    
</body>
</html>