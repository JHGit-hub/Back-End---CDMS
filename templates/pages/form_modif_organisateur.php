<?php

/* 

Template de page compléte : formulaire de modification de la fiche organisateur pre-rempli

Paramétres : 
        $organizer : tableau d'objet de détail de la fiche organisateur
        $user : tableau d'objet des details de l'utilisateur

*/

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Organisateur</title>
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
        <form method="post" action="enregistrer_modif_fiche_organisateur.php">
            <label for="name">
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user->get("name")) ?>">
            </label><br><br>
            <label for="email">
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($user->get("email")) ?>">
            </label><br><br>
            <button type="button" onclick="afficherMotDePasse()">Modifier le mot de passe</button><br><br>
            <div id="modifPassword" style="display: none;">
                <label for="password">Nouveau mot de passe :
                    <input type="password" name="password" id="password" value="">
                </label><br><br>
            </div>
            <label for="city">
                <input type="texte" id="city" name="city" value="<?= htmlspecialchars($organizer->get("city")) ?>"><br><br>
            </label><br><br>
            <label for="place_description">
                <textarea id="place_description" id="place_description" name="place_description" rows="5" cols="40"><?= htmlspecialchars($organizer->get("place_description")) ?></textarea><br><br>
            </label><br><br>
            <input type="submit" value="Valider changement"/>
        </form>
    </section>
</main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>