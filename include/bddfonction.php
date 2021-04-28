<?php 

function connection_bdd() {
 //se connecter à la base de donnée
 $co = mysqli_connect("localhost", "root");
 mysqli_select_db($co,"projet-web");
    return $co;
}

function select_client($co, $nomclient) {
    $query = "SELECT identifiant, pass, carte_num, carte_cvv, carte_date FROM client WHERE identifiant LIKE \"$nomclient\"";
    $response = mysqli_query($co, $query);
    $datarow = $response->fetch_array();
    return $datarow;
}

function select_admin($co, $nomclient) {
    $query = "SELECT identifiant, pass FROM admin WHERE identifiant LIKE \"$nomclient\"";
    $response = mysqli_query($co, $query);
    $datarow = $response->fetch_array();
    return $datarow;
}



function identifiant($datarow) {
    return $datarow[0];
}

function pass($datarow) {
    return $datarow[1];
}

function carte_num($datarow) {
    return $datarow[2];
}

function carte_3num($datarow) {
    return $datarow[3];
}

function carte_date($datarow) {
    return $datarow[4];
}




?>