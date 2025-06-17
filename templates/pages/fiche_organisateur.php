<?php

/* 

Template de page compléte : detail de la fiche organisateur

Paramétres : 
        $user: tableau d'objet de l'utilisateur connecté
        $organizer : tableau d'objet de l'organisateur connecté

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
<main class="profil">
    <section>
        <a href="deconnecter.php">
            <button>Déconnexion</button>
        </a>
    </section>
    <section>
        <h1>Votre Profil d'Organisateur</h1>
        <p><u>Nom</u> : <?= htmlspecialchars($user->get("name")) ?></p><br>
        <p><u>Email</u> : <?= htmlspecialchars($user->get("email")) ?></p><br>
        <p><u>Mot de Passe</u> : *********** </p><br>
        <p><u>Ville</u> : <?= htmlspecialchars($organizer->get("city")) ?></p><br>
        <p><u>Description du lieu</u> : <?= htmlspecialchars($organizer->get("place_description")) ?></p><br>
        <a href="preparer_form_modif_fiche_organisateur.php">
            <button>Modifier la fiche</button>
        </a>
    </section>
    <section>
        <a href="extraire_conversation.php">
            <button>Voir les messages</button>
        </a>
    </section>
    <section>
        <a href="preparer_form_recherche.php">
            <button>Rechercher</button>
        </a>
    </section>
</main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>