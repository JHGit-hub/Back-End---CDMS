<?php

/*

controleur

rôle : si connecter: extraire fiche de l'utilisateur, 
        sinon, préparer le formulaire de connexion
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
}

////// Récupération des paramètres:
$id = $_SESSION["id"];

////// Traitement:
// On verifie le role de l'utilisateur (organisateur ou artiste)
$user = new User($id);
$user_id = $id;

if($user->get("role") === "organizer"){
    // On instancie la classe Organizer et on extrait les valeurs de la ligne de l'utilisateur

    $organizer = new Organizer();
    $organizer->loadFromField("user_id", $user_id);

    // On affiche le template
    include "templates/pages/fiche_organisateur.php";
} else {
    // On instancie la classe Artist et on extrait les valeurs de la ligne de l'utilisateur
    $artist = new Artist();
    $artist->loadFromField("user_id", $user_id);

    // On affiche le template
    include "templates/pages/fiche_artiste.php";
}
