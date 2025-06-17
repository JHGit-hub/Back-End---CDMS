<?php

/* 

Template de fragment de page : fragment des messages de la conversation 

Paramétres :
            si nouvelle conversation: 
                                    $user_contact: tableau d'objet utilisateur du nouveau contact
                                    $artist_contact : tableau d'objet artiste du nouveau contact
            si conversation existe: 
                                    $conversation: objet conversation chargé incluant tous les messages

*/

// on verifie l'existence de $conversation["messages"] et qu'elle soit non vide
if(isset($conversation["messages"]) &&  $conversation["messages"] != []):
    foreach($conversation["messages"] as $msg): ?>
        <div class="<?= $msg->get("id_sender") == $id ? "msg_right" : "msg_left"?>">
            <p class="<?= $msg->get("id_sender") == $id ? "msg_send" : "msg_receive"?>">
                <?= htmlspecialchars($msg->get("message")) ?>
            </p>
        <p class="date_msg"><?= htmlspecialchars($msg->get("date")) ?></p>
    </div>
    <?php endforeach ?>
    <div id="scroller"></div>
<?php 
else: ?>
    <div></div>
<?php endif; ?>