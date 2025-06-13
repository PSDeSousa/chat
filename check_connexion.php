<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : vérifie que le mot de passe est juste
Paramètres :
            POST $pseudo (VARCHAR)
            POST $password (VARCHAR)

*/


//Initialisation
require_once "library/init.php";

//Récupérer les paramètres
if (empty($_POST["pseudo"]) || empty($_POST["password"])){
    $connexionFailed = true;
    $pseudo ="";
    $password = "";
}else{
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];
    }

//Récupérer les données à afficher sur le template

//Vérification des droits


    //On vérifie si l'utilisateur est déjà connecté
    if(!estConnecte()){
        //on vérifie que l'utilisateur existe et qu'il correpond au mot de passe
        $result=checkConnexion($pseudo,$password);
        //Si non, on revient à la page de connexion
        if(!$result){
            //Initialisation résultat vérif mot de passe
            $connexionFailed=false;
            //Afficher le template
            include "templates/pages/login_page.php";
            //On arrête
            exit;
            
        }
        //enregistrer l'id utilisateur dans la session
        connecter($result);
    }

//Traitement principal du contrôleur




//charger les paramètres
//On liste les conversations
$conversations = quiEstConnecte()->getConversations();


//Afficher le template
include "templates/pages/home_page.php";
