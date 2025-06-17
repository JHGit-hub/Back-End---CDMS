<?php 

/* classe organizer : manipulation de l'objet utilisateur du MCD */


class Organizer extends _model {

    // Description de la structure de l'objet dans le MCD et le MPD

    protected $table = "Organizers";
    protected $colonnes = ["user_id", "city", "place_description"];


}