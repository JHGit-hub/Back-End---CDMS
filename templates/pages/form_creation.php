<?php

/* 

Template de page compléte : formulaire de création

Paramétres : 
        néant

*/

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire nouvel utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
   <main>
    <h1>Création d'un nouveau compte</h1>
        <form method="post" action="enregistrer_compte.php">
            <label for="email">Entrez votre Email :
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
            </label><br><br>
            <label for="password">Choisir un mot de passe :
                <input type="password" name="password" id="password" value="" required>
            </label><br><br>
            <label for="name">Votre Nom d'utilisateur :
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
            </label><br><br>
            <label for="role">Votre rôle :
                <select id="role" name="role">
                    <option value="organizer">Organisateur</option>
                    <option value="artist">Artiste</option>
                </select>
            </label><br><br>
            <input type="submit" value="Valider création"/>
        </form>
   </main>
<script src="js/fonctions.js" type="text/javascript" ></script> 
</body>
</html>