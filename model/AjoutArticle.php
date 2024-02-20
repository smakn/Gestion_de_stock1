<?php
include 'connexion.php';

if (
    !empty($_POST ['Nom_article'] )
    && !empty($_POST ['id_categorie'] )
    && !empty($_POST ['quantite'] )
    && !empty($_POST ['prix_unitaire'] )
    && !empty($_POST ['date_fabrication'] )
    && !empty($_POST ['date_expiration'] )
    #Appeler l images
    && !empty($_FILES ['images'] )

    ) {
    $sql = "INSERT INTO articles(Nom_article, id_categorie, quantite, prix_unitaire, date_fabrication, date_expiration, images)
    VALUES (?, ?, ?, ?, ?, ?, ?)   "; 
    $req = $connexion->prepare($sql);
    #recuperation de l image
    $name = $_FILES['images']['name'];;
    $tmp_name = $_FILES['images']['tmp_name'];
    # Dossier ou se trouve l image
    $folder = "../public/images/";
    # Lieu ou l image sera deplace
    $destination = "../public/images/$name";

    #condition pour voire si le dossier creer exisiste 
    if (is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    # condition pour deplacer l image
    if (move_uploaded_file($tmp_name, $destination)) {
        $req -> execute(array(
            $_POST ['Nom_article'],
            $_POST ['id_categorie'],
            $_POST ['quantite'],
            $_POST ['prix_unitaire'],
            $_POST ['date_fabrication'],
            $_POST ['date_expiration'],
            $destination
        ));
    //message a afficher dans article apres l enregistrement
        if ($req ->rowCount()!=0) {
            $_SESSION['message']['text'] = "Article ajouté avec succes:";
            $_SESSION['message']['type'] = "succes";
        } 
        else{
            $_SESSION['message']['text'] = "Une erreur a été détecté lors l importation de l image de l'article:";
            $_SESSION['message']['type'] = "danger";
        }
    
    }
    }else {
    $_SESSION['message']['text'] =  "Une information obligatoir non renseignée:";
    $_SESSION['message']['type'] = "danger";

    }
    

header("Location:../vue/article.php");
    
?>