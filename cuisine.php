<?php 
    session_start(); ?>
   
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
                <li><a href="maison.php" >Maison</a> </li>
                <li><a class="active"  href="cuisine.php" >Cuisine</a> </li>
                <li><a href="beaute.php" >Beauté</a> </li>
                <li class="push"><a href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class=><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

    </nav>
    <div class="cover">
        <div class="categories">
        <?php 
    
    //connexion au serveur
    $co=mysqli_connect('localhost','root');
    //connexion à la base de donnée projet-web
    mysqli_select_db($co,"projet-web");
    $sql = "SELECT * FROM produit WHERE categorie='6'";
    $result = mysqli_query($co,$sql );

if (mysqli_num_rows($result) > 0) {
    $i = 0; 
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div onclick="describe('.$i.')" class="box zone">';
        echo '<img src="'.$row["image_addr"].'"/>';
        echo '<input id="btnprod" type="submit" value="ajouter au panier"/>';
        echo '<p id="prod_'.$i.'" class="desribe-prod" hidden  >';
        echo $row["description"];
        echo '</p>';
        
        echo '<input hidden value="'.$row["id"].'"/>';
        echo '<input class="nom_prod" hidden value="'.$row["nom"].'"/>';
        
        echo '</div>';
        $i = $i+1;
    } 
        
} else {
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
<script>
      function describe(i) {
      var desc = document.querySelector('#prod_'+i);
      desc.hidden = !desc.hidden;
  }
    </script>
</html>