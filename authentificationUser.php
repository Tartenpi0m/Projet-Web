<?php 
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body>
<div class="main_modal">
<a href="#demo">Ouvrir la modale</a>
   <div id="demo" class="modal">
        <div class="modal_content">
        <h1>User Authentification</h1><br><br>
        <a href="#" class="modal_close">&times;</a>

        <div>
     
            <form method="post">
                <label id="txt1">Identifiant:</label>
                <input id="input1" type="text" name="identifiant"><br><br>
                <label id="txt2">Mot de passe : </label>
                <input id="input1" type="password" name="mdp" ><br><br>
                <input id="bouton1" type="submit" name="confirmer" value="Confirmer"><br>
                <p style="color: red; text-align: center"><?php if (isset($_POST["identifiant"])) { echo "identifiants incorrects";} ?></p>
            </form>
            

        </div>
    

    <?php

    include("include\\bddfonction.php");

    if (isset($_POST["identifiant"])) {

        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp"];


        $co = connection_bdd();
        $datarow = select_client($co, $login);
        $vrai_pass = pass($datarow);
        
        if($vrai_pass == $mdp) {  
            //Redirection  vers la page d'accueil
            $_SESSION['identifiant'] = $login;
            $_SESSION['admin'] = "no";
            header("Location: Client.php");        
        } 
    }
    ?>   
        
     </div>
   </div>
</div>
</body>
</html>