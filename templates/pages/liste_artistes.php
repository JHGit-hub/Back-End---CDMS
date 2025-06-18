<?php

/* 

Template de page compléte : liste des artiste filtrés

Paramétres : 
        $liste_artistes_filtres : tableau d'objet des artistes filtrés

*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Artistes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main>
        <section>
        <h1>Liste des artistes qui correspondent à votre recherche</h1>
        <?php
            // afficher la liste des artistes filtrés
            include "templates/fragments/frag_liste_artistes.php";
        ?>
        <?php
            foreach($liste_artistes_filtres as $artiste){
                include "templates/fragments/frag_liste_artistes.php";
            };
        ?>          
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