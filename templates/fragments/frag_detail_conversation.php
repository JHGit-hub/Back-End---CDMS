<?php

/* 

Template de fragment de page : fragment du détail de la conversation 

Paramétres :
            si nouvelle conversation: 
                                    $user_contact: tableau d'objet utilisateur du nouveau contact
                                    $artist_contact : tableau d'objet artiste du nouveau contact
            si conversation existe: 
                                    $conversation: objet conversation chargé incluant tous les messages

*/

?>

<div>
    <h2>
        <?php
            // on verifie si $user_contact existe pour afficher le nom du correspondant
            if(isset($user_contact) && $user_contact->id()){
                echo htmlspecialchars($artist_contact->get("group_name"));
             } else if (isset($conversation["contact_name"])) { 
                echo htmlspecialchars($conversation["contact_name"]);
             };
        ?>
    </h2>
</div>
<div class="msg_list" id="msg_list"
    data-contact-id="<?= htmlspecialchars($conversation['contact_id'] ?? "" ) ?>"
    data-contact-role="<?= htmlspecialchars($conversation['contact_role'] ?? "") ?>">
    <?php
        include "frag_msg_conversations.php";
    ?>
</div>
<div>
    <form id="form_msg">
        <input type="hidden" name="contact_id"
            value="<?php
                if(isset($user_contact) && $user_contact->id()){
                    echo htmlspecialchars($user_contact->id());
                } else if (isset($conversation["contact_id"])) { 
                    echo htmlspecialchars($conversation["contact_id"]);
                }
            ?>">
        <label for="message">
            <textarea id="message" name="message" rows="5" cols="40" placeholder="Votre message"></textarea><br>
        </label>
        <button type="button" onclick="nouveauMessage(event)">Envoyer</button>
    </form>
</div>