<?php


//librairie : fonctions de gestion de la session
//$_SESSION[id] contiendra l'id de l'utilisateur connecté ou 0 si pas d'utilisateur connecté



function connecter($id){
    //Rôle : enregistrer dans $_SESSION l'id de l'utilisateur connecté
    //Paramètres : $id (l'id de l'utilisateur connecté)
    //Retour : vrai ou faux


    //Si le mot de passe est égale au mot de passe de la bdd alor svrai sinon faux
    if(!empty($id)){
        $_SESSION["id"] = $id;
        return true;
    }else{
        return false;
    }
}



function deconnecter(){
    //Rôle : enregistrer dans $_SESSION 0 pour indiquer qu'aucun utilisateur n'est connecté
    //Paramètres : aucun
    //Retour : vrai ou faux


        $_SESSION["id"]=0;
        return true;
}

function estConnecte(){
    //Rôle : indique si un utilisateur est connecté
    //Paramètres : aucun
    //Retour : vrai ou faux

    //Si l'id enregistré dans $_SESSION est égale à 0 null ou n'existe pas
    if( !isset($_SESSION["id"]) || $_SESSION["id"] == 0 || empty($_SESSION["id"])){
        //on retourne faux
        return false;
    }else{
        return true;
    }
}

function quiEstConnecte(){

    //Rôle : indique l'utilisateur connecté
    //Paramètres : aucun
    //Retour : l'utilisateur connecté ou faux si aucun utilisateur connecté

    //Si un utilisateur est connecté
    if(estConnecte()){
        //on crée un utilisateur
        $user = new utilisateur(); 
        //on retourne l'utilisateur chargé à partir de l'id de la session
        $user->loadFromId($_SESSION["id"]);
        return $user;
    }

}


function checkConnexion($login, $password){
    //Rôle : vérifier si le login existe et si le mot de passe correspond au login
    //Paramètre : 
    //          _$login (le login renseigné par un utilisateur)
    //          _$password (le password renseigné par un utilisateur)
    //Retour : vrai si $login et $password correspondent aux données de la bdd faux sinon

    $user = new utilisateur();
    //Si le login existe avec un id
    if($user->getIdFromPseudo($login)){
        $user->loadFromId($user->getIdFromPseudo($login));
        //On vérifie le mot de passe
        //Si le mot de passe est égale au mot de passe de la bdd alor svrai sinon faux
        if(password_verify($password, $user->get("password"))){
            return $user->id();
        }else{
            return false;
        }
    }else{
        return false;
    }

}

/*

function ouvrirConversation($id){
    //Rôle : enregistrer dans $_SESSION l'id de l'interlocuteur
    //Paramètres : $interlocuteur (l'id de l'interlocuteur)
    //Retour : vrai ou faux


    if(!empty($id)){
        $_SESSION["interlocuteur"] = $id;
        return true;
    }else{
        return false;
    }

}

function fermerConversation(){
    //Rôle : enregistrer dans $_SESSION 0 pour indiquer qu'aucune conversation est en cours
    //Paramètres : aucun
    //Retour : vrai ou faux


        $_SESSION["interlocuteur"]=0;
        return true;   
}

function conversationOuverte(){
    //Rôle : indique si une conversation est en cours
    //Paramètres : aucun
    //Retour : vrai ou faux

    //Si l'interlocuteur enregistré dans $_SESSION est égale à 0 null ou n'existe pas
    if( !isset($_SESSION["interlocuteur"]) || $_SESSION["interlocuteur"] == 0 || empty($_SESSION["interlocuteur"])){
        //on retourne faux
        return false;
    }else{
        return true;
    }
}

function quiEstInterlocuteur(){

    //Rôle : indique l'interlocuteur avec qui l'utilisateur connecté discute
    //Paramètres : aucun
    //Retour : l'interlocuteu ou faux si aucun interlocuteur

    //Si une conversation est en cours
    if(conversationOuverte()){
        //on crée un utilisateur
        $user = new utilisateur(); 
        //on retourne l'utilisateur chargé à partir de l'id de la session
        $user->loadFromId($_SESSION["interlocuteur"]);
        return $user;
    }

}

*/