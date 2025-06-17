<?php

/*

TEST

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    include "templates/pages/form_connexion.php";
    exit;
};


////// Récupération des paramètres:
$id = 1;

$contact_id = 13;
$contact_role = "artist";

////// Traitement:
// On instancie la classe Message
$message = new Message();

// On extrait la conversation
$conversation = $message->conversationByContact($id, $contact_id, $contact_role);

// On récupére la liste des contacts dont il existe une conversation avec l'utilisateur
$contacts = $message->listByContact($id);

// On récupére la liste des conversations
$liste_conversations = $message->contactByDate($contacts, $id);

echo "<pre>";
echo print_r($liste_conversations);
echo "</pre>";


/*
<input type="hidden" name="contact_name"
value="<?php
if(isset($user_contact) && $user_contact->id()){
echo htmlspecialchars($user_contact->get("name"));
} else if (isset($conversation["contact_name"])) { 
echo htmlspecialchars($conversation["contact_name"]);
}
?>">
*/

