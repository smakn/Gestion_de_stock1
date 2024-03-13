<?php
include 'connexion.php';

if (
    !empty($_POST ['Nom_article'] )
    && !empty($_POST ['id_categorie'] )
    && !empty($_POST ['quantite'] )
    && !empty($_POST ['prix_unitaire'] )
    && !empty($_POST ['date_fabrication'] )
    && !empty($_POST ['date_expiration'] )
    && !empty($_POST ['id'] )

    ) {
    $sql = "UPDATE articles SET Nom_article=?, id_categorie=?, quantite=?, prix_unitaire=?, 
    date_fabrication=?, date_expiration=? WHERE id=? "; 
    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['Nom_article'],
        $_POST ['id_categorie'],
        $_POST ['quantite'],
        $_POST ['prix_unitaire'],
        $_POST ['date_fabrication'],
        $_POST ['date_expiration'],
        $_POST ['id']
    ));
//message a afficher dans article apres l enregistrement
    if ($req ->rowCount()!=0) {
        $_SESSION['message']['text'] = "Article modifié avec succes:";
        $_SESSION['message']['type'] = "succes";
    } 
    else{
        $_SESSION['message']['text'] = "Rien a ete modifie:";
        $_SESSION['message']['type'] = "danger";
    }

}
else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
header("Location:../vue/article.php");
    
?>