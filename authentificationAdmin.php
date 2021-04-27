<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
</head>
<body>

    <div style="border:ridge 5px black; margin: 0 auto; width:max-content; padding: 1em; padding-top: 0;">
        <p style="font-size: xx-large; text-align: center; margin-top:10px;">Admin Authentification</p>

        <div>
            <form method="post">
                <p style="text-align:end;">Identifiant: <input type="text" name="identifiant"/></p>
                <p style="text-align:end;">Mot de passe: <input type="text" name="mdp"></p>
                <p style="margin-left: 1em;"><input type="submit" value="Confirmer"></p>
                <p style="color: red; text-align: center"><?php if (isset($_POST["identifiant"])) { echo "identifiants incorrects";} ?></p>
            </form>
        </div>
    </div>

    <?php

    if (isset($_POST["identifiant"])) {

        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp"];
        
        
        //se connecter à la base de donnée
        $co = mysqli_connect("localhost", "root");
        mysqli_select_db($co,"projet-web");

        //formuler la requête
        $query = "SELECT identifiant, pass FROM admin WHERE identifiant LIKE \"$login\"  ";

        //faire la requête
        $response = mysqli_query($co, $query);

        while($datarow = $response->fetch_array()) {

            if($datarow[0] == $login) {

                if($datarow[1] == $mdp) {  
                    //Redirection  vers la page administrateur (en indiquant que l'on est bien un admin)
                    $_SESSION['identifiant'] = $login;
                    $_SESSION['admin'] = "yes";
                    header("Location: admin.php");
                
                }
            }
        }
    }
    ?>    
    
</body>
</html>