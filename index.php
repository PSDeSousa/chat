<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : Vérifier si un utilisateur est connecté et préparer l'affichage de la home page (messagerie) si oui ou la page de connexion si non
Paramètres :
            Néant

*/


//appel prog d'initialisation
require_once "library/init.php";

//On récupère les paramètres


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
//On liste les conversations
$conversations = quiEstConnecte()->getConversations();

//On affiche le template

include "templates/pages/home_page.php";