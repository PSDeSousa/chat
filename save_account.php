<?php

/*
Controleur (ne peut être utilisé que comme URL)

Rôle : Vérifier si le pseudo n'existe pas déjà
        et si le mot de passe est correctement saisi et préparer l'affichage de la page de connexion si oui ou la page de de création de compte si non
Paramètres :
            POST pseudo (VARCHAR)
            POST password (VARCHAR)
            POST passwordCheck (VARCHAR)

*/


//Initialisation
require_once "library/init.php";

//Récupérer les paramètres
$registerFailed ="";
if (empty($_POST["pseudo"]) ){
    $registerFailed .= "Le champ pseudo est obligatoire <br>";
    include "templates/pages/register_page.php";
    exit;
}else{
    $pseudo = $_POST["pseudo"];
    }
if (empty($_POST["password"]) ){
    $registerFailed .= "Le champ password est obligatoire <br>";
    include "templates/pages/register_page.php";
    exit;
}else{
    $password = $_POST["password"];
    }
if (empty($_POST["passwordCheck"]) ){
    $registerFailed .= "Le champ password vérif est obligatoire <br>";
    include "templates/pages/register_page.php";
    exit;
}else{
    $passwordCheck = $_POST["passwordCheck"];
    }
//Récupérer les données à afficher sur le template

//Verification des droits
//Pas là

//Traitement principal du contrôleur

$utilisateur = new utilisateur();
if($utilisateur->getIdFromPseudo($pseudo)){
    $registerFailed .= "Le pseudo existe déjà <br>";
}
if($password != $passwordCheck){
    $registerFailed .= "Les mots de passe doivent être identiques <br>";
}

if($registerFailed == ""){


    $utilisateur->loadFromTab(["pseudo"=>$pseudo, "password"=>password_hash($password,PASSWORD_DEFAULT)]);
    $utilisateur->insert();

    //On ouvre le template
    $connexionFailed = true;
    include "templates/pages/login_page.php";


}else{
    include "templates/pages/register_page.php";
}




