<?php

/* 

Template de page compléte : formulaire de connexion

Paramétres : 
        néant

*/

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="form">
        <h1>Veuillez vous connecter</h1>
        <form method="post" action="connecter.php">
            <label>
                <input type="text" name="email" placeholder="email" value="<?= htmlspecialchars($_POST["email"] ?? '') ?>" required>
            </label><br><br><br>
            <label>
                <input type="password" name="password" placeholder="password" required>
            </label><br><br><br>
                <input type="submit" value="Se Connecter"/>
        </form><br><br><br>
        <a href="preparer_form_creation.php">
            <button>Créer un nouveau compte</button>
        </a>
    </main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>