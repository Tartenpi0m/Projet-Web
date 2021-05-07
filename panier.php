<?php 
    session_start();
    
    include("include\\bddfonction.php");   
    if (isset($_POST["identifiant"])) {

        $login = $_POST["identifiant"];
        $mdp = $_POST["mdp"];


        $co = connection_bdd();
        $datarow = select_client($co, $login);
        $vrai_pass = pass($datarow);
        
        if($vrai_pass == $mdp) {  
            //Redirection  vers la page du panier
            $_SESSION['identifiant'] = $login;
            $_SESSION['admin'] = "no";
            header("Location: panier.php");        
        } 
    }
    ?>
   
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
                <li ><a  href="Accueil.php" >Home</a> </li>
                
                <li class="push"><a class="active" href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class="push"><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="container zone  ">
        <?php
        //connexion au serveur
    $co=mysqli_connect('localhost','root');
    //connexion à la base de donnée projet-web
    mysqli_select_db($co,"projet-web");
    $sql = "SELECT id,quantite,id_client,id_produit,id_commande,identifiant,nom FROM commande,client,produit_commande,produit 
    WHERE id_client.commande = id.client 
    AND id.commande = id_commande.produit_commande
    AND id_produit.produit_commande = id.produit
    ANd id.produit_commande = id.client";
    $result = mysqli_query($co,$sql );

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo 'numéro de commande' .$row["id_commande"]."<br>";
        echo 'Nom client' .$row["identifiant"]."<br>";
        echo 'Nom du produit' .$row["nom"]. "Quantité".$row["quantite"]."<br>";
        //echo '<div class="box zone">';
        //echo '<img src="'.$row["image_addr"].'"/>';
        //echo '</div>';
       
        
    } 
}       
 else {
    echo "0 results";
} 

        ?>
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