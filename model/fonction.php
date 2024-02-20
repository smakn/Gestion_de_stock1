<?php
include 'connexion.php';

//fonction article
function getArticle($id=null, $searchDATA =array())
{

    if (!empty($id)) {
        $sql = "SELECT Nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, images,
         date_expiration, id_categorie, a.id FROM articles AS a, categorie_article AS c WHERE a.id_categorie=c.id AND a.id=?";
        $req = $GLOBALS ['connexion']->prepare($sql);
    
        $req ->execute(array($id));
       return $req->fetch();
    }elseif (!empty($searchDATA)) {
        $search = "";
       extract($searchDATA);
       if (!empty($nom_article )) $search .= "AND a.nom_article LIKE '%$nom_article%' ";
       if (!empty($id_categorie)) $search .= "AND a.id_categorie = $id_categorie ";
       if (!empty($quantite)) $search .= "AND a.quantite = $quantite ";
       if (!empty($prix_unitaire)) $search .= "AND a.prix_unitaire = $prix_unitaire ";
       if (!empty($date_fabrication)) $search .= "AND DATE(a.date_fabrication) = '$date_fabrication' ";
       if (!empty($date_expiration)) $search .= "AND DATE(a.date_expiration) = '$date_expiration' ";
       if (!empty($prix_unitaire)) $search .= "AND a.prix_unitaire = '$prix_unitaire' ";


            $sql = "SELECT Nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, images,
            date_expiration, id_categorie, a.id FROM articles AS a, categorie_article AS c WHERE a.id_categorie=c.id $search";
            $req = $GLOBALS ['connexion']->prepare($sql);

            $req ->execute();
            return $req->fetchAll();

    } else{
        $sql = "SELECT Nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, images,
         date_expiration, id_categorie, a.id FROM articles AS a, categorie_article AS c WHERE a.id_categorie=c.id";
        $req = $GLOBALS ['connexion']->prepare($sql);

        $req ->execute();
    return $req->fetchAll();
    }  
}

//fonction client
function getClient($id=null)
{

    if (!empty($id)) {
        $sql = "SELECT * FROM clients WHERE id=?";
        $req = $GLOBALS ['connexion']->prepare($sql);
    
        $req ->execute(array($id));
       return $req->fetch();
    } else{
        $sql = "SELECT * FROM clients";
        $req = $GLOBALS ['connexion']->prepare($sql);

        $req ->execute();
    return $req->fetchAll();
    } 
}

function getVente($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT Nom_article, Nom, Prenom, v.quantite, prix, date_vente, v.id, prix_unitaire, adresse, telephone
         FROM clients AS c, ventes AS v, articles AS a WHERE v.id_articles = a.id AND v.id_clients = c.id AND v.id = ? AND etat=?" ;
        $req = $GLOBALS['connexion']->prepare($sql);
    
        $req->execute(array($id,1));
        return $req->fetch();
    } else {
        $sql = "SELECT Nom_article, Nom, Prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticles
        FROM clients AS c, ventes AS v, articles AS a WHERE v.id_articles = a.id AND v.id_clients = c.id AND etat=?";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));
        return $req->fetchAll();
    }
}

//fonction fournisseur
function getFournisseur($id=null)
{

    if (!empty($id)) {
        $sql = "SELECT * FROM fournisseur WHERE id=?";
        $req = $GLOBALS ['connexion']->prepare($sql);
    
        $req ->execute(array($id));
       return $req->fetch();
    } else{
        $sql = "SELECT * FROM fournisseur";
        $req = $GLOBALS ['connexion']->prepare($sql);

        $req ->execute();
    return $req->fetchAll();
    } 
}

function getCommande($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT Nom_article, Nom, Prenom, co.quantite, prix, date_commande, co.id, prix_unitaire, adresse, telephone
         FROM fournisseur AS f, commande AS co, articles AS a WHERE co.id_articles = a.id AND co.id_fournisseur = f.id AND co.id = ?" ;
        $req = $GLOBALS['connexion']->prepare($sql);
    
        $req->execute(array($id));
        return $req->fetch();
    } else {
        $sql = "SELECT Nom_article, Nom, Prenom, co.quantite, prix, date_commande, co.id, a.id AS idArticles
        FROM fournisseur AS f, commande AS co, articles AS a WHERE co.id_articles = a.id AND co.id_fournisseur = f.id";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();
        return $req->fetchAll();
    }
}

function getAllCommande()
{
    $sql = "SELECT COUNT(*) AS nbre FROM commande";
    $req = $GLOBALS['connexion']->prepare($sql);
    
    $req->execute();
    return $req->fetch();
}

function getAllVente()
{
    $sql = "SELECT COUNT(*) AS nbre FROM ventes WHERE etat=?";
    $req = $GLOBALS['connexion']->prepare($sql);
    
    $req->execute(array(1));
    return $req->fetch();
}

function getAllArticle()
{
    $sql = "SELECT COUNT(*) AS nbre FROM articles";
    $req = $GLOBALS['connexion']->prepare($sql);
    
    $req->execute();
    return $req->fetch();
}

function getAllCA()
{
    $sql = "SELECT SUM(prix) AS prix FROM ventes";
    $req = $GLOBALS['connexion']->prepare($sql);
    
    $req->execute();
    return $req->fetch();
}


function getLastVente()
{

        $sql = "SELECT Nom_article, Nom, Prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticles
        FROM clients AS c, ventes AS v, articles AS a WHERE v.id_articles = a.id AND v.id_clients = c.id AND etat=?
        ORDER BY date_vente DESC LIMIT 10";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));
        return $req->fetchAll();
}

function getMostVente()
{

        $sql = "SELECT Nom_article, SUM(prix) AS prix
        FROM clients AS c, ventes AS v, articles AS a WHERE v.id_articles = a.id AND v.id_clients = c.id AND etat=?
        GROUP BY a.id
        ORDER BY SUM(prix) DESC LIMIT 10";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));
        return $req->fetchAll();
}

function getCategorie($id=null)
{

    if (!empty($id)) {
        $sql = "SELECT * FROM categorie_article WHERE id=?";
        $req = $GLOBALS ['connexion']->prepare($sql);
    
        $req ->execute(array($id));
       return $req->fetch();
    } else{
        $sql = "SELECT * FROM categorie_article";
        $req = $GLOBALS ['connexion']->prepare($sql);

        $req ->execute();
    return $req->fetchAll();
    }

    
}