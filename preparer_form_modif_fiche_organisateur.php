<?php

/*

controleur

rôle :  préparer le formulaire de modification de la fiche organisateur pré-rempli
paramétre: 
            néant
            
Retour : $organizer : tableau d'objet de détail de la fiche organisateur
        $user : tableau d'objet de detail de la fiche utilisateur

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
$user_id = $id;


////// Traitement:
// On instancie et charge les tableaux
$user = new User($id);
$organizer = new Organizer($user_id);

////// Affichage de la page
include "templates/pages/form_modif_organisateur.php";