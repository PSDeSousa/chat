<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : Vérifier si un utilisateur est connecté, lister ses messages avec un interlocuteur donné et préparer du fragment de page (messages_list_layout) si oui ou la page de connexion si non
Paramètres :
            $id : id de l'interlocuteur

*/


//appel prog d'initialisation
require_once "library/init.php";

//On récupère les paramètres
//Si le paramètre est renseigné on récupère le paramètre



if(!isset($_GET["id"]) || empty($_GET["id"])){
    exit;
}else{
    $id=$_GET["id"];
}


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

//Traitement principal

//On récupère l'interlocuteur
$interlocuteur = new utilisateur();
$interlocuteur->loadFromId($id);

//On liste les messages
$message = new message();
if($message->getMessages(quiEstConnecte()->id(), $id)){
    $messages = $message->getMessages(quiEstConnecte()->id(), $id);
}else{
    $messages=[];
}



//On affiche le template

include "templates/fragments/messages_list_layout.php";