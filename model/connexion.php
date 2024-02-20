<?php

$serveur = "localhost";
$bd="gestion_stock";
$utilisateur="dev";
$pass="dev";

try {
    $connexion = new PDO ("mysql:host = $serveur; dbname=$bd", $utilisateur,  $pass);
    $connexion-> setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connexion;
}catch (Exception $e){ 
    die ("Erreur de connexion:" . $e->getMessage());
}

?>