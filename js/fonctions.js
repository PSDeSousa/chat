/*
Librairies des fonctions spécifiques générales du projet
*/

//Au clic sur le bouton rechercher utilisateur
const rechercheForm = document.getElementById("rechercheForm");
//Au click sur rechercher : on lance la fonction getIdFromPseudo
rechercheForm.addEventListener("submit", function(e){
    e.preventDefault();
    getIdFromPseudo();
});


//Au clic sur le bouton envoyer message
const messageForm = document.getElementById("messageForm");
//Au click sur rechercher : on lance la fonction getIdFromPseudo
messageForm.addEventListener("submit", function(e){
    e.preventDefault();
    sendMessage();
});




//Rafraichissements
setInterval(getConversations, 10000); // 10 000 millisecondes = 10 secondes
setInterval(getMessages, 2000);



function getConversations(){
    //Rôle :        demander au serveur la liste des conversations de l'utilisateur connecté
    //              et transmettre le retour à la fonction show conversations
    //Paramêtres :  Aucun (on récupère les conversations de l'utilisateur connecté)
    //Retour :      néant

    //Indiquer l'url du contrôleur php qui récupère les données de la bdd
    let url="list_conversations.php";
    //On envoi la requète au contrôleur
    fetch(url).then(function(response){
        //On retourne le texte du contenu html à la fin
        return response.text(); //attend le html (texte brut)
        //On exploite le contenu du contenu html avec la fonction showConversations
    }).then(showConversations);
    //En attendant : Message d'attente pendant le chargement
    //document.getElementById("listeConversations").innerHTML = "Chargement des conversations...";


}



function showConversations(htmlContent){
    //Rôle :        Afficher la liste des conversations de l'utilisateur connecté dans la div prévue de la page
    //Paramêtres :  htmlContent (texte contenant le code html d'affichage de la liste dans la div)
    //Retour :      néant

    //ON injecte le text du contenu html dans la div
    document.getElementById("listeConversations").innerHTML = htmlContent;


}


function getIdFromPseudo(){
    //Rôle :        Récupérer l'id à partir du pseudo saisi dans le champ rechercher
    //Paramêtres :  Aucun
    //Retour :      néant



    //recupérer le champ pseudoRecherche
    let pseudoRecherche = document.getElementById("pseudoRecherche");
    //On cherche si un id correspond
    //Indiquer l'url du contrôleur php qui récupère les données de la bdd
    let url="check_pseudo.php?pseudo=" + pseudoRecherche.value;

    //On envoi la requète au contrôleur
    fetch(url)
    .then(function(response){
        //On retourne le texte du contenu html à la fin
        return response.text(); //attend le html (texte brut)
        //On exploite le contenu du contenu html avec la fonction showConversations
    })
    .then(function(id){
        if(id != 0){
        //Si on trouve un id
            getMessages(id);
        }else{
            showMessages("<p>Pseudo inconnu</p>");
        }
    })
    
    //Vider le champ pseudo
    pseudoRecherche.value = "";


}


function sendMessage(){
    //Rôle :        Envoi un message de l'utilisateur connecté ver son interlocuteur en cours
    //Paramêtres :  Aucun
    //Retour :      néant

    //recupérer le champ nouveauMessage
    let nouveauContenu = document.getElementById("nouveauContenu");
    let formData = new FormData(messageForm);

    //On enregistre le nouveau message
    //Indiquer l'url du contrôleur php qui enregistre le message dans la bdd
    let url="save_message.php";
    //On envoi la requète au contrôleur
    fetch(url, {
        //On envoie les données du formulaire en POST
        method: "POST",
        body: formData
    })
    .then(function(response){
        //On retourne le texte du contenu html à la fin
        return response.text(); //attend le html (texte brut)
        //On exploite le contenu du contenu html avec la fonction showMessages
    })
    .then(showMessages)
    
    //Vider le champ message
    nouveauContenu.value = "";




}


function getMessages(id=0){
    //Rôle :        demander au serveur la liste des messages entre l'utilisateur connecté et son interlocuteur
    //              et transmettre le retour à la fonction show messages
    //Paramêtres :  id : id de l'interlocuteur
    //Retour :      néant

    //On récupère la valeur du champ interlocuteur (destinataire des messages envoyés par l'utilisateur)
    let interlocuteur = document.getElementById("interlocuteur");

    //Si id est renseigné
    if(id!=0){
        //On indique l'id en valeur du champ interlocuteur dans le formulaire d'envoi de message
        interlocuteur.value = id;
    }else{
        //Sinon, on alimente id avec la valeur du formulaire d'envoi de message
        id = interlocuteur.value;
        }
    

    //Indiquer l'url du contrôleur php qui récupère les données de la bdd
    let url="list_messages.php?id=" + id;
    //On envoi la requète au contrôleur
    fetch(url).then(function(response){
        //On retourne le texte du contenu html à la fin
        return response.text(); //attend le html (texte brut)
        //On exploite le contenu du contenu html avec la fonction showMessages
    }).then(showMessages);
    //En attendant : Message d'attente pendant le chargement
    //document.getElementById("listeMessages").innerHTML = "Chargement des messages...";

}


function showMessages(htmlContent){
    //Rôle :        Afficher la liste des messages entre l'utilisateur connecté et son interlocuteur dans la div prévue de la page
    //Paramêtres :  htmlContent (texte contenant le code html d'affichage de la liste dans la div)
    //Retour :      néant


    //ON injecte le text du contenu html dans la div
    document.getElementById("listeMessages").innerHTML = htmlContent;


}





