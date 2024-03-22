<?php
session_start(); // Démarrage de la session si ce n'est pas déjà fait
include 'connexion.php';

// Vérifier si le champ libelle_categorie est rempli
if (!empty($_POST['libelle_categorie'])) {
    try {
        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO categorie_article(libelle_categorie) VALUES (?)"; 
        $req = $connexion->prepare($sql);
        $req->execute(array(
            $_POST['libelle_categorie'],
        ));

        // Vérifier si l'insertion a réussi
        if ($req->rowCount() > 0) {
            $_SESSION['message']['text'] = "Catégorie ajoutée avec succès";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout de la catégorie";
            $_SESSION['message']['type'] = "danger";
        }
    } catch (PDOException $e) {
        // Capturer et afficher les erreurs PDO
        $_SESSION['message']['text'] = "Erreur PDO : " . $e->getMessage();
        $_SESSION['message']['type'] = "danger";
    }
} else {
    // Champ obligatoire non renseigné
    $_SESSION['message']['text'] = "Une information obligatoire n'est pas renseignée";
    $_SESSION['message']['type'] = "danger";
}

// Redirection vers la page de gestion des catégories
header("Location:../vue/categorie.php");
?>
