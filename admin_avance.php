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
                
                <li class="push"><a  href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push"><a class="active" href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="main-adminAv ">
    <?php 
 //se connecter à la base de donnée
 $co = mysqli_connect("localhost", "root");
 mysqli_select_db($co,"projet-web");

?>

<h2>Espace Administrateur Avancée</h2>
            <div class="formulaire">
     
             <form class="forminscriptionAdmin" action="#" method="post">
                <input id="reqAdmin" type="text" name="query" placeholder="Vous pouvez faire des requêtes SQL à la base de données du site directement depuis ce champs de texte"><br><br>
                <input type="hidden" name="ok" value="ok">
                <input id="bouton" type="submit" value="Envoyer">

    </form>
   
    <?php 

    if( isset($_POST["ok"])) {


        $query = $_POST["query"];
        $response = mysqli_query($co, $query)  or die("Impossible d'exécuter la requête.<br />\nMySQL a retourné : \"". mysqli_error($co) ."\"");
    
        if($response) {
    
            echo "<TABLE BORDER='1'><CAPTION>Résultat de la requête</CAPTION>";
    
            while($datarow = mysqli_fetch_array($response, MYSQLI_ASSOC)) {
                echo "<TR>";
    
                foreach($datarow as $value) {
    
                    echo "<TH>$value</TH>";
                }
    
                echo "</TR>";
            }
    
    
            echo "</TABLE>";
        }
        


    }
    ?>
    

</div>

    <a href="admin.php"><p style="text-align:center;">Retour au paramètres standard administrateur ?</p></a>
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
