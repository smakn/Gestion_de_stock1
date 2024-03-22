<?php
    include 'entete.php';
?>
    <div class="home-content">
        <button class="hidden-print" id="btnPrint" style="position: relative; left: 45%;"> <i class='bx bx-printer'></i> Imprimer</button>
    </div>

    <div class="page">
        
            <div class="cote-a-cote">
                <h2>GESAC stock</h2>
                <div>
                    <p>Recu N #: <?= isset($vente['id']) ? $vente['id'] : '' ?> </p>
                    <p>Date: <?= isset($vente['date_vente']) ? date('d/m/Y H:i:s', strtotime($vente['date_vente'])) : '' ?> </p>
                </div>
            </div>

            <div class="cote-a-cote" style="width:50%;">
                <p>Nom: </p>
                <p><?= isset($vente['Nom']) && isset($vente['Prenom']) ? $vente['Nom'] . " " . $vente['Prenom'] : '' ?></p>
            </div>

            <div class="cote-a-cote" style="width:50%;">
                <p>Tel: </p>
                <p><?= isset($vente['telephone']) ? $vente['telephone'] : '' ?></p>
            </div>

            <div class="cote-a-cote" style="width:50%;">
                <p>Adresse: </p>
                <p><?= isset($vente['adresse']) ? $vente['adresse'] : '' ?></p>
            </div>

            <br>

            <table class="mtable">
                <tr>
                    <th>Designation</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Prix total</th>
                            
                </tr>
                        <!--afficher les article enregistre dans la base sur article-->
        <?php
            $prixtotal = 0;
            // Vérifier si la clé 'vente' existe dans $_POST et si elle est un tableau
            if(isset($_POST['vente']) && is_array($_POST['vente'])) {
                foreach ($_POST['vente'] as $v) {
                    $vente = getVente($v);
                    $prixtotal += $vente['prix'];
        ?>
        <tr>
            <td><?= $vente['Nom_article'] ?></td>
            <td><?= $vente['quantite'] ?></td>
            <td><?= $vente['prix_unitaire'] ?></td>
            <td><?= $vente['prix'] ?></td>
        </tr>
        <?php
            }
        }
        ?>
        <tr>
            <td>Totaux</td>
            <td></td>
            <td></td>
            <td><?= $prixtotal ?></td>
        </tr>



<?php
    include 'pied.php';
?>
<script>
    var btnPrint = document.querySelector('#btnPrint');
    btnPrint.addEventListener("click",  () => {
        window.print();
    });

    function setPrix() {
        var article = document.querySelector('#id_articles');
        var quantite = document.querySelector('#quantite');
        var prix = document.querySelector('#prix');

        // Vérifier si un article est sélectionné
        if (article.selectedIndex !== -1) {
            var prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix');
            prix.value = Number(quantite.value) * Number(prixUnitaire);
        } else {
            // Afficher un message d'erreur ou gérer ce cas selon vos besoins
            alert("Veuillez sélectionner un article avant de calculer le prix.");
            prix.value = ''; // Réinitialiser le champ prix
        }
    }
</script>
