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
                <p style="text-align:end;">Mot de passe: <input type="password" name="mdp"></p>
                <p style="margin-left: 1em;"><input type="submit" value="Confirmer"></p>
                <p style="color: red; text-align: center">
                <?php if (isset($_POST["identifiant"]))
                 { echo "identifiants incorrects";} ?></p>
            </form>
        </div>
    </div>

    <?php

    include("include\\bddfonction.php");

    if (isset($_POST["identifiant"])) {

        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp"];

        $co = connection_bdd();
        $datarow = select_admin($co, $login);
        $vrai_pass = pass($datarow);
        
        if($vrai_pass == $mdp) {  
            //Redirection  vers la page administrateur (en indiquant que l'on est bien un admin)
            $_SESSION['identifiant'] = $login;
            $_SESSION['admin'] = "yes";
            header("Location: admin.php");        
        } 
 
    }
    ?>    
    
</body>
</html>