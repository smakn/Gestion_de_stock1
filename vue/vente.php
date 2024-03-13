<?php
    include 'entete.php';

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../registration/login.php"); // Redirige vers la page de connexion si non authentifié
        exit();
    }
    
    // Vérifiez si l'utilisateur a le rôle approprié pour la gestion des articles
    if ($_SESSION['role'] != 'vendeur' && $_SESSION['role'] != 'admin') {
        header("Location: dashboard.php"); // Redirige vers la page non autorisée
        exit();
    }


//recupaire l article qui est dans GET pour le mettre dans le formulaire
    if (!empty($_GET['id'])) {
        $article = getVente($_GET['id']);
    }
    
?>

<div class="home-content">
        <div class="overview-boxes">
            <div class="box">
                <form action=" <?= !empty($_GET['id']) ? "../model/modifVente.php" : "../model/AjoutVente.php " ?>"  method="POST">
                    
                    <input value="<?= !empty($_GET['id']) ? $article['id']  : "" ?>" type="hidden" name="id" id="id" >


                    <label for="id_articles"> Article</label>
                    <select onchange="setPrix()" name="id_articles" id="id_articles">
                    <?php

                    //recupaire tout les articles et les stock dans get
                            $articles = getArticle();
                            if (!empty($articles) && is_array($articles)) {
                                //parcourir le tableau
                                foreach ($articles as $key => $value) {
                            ?>
                            <!--verification si disponible-->
                            <option data-prix="<?= $value['prix_unitaire']?>" value="<?= $value['id']?>"> <?= $value['Nom_article']. "-" . $value['quantite']. "-" . 'Disponible'?></option>
                            <?php
                                }
                            }
                           
                    ?>
                        
                    </select>

                    <label for="id_clients"> Client</label>
                    <select name="id_clients" id="id_clients">
                    <?php

                    //recupaire tout les articles et les stock dans get
                            $clients = getClient();
                            if (!empty($clients) && is_array($clients)) {
                                //parcourir le tableau
                                foreach ($clients as $key => $value) {
                            ?>
                            <!--verification si disponible-->
                            <option value="<?= $value['id']?>"> <?= $value['Nom']. " " . $value['Prenom'] ?></option>
                            <?php
                                }
                            }
                           
                    ?>
                        
                    </select>

                    <label for="quantite"> Quantité</label>
                    <input onkeyup = "setPrix()" value="<?= !empty($_GET['id']) ? $article['quantite']  : "" ?>" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la auqntité">

                    <label for="prix"> Prix</label>
                    <input value="<?= !empty($_GET['id']) ? $article['prix']  : "" ?>" type="text" name="prix" id="prix" placeholder="Veuillez saisir le prix">

                   

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
                <form method="POST" action="recuVente.php">
                    <table class="mtable">
                        <tr>
                            <th>Selectionne</th>
                            <th>Article</th>
                            <th>Client</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Date</th>
                            <th>Action</th>

                        </tr>
                        <!--afficher les article enregistre dans la base sur article-->
                        <?php
                            $ventes = getVente();
                            if (!empty($ventes) && is_array($ventes)) {
                                foreach ($ventes as $key => $value) { 
                        ?>
                        <tr>
                        <td><input type="checkbox" id="<?=$value['id'] ?>" name="checkbox[]" value="<?=$value['id']?>"></td> 
                       
                            <td> <?= $value['Nom_article'] ?></td>
                            <td> <?= $value['Nom'] ." ". $value['Prenom']?></td>
                            <td> <?= $value['quantite'] ?></td>
                            <td> <?= $value['prix'] ?></td>
                            <td> <?= date('d/m/Y H:i:s', strtotime ($value['date_vente'])) ?></td>
                            <td>
                                <a href="recuVente.php?id=<?=  $value['id'] ?>"> <i class='bx bx-receipt'></i> </a>
                                <a onclick="annuleVente(<?=$value['id'] ?>, <?=$value['idArticles'] ?>, <?=$value['quantite'] ?> )" style="color:red;"> <i class='bx bx-stop-circle'></i> </a>
                            </td>
                        </tr>
                        
                        <?php
                                }
                            }
                        ?>
                        
                    </table>
                    <button type="submit" name="imprimerVentes"><a href="recuVente.php?id=<?=$value['id'] ?>" style="color:blue;"> <i class='bx bx-stop-circle'></i> Imprimer tout</a></button>
                </form>
            </div>
          
        </div>

    </div>
    </section>
</body>
</html>
    
<?php
    include 'pied.php';
?>
<script>

    function annuleVente(idVentes, idArticles, quantite) {
        if (confirm("Voulez-vous vraiment annuler cette vente ?")) {
            window.location.href = "../model/annuleVente.php?idVentes="+idVentes+"&idArticles="+idArticles+"&quantite="+quantite
        }
        
    }
    //calul du prix de l article et gestion automatique
    function setPrix() {
        var article = document.querySelector('#id_articles');
        var quantite = document.querySelector('#quantite');
        var prix = document.querySelector('#prix');

        var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');
        prix.value = Number(quantite.value) * Number(prixUnitaire);
    }
</script>


<!--<script>
    function setPrix(){
        var article = document.querySelector('#id_articles');
        var article = document.querySelector('#quantite');
        var article = document.querySelector('#prix');

        var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');
        prix.value = Number(quantite.value) * Number(prixUnitaire);
    }
</script>