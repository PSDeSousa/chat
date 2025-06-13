<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : vérifie que le pseudo existe
Paramètres :
            GET $pseudo (VARCHAR)

*/


//Initialisation
require_once "library/init.php";

//Récupérer les paramètres
if (empty($_GET["pseudo"]) ){
    $id = 0;
    echo($id);
    exit;
}else{
    $pseudo = $_GET["pseudo"];
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
//On trouve l'utilisateur
$interlocuteur = new utilisateur();
if($interlocuteur->getIdFromPseudo($pseudo)){
    $id = $interlocuteur->getIdFromPseudo($pseudo);
}else{
    $id = 0;
}

//renvoi l'id trouvé


echo($id);
