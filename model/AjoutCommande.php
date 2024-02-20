<?php
include 'connexion.php';
include_once "fonction.php";

if (
    !empty($_POST ['id_articles'] )
    && !empty($_POST ['id_fournisseur'] )
    && !empty($_POST ['quantite'] )
    && !empty($_POST ['prix'] )

    ) {
        
                $sql = "INSERT INTO commande(id_articles, id_fournisseur, quantite, prix)
                VALUES (?, ?, ?, ?)   "; 
                $req = $connexion->prepare($sql);
                $req -> execute(array(
                    $_POST ['id_articles'],
                    $_POST ['id_fournisseur'],
                    $_POST ['quantite'],
                    $_POST ['prix']
                ));
            //message a afficher dans article apres l enregistrement
                if ($req ->rowCount()!=0) {
                    $sql= "UPDATE articles SET quantite=quantite+? WHERE id=?";

                    $req = $connexion->prepare($sql);
                    $req -> execute(array(
                        $_POST ['quantite'],
                        $_POST ['id_articles'],
                        
                    ));

                    if ($req ->rowCount()!=0) {
                      
                        $_SESSION['message']['text'] = "Commande effectué avec succes:";
                        $_SESSION['message']['type'] = "succes";
                    }else{
                        $_SESSION['message']['text'] = "impossible de faire cette commande:";
                    $_SESSION['message']['type'] = "danger";
                    }


                } 
                else{
                    $_SESSION['message']['text'] = "Une erreur a été détecté lors de la commande:";
                    $_SESSION['message']['type'] = "danger";
                }

        

}
else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
header("Location:../vue/commande.php");
    
?>