<?php
/*

controleur

rôle : enregistrer le nouveau message dans la bdd
paramétre: 
            par methode $_GET:
                    $message: le message envoyé
                    $contact_id : id du contact

Retour : true si valide, false sinon

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
$id_sender = $_SESSION["id"];
$message = $_GET["message"] ?? 0;
$id_receiver = $_GET["contact_id"] ?? 0;




////// Traitement:
// On instancie la classe User
$user = new User($id_sender);


// On instancie la classe Message
$new_message = new Message();
$new_message->newMessage($id_sender, $id_receiver, $message);



if($user->get("role") === "organizer"){
    // On prépare la réponse
    $response = ["contact_id" => $id_receiver, "contact_role" => "artist"];

    // on transmet la reponse
    echo json_encode($response);

} else {
    // On prépare la réponse
    $response = ["contact_id" => $id_receiver, "contact_role" => "organizer"];

    // on transmet la reponse
    echo json_encode($response);
}


////// Affichage de la page
header('Content-Type: application/json');