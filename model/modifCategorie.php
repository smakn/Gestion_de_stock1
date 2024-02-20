<?php
include 'connexion.php';

if (
    !empty($_POST ['libelle_categorie'] )

    && !empty($_POST ['id'] )

    ) {
    $sql = "UPDATE categorie_article SET libelle_categorie=? WHERE id=? "; 
    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['libelle_categorie'],
        $_POST ['id']
    ));
//message a afficher dans article apres l enregistrement
    if ($req ->rowCount()!=0) {
        $_SESSION['message']['text'] = "Categorie modifié avec succes:";
        $_SESSION['message']['type'] = "succes";
    } 
    else{
        $_SESSION['message']['text'] = "Rien a ete modifie:";
        $_SESSION['message']['type'] = "warning";
    }

}
else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
header("Location:../vue/categorie.php");
    
?>