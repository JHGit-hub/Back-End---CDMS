<?php

/* 

Template de page compléte : liste des conversations entre l'utilisateur et les correspondants

Paramétres : 
        $liste_conversations : tableau simple des conversations

*/

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des conversations</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="liste_conv">
        <div id="liste">
            <h1>Listes des Conversations</h1>
            <section>
                <a href="deconnecter.php">
                    <button>Déconnecter de la session</button>
                </a><br><br>
                <a href="index.php">
                    <button>Retour Accueil</button>
                </a>
            </section>
            <section  id="liste_conversations">
                <?php
                    // afficher la liste des conversations
                    // la variable $liste_conversations est dispoible, je peux appler le fragment
                    include "templates/fragments/frag_liste_conversations.php";
                ?>
            </section>
        </div>
        <div id="conversation">
            <!-- fenetre de conversation afficher par AJAX -->
        </div>
        <script src="js/fonctions.js" type="text/javascript" ></script>
    </main>
<script src="js/fonctions.js" type="text/javascript" ></script>
</body>
</html>