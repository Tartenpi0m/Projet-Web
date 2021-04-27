<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
</head>
<body>
<?php 
session_start();
if($_SESSION['admin'] !== "yes") {
    header("Location: authentificationAdmin.php");
}

//Déconnecte l'admin

   /* foreach ($_SESSION as $key=>$value)
    {
        if (isset($GLOBALS[$key]))
            unset($GLOBALS[$key]);
    }
    session_destroy();*/
?> 


<?php 
 //se connecter à la base de donnée
 $co = mysqli_connect("localhost", "root");
 mysqli_select_db($co,"projet-web");

?>

<div>
    <p>Client</p>
    
    <div>
        <p>Ajouter</p>
        <form method="POST">
        <p>Identifiant: <input type="text" name="identifiant"/></p>
        <p>Mot de passe: <input type="text" name="mdp"></p>
        <p><input type="submit" value="Ajouter"></p>
        <p><input type="hidden" name="ajouter_client" value="ajouter_client"></p>
        </form>
    <p>
    <?php 
    if( isset($_POST['ajouter_client'])) {

        //mettre dans des variables
        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp"];

        //formuler la requête
        $query = "INSERT INTO client (id, identifiant, pass) VALUES (NULL, \"$login\", \"$mdp\")";

        //faire la requête
        $response = mysqli_query($co, $query);
        
        if($response) {
            echo "client ajouter !";
            $_POST['ajouter_client'] = NULL;
        } else {
            echo "L'opération n'a pas fonctionnée";
        }
    }
    ?>
    </p>


        <p>Supprimer</p>
        <form method="POST">

        </form>
        <p>Modifier</p>
        <form method="POST">

        </form>
    </div>
    
</div>

<div>
    <p>Catégories</p>
    
    <div>
        <p>Ajouter</p>
        <form method="POST">

        </form>
        <p>Supprimer</p>
        <form method="POST">

        </form>
        <p>Modifier</p>
        <form method="POST">

        </form>
    </div>
    
</div>

<div>
    <p>Utilisateurs</p>
    
    <div>
        <p>Ajouter</p>
        <form method="POST">

        </form>
        <p>Supprimer</p>
        <form method="POST">

        </form>
        <p>Modifier</p>
        <form method="POST">

        </form>
    </div>
    
</div>


</body>
</html>