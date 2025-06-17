<?php

/*

controleur

rôle : enregistrer les modifications apportés à la fiche artiste
paramètre: 
            $_POST: nouvel valeur des champs

Retour : true si valide, false sinon 

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
// On instancie les classes Artist et User
$artist = new Artist();
$artist->loadFromField("user_id", $id);

$user = new User($id);

// On charge les nouvelles valeurs issues du formulaire
$artist->loadFromTab($_POST);
$user->loadFromTab($_POST);

// Mise à jour du mot de passe uniquement s'il a été modifié
if (!empty($_POST["password"])) {
    $password_hashed = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $user->set("password", $password_hashed);
}


// Met à jour dans la BDD


if ($artist->update() && $user->update()) {
    // La mise à jour a réussi : on affiche la page fiche_artiste.php avec les modifications
////// Affichage de la page
    include "templates/pages/fiche_artiste.php";

} else {
    // Echec mise à jour : on réaffiche le formulaire
    echo "échec de la modification";
////// Affichage de la page
    include "templates/pages/form_modif_artiste.php";
}

