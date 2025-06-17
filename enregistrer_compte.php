<?php

/*

controleur

rôle : enregistrer le nouveau compte dans la bdd
paramétre: 
            $_POST: valeur rempli dans formulaire de création de compte

Retour : true si valide, false sinon

*/

////// Initialisation:
include_once "library/init.php";

////// Vérification des droits:

////// Récupération des paramètres:
// On instancie la classe user
$new_user = new User();

// On verifie que le formulaire est correctement rempli
if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["role"]) || empty($_POST["name"])){
    echo "Formulaire non valide"; //affichage d'un message d'erreur
    include "templates/pages/form_creation.php"; // renvoi vers la page du formulaire de création de compte
    exit; // arrete le script si form invalide
} else {
    // Donner les valeurs aux champs de la fiche utilisateur
    $new_user->loadFromTab($_POST);
}

////// Traitement:   
// On verife que l'utilisateur n'existe pas et si oui, on met a jour la bdd, 
//              sinon on le renvoi vers la page de connexion
                                
// On instancie la classe
$old_user = new User();
// On verifie si le compte existe
if($old_user->verifUser($new_user)){
    // l'utilisateur existe dèjà, on renvoi vers la page de connexion
    echo "l'utilisateur existe déjà";
    include "templates/pages/form_connexion.php";
} else { // l'utilisateur n'existe pas
    // On hashe le mot de passe
    $password_none_secure = $new_user->get("password");
    $password_hashed = password_hash($password_none_secure, PASSWORD_DEFAULT);

    // On remplace le mot de passe par sa version hashé
    $new_user->set("password", $password_hashed);
    // Met à jour dans la BDD
    if ($new_user->insert()) {
        echo "Création de compte réussie";
        // La création à réussi : on renvoi vers l'index
        include "index.php";

    } else {
        echo "La création a échoué";
        // Echec création : on réaffiche le formulaire
        include "templates/pages/form_creation.php";
    }
};
