<?php
session_start(); // Démarrage de la session si ce n'est pas déjà fait

include 'connexion.php';
include_once "fonction.php";

// Vérifier si tous les champs requis sont remplis
if (
    !empty($_POST['id_articles']) &&
    !empty($_POST['id_clients']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix'])
) {
    // Récupérer les informations sur l'article
    $article = getArticle($_POST['id_articles']);
    
    if (!empty($article) && is_array($article)) {
        // Vérifier si la quantité demandée est disponible
        if ($_POST['quantite'] <= $article['quantite']) {
            // Procéder à la vente
            $sql = "INSERT INTO ventes(id_articles, id_clients, quantite, prix) VALUES (?, ?, ?, ?)"; 
            $req = $connexion->prepare($sql);
            $req->execute(array(
                $_POST['id_articles'],
                $_POST['id_clients'],
                $_POST['quantite'],
                $_POST['prix']
            ));
            
            // Vérifier si la vente a été effectuée avec succès
            if ($req->rowCount() > 0) {
                // Mettre à jour la quantité de l'article
                $sql = "UPDATE articles SET quantite = quantite - ? WHERE id = ?";
                $req = $connexion->prepare($sql);
                $req->execute(array(
                    $_POST['quantite'],
                    $_POST['id_articles']
                ));
                
                // Vérifier si la mise à jour a été effectuée avec succès
                if ($req->rowCount() > 0) {
                    $_SESSION['message']['text'] = "Vente effectuée avec succès";
                    $_SESSION['message']['type'] = "success";
                } else {
                    $_SESSION['message']['text'] = "Impossible de mettre à jour la quantité de l'article";
                    $_SESSION['message']['type'] = "danger";
                }
            } else {
                $_SESSION['message']['text'] = "Une erreur s'est produite lors de la vente";
                $_SESSION['message']['type'] = "danger";
            }
        } else {
            $_SESSION['message']['text'] = "La quantité demandée n'est pas disponible";
            $_SESSION['message']['type'] = "danger";
        }
    } else {
        $_SESSION['message']['text'] = "Article non trouvé";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire n'est pas renseignée";
    $_SESSION['message']['type'] = "danger";
}

header("Location:../vue/vente.php");
?>
