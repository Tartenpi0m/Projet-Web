<?php 
    session_start();
    if( isset($_SESSION['identifiant']) and $_SESSION['admin'] == "no") {
        $identifiant = $_SESSION['identifiant'];
    } else if($_SESSION['admin'] == "yes") {
        header("Location: admin.php");
    }  else {
        header("Location: authentificationUser.php");
    }
    


    include("include\\bddfonction.php"); 
    $co = connection_bdd();
    $datarow = select_client($co, $identifiant);
    $identifiant = identifiant($datarow);
    $pass = pass($datarow);

    $carte_num = carte_num($datarow);

    
    ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Compte client</title>
</head>

<header>
<p>COMPTE CLIENT</p>
</header>

<body>
<div class="updiv">
    <p>INFORMATIONS PERSONNEL</p>
    <div class="downdiv">
    
    <p>Identifiant : <?php echo $identifiant?></p>
    <p>Carte bleue : 
    <?php 
    if($carte_num == 0) {
        echo "aucune carte";
    } else {
        echo $carte_num;
    }
    ?> </p>
    <p><form methode="POST"><input type="submit" value="Actualiser"></form></p>
    </div>

</div>

<div class="updiv">
    <p>MODIFICATION INFORMATIONS PERSONNEL</p>

    <div class="downdiv">
    <form method="POST">
    <p>Identifiant: <input type="text" name ="identifiant"></p>
    <p>Mot de passe: <input type="password" name ="pass1"> Confirmer votre mot de passe: <input type="password" name ="pass2"></p>
    <p>Carte:</p>
    <p>Numéro: <input type="text" name="carte_num"> cvv: <input type="text" name="carte_cvv">Date d'expiration (mm/aaaa): <input type="text" name="carte_date"></p>
    <p><input type="hidden" name="modif_info" value="modif_info"></p>
    <p><input type="submit" value="Mettre à jour"></p>
    </form>
    
    <?php 
        if(isset($_POST["modif_info"])) {

            $ID = $_POST['identifiant'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            $carte_num = $_POST['carte_num'];
            $carte_cvv = $_POST['carte_cvv'];
            $carte_date = $_POST['carte_date'];


            //IDENTIFIANT
            if($ID !== "") {
                if(mysqli_query($co, "UPDATE client SET identifiant = \"$ID\"  WHERE client.identifiant = \"$identifiant\"")) {
                    echo '<p style="color: green;">Votre identifiant à été mis à jour<p>';
                    $_SESSION['identifiant'] = $ID;
                } else {
                    echo '<p style="color: red;">L\'identifiant choisis est déjà utilisé, votre identifiant n\'a pas été mis à jour<p>';
                }
            } 

            //PASSWORD
            if($pass1 !== "") {
                if($pass1 !== $pass2) {
                    echo '<p style="color: red;">Les deux mots de passe ne sont pas identiques</p>';
                } else {
                    if(mysqli_query($co, "UPDATE client SET pass = \"$pass1\"  WHERE client.identifiant = \"$identifiant\"")) {
                        echo '<p style="color: green;">Votre mot de passe à été mis à jour<p>';
                    } else {
                        echo '<p style="color: red;">Erreur, votre mot de passe n\'a pas été mis à jour<p>';
                    }
                }
            }

            if($carte_num !== "" or $carte_cvv !== "" or $carte_date !== "") {
                if($carte_num == "" or $carte_cvv == "" or $carte_date == "") {
                    echo '<p style="color: red;">Tous les champs de la carte de paiment ne sont pas remplis, aucune modification n\'a été apportée sur la carte</p>';
                } else {
                    $valide = 1;
                    if(!preg_match("#^[0-9]{16}$#",$carte_num)) {
                        $valide = 0;
                        echo '<p style="color: red;">Numéro de carte invalide<p>';
                    }
                    if(!preg_match("#^[0-9]{3}$# ", $carte_cvv)) {
                        $valide = 0;
                        echo '<p style="color: red;">Cryptogramme visuel invalide<p>';
                    }
                    if(!preg_match("#^[0-9]{2}/[0-9]{4}$#",$carte_date)) {
                        $valide = 0;
                        echo '<p style="color: red;">Mauvais format de date, veuillez respectez mm/aaaa<p>';
                    }

                    if($valide == 1) {
                        if(mysqli_query($co, "UPDATE client SET carte_num = \"$carte_num\", carte_cvv = \"$carte_cvv\", carte_date = \"$carte_cvv\" WHERE client.identifiant = \"$identifiant\";")) {
                            echo '<p style="color: green;">Votre carte de paiment à été mise à jour<p>';
                        }
                        else {
                            echo '<p style="color: red;">Erreur, votre votre carte de paiement n\'a pas été mise à jour<p>';
                        }
                    }

                }
            }
           

        }
    ?>


    </div>

</div>


<div class="updiv">
        <p>COMMANDES</p>
        <div class="downdiv">
        
        </div>
</div>




    
    

    



    <script>
        ladate=new Date()
        document.write(ladate.getDate()+"/"+(ladate.getMonth()+1)+"/"+ladate.getFullYear()+"<br />"+ladate.getHours()+":"+ladate.getMinutes()+":"+ladate.getSeconds())
    </script>

</body>
</html>