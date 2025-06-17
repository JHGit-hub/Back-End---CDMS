<?php
session_start();
// Initialisations communes à tous les controleurs 


// mise en place des messages d'erreur
ini_set('display_errors',1);
error_reporting(E_ALL);

// Charger les librairies
include_once "library/bdd.php";
include_once "library/session.php";

// Charger les différentes classes de modèle de données
include_once "model/_model.php";
include_once "model/messages.php";
include_once "model/users.php";
include_once "model/organizers.php";
include_once "model/artists.php";

// ouvrir la BDD dans la variable globale $bdd
global $bdd;
$bdd = new PDO("mysql:host=172.18.0.1;dbname=cdms-juha;charset=UTF8", "cdms-juha", "P*20ugbgni");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING) ;