<?php

/* 

Template de fragement de page : liste des artiste filtrés

Paramétres : 
        $liste_artistes_filtres : tableau d'objet des artistes filtrés 
        on boucle dessus avec $artiste comme index

*/

?>
<div class="artists_filtered">
    <h3><?= htmlentities($artiste->get("group_name")) ?></h3>
    <p><u>Présentation</u> : <?= htmlentities($artiste->get("presentation")) ?></p>
    <a href="extraire_fiche_artiste.php?id=<?= $artiste->id() ?>&user_id=<?= $artiste->get("user_id") ?>">
        <button>Voir la fiche</button>
    </a>
</div>