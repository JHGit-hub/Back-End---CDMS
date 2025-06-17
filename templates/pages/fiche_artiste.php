<?php

/* 

Template de page compléte : detail de la fiche artiste

Paramétres : 
        $user: tableau d'objet de l'utilisateur connecté
        $artist : tableau d'objet de l'artiste connecté

*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Artiste</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="profil">
        <section>
            <a href="deconnecter.php">
                <button>Deconnexion</button>
            </a>
        </section>
        <section>
            <h1>Votre Profil d'Artiste</h1>
            <p><u>Nom</u> : <?= htmlspecialchars($user->get("name")) ?></p><br>
            <p><u>Email</u> : <?= htmlspecialchars($user->get("email")) ?></p><br>
            <p><u>Mot de Passe</u> : *************** </p><br>
            <p><u>Nom de scéne</u> : <?= htmlspecialchars($artist->get("group_name")) ?></p><br>
            <p><u>Présentation</u> : <?= htmlspecialchars($artist->get("presentation")) ?></p><br>
            <p><u>Membres</u> : <?= htmlspecialchars($artist->get("group_members")) ?></p><br>
            <p><u>Genre</u> : <?= htmlspecialchars($artist->get("genre")) ?></p><br>
            <p><u>Description du style de musique</u> : <?= htmlspecialchars($artist->get("music_description")) ?></p><br>
            <p><u>Description du lieu</u> : <?= htmlspecialchars($artist->get("available_place")) ?></p><br>
            <p><u>Region</u> : <?= htmlspecialchars($artist->get("region")) ?></p><br>
            <p><u>Durée du concert</u> : <?= htmlspecialchars($artist->get("duration")) ?></p><br>
            <p><u>Tarif</u> : <?= htmlspecialchars($artist->get("price")) ?></p><br>
            <a href="preparer_form_modif_fiche_artiste.php">
                <button>Modifier la fiche</button>
            </a>
        </section>
        <section>
            <a href="extraire_conversation.php">
                <button>Voir les messages</button>
            </a>
        </section>
    </main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>