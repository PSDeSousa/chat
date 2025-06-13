<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : enregistrer dans la bdd un nouveau message
Paramètres :
            POST $contenu (VARCHAR)

*/


//Initialisation
require_once "library/init.php";

//Récupérer les paramètres
if (empty($_POST["contenu"])){
    exit;
}else{
    $contenu=$_POST["contenu"];
}

if (empty($_POST["destinataire"])){
    exit;
}else{
    $destinataire=$_POST["destinataire"];
}


//Récupérer les données à afficher sur le template

//Verification des droits
//On vérifie si l'utilisateur est déjà connecté
if(!estConnecte()){
    //Si non, on revient à la page de connexion
    //Initialisation résultat vérif mot de passe
    $connexionFailed = false;
    //Afficher le template pour 
    include "templates/pages/login_page.php";
    //On arrête
    exit;
}

//Traitement principal du contrôleur



//charger les paramètres
//On récupère l'interlocuteur
$interlocuteur = new utilisateur();
$interlocuteur->loadFromId($destinataire);

$message = new message();
//On charge le nouveau message avec les données envoyées
$message->set("contenu", $contenu);
$message->set("date", date('Y-m-d H:i:s'));
$message->set("expediteur", quiEstConnecte()->id());
$message->set("destinataire", $destinataire);
$message->insert();
$messages = $message->getMessages(quiEstConnecte()->id(), $destinataire);
//affiche les messages à jour
include "templates/fragments/messages_list_layout.php";
