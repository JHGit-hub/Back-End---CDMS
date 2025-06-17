<?php

/* 

Template de page compléte : formulaire de recherche

Paramétres : 
        $liste_artistes: tableau d'objet de la liste des artistes

*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de recherche</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main>
        <h1>Cherchez votre concert!</h1>
        <form method="post" action="extraire_liste_artistes_filtres.php">
            <label for="region">Dans quelle région?</label>
                <select id="region" name="region">
                    <option value="">Toutes les régions</option>
                    <?php
                        $no_duplicate_region = [];
                        foreach ($liste_artistes as $artiste) {
                            $region = $artiste->get("region");

                            if (!in_array($region, $no_duplicate_region)) {
                                $no_duplicate_region[] = $region;
                                echo "<option value='" . htmlspecialchars($region) . "'>" . htmlspecialchars($region) . "</option>";
                            }
                        }
                    ?>
                </select><br><br>
            <label for="genre">Quelle genre de musique?</label>
                <select id="genre" name="genre">
                    <option value="">Tous les styles</option>
                    <?php
                        $no_duplicate_genre = [];
                        foreach ($liste_artistes as $artiste) {
                            $genre = $artiste->get("genre");

                            if (!in_array($genre, $no_duplicate_genre)) {
                                $no_duplicate_genre[] = $genre;
                                echo "<option value='" . htmlspecialchars($genre) . "'>" . htmlspecialchars($genre) . "</option>";
                            }
                        }
                    ?>
                </select><br><br>
            <input type="submit" value="Rechercher">
        </form>
        <section>
            <a href="preparer_form_recherche.php">
                <button>Nouvelle Recherche</button>
            </a>
        </section>
        <section>
            <a href="index.php">
                <button>Retour Accueil</button>
            </a>
        </section>
    </main>
<script src="js/fonctions.js" type="text/javascript" ></script>    
</body>
</html>