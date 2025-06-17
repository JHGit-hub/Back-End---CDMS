<?php

/*

controleur

rôle :  préparer le formulaire de modification de la fiche artiste pré-rempli
paramétre: 
            néant
            
Retour : $artist: tableau d'objet de la fiche artiste
        $user : tableau d'objet de detail de la fiche utilisateur

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    include "templates/pages/form_connexion.php";
    exit;
};

////// Récupération des paramètres:
$id = $_SESSION["id"];


////// Traitement:
// On instancie et charge le tableau d'objet User
$user = new User($id);

// On instanci la classe Artist
$artist = new Artist();
$artist->loadFromField("user_id", $id);

////// Affichage de la page
include "templates/pages/form_modif_artiste.php";