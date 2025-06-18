<?php

/* 

Template de fragement de page : liste des artiste filtrés

Paramétres : 
        $liste_artistes_filtres : tableau d'objet des artistes filtrés 
        on boucle dessus avec $artiste comme index

*/

?>

<?php
    foreach($liste_artistes_filtres as $artiste){
    ?>
    <div class="artists_filtered">
    <h3><?= htmlspecialchars($artiste->get("group_name")) ?></h3>
    <p><u>Présentation</u> : <?= htmlspecialchars($artiste->get("presentation")) ?></p>
    <a href="extraire_fiche_artiste.php?id=<?= $artiste->id() ?>&user_id=<?= $artiste->get("user_id") ?>">
        <button>Voir la fiche</button>
    </a>
    </div>
    <?php
    }
?>