<?php

use function PHPSTORM_META\type;

session_start(); 

     //connexion au serveur
     $co=mysqli_connect('localhost','root');
     //connexion à la base de donnée projet-web
     mysqli_select_db($co,"projet-web");

    //$_SESSION['categorie'] = "Maison";
    $categorie =  $_POST['cat_button'];

    if(!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }
    if(isset($_POST['id_produit'])) {
        array_push( $_SESSION['panier'], $_POST['id_produit']);
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

                <?php
                
                    $sql = "SELECT id, nom FROM categorie";
                    $response = mysqli_query($co,$sql );

                    if($response) {

                        while($datarow = mysqli_fetch_array($response, MYSQLI_NUM)) {
                            
                            if($datarow[1] == $categorie) {
                                echo "
                            <form action='categorie.php' id='$datarow[1]' method='POST' style='display:inline'>
                            <input type='hidden' name='cat_button' value='$datarow[1]'>
                            <li><a class='active' onclick='gocat(\"$datarow[1]\")'>$datarow[1]</a><li>               
                            </input></form>";
                                $id_cat = $datarow[0];
                                $cat_button= $datarow[1];
                            } else {
                                echo "
                            <form action='categorie.php' id='$datarow[1]' method='POST' style='display:inline'>
                            <input type='hidden' name='cat_button' value='$datarow[1]'>
                            <li><a onclick='gocat(\"$datarow[1]\")'>$datarow[1]</a><li>               
                            </input></form>";
                            }
                        
                            
                        }
                    }
                ?>
                <li class="push"><a href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class=><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>
                
        </ul>

        
        <script type="text/javascript">
                    function gocat(cat) {
                        document.getElementById(cat).submit();
                    }
        </script>

    </nav>
    <div class="cover">
        <div class="categories">
        <?php 
   
    
  
    $sql = "SELECT * FROM produit WHERE categorie=$id_cat";
    $result = mysqli_query($co,$sql );


if (mysqli_num_rows($result) > 0) {
    $i = 0; 
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div  class="box zone">';
        echo '<img onclick="describe('.$i.')" src="'.$row["image_addr"].'"/>';
        echo '<form action="#" id="'.$row["id"].'" method="POST" style="display:inline">';
        echo '<input id="btnprod_cat" onclick="add_panier('.$row["id"].')" type="submit" value="ajouter au panier"/>';
        echo '<input hidden name="id_produit" value="'.$row["id"].'"/>';
        echo '<input hidden name="cat_button" value="'.$cat_button.'">';
        echo "</form>";
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

    <script type="text/javascript">
        function add_produit(id_produit) {
            document.getElementById(id_produit).submit();
        }
    </script>


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