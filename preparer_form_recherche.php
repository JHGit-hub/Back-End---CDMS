<?php

/*

controleur

rôle : préparer la page du formulaire de recherche par filtre
paramétre: 
            néant

Retour : néant

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    include "templates/pages/form_connexion.php";
    exit;
};

////// Récupération des paramètres:

////// Traitement:
// On instancie Artist
$artists = new Artist();

// On charge tous les artistes
$liste_artistes = $artists->getAll();

////// Affichage de la page
include "templates/pages/form_recherche.php";