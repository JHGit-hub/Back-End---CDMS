<?php

/* 

Template de fragment de page : fragment de la liste des conversations  

Paramétres : 
        $liste_conversations : tableau simple des conversations
        on boucle dessus avec $firstMsg comme index

*/


?>
<?php
foreach ($liste_conversations as $firstMsg) {
    $has_unread = ($firstMsg['msg_read'] == 0 && $firstMsg['id_receiver'] == $id);
    ?>
    <div class="conv<?= $has_unread ? ' unread' : '' ?>"
         onclick="recupererConversation(this, '<?= htmlspecialchars($firstMsg['contact_id']) ?>', '<?= htmlspecialchars($firstMsg['contact_role']) ?>')">
        <h3><?= htmlspecialchars($firstMsg["contact_name"]) ?></h3>
        <p class="date"><?= htmlspecialchars($firstMsg["date"]) ?></p>
    </div>
    <?php
}
?>