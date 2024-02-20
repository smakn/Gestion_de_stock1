<?php
    include 'entete.php';

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../registration/login.php"); // Redirige vers la page de connexion si non authentifié
        exit();
    }
    // Vérifiez si l'utilisateur a le rôle approprié pour la gestion des articles
    if ($_SESSION['role'] != 'admin') {
        header("Location: dashboard.php"); // Redirige vers la page non autorisée
        exit();
    }
//recupaire l article qui est dans GET pour le mettre dans le formulaire
    if (!empty($_GET['id'])) {
        $article = getCategorie($_GET['id']);
    }
    
?>

<div class="home-content">
        <div class="overview-boxes">
            <div class="box">
                <form action=" <?= !empty($_GET['id']) ? "../model/modifCategorie.php" : "../model/AjoutCategorie.php " ?>"  method="POST">
                    <label for="libelle_categorie"> Libelle</label>
                    <input value="<?= !empty($_GET['id']) ? $article['libelle_categorie']  : "" ?>" type="text" name="libelle_categorie" id="libelle_categorie" placeholder="Veuillez saisir votre nom">
                    <input value="<?= !empty($_GET['id']) ? $article['id']  : "" ?>" type="hidden" name="id" id="id" >

                    

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
                        <th>Libelle</th>
                        <th>Action</th>
                    </tr>
                    <!--afficher les article enregistre dans la base sur article-->
                    <?php
                        $categories = getCategorie();
                        if (!empty($categories) && is_array($categories)) {
                            foreach ($categories as $key => $value) { 
                    ?>
                    <tr>
                        <td> <?= $value['libelle_categorie'] ?></td>

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