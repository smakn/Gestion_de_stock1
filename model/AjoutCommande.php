<?php
session_start(); // Démarrage de la session si ce n'est pas déjà fait
include 'connexion.php';

if (
    !empty($_POST['id_articles']) &&
    !empty($_POST['id_fournisseur']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix'])
) {
    try {
        // Insérer la commande dans la base de données
        $sql = "INSERT INTO commande(id_articles, id_fournisseur, quantite, prix) VALUES (?, ?, ?, ?)";
        $req = $connexion->prepare($sql);
        $req->execute(array(
            $_POST['id_articles'],
            $_POST['id_fournisseur'],
            $_POST['quantite'],
            $_POST['prix']
        ));

        // Vérifier si l'insertion a réussi
        if ($req->rowCount() > 0) {
            // Mettre à jour la quantité d'article
            $sql = "UPDATE articles SET quantite = quantite + ? WHERE id = ?";
            $req = $connexion->prepare($sql);
            $req->execute(array(
                $_POST['quantite'],
                $_POST['id_articles']
            ));

            // Vérifier si la mise à jour a réussi
            if ($req->rowCount() > 0) {
                $_SESSION['message']['text'] = "Commande effectuée avec succès";
                $_SESSION['message']['type'] = "success";
            } else {
                $_SESSION['message']['text'] = "Impossible de mettre à jour la quantité d'article";
                $_SESSION['message']['type'] = "danger";
            }
        } else {
            $_SESSION['message']['text'] = "Une erreur s'est produite lors de la commande";
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

// Redirection vers la page de gestion des commandes
header("Location:../vue/commande.php");
?>
