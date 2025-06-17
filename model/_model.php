<?php

/* Classe _model : manipulation d'un objet générique du MCD */

// La clé primaire s'appelle id


class _model {

    
    // Attributs
    protected $table = "";          // nom de la table
    protected $colonnes = [];       // Liste simple des colonnes, sauf l'id

    protected $valeurs = [];        // stockage des valeurs des attributs
    protected $id;                  // Stockage de l'id


    function __construct($id = null) {
        // Rôle : constructeur : charger une ligne de la BDD si on précise un id
        // Paramètre :
        //      $id (facultatif) : id de la ligne à charger

        if (! is_null($id)) {
            $this->loadFromId($id);
        }
    }

    function is() {
        // Rôle : indiquer si l'objet est chargé ou non
        // Paramètres : néant
        // Retour : true si l'objet est chargé, false sinon

        return ! empty($this->id);

    }

    function id() {
        // Rôle : retourner l'id de l'objet dans la BDD ou 0
        // Paramètres : néant
        // Retour : la valeur de l'id ou 0

        return $this->id;
    }

///////////// Getters
    function get($nomColonne) {
        // Rôle : Getters; Récupérer la valeur d'une colonne
        // Paramètres : 
        //      $nomColonne : nom de la colonne à récupérer
        // Retour : valeur de la colonne ou valeur par défaut (chaine vide)

        // On Vérifie que $nomColonne est bien une colonne qui existe sinon on retourne vide
        if ( ! in_array($nomColonne, $this->colonnes)){
            return "";
        }

        // On verifie qu'il y ai une valeur
        if (isset($this->valeurs[$nomColonne])) {
            // On a un valeur : on la retourne
            return $this->valeurs[$nomColonne];
        } else {
            return "";
        }
    }

///////////// Setters
    function set($nomColonne, $valeur) {
        // Rôle : Setter; donne ou modifie la valeur d'une colonne
        // Paramètres :
        //      $nomColonne : nom de la colonne concerné
        //      $valeur : nouvelle valeur de la colonne
        // Retour : true si ok, false sinon

        // Vérification si $nomColonne est une colonne, si n'existe pas, on retourne false
        if ( ! in_array($nomColonne, $this->colonnes)){
            return false;
        }

        // On met la valeur dans le tableau des valeurs
        $this->valeurs[$nomColonne] = $valeur;
        return true;

    }

///////////// Méthodes d'accés à la base de donnés
    function loadFromId($id) {
        // Rôle : Extraire les données d'un objet à partir de son id
        // Paramètre :
        //          $id: clé primaire de l'objet
        // Retour: true si succés et rempli le tableau $this->valeurs, false sinon


        // Construire la requête : SELECT en utilisant sqlConstruct
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE `id` = :id";

        // Extraire la première ligne
        $tab = bddGetFirstLigne($sql, [ ":id" =>  $id ]);

        // On verifie le cas d'échec
        if (!$tab) {
            $this->valeurs = [];
            $this->id = null;
            return false;
        }

        // On a un objet : on remplit donc les valeurs avec les données du tableau
        $this->loadFromTab($tab);
        $this->id = $id;
        return true;

    }

    function update() {
        // Rôle : mette à jour l'objet courant dans la BDD
        // Paramètres : néant
        // Retour : true si ok, false sinon

        // Si l'objet n'est pas chargé : on refuse
        if (! $this->is()) {
            return false;
        }

        // On ignore le champ password s'il est vide ou null
        if (array_key_exists('password', $this->valeurs) &&
            ($this->valeurs['password'] === null || $this->valeurs['password'] === "")) {
            unset($this->valeurs['password']);
        }

        return bddUpdate($this->table, $this->valeurs, $this->id);
    }

    function insert() {
        // Rôle : créer l'objet courant dans la BDD
        // Paramètres : néant
        // Retour : true si ok, false sinon

        // Si l'objet est chargé : on refuse
        if ($this->is()) {
            return false;
        }

        $id = bddInsert($this->table, $this->valeurs);

        // On verifie le succés de l'opération
        if (empty($id)) return false;

        // On retourne la clé primaire
        $this->id = $id;
        return true;

    }

    function delete() {
        // Rôle : supprimer l'objet courant de  la BDD
        // Paramètres : néant
        // Retour : true si ok, false sinon

        // Si l'objet n'est pas chargé : on refuse
        if (! $this->is()) {
            return false;
        }

        $resultat = bddDelete($this->table, $this->id);

        // On verifie le succés de l'opération
        if (!$resultat) return false;

        // On vide l'id et on retourne true 
        $this->id = null;
        return true;

    }

    function getAll() {
        // Rôle : récupérer tous les objets de ce type dans la BDD
        // Paramètres : néant
        // Retour : list (tableau indexé) d'objet de cette nature, indexé par l'id

        // Construire la requête : SELECT
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table`";

        // Extraction des lignes :
        $tab = bddGetAll($sql);

        // Transformation du tableau de tableau en un tableau d'objets
        return $this->tblTransform($tab);

    }

    function loadFromField($champ, $valeurChamp){
    // rôle : extraire les données de la bdd concernant l'utilisateur à partir d'un champ spécifique
    // paramètre : 
    //          $champ: champ à partir du quel on veux charger les données objets
    //          $valeurChamp: la valeur du champ concerné
    // retour : true, false sinon


    //construction de la requête:
    $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE `$champ` = :valeur";
    $param = [":valeur" => $valeurChamp];

    // Extraire la première ligne
    $ligne = bddGetFirstLigne($sql, $param);

    if (empty($ligne)) {
        return false;
    }

    // On a un objet : on remplit donc les valeurs avec les données du tableau
    $this->loadFromtab($ligne);
    $this->id = $ligne["id"];
    return true;
    }



    ///////////// Méthodes utilitaires
    function sqlConstruct(){
        // rôle : construire l'extrait de la commande sql contenant le nom des colonnes
        // paramètres:
        //          néant
        // retour: le texte a concaténer dans la requête sql

        // On créer l'extrait de commande
        $sqlConcatene = "`id`";

        // On boucle avec foreach pour ajouter le nom des colonnes dans l'extrait de commande sql
        foreach($this->colonnes as $nomColonne){
            $sqlConcatene .= ", `$nomColonne`";
        }
        return $sqlConcatene;
    }

    function loadFromTab($tab) {  
        // Rôle : extraire les valeurs des colonnes dans un tableau indexé par les noms des colonnes (sauf l'id)
        // Paramètres :
        //      $tab : tableau indexé comportant en index le noms des colonnes de cet objet et leurs valeurs
        // Retour : true si ok, false sinon

        // On verifie que si on a une valeur dans le tableau 
        // on donne cette valeur a la bonne colonne
        foreach ($this->colonnes as $nomColonne) {
            if (isset($tab[$nomColonne])){
                $valeur = $tab[$nomColonne];

                // On ignore le champ "password" s'il est vide (car non modifier)
                if ($nomColonne === "password" && $valeur === "") {
                    continue;
                }

                //Si la valeur est une chaine vide, on la converti en NULL
                if($valeur === ""){
                    $valeur = NULL;
                };

                // On affecte la valeur au champ avec le setter
                $this->set($nomColonne, $valeur);
            }
        }
        return true; 

    }

    function tblTransform($tab) {
        // Rôle : transformer un tableau de tableaux en un tableau d'objet
        // Paramètres :
        //          $tab : le tableau à transformer
        // Retour : tableau d'objets de la classe courant, indexé par l'id

        // On part d'un tableau de résultat vide
        $resultat = [];
        // Pour chaque élément de $tab 
        foreach ($tab as $element) {
            // On créée un objet de la class courante enfant de _model
            $objet = new static();

            // On charge les valeurs des colonnes
            $objet->loadFromTab($element);

            // On charge l'id
            $objet->id = $element["id"];

            // On l'ajoute à $resultat au bon index
            $resultat[$objet->id()] = $objet;

        }
        return $resultat;

    }
}
