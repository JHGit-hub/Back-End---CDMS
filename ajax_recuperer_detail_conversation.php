<?php
/*

controleur pour Ajax

rôle : recupere le détail de la conversation et prépare son affichage
paramétre: 
        par methode $_GET  avec fetch: 
                    $contact_id, id du contact avec qui on converse
                    $contact_role : role du contact

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


////// Affichage de la page
header('Content-Type: application/json');
include "templates/fragments/frag_detail_conversation.php";