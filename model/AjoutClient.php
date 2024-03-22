<?php
session_start(); // Démarrage de la session si ce n'est pas déjà fait
include 'connexion.php';

// Vérifier si tous les champs obligatoires sont remplis
if (
    !empty($_POST['Nom']) &&
    !empty($_POST['Prenom']) &&
    !empty($_POST['Telephone']) &&
    !empty($_POST['adresse'])
) {
    try {
        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO clients(Nom, Prenom, Telephone, adresse) VALUES (?, ?, ?, ?)";
        $req = $connexion->prepare($sql);
        $req->execute(array(
            $_POST['Nom'],
            $_POST['Prenom'],
            $_POST['Telephone'],
            $_POST['adresse']
        ));

        // Vérifier si l'insertion a réussi
        if ($req->rowCount() > 0) {
            $_SESSION['message']['text'] = "Client ajouté avec succès";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout du client";
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

// Redirection vers la page de gestion des clients
header("Location:../vue/client.php");
?>
