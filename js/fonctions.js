/*
Librairies des fonctions spécifiques générales du projet
*/


window.addEventListener('DOMContentLoaded', function() {
    majListeConversation();
    setInterval(majListeConversation, 10000); // Mise a jour des conversations toutes les 10 secondes

    majMessages();
    setInterval(majMessages, 2000); // Mise a jour des messages toutes les 2 secondes
});


function recupererConversation(divConv, contact_id, contact_role){
    // rôle :   demander au serveur les messages avec le correspondant
    //          retirer la classe unread a la division cliquée
    // paramètre:
    //          contact_id: id du correspondant
    //          contact_role : role du correspondant
    // retour: renvoi la conversation sous forme de text hmtl vers afficherConversation()

    // Retirer la classe unread sur le div cliqué
    divConv.classList.remove('unread');

    // Construire l'URL a appeler
    let url = "ajax_recuperer_detail_conversation.php?contact_id=" + contact_id + "&contact_role=" + contact_role;
    fetch(url)
        .then(function(response){
            return response.text();
        })
        .then(htmlRetourAjax => {
            majListeConversation();
            afficherConversation(htmlRetourAjax);
        });

}

function afficherConversation(fragment){
    // rôle : affiche dans le cadre  #conversation le contenu html reçu
    // paramètre : fragment; code HTML à afficher
    // retour: néant

    document.getElementById("conversation").innerHTML = fragment;

    // On ajoute le listener sur le form
    // document.addEventListener("DOMContentLoaded", function() {
    // document.getElementById('form_msg').addEventListener('submit', nouveauMessage);
    // });

    // Obliger le scroll a être en bas de la div par defaut,
    // pour que les messages les plus récents soient les premiers visibles
    setTimeout(function() {
        var scroller = document.getElementById('scroller');
        if(scroller) scroller.scrollIntoView({behavior: "auto"});
    },30);
}

function VerifConversation(artist_id){
    // rôle : demander au serveur si la la conversation avec l'artiste existe
    // paramètre: 
    //          $artist_id; id de l'artiste avec qui on veut converser
    // retour: si existe: renvoi la conversation sous forme de text hmtl vers recupererConversation()
    //          sinon: renvoi vers nouvelleConversation()


    // On construit l'url a appeler
    const url = "ajax_verifier_conversation.php?artist_id=" + artist_id;

    fetch(url)
    .then(function(response){
        return response.json();
    })
    .then(function(data){
        //Vérification des droits
        if(data.error === "Non connecté") {
            window.location.href = data.redirect; // Redirige vers la page de connexion
            return;
        }
        // Verification de l'existance de la conversation
        if (data.existe) {
            // Le conversation existe
            recupererConversation(data.contact_id, "artist"); //On sait que le contact est un artiste car 
            // seul les organisateurs peuvent créer une nouvelle discution
        } else {
            // La conversation n'existe pas
            nouvelleConversation(data.contact_id);
        }
    })
}


function nouvelleConversation(user_id){
    // rôle : créer une nouvelle conversation
    // paramètre:
    //          user_id: id de l'artiste dans la table User
    // retour: créer un fragment vide pour à afficher

    // Construire l'URL a appeler
    let url = "ajax_afficher_nouvelle_conversation.php?user_id=" + user_id;
    fetch(url)
        .then(function(response){
            return response.text();
        })
        .then(function(fragment){
            document.getElementById("conversation").innerHTML = fragment;
        });
}

function nouveauMessage(event){
    // rôle : demander au serveur d'enregistrer le nouveau message
    // paramètre : contact_id du correspondant
    //              texte du message
    // retour : néant
    event.preventDefault(); // on empeche l'envoi du formulaire 
    // On recupére le message dans le form et l'id du correspondant
    const message = document.querySelector('textarea[name="message"]').value;
    const contact_id = document.querySelector('input[name="contact_id"]').value;

    // Construire l'URL a appeler
    let url = "ajax_enregistrer_message.php?message=" + encodeURIComponent(message) + "&contact_id=" + encodeURIComponent(contact_id);

    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //Vérification des droits
            if(data.error === "Non connecté") {
                window.location.href = data.redirect; // Redirige vers la page de connexion
                return;
            }
            majMessages() // recuperer la mise a jour des messages
            recupererConversation(data.contact_id, data.contact_role) // afficher les messages
        });
}

function afficherMotDePasse(){
    document.getElementById("modifPassword").style.display = "block";
}

function majListeConversation() {
    // rôle: mettre a jour la liste des conversations toutes les 10 secondes ou manuellement au click
    // paramètre: 
    //           néant
    // retour: renvoi vers le HTML avec la mise a jour dans le framgent frag_liste_conversations
    
    let url ="ajax_maj_conversations.php";

    fetch(url)
        .then(function(response){ // on interroge le controleur ajax et nous renvoi une repoqsne sous forme de HTML
            return response.text();
        })
        .then(htmlRetourAjax => {
            let listeMaj = document.getElementById("liste-conversations");
            if (listeMaj) {
                listeMaj.innerHTML = htmlRetourAjax;
            }
        });
}

function majMessages() {
    // rôle: mettre a jour la liste des messages de la conversation toutes les 2 secondes ou manuellement a l'envoi d'un message
    // paramètre: 
    //           néant
    // retour: renvoi vers le HTML avec la mise a jour dans le framgent frag_msg_conversations 

    let msgList = document.getElementById("msg_list");
    if(!msgList) return; // on arrete le function si msgList n'existe pas

    let contact_id = msgList.dataset.contactId;
    let contact_role = msgList.dataset.contactRole;


    let url = "ajax_maj_messages.php?contact_id=" + encodeURIComponent(contact_id) + "&contact_role=" + encodeURIComponent(contact_role);
    fetch(url)
        .then(response => response.text())
        .then(htmlRetourAjax => {
            let msgList = document.getElementById('msg_list');
            if(msgList) {
                msgList.innerHTML = htmlRetourAjax;
                // Scroll à la fin si besoin
                setTimeout(function() {
                    var scroller = document.getElementById('scroller');
                    if(scroller) scroller.scrollIntoView({behavior: "auto"});
                },30);
            }
        });
}
