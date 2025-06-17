<?php 

/* classe user : manipulation de l'objet Message du MCD */


class Message extends _model {

    // Description de la structure de l'objet dans le MCD et le MPD

    protected $table = "Messages";
    protected $colonnes = ["date", "message", "id_sender", "id_receiver", "msg_read"];


    function listByContact($id){
        // rôle : Extraire la liste des personnes avec qui une conversation existe
        //          en utilisant les clés étrangéres entre les tables
        // paramètre : $id; id du propriétaire de la SESSION
        //              
        //  retour : tableau de tableaux incluant l'id, le role et le nom

        
        // creation de la requête $sql
        $sql = "SELECT DISTINCT Users.id, Users.role, Users.name FROM Messages 
        JOIN Users ON (Users.id = Messages.id_sender OR Users.id = Messages.id_receiver)
        WHERE (Messages.id_sender = :id OR Messages.id_receiver = :id) AND Users.id != :id";

        $param = [":id" => $id];

        // On execute la requête
        $resultat = bddGetAll($sql, $param);

        // Verification du résultat
        if(!$resultat) return [];

        // On va remplacer le nom de l'utilisateur par son nom de scéne si c'est un artiste
        foreach($resultat as &$ligne){
            if($ligne["role"] === "artist"){ // si c'est un artiste
                $sqlArtistName = "SELECT group_name FROM Artists WHERE user_id = :id"; // on va chercher son nom de scene
                $paramArtistName = [":id" => $ligne["id"]];

                $res = bddGetFirstLigne($sqlArtistName, $paramArtistName);
                if($res && isset($res["group_name"])){ // si $res existe s'il y a un nom de scéne qui existe
                    $ligne["name"] = $res["group_name"]; // on remplace le nom d'utilisateur par nom de scéne
                }
            }
        }

        // On retourne le resultat
        return $resultat;
        
    }


    function contactByDate($contacts, $id){
        // rôle : Extraire la liste des messages les plus récent 
        //      en fonction du correspondant (id_sender ou id_receiver) 
        //      et  du propriétaire de la SESSION
        // paramètre : $contacts : tableau des correspondant du propriétaire de la SESSION avec qui 
        //                  une conversation existe (obtenu avec listByContact)
        //             $id : id du propriétaire de la SESSION
        // retour : tableau d'objet incluant les noms, les roles, les id, les message 
        //                  le statut "lu" ou pas, et les date des plus récents trié par correspondant


        // Création du tableau
        $liste_conversations = [];

        // On fais une boucle pour extraire chaque premiére ligne de la requête pour chaque id contenu dans $contact

        foreach($contacts as $contact){
            $contact_id = $contact["id"]; // id du contact
            $contact_role = $contact["role"]; // role du contact
            $contact_name = $contact["name"]; // nom du contact

            // construction de la requête
            $sql = "SELECT " . $this->sqlConstruct() . " FROM Messages 
            WHERE ((id_sender = :session_id AND id_receiver = :contact_id)
            OR (id_sender = :contact_id AND id_receiver = :session_id)) 
            ORDER BY `date` DESC";
            $param = [":session_id" => $id, ":contact_id"=>$contact_id];

            // Execution de la requête
            $req =  bddRequest($sql, $param);

            
            // On récupére la première ligne
            if($req){
                // ligne du message le plus récent issu de la table message entre le propriétaire de la sesssion et son correspondant
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            };

            // On remplie le tableau uniquement si $ligne n'est pas vide
            if($ligne){
                $ligne['contact_id'] = $contact_id;
                $ligne['contact_role'] = $contact_role;
                $ligne['contact_name'] = $contact_name;
                $liste_conversations[] = $ligne;
            }

        }
        return $liste_conversations;

    }

    function conversationByContact($id, $contact_id, $contact_role = "artist"){
        // rôle : Extraire tous les messages issu d'une conversation entre le propriétaire de la SESSION et son correspondant
        // paramètre : $id : id du propriétaire de la SESSION
        //              $contact_id : id du correspondant
        //              $contact_role : role du correspondant (artist ou organizer)
        // retour : tableau d'objet des conversations classé par date ou rien sinon

        // Identification du correspondant
        if($contact_role === "organizer"){
            $sqlContact = "SELECT `name` FROM Users WHERE id = :contact_id";
        } else {
            $sqlContact = "SELECT `group_name` FROM Artists WHERE user_id = :contact_id";
        }
        $paramContact = [":contact_id"=>$contact_id];

        // Extraction de la ligne
        $contact = bddGetFirstLigne($sqlContact, $paramContact);

        // On crée une requête pour recupérer tous les messages entre les 2 correspondants
        $sqlMsg = "SELECT " . $this->sqlConstruct() . " FROM `$this->table`
        WHERE ((id_sender = :session_id AND id_receiver = :contact_id)
            OR (id_sender = :contact_id AND id_receiver = :session_id))
            ORDER BY `date`";
        $paramMsg = [":session_id" => $id, ":contact_id"=>$contact_id];

        // Extraction des lignes :
        $tabMsg = bddGetAll($sqlMsg, $paramMsg);
        if($tabMsg === []){
            return false;
        }

        // On marque comme lu les messages reçu par l'utilisateur qui ne le sont pas
        $this->markMessagesAsRead($id, $contact_id);
      
        // On retourne les 2 tableaux
        if($contact_role === "organizer"){
            return [
                "contact_id" => $contact_id,
                "contact_name" => $contact["name"],
                "messages" => $this->tblTransform($tabMsg)
            ];
        } else {
            return [
                "contact_id" => $contact_id,
                "contact_name" => $contact["group_name"],
                "messages" => $this->tblTransform($tabMsg)
            ];
        };
        
    }

    function newMessage($id_sender, $id_receiver, $message){
        // rôle : Enregistrer un nouveau message dans la table message
        // paramètre : $id_sender: id du propriétaire de la session
        //              $id_receiver : id du destinataire du message
        //              $message: message a enregistrer

        // construire la requête
        $sql = "INSERT INTO `Messages`(`message`, `id_sender`, `id_receiver`) VALUES (:message, :id_sender, :id_receiver)";
        $param = [":id_sender" => $id_sender, ":id_receiver" => $id_receiver, ":message" => $message];

        // Execution de la requête
        $req =  bddRequest($sql, $param);

        return $req !== false;

    }

    function markMessagesAsRead($id, $contact_id) {
        // rôle : marquer les messages de la conversation reçu comme lu lorsque qu'on ouvre la conversation
        // paramètres:
        //          $id: id de l'utilisateur
        //          $contact_id : id du correspondant
        // retour: ture si succés, false sinon
        $sqlUpdateMsg = "UPDATE `Messages` SET msg_read = 1
                WHERE id_receiver = :id_receiver
                AND id_sender = :id_sender
                AND msg_read = 0";
        $paramUpdateMsg = [
            ':id_receiver' => $id,
            ':id_sender' => $contact_id
        ];
        return bddRequest($sqlUpdateMsg, $paramUpdateMsg) !== false;
    }

}