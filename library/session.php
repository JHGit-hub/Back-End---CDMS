<?php

// library de function de gestion de la session

#### 1. logged($id)
// - But : Déclare qu’un utilisateur est connecté en stockant son identifiant dans la session.
// - Utilisation : À appeler après une connexion réussie.
// - Retour : `true` si tout s’est bien passé.

#### 2. logOut()
// - But : Déconnecte l’utilisateur en réinitialisant l’id stocké en session.
// - Utilisation : À appeler lors de la déconnexion.
// - Retour : `true` si la déconnexion a réussi.

#### 3. islogged()
// - But : Indique si un utilisateur est actuellement connecté.
// - Utilisation : Pour sécuriser des pages ou des actions réservées aux utilisateurs connectés.
// - Retour : `true` si la session contient un id utilisateur, sinon `false`.

#### 4. loggedInUser()
// - But : Récupère l’objet utilisateur correspondant à la personne actuellement connectée.
// - Utilisation : Pour accéder à toutes les infos de l’utilisateur courant.
// - Retour : Un objet `User` chargé si un utilisateur est connecté, un objet vide sinon.

#### 5. idConnected()
// - But : Retourne l’id de l’utilisateur connecté, ou 0 si personne n’est connecté.
// - Utilisation : Associer des actions à l’id utilisateur.
// - Retour : L’id (entier) ou 0.

#### 6. validateLogin($email, $password)
// - But : Valide les identifiants (email et mot de passe) lors de la tentative de connexion.
// - Utilisation : Lors de la soumission d’un formulaire de connexion.
// - Retour : Un objet `User` si la connexion est valide, sinon `false`.


function logged($id) {
    // Rôle : déclarer qu'un utilisateur est connecté
    // Paramètres : 
    //      $id : id de l'utilisateur
    // Retour : true si réussi, false sinon

    $_SESSION["id"] = $id;
    return true;
}

function logOut() {
    // Rôle : déconnecter l'utilisateur connecté
    // Paramètres : néant
    // Retour : true si réussi false sinon

    $_SESSION["id"] = 0;
    return true;
}

function islogged() {
    // Rôle : indiquer si un utilisateur est connecté
    // Paramètres : néant
    // Retour : true si une conection est active; false sinon

    return (!empty($_SESSION["id"]));
}

function loggedInUser() {
    // Rôle : Récupérer l'utlisateur connecté (moi)
    // Paramètres  : néant
    // Retour : objet utiisateur, chargé avec l'utilisateur connecté, ou non chargé

    if (islogged()) {
        return new User($_SESSION["id"]);
    } else {
        return new User();
    }
}

function idConnected(){
    // Rôle: renvoi l'id de l'utilisateur connecté ou 0
    // Paramètre:
    //          néant
    // Retour: 0 ou l'id

    if (islogged()) {
        return $_SESSION["id"];
    } else {
        return 0;
    }
}

function validateLogin($email, $password){
    // rôle : valider la connection en verifiant la combinaison email et password
    // paramêtre : 
    //              $password: mot de passe entré dans le formulaire par method POST
    //             $email: email entré dans le formulaire par method POST
    // retour : objet User si connexion réussie, false sinon

    // Chargement des informations de l'utilisateur dont on a l'email
    $user = new User;
    $user->loadFromUser($email);

    // On verifie qu'il existe
    if(!$user->is()){
        return false;
    }

    // On récupére le mot de passe hashé
    $password_hashed = $user->get("password");

    // On verifie la concordance avec le mot de passe
    if(password_verify($password,$password_hashed)){
        return $user; // connexion réussi
    } else {
        return false;
    }
}