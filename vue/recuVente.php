<?php
    include 'entete.php';
//recupaire l article qui est dans GET pour le mettre dans le formulaire
    if (!empty($_GET['id'])) {
        $vente = getVente($_GET['id']);
    }
    
?>

<div class="home-content">

<button class="hidden-print" id="btnPrint" style="position: relative; left: 45%;"> <i class='bx bx-printer'></i> Imprimer</button>

    <div class="page">
        <div class="cote-a-cote">
            <h2>GESAC stock</h2>
            <div>
                <p>Recu N #: <?= $vente ['id'] ?> </p>
                <p>Date: <?= date('d/m/Y H:i:s', strtotime ($vente['date_vente'])) ?> </p>
            </div>
        </div>

        <div class="cote-a-cote" style="width:50%;">
            <p>Nom: </p>
            <p><?= $vente['Nom'] ." ". $vente['Prenom']?></p>

        </div>

        <div class="cote-a-cote" style="width:50%;">
            <p>Tel: </p>
            <p><?= $vente['telephone']?></p>

        </div>

        <div class="cote-a-cote" style="width:50%;">
            <p>Adresse: </p>
            <p><?= $vente['adresse']?></p>

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

                    <tr>
                        <td> <?= $vente['Nom_article'] ?></td>
                        <td> <?= $vente['quantite'] ?></td>
                        <td> <?= $vente['prix_unitaire'] ?></td>
                        <td> <?= $vente['prix'] ?></td>
                    </tr>

                </table>
    </div>
       
    </div>
    </section>
</body>
</html>
    
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