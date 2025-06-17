<?php

/* 

Template de page compléte : formulaire de modification de la fiche artiste pre-rempli

Paramétres : 
        $user : tableau d'objet des details de l'utilisateur
        $artist: tableau d'objet des détail de la fiche artiste

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
<main>
    <section>
        <a href="index.php">
            <button>Retour Acceuil</button>
        </a>
    </section>
    <section>
        <h1>Modifier et valider pour quitter</h1>
        <form method="post" action="enregistrer_modif_fiche_artiste.php">
            <label for="name">Nom:
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user->get("name")) ?>">
            </label><br><br>
            <label for="group_name">Nom de scéne:
                <input type="text" id="group_name" name="group_name" value="<?= htmlspecialchars($artist->get("group_name")) ?>">
            </label><br><br>
            <label for="email">Email:
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($user->get("email")) ?>">
            </label><br><br>
            <button type="button" onclick="afficherMotDePasse()">Modifier le mot de passe</button><br><br>
            <div id="modifPassword" style="display: none;">
                <label for="password">Nouveau mot de passe :
                    <input type="password" name="password" id="password" value="">
                </label><br><br>
            </div>
            <label for="presentation">Présentation:<br>
                <textarea id="presentation" name="presentation" rows="5" cols="40"><?= htmlspecialchars($artist->get("presentation")) ?></textarea><br><br>
            </label>
            <label for="group_members">Membre du groupe:
                <input type="text" name="group_members" id="group_members" value="<?= htmlspecialchars($artist->get("group_members")) ?>">
            </label><br><br>
            <label for="genre">Genre musical:
                <input type="text" name="genre" id="genre" value="<?= htmlspecialchars($artist->get("genre")) ?>">
            </label><br><br>
            <label for="music_description">Style de musique:<br><br>
                <textarea id="music_description" id="music_description" name="music_description" rows="5" cols="40"><?= htmlspecialchars($artist->get("music_description")) ?></textarea><br><br>
            </label>
            <label for="available_place">Lieux disponible:
                <input type="text" name="available_place" id="available_place" value="<?= htmlspecialchars($artist->get("available_place")) ?>">
            </label><br><br>
            <label for="region">Région:
                <input type="text" name="region" id="region" value="<?= htmlspecialchars($artist->get("region")) ?>">
            </label><br><br>
            <label for="duration">Durée du concert:
                <input type="text" name="duration" id="duration" value="<?= htmlspecialchars($artist->get("duration") )?>">
            </label><br><br>
            <label for="price">Prix:
                <input type="text" name="price" id="price" value="<?= htmlspecialchars($artist->get("price")) ?>">
            </label><br><br>
            <input type="submit" value="Valider changement"/>
        </form>
    </section>
</main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>