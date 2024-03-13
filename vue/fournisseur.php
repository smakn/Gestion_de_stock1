<?php
    include 'entete.php';
    
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../registration/login.php"); // Redirige vers la page de connexion si non authentifié
        exit();
    }
    
    // Vérifiez si l'utilisateur a le rôle approprié pour la gestion des articles
    if ($_SESSION['role'] != 'admin'&& $_SESSION['role'] != 'commande') {
        header("Location: dashboard.php"); // Redirige vers la page non autorisée
        exit();
    }
//recupaire l article qui est dans GET pour le mettre dans le formulaire
    if (!empty($_GET['id'])) {
        $fournisseur = getFournisseur($_GET['id']);
    }
    
?>

<div class="home-content">
        <div class="overview-boxes">
            <div class="box">
                <form action=" <?= !empty($_GET['id']) ? "../model/modifFournisseur.php" : "../model/AjoutFournisseur.php " ?>"  method="POST">
                    <label for="Nom"> Nom</label>
                    <input value="<?= !empty($_GET['id']) ? $fournisseur['Nom']  : "" ?>" type="text" name="Nom" id="Nom" placeholder="Veuillez saisir votre nom">
                    <input value="<?= !empty($_GET['id']) ? $fournisseur['id']  : "" ?>" type="hidden" name="id" id="id" >

                    <label for="Prenom"> Prénom</label>
                    <input value="<?= !empty($_GET['id']) ? $fournisseur['Prenom']  : "" ?>" type="text" name="Prenom" id="Prenom" placeholder="Veuillez saisir votre prenom">


                    <label for="Telephone"> Numéro de Téléphone</label>
                    <input value="<?= !empty($_GET['id']) ? $fournisseur['Telephone']  : "" ?>" type="text" name="Telephone" id="Telephone" placeholder="Veuillez saisir  votre numéro de téléphone">

                    <label for="adresse"> Adresse</label>
                    <input value="<?= !empty($_GET['id']) ? $fournisseur['adresse']  : "" ?>" type="text" name="adresse" id="adresse" placeholder="Veuillez saisir  votre numéro adresse">
                    

                    <button type="submit" name="valider"> Valider</button>
                <!--message a afficher en cas de reussite du remplissage du formulaire ou de l echec-->
                    <?php
                        if (!empty($_SESSION['message']['text'])) {
                    ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
                    </div>

                    <?php    
                    } 
                    ?>
                    
                </form>

            </div>
            <div class="box">
                <table class="mtable">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                    <!--afficher les article enregistre dans la base sur article-->
                    <?php
                        $fournisseur = getFournisseur();
                        if (!empty($fournisseur) && is_array($fournisseur)) {
                            foreach ($fournisseur as $key => $value) { 
                    ?>
                    <tr>
                        <td> <?= $value['Nom'] ?></td>
                        <td> <?= $value['Prenom'] ?></td>
                        <td> <?= $value['Telephone'] ?></td>
                        <td> <?= $value['adresse'] ?></td>
                        <td><a href="?id=<?=  $value['id'] ?>"> <i class="bx bx-edit-alt"></i> </a></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
            </div>
        </div>

    </div>
    </section>
</body>
</html>
    
<?php
    include 'pied.php';
?>