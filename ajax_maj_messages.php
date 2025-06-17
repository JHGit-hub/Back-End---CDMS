<?php

/*

controleur ajax

rôle : extraire les conversations avec la MAJ et péparer son affichage
paramétre: 
            contact_id : id du correspondant
            contact_role ; role du correspondant

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

$contact_id = $_GET["contact_id"] ?? 0;
$contact_role = $_GET["contact_role"] ?? 0;

////// Traitement:
// On instancie la classe Message
$message = new Message();

// On extrait la conversation
$conversation = $message->conversationByContact($id, $contact_id, $contact_role);


////// Affichage du fragment de page
include "templates/fragments/frag_msg_conversations.php";