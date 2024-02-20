<?php
include 'connexion.php';

if (
    !empty($_POST ['id_articles'] )
    && !empty($_POST ['id_clients'] )
    && !empty($_POST ['quantite'] )
    && !empty($_POST ['prix'] )
    && !empty($_POST ['date_vente'] )
    && !empty($_POST ['id'] )

    ) {
    $sql = "UPDATE ventes SET id_articles=?, id_clients=?, quantite=?, prix=?, date_vente=? WHERE id=? "; 
    $req = $connexion->prepare($sql);
    $req -> execute(array(
        $_POST ['id_articles'],
        $_POST ['id_clients'],
        $_POST ['quantite'],
        $_POST ['prix'],
        $_POST ['date_vente'],
        $_POST ['id']
    ));
//message a afficher dans article apres l enregistrement

    if ($req ->rowCount()!=0) {
        
        $_SESSION['message']['text'] = "Article modifié avec succes:";
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
header("Location:../vue/vente.php");
    
?>