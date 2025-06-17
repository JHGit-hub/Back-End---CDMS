<?php

/*

controleur

rôle : déconnecter la session
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
// Suppression de la session
logOut();

////// Affichage de la page
include "index.php";
