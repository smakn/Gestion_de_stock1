<?php
include 'connexion.php';

if (
    !empty($_POST ['Nom'] )
    && !empty($_POST ['Prenom'] )
    && !empty($_POST ['Telephone'] )
    && !empty($_POST ['adresse'] )
    ) {

    $sql = "INSERT INTO fournisseur(Nom, Prenom, Telephone, adresse)
    VALUES (?, ?, ?, ?)  ";

    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['Nom'],
        $_POST ['Prenom'],
        $_POST ['Telephone'],
        $_POST ['adresse']
    ));
//message a afficher dans article apres l enregistrement
    if ($req ->rowCount()!=0) {
        $_SESSION['message']['text'] = "Fournisseur ajouté avec succes:";
        $_SESSION['message']['type'] = "succes";
    } 
    else{
        $_SESSION['message']['text'] = "Une erreur a été détecté lors de l'ajout du Fournisseur:";
        $_SESSION['message']['type'] = "danger";
    }

}
else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
header("Location:../vue/fournisseur.php");
    
?>