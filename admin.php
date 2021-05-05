<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <nav class="nav sticky">
        <label class="ShopOn">ShopOn</label>
        <ul class="main-nav">
                <li ><a  href="Accueil.php" >Home</a> </li>
                
                <li class="push"><a class="active" href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push"><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="main-client ">
    <?php 
 //se connecter à la base de donnée
 $co = mysqli_connect("localhost", "root");
 mysqli_select_db($co,"projet-web");

?>
<p>Espace Administrateur</p>

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
            echo "L'operation n'a pas fonctionnée";
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
                    echo "L'opération n'a pas fonctionnée, la catégorie existe surement déjà";
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
                    echo "L'opération n'a pas fonctionnée (peut-être que cette catégorie contient certains produits)";
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
                        $categorieINT = $cat_response->fetch_array();
                        $categorieINT = intval($categorieINT[0]);

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
