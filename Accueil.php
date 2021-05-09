<?php session_start(); 

    //connexion au serveur
    $co=mysqli_connect('localhost','root');
    //connexion à la base de donnée projet-web
    mysqli_select_db($co,"projet-web");

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
    <title>AchatGo</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    
    <nav class="nav sticky">
        <label class="ShopOn">ShopOn</label>
        <ul class="main-nav">
                <li ><a class="active" href="Accueil.php" >Home</a> </li>

                <?php
                
                    $sql = "SELECT id, nom FROM categorie";
                    $response = mysqli_query($co,$sql );

                    if($response) {

                        while($datarow = mysqli_fetch_array($response, MYSQLI_NUM)) {
                            
                            echo "
                            <form action='categorie.php' id='$datarow[1]' method='POST' style='display:inline'>
                            <input type='hidden' name='cat_button' value='$datarow[1]'>
                            <li><a onclick='gocat(\"$datarow[1]\")'>$datarow[1]</a><li>               
                            </input></form>";
                        }
                    }

                ?>

                <script type="text/javascript">
                    function gocat(cat) {
                        document.getElementById(cat).submit();
                    }
                </script>

                <li class="push"><a href="panier.php" ><i class="fas fa-shopping-cart"></i></a> </li>
                <li class=><a href="client.php" ><i class="fas fa-user-circle"></i></a> </li>    
        </ul>

    </nav>

    <div class="container zone  ">
        
        
        <div class="search-box">
            <div class="txt"><h2 id="h2">Bienvenue chez ShopOn</h2>
                <p id="p">Vous trouverez tous les articles à mini prix !</p></div>
            
            <input id="search" class="search-txt" type="text" name="search" placeholder="Tapez articles" > 
            <input id="btn_search" class="btn-search" type="button"  onclick="search()" value="Search"><br>
            <div class="connexion_utilisateur">
               <p > Connectez vous à votre compte <a href="authentificationUser.php" >Se connecter </a></p> <br>
                <p >Créer un compte ? <a href="s'inscrire.php" >S'inscrire </a></p>
                <p > Compte admin ? <a href="authentificationAdmin.php" >Admin </a></p>
            </div>
         
        </div>
    
    </div>
    <div id="wrapper" class="zone grid-wrapper">

    <?php 

    $sql = "SELECT * FROM produit ";
    $result = mysqli_query($co,$sql );
   
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $i = 0; 
    while($row = mysqli_fetch_assoc($result)) {
        echo '<div onclick="describe('.$i.')" class="box zone">';
        echo '<img src="'.$row["image_addr"].'"/>';
<<<<<<< HEAD
        echo '<input id="btnprod" type="submit" value="ajouter au panier"/>';
        echo '<p id="prod_'.$i.'" class="desribe-prod" hidden  >';
        echo $row["description"];
        echo '</p>';
        
        echo '<input hidden value="'.$row["id"].'"/>';
=======
        echo '<input id="desc"  value="'.$row["description"].'"/>';

        echo '<form action="#" id="'.$row["id"].'" method="POST" style="display:inline">';
        echo '<input id="btnprod" onclick="add_panier('.$row["id"].')" type="submit" value="ajouter au panier"/>';
        echo '</div>';
        echo '<input type="hidden" name="id_produit" value="'.$row["id"].'"/>';
>>>>>>> 8e6b1411de978b444ca11e3a542b4356777f1de3
        echo '<input class="nom_prod" hidden value="'.$row["nom"].'"/>';
        echo "</form>";
        echo '</div>';
<<<<<<< HEAD
        $i = $i+1;
=======
        
        
>>>>>>> 8e6b1411de978b444ca11e3a542b4356777f1de3
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
            
                <a href="#"><i class="fab fa-facebook-f">f </i></a>
                <a href="#"><i class="fab fa-instagram"> </i></a>
                <a href="#"><i class="fab fa-twitter"> </i></a>
                
                
            </div>
        </div>   
        </div>
    </div>
        
    </footer>
    
</body>

</html>
<script>
 function filterProduct(text) {
    console.log('filtering ' + text);
    var wrapper = document.querySelector('#wrapper');
	if (wrapper) {
	  console.log('inside wrapper');
	  var items = wrapper.getElementsByClassName('produit_');
	  console.log(items);
	  for (var item of items) {
	    console.log(item)
	    var inputNom = item.getElementsByClassName('nom_prod');
        if (!text || text===""){
            item.hidden=false;
        
        }
        else {
           
          if (inputNom && inputNom[0] && inputNom[0].value && inputNom[0].value.includes(text)) {
		     item.hidden=false;
		     console.log('set to display');
		} 
         else {
		    console.log('hide');
		    item.hidden=true;
	     }

     }
		
	}
  }
}
  function search() {
    filterProduct(document.querySelector('#search').value);
  }
  function describe(i) {
      var desc = document.querySelector('#prod_'+i);
      desc.hidden = !desc.hidden;
  }
</script>