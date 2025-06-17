<?php

/*

controleur

rôle : extraire le détail de la fiche artiste
paramétre: 
            par methode $_GET: user_id : user_id de l'artiste selectionné de la table Artist

Retour : tableau d'objet $artist : tableau d'objet des details de la fiche de l'artiste

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    include "templates/pages/form_connexion.php";
    exit;
};


////// Récupération des paramètres:
$id = $_GET["id"] ?? 0;
$user_id = $_GET["user_id"] ?? 0;

////// Traitement:
// On instancie la classe Artist et charge les données
$artist = new Artist($id);

// On instancie la classe User et charge les données
$user = new User($user_id);


////// Affichage de la page;
include "templates/pages/detail_artiste.php";