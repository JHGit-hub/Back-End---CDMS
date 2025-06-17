<?php

/*

controleur

rôle : extraire la liste des articles en fonction des filtres selectionnés
paramétre: 
            $_POST: filtres choisi dans le formulaire

Retour : $liste_artistes_filtres : tableau d'objet des artistes filtrés

*/

////// Initialisation:
include_once "library/init.php";


////// Vérification des droits:
if(! islogged()){
    include "templates/pages/form_connexion.php";
    exit;
};

////// Récupération des paramètres:
$region = $_POST["region"] ?? null; // peut ne pas etre rempli dans la table artiste
$genre = $_POST["genre"] ?? "";

////// Traitement:
// On instancie la classe artistes
$artistes = new Artist();

// On extrait la liste
$liste_artistes_filtres = $artistes->artistsFiltered($region, $genre);


////// Affichage de la page
include "templates/pages/liste_artistes.php";