<?php

/*
Librairie de fonctions d'accès à la Base de données

Les fonctions s'appuient sur $bdd, variable globale contenant un objet PDO initialisé sur la bonne base

*/

function bddRequest($sql, $param = []){
    // rôle :préparer et executer une requête
    // paramètres:
    //          $sql: texte de la commande $sql a executer et preparer
    //          $param : tableau des paramètres de la commande $sql ( vide si non préciser)
    // retour: la requête préparer et executer, false sinon

    // Préparer la requête
    global $bdd;
    $request = $bdd->prepare($sql);

    // Verifier si la préparation s'est bien executer
    if (!$request) {
        return false;
    }

    // Executer la requête
    $execute = $request->execute($param);

    // Verifier la bonne execution de la requête
    if(!$execute){
        return false;
    }

    return $request;

}

function bddGetFirstLigne($sql, $param =[]){
    // rôle : retourne la premiére ligne récupérer par un select sous forme d'un tableau indéxé
    // paramètres:
    //          $sql : texte de la commande $sql
    //          $param : tableau des paramètres de la commande $sql ( vide si par préciser)
    // retour: la premiére ligne récupérée ou false sinon

    // Préparer la requête
    $request = bddRequest($sql, $param);

    // Verifier la bonne execution de la requête pour eviter les erreurs avec fetch
        if ($request === false) {
        return false;
    }

    // Récupération de la premiére ligne
    $firstLigne = $request->fetch(PDO::FETCH_ASSOC);

    // Verifer que $fisrtLigne n'est pas vide
    if(!$firstLigne){
        return false;
    }

    return $firstLigne;

}

function bddGetAll($sql, $param =[]){
    // rôle : retourne toutes les lignes d'un SELECT sous forme d'un tableau de tableaux associatifs
    // paramètres:
    //          $sql : texte de la commande $sql
    //          $param : tableau des paramètres de la commande $sql ( vide si par préciser)
    // retour: tableau de tableaux associatifs, ou vide sinon
    
    // Préparer la requête
    $request = bddRequest($sql, $param);

    // Verifier la bonne execution de la requête pour eviter les erreurs avec fetchAll
    if ($request === false) {
        return [];
    }

    // Récupération de toutes les lignes
    return $request->fetchAll(PDO::FETCH_ASSOC);

}

function bddSqlConstruct($valeurs){
    // rôle : Construire l'extrait de la ligne de commande $sql avec pour chaque colonne de la table son nom;
    //           " `$nomColonne` = :$nomColonne " en les séparant par une virgule.
    //          Et ajouter dans le tableau des paramétres les valeurs des colonnes selon leurs noms; :$nomColonne => valeur
    // paramétres:
    //          $valeurs : tableau contenant les valeurs des colonnes
    // retour : extrait de ligne de commande $sqlConstruct et le tableau des paramètres $param

    // Création du tableau de paramètre vide
    $param = [];

    // Création de $sqlConstruct vide
    $sqlConstruct = "";

    // On doit créer la commande sql en ajoutant, pour chaque colonne de la table son nom; " `$nomColonne` = :$nomColonne " 
    // en les séparant par une virgule.
    // Et ajouter dans le tableau des paramétres les valeurs des colonnes selon leur nom
    // :$nomColonne => valeur

    // Ecriture de la ligne de commande en fonction des noms des colonnes et de leurs valeurs
    $tab = []; // tableau contenant le nom des colonnes et leurs valeurs

    foreach($valeurs as $nomColonne => $valeurColonne){
        $tab[] = "`$nomColonne` = :$nomColonne";
        $param[":$nomColonne"] = $valeurColonne;
    }

    // On concaténe les éléments du tableau à $sqlConstruct
    $sqlConstruct .= " SET " . implode(", ", $tab);

    return [
        "sql" => $sqlConstruct,
        "param" => $param
    ];

}

function bddInsert($table, $valeurs){
    //  rôle : Insérer une nouvelle ligne dans la base de données
    //  paramètres:
    //          $table : nom de la table de la bdd concernée
    //          $valeurs : tableau contenant les valeurs des colonnes
    // retour: la clé primaire ou 0 si échec
    

    // Création du tableau de paramètre vide
    $param = [];

    // On construit l'extrait de commande sql et le tableau de paramètre
    $construct = bddSqlConstruct($valeurs);

    $sqlConstruct = $construct["sql"];
    $param = $construct["param"];

    // Construction de la commande $sql INSERT
    $sql = "INSERT INTO `$table` " . $sqlConstruct;

    // On utilise bddRequest()
    $request = bddRequest($sql, $param);

    // Verifier la bonne execution de la requête
    if ($request === false) {
        return 0;
    }

    // Si succés, on retourne la valeur de la clé primaire nouvellement créée
    global $bdd;
    return $bdd->lastInsertId();

}

function bddUpdate($table, $valeurs, $id){
    // rôle : mettre à jour une ligne dans la base de données
    // paramètres:
    //          $table: nom de la table
    //          $valeurs: tableau contenant les valeurs des colonnes
    //          $id: valeur de la clé primaire
    // retour: true si ok, false sinon


    // Création du tableau de paramètre vide
    $param = [];

    // On construit l'extrait de commande sql et le tableau de paramètre
    $construct = bddSqlConstruct($valeurs);

    $sqlConstruct = $construct["sql"];
    $param = $construct["param"];

    // Construction de la commande $sql UPDATE
    $sql = "UPDATE `$table` " . $sqlConstruct;

    // Ajouter la clause WHERE et le paramètre :id
    $sql .= " WHERE `id` = :id";
    $param[":id"] = $id;

    // On utilise bddRequest()
    $request = bddRequest($sql, $param);

    //Verification du résultat de
    return $request !== false;

}

function bddDelete($table, $id){
    // rôle : supprimer une ligne de la bdd
    // paramètres:
    //           $table: nom de la table
    //           $id: valeur de la clé primaire
    // retour: true si ok, false sinon

    // Construire la requête SQL et le tableau de paramètres
    $sql = "DELETE FROM `$table`  WHERE `id` = :id";
    $param = [ ":id" => $id ];

    // préparer et exécuter la requête
    $request = bddRequest($sql, $param);

    //Verification du résultat de
    return $request !== false;

}
