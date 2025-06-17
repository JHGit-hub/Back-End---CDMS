<?php
/*

controleur pour Ajax

rôle : préparer une page de conversation vide
paramétre: 
            par methode $_GET : 
                $user_id; user_id de l'artiste de la table Artist

Retour : un fragment HTML (DIV)

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

$user_id = $_GET["user_id"] ?? 0;

////// Traitement:
// On instancie la classe Artist
$artist_contact = new Artist();
$artist_contact->loadFromField("user_id", $user_id);

// On instancie la classe User
$user_contact = new User($user_id);


////// Affichage de la page
header('Content-Type: application/json');
include "templates/fragments/frag_detail_conversation.php";