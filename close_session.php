<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : fermer une session en cours
Paramètres :
            Aucun

*/


//appel prog d'initialisation
require_once "library/init.php";


//On vérifie si l'utilisateur est déjà connecté
if(estConnecte()){
    //Si oui; on deconnecte l'utilisateur
    deconnecter();
}

//Initialisation résultat vérif mot de passe
$connexionFailed=true;
//Affiche le formulaire de connexion
include "templates/pages/login_page.php";


