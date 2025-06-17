<?php
/*

controleur pour Ajax

rôle : verifier si une conversation existe
paramétre: 
            $_GET avec fetch: $artist_id, id de l'artiste avec qui ont veux converser

Retour : true si existe, false sinon

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    http_response_code(401);
    echo json_encode(["error" => "Non connecté", "redirect" => "templates/pages/form_connexion.php"]);
    exit;
};


////// Récupération des paramètres:
$id = $_SESSION["id"];
$artist_id = $_GET["artist_id"] ?? 0;

////// Traitement:
// On instancie la classe Artist
$artist = new Artist($artist_id);

$user_id = $artist->get("user_id");

// On instancie la classe Message
$message = new Message();

// On charge $message avec la function conversationByContact
$conv = $message->conversationByContact($id, $user_id);

// On prépare la reponse
$response = [];

// On verifie si la conversation existe et construit la réponse
$response = [
    "id" => $id,
    "existe" => (bool)$conv,
    "contact_id" => $user_id
];

// on transmet la reponse
echo json_encode($response);


////// Affichage de la page
header('Content-Type: application/json');