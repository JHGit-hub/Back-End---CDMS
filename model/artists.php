<?php 

/* classe artist : manipulation de l'objet utilisateur du MCD */


class Artist extends _model {

    // Description de la structure de l'objet dans le MCD et le MPD

    protected $table = "Artists";
    protected $colonnes = ["user_id", "group_name", "presentation", "group_members", "music_description", "genre", "available_place", "region", "duration", "price"];


    function artistsFiltered($region = null, $genre = null){
        // rôle : Filtrer la liste des artistes selon des critéres selectionnés dans un formulaire
        // paramètres:
        //          $genre : genre de la musique
        //          $region : égion de répresentation de l'artiste
        // retour : tableaux d'objet des artistes filtrés 

        // Création de la requête
        $sqlFiltered = "SELECT * FROM Artists";
        $paramFiltered = [];
        $conditions = [];

        if (!empty($genre)) {
            $paramFiltered[":genre"] = $genre;
            $conditions[] = "`genre` = :genre";
        }

        if (!empty($region)) {
            $paramFiltered[":region"] = $region;
            $conditions[] = "`region` = :region";
        }

        if(!empty($conditions)){
            $sqlFiltered .= " WHERE " . implode(" AND ", $conditions);
        }
        
        // Exécution
        $resultats = bddGetAll($sqlFiltered, $paramFiltered);

        // Transformation en objets
        return $this->tblTransform($resultats);

    }

    function loadFromArtist($contact_name){
        // rôle : extraire les données de la bdd concernant l'artiste à partir de son nom de scéne
        // paramètre : 
        //          $contact_name; nom de scéne de l'artiste
        // retour : true, false sinon


        //construction de la requête:
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE `group_name` = :group_name";
        $param = [":group_name" => $contact_name];

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

}