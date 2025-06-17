<?php

/*

controleur

rôle : verifier les identifiants
paramétre: 
            par methode $_POST: password et email

Retour : true si valide, false sinon

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:


////// Récupération des paramètres:
// On verife si le formulaire est bien rempli
if(empty($_POST["email"]) || empty($_POST["password"])){
    echo "Formulaire non valide"; //affichage d'un message d'erreur
    include "templates/pages/form_connexion.php"; // renvoi vers la page du formulaire
    exit; // arrete le script si form invalide
} else {
    $email = $_POST["email"];
    $password = $_POST["password"];
};

////// Traitement:
// Verification de la connexion
$user = validateLogin($email, $password);

if(!$user){ // connexion refusé, retour au formulaire
    echo "Erreur de connexion";
    include "templates/pages/form_connexion.php";
    exit;
} else { // connexion réussi, on le log à la session
    logged($user->id());
}


////// Affichage de la page
include "index.php";
