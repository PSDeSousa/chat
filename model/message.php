<?php

//Classe utilisateur : manipulation de l'objet utilisateur du MCD

class message extends _model {
    //Description des attributs de l'objets dans la MCD et le MPD

    protected $table = "message"; //nom de la table dans le MPD
    protected $fields=["contenu", "date", "expediteur", "destinataire"]; //nom des champs de la table dans le MPD
    protected $links=["expediteur"=>"utilisateur", "destinataire"=>"utilisateur"]; //liens (nom du champ avec l'id d'un autre objet suivi du nom de la table de cet autre objet)

    //Méthodes spécifiques


    function getMessages($idUtilisateur, $idInterlocuteur){
        //Rôle : récupérer la liste des messages recu ou envoyé de l'utilisateur vers ou depuis l'interlocuteur
        //Paramètre : $interlocuteur (celui qui échange avec l'utilisateur)
        //Retour : liste d'objets messages triés du plus récent au plus ancien

       // Construire la requête : SELECT `id`, `nomChamp1`, `nomChamp2`, ... FROM `nomTable` 

        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table`
        WHERE (`expediteur` = :idU AND `destinataire` = :idI) OR (`expediteur` = :idI AND `destinataire` = :idU)
        ORDER BY `DATE` DESC";
        //On alimente les paramètres de la requête
        $param = [':idU'=>$idUtilisateur, ':idI'=>$idInterlocuteur];
        //On récupère le résultat de la requête
        $list = bddGetRecords($sql, $param);
        //si la liste est vide on ramène faux
        if (empty($list)){
            return false;
        }else{
            return $this->listBddToListObj($list);
        }


    }

    function lastMessage($idUtilisateur, $idInterlocuteur){
        //Rôle : récupérer le dernier message envoyé
        //Paramètre : Néant
        //Retour : liste d'objets utilisateurs

        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table`
        WHERE (`expediteur` = :idU AND `destinataire` = :idI) OR (`expediteur` = :idI AND `destinataire` = :idU)
        ORDER BY `DATE` DESC";
        //On alimente les paramètres de la requête
        $param = [':idU'=>$idUtilisateur, ':idI'=>$idInterlocuteur];
        //On récupère le résultat de la requête
        $tab = bddGetRecord($sql, $param);
        if($tab==false){
            //On met des valeurs par défaut vides
            $this->values = [];
            $this->id = null;
            return false;
        }
        //On alimente les valeurs de l'objet à partir de $tab
        $this->loadFromTab($tab);
        $this->id=$tab["id"];
        return true;  

    }


}