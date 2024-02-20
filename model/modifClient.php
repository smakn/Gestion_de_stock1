<?php
include 'connexion.php';

if (
    !empty($_POST ['Nom'] )
    && !empty($_POST ['Prenom'] )
    && !empty($_POST ['Telephone'] )
    && !empty($_POST ['adresse'] )
    && !empty($_POST ['id'] )

    ) {
    $sql = "UPDATE clients SET Nom=?, Prenom=?, Telephone=?, adresse=? 
     WHERE id=? "; 
    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['Nom'],
        $_POST ['Prenom'],
        $_POST ['Telephone'],
        $_POST ['adresse'],
        $_POST ['id']
    ));
//message a afficher dans article apres l enregistrement
    if ($req ->rowCount()!=0) {
        $_SESSION['message']['text'] = "client modifié avec succes:";
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
header("Location:../vue/client.php");
    
?>