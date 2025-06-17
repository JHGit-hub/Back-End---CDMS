<?php 

/* classe user : manipulation de l'objet utilisateur du MCD */


class User extends _model {

    // Description de la structure de l'objet dans le MCD et le MPD

    protected $table = "Users";
    protected $colonnes = ["email", "password", "role", "name"];

    

    function loadFromUser($email){
        // rôle : extraire les données de la bdd concernant l'utilisateur à partir de son email
        // paramètre : 
        //          $email; valeur du email entrée dans le formulaire par method POST
        // retour : true, false sinon


        //construction de la requête:
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE `email` = :email";
        $param = [":email" => $email];

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

    
    function loadFromName($contact_name){
        // rôle : extraire les données de la bdd concernant l'utilisateur à partir de son nom
        // paramètre : 
        //          $contact_name; valeur du nom de l'utilisateur
        // retour : true, false sinon


        //construction de la requête:
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE `name` = :name";
        $param = [":name" => $contact_name];

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

    function verifUser($user){
        // rôle : Verifier que le compte n'existe pas dans la bdd lors de la création de compte
        // paramètre : 
        //          $user: $user: objet User contenant les valeurs du formulaire de création
        // retour: retourne false si aucun compte, true sinon

        // Création d'une requête
        $sql = "SELECT " . $this->sqlConstruct() . " FROM `$this->table` WHERE email = :email";
        $param = [":email" => $user->get("email")];

        // Execution de la requête
        $resultat = bddRequest($sql, $param);

        if ($resultat && $resultat->fetch()) {// on fais un fecth() sur $resultat pour recuperer la ligne ou non
        // Il y a un utilisateur avec cet email et ce mot de passe
        return true;
        } else {
        // Aucun utilisateur trouvé
        return false;
        }
    }
}