<?php

//Initialisations communes à tous les contrôleurs


//Gestion des messages d'erreur
    //Afficher messages d'erreur (pour la mise au point)
    ini_set('display_errors',1);
    error_reporting(E_ALL);

//Démarrage de la session
    //initialise ou récupère les infos de la session
    session_start(); //gère le cookie, récupère $_SESSION avec ses dernières valeurs connues

//Charge les librairies
    include "library/bdd.php";
    include "library/session.php";

//Charger les classes
    include "model/model.php";
    include "model/utilisateur.php";
    include "model/message.php";



//connexion BDD : ouvre la bdd dans la variable globale $bdd
    include "library/config.php";



