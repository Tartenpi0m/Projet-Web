<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
    <link rel="stylesheet" href="admin.css">
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

<div class="updiv">
    <p class="cat">Client</p>
    
    <div class="downdiv">
        <p class="fct">Ajouter</p>
        <form method="POST">
        <p class="champs">Identifiant: <input type="text" name="identifiant"/></p>
        <p class="champs">Mot de passe: <input type="password" name="mdp"></p>
        <p class="champs"><input type="submit" value="Ajouter"></p>
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
            echo "Client ajouter !";
        } else {
            echo "L'opération n'a pas fonctionnée (le client existe surement déjà)";
        }
        unset($_POST['ajouter_client']);
    }
    ?>
    </p>
    </div>

    <div class="downdiv">
        <p class="fct">Supprimer</p>
        <form method="POST">
        <p class="champs">Identifiant: <input type="text" name="identifiant"/></p>
        <p class="champs"><input type="submit" value="Supprimer"></p>
        <p><input type="hidden" name="supprimer_client" value="supprimer_client"></p>
        </form>
        <p>
    <?php 
    if( isset($_POST['supprimer_client'])) {

        //mettre dans des variables
        $login = $_POST["identifiant"];

        //formuler la requête
        $query = "DELETE FROM client WHERE client.identifiant LIKE \"$login\"";

        //faire la requête
        $response = mysqli_query($co, $query);
        
        if($response) {
            echo "Si le client existait, son compte à été supprimé !";
        } else {
            echo "L'opération n'a pas fonctionnée";
        }
        unset($_POST['supprimer_client']);
    }
    ?>
    </p>
    </div> 
</div>

<div class="updiv">
    <p class="cat">Catégories</p>
    
    <div class="downdiv">
        <p class="fct">Ajouter</p>
        <form method="POST">
            <p class="champs">Nom : <input type="text" name="nom"></p>
            <p class="champs"><input type="submit" value="Ajouter"></p>
            <p><input type="hidden" name="ajouter_categorie" value="ajouter_categorie"></p>
        </form>
    <p>
        <?php
            if( isset($_POST['ajouter_categorie'])) {

                $name = $_POST['nom'];

                $query = "INSERT INTO categorie (id, nom) VALUES (NULL, \"$name\")";

                $response = mysqli_query($co, $query);

                if($response) {
                    echo "Catégorie ajouter !";
                } else {
                    echo "L'opération n'a pas fonctionnée";
                }
                unset($_POST['ajouter_categorie']);


            }
        ?>
    </p>
    </div>
    
    <div class=downdiv> 
        <p class="fct">Supprimer</p>
        <form method="POST">
            <p class="champs">Nom : <input type="text" name="name"></p>
            <p class="champs"><input type="submit" value="Supprimer"></p>
            <p><input type="hidden" name="supprimer_categorie" value="supprimer_categorie"></p>
        </form>
    <p>
        <?php
            if( isset($_POST['supprimer_categorie'])) {

                $name = $_POST['name'];

                $query = "DELETE FROM categorie WHERE nom LIKE \"$name\"";

                $response = mysqli_query($co, $query);

                if($response) {
                    echo "Si la catégorie existait, elle a été supprimée !";
                } else {
                    echo "L'opération n'a pas fonctionnée";
                }
                unset($_POST['supprimer_categorie']);


            }
        ?>
    </div>
</div>

<div class="updiv">
    <p class="cat">Produits</p>
    
    <div class="downdiv">
        <p class="fct">Ajouter</p>
        <form method="POST">
            <p class="champs">Nom:<input type="text" name="nom"></p>
            <p class="champs">Description:<input type="text" name="description"></p>
            <p class="champs">Image(nom):<input type="text" name="img_addr"></p>
            <p class="champs">Prix:<input type="number" name="prix"></p>
            <p class="champs">Catégorie:<input type="text" name="categorie"></p>
            <p class="champs"><input type="submit" value="Ajouter"></p>
            <p><input type="hidden" name="ajouter_produit" value="ajouter_produit"></p>
        </form>
        <p>
            <?php 
                 if( isset($_POST['ajouter_produit'])) {

                    $nom = $_POST['nom'];
                    $description = $_POST['description'];
                    $img_addr = $_POST['img_addr'];
                    $prix = $_POST['prix'];
                    $categorieCHAR = $_POST['categorie'];

                    //requête pour avoir l'id de la catégorie specifiée
                    $cat_id_query = "SELECT id FROM categorie WHERE nom LIKE \"$categorieCHAR\"";
                    $cat_response = mysqli_query($co, $cat_id_query);
                    if($cat_response) {

                        //requête d'insertion du produit
                        $categorieINT = mysqli_fetch_array($cat_response);
                        $categorieINT = intval($categorieINT);

                        $query2 = "INSERT INTO produit (id, nom, description, image_addr, prix, categorie) VALUES (NULL, \"$nom\", \"$description\", \"$img_addr\", \"$prix\", \"$categorieINT\")";
        
                        $response = mysqli_query($co, $query2);
        
                        if($response) {
                            echo "Produit ajouté!";
                        } else {
                            echo "L'opération n'a pas fonctionnée (il se peut que la catégorie spécifiée n'existe pas)";
                        }
                        
                    } else {
                        echo "L'opération n'a pas fonctionnée";
                    }

                    unset($_POST['ajouter_produit']);
    
                }
            ?>
        </p>
    </div>

    <div class="downdiv">
        <p class="fct">Supprimer</p>
        <form method="POST">
            <p class="champs">Nom : <input type="text" name="name"></p>
            <p class="champs"><input type="submit" value="Supprimer"></p>
            <p><input type="hidden" name="supprimer_produit" value="supprimer_produit"></p>
        </form>
    <p>
        <?php
            if( isset($_POST['supprimer_produit'])) {

                $name = $_POST['name'];

                $query = "DELETE FROM produit WHERE nom LIKE \"$name\"";

                $response = mysqli_query($co, $query);

                if($response) {
                    echo "Si le produit existait, il a été supprimé !";
                } else {
                    echo "L'opération n'a pas fonctionnée";
                }
                unset($_POST['supprimer_produit']);


            }
        ?>

    </div>   
</div>
<div>
<a href="admin avancée"><p>Paramètres avancées administrateur</p></a>

</div>

</body>
</html>