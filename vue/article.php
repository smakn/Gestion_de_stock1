<?php
    include 'entete.php';
    session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../registration/login.php"); // Redirige vers la page de connexion si non authentifié
            exit();
        }

// Vérifiez si l'utilisateur a le rôle approprié pour la gestion des articles

        if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'commande') {
            header("Location: dashboard.php"); // Redirige vers la page non autorisée
            exit();
        }


//recupaire l article qui est dans GET pour le mettre dans le formulaire
        if (!empty($_GET['id'])) {
            $article = getArticle($_GET['id']);
        }
        
    ?>

    <div class="home-content">
        <div  class="overview-boxes">
            <div  class="box">
                <!--enctype="multipart/form-data" pour que l image sois reconnu-->
                <form action=" <?= !empty($_GET['id']) ? "../model/modifArticle.php" : "../model/AjoutArticle.php " ?>"  method="POST" enctype="multipart/form-data">
                    <label for="Nom_article"> Nom de l'article</label>
                    <input value="<?= !empty($_GET['id']) ? $article['Nom_article']  : "" ?>" type="text" name="Nom_article" id="Nom_article" placeholder="Veuillez saisir votre nom">
                    <input value="<?= !empty($_GET['id']) ? $article['id']  : "" ?>" type="hidden" name="id" id="id" >

                    <label for="id_categorie"> Categorie</label>
                    <select name="id_categorie" id="id_categorie">
                    <?php
                    #parcourir le tableau
                       $categories=getCategorie();
                        if (!empty($categories) && is_array($categories)) {
                            foreach ($categories as $key => $value) {
                                # code...
                          
                        ?>
                        <option <?= !empty($_GET['id']) && $article['id_categorie'] == $value['id'] ? "selected" : "" ?> value="<?= $value['id']  ?>"><?= $value['libelle_categorie']  ?></option>
                        <?php
                         }
                        }
                        
                    ?>                       
                    </select>

                    <label for="quantite"> Quantité</label>
                    <input value="<?= !empty($_GET['id']) ? $article['quantite']  : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la auqntité">

                    <label for="prix_unitaire"> Prix unitaire</label>
                    <input value="<?= !empty($_GET['id']) ? $article['prix_unitaire']  : "" ?>" type="text" name="prix_unitaire" id="prix_unitaire" placeholder="Veuillez saisir le prix unitaire">

                    <label for="date_fabrication"> Date de fabrication</label>
                    <input value="<?= !empty($_GET['id']) ? $article['date_fabrication']  : "" ?>" type="datetime-local" name="date_fabrication" id="date_fabrication" >

                    <label for="date_expiration"> Date d'expiration</label>
                    <input value="<?= !empty($_GET['id']) ? $article['date_expiration']  : "" ?>" type="datetime-local" name="date_expiration" id="date_expiration" >

                    <label for="images"> Image</label>
                    <input value="<?= !empty($_GET['id']) ? $article['images']  : "" ?>" type="file" name="images" id="images" >

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
             <div style="display:block;" class="box">

                <form action="" method="get">
                        <table class="mtable">
                                
                                <tr>
                                    <th>Nom article</th>
                                    <th>Categorie</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Date de fabrication</th>
                                    <th>Date d'expiration</th>
                                </tr>
                                <tr>
                                    <td>
                                    <input type="text" name="Nom_article" id="Nom_article" placeholder="Veuillez saisir votre nom">   
                                    </td>
                                    <td>
                                            <select name="id_categorie" id="id_categorie">
                                                <option value="">--choisir une categorie--</option>
                                        <?php
                                        #parcourir le tableau
                                        $categories=getCategorie();
                                            if (!empty($categories) && is_array($categories)) {
                                                foreach ($categories as $key => $value) {
                                                    # code...
                                            
                                            ?>
                                            <option <?= !empty($_GET['id']) && $article['id_categorie'] == $value['id'] ? "selected" : "" ?> value="<?= $value['id']  ?>"><?= $value['libelle_categorie']  ?></option>
                                            <?php
                                            }
                                            }
                                            
                                            ?>                       
                                            </select>   
                                    </td>

                                    <td>
                                        <input  type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la auqntité">   
                                    </td>

                                    <td>
                                        <input  type="text" name="prix_unitaire" id="prix_unitaire" placeholder="Veuillez saisir le prix unitaire">   
                                    </td>

                                    <td>
                                        <input  type="date" name="date_fabrication" id="date_fabrication" >   
                                    </td>

                                    <td>
                                        <input type="date" name="date_expiration" id="date_expiration" >
                                    </td>
                                </tr>
                                <!--afficher les article enregistre dans la base sur article-->

                        </table>
                        <br>
                        <button type="submit" name="valider"> Valider</button>
                        
                </form>
                <br>
                <table class="mtable">
                    
                    <tr>
                        <th>Nom article</th>
                        <th>Categorie</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Date de fabrication</th>
                        <th>Date d'expiration</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    <!--afficher les article enregistre dans la base sur article-->
                    <?php
                    if (!empty($_GET)) {
                        $articles = getArticle(null, $_GET);
                    }else{
                        $articles = getArticle();
                    }

                        
                        if (!empty($articles) && is_array($articles)) {
                            foreach ($articles as $key => $value) { 
                    ?>
                    <tr>
                        <td> <?= $value['Nom_article'] ?></td>
                        <td> <?= $value['libelle_categorie'] ?></td>
                        <td> <?= $value['quantite'] ?></td>
                        <td> <?= $value['prix_unitaire'] ?></td>
                        <td> <?= date('d/m/Y H:i:s', strtotime ($value['date_fabrication'])) ?></td>
                        <td> <?= date('d/m/Y H:i:s', strtotime ( $value['date_expiration'])) ?></td>
                        <td> <img width="50" height="50" src="<?= $value['images'] ?>" alt="<?= $value['Nom_article'] ?>"></td>
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
            