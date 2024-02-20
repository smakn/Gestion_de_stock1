<?php
include 'connexion.php';

if (
    !empty($_GET['idVentes']) &&
    !empty($_GET['idArticles']) &&
    !empty($_GET['quantite']) 
) {
    $sql = "UPDATE ventes SET etat=? WHERE id=?";
    $req = $connexion->prepare($sql);
    $req -> execute(array(0,$_GET['idVentes']));

    if ($req ->rowCount()!=0) {
        $sql = "UPDATE articles SET quantite=quantite+?  WHERE id=?";
        $req = $connexion->prepare($sql);
        $req -> execute(array($_GET['quantite'], $_GET['idArticles']));
    }
}

header("Location:../vue/vente.php");
    
?>