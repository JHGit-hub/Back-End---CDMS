<?php

/* 

Template de page compléte : detail de la fiche artiste visible par l'organisateur

Paramétres : 
        $artist : tableau d'objet des details de la fiche de l'artiste

*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de <?= $artist->get("group_name") ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="conv_artist">
        <div id="detail_artist">
            <div>
                <a href="preparer_form_recherche.php">
                    <button>Retour Liste</button>
                </a>
            </div>
            <div>
                <h1><?= htmlspecialchars($artist->get("group_name")) ?></h1><br>
                <p><u>Présentation</u> : <?= htmlspecialchars($artist->get("presentation")) ?></p>
                <p><u>Membres</u> : <?= htmlspecialchars($artist->get("group_members")) ?></p><br>
                <p><u>Genre</u> : <?= htmlspecialchars($artist->get("genre")) ?></p>
                <p><u>Description du style de musique</u> : <?= htmlspecialchars($artist->get("music_description")) ?></p><br>
                <p><u>Description du lieu</u> : <?= htmlspecialchars($artist->get("available_place")) ?></p>
                <p><u>Region</u> : <?= htmlspecialchars($artist->get("region")) ?></p><br>
                <p><u>Durée du concert</u> : <?= htmlspecialchars($artist->get("duration")) ?></p>
                <p><u>Tarif</u> : <?= htmlspecialchars($artist->get("price")) ?></p><br>
            </div>
            <div>
                <button type="button" onclick="VerifConversation(<?= $artist->id() ?>)">Contacter</button>
                <a href="index.php">
                    <button>Retour Accueil</button>
                </a>
            </div>
        </div>
        <div id="conversation"></div>
    </main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>