<?php

/*

controleur ajax

rôle : extraire les conversations avec la MAJ et péparer son affichage
paramétre: 
            néant

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

////// Traitement:
// On instancie la classe Message
$message = new Message();

// On récupére la liste des contacts dont il existe une conversation avec l'utilisateur
$contacts = $message->listByContact($id);

// On récupére la liste des conversations
$liste_conversations = $message->contactByDate($contacts, $id);


////// Affichage du fragment de page
include "templates/fragments/frag_liste_conversations.php";