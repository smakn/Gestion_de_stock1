<?php
include 'connexion.php';

if (
    !empty($_POST ['libelle_categorie'] )

    ) {
    $sql = "INSERT INTO categorie_article(libelle_categorie)
    VALUES (?)   "; 
    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['libelle_categorie'],

    ));
//message a afficher dans article apres l enregistrement
    if ($req ->rowCount()!=0) {
        $_SESSION['message']['text'] = "Categorie ajouté avec succes:";
        $_SESSION['message']['type'] = "succes";
    } 
    else{
        $_SESSION['message']['text'] = "Une erreur a été détecté lors de l'ajout de la categorie:";
        $_SESSION['message']['type'] = "danger";
    }

}
else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
header("Location:../vue/categorie.php");
    
?>