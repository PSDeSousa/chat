<?php

//Classe utilisateur : manipulation de l'objet utilisateur du MCD

class utilisateur extends _model {
    //Description des attributs de l'objets dans la MCD et le MPD

    protected $table = "utilisateur"; //nom de la table dans le MPD
    protected $fields=["pseudo", "password"]; //nom des champs de la table dans le MPD
    protected $links=[]; //liens (nom du champ avec l'id d'un autre objet suivi du nom de la table de cet autre objet)

    //Méthodes spécifiques
    function getIdFromPseudo($pseudo){
        //Rôle : récupérer l'id de la première (et en principe seule) ligne dont le champ pseudo correspond au paramètre $pseudo
        //Paramètre : $pseudo (le pseudo renseigné par un utilisateur)
        //Retour : l'id correspondant au pseudo ou faux si le pseudo est absent de la bdd
        
        // Construire la requête : SELECT `id`, `nomChamp1`, `nomChamp2`, ... FROM `nomTable` 
        $sql = "SELECT `id` FROM `utilisateur` WHERE `pseudo` = :pseudo ";
        $param=[':pseudo'=>$pseudo];

        // Extraction de la première (en principe unique) ligne :
        $tab = bddGetRecord($sql,$param);

        // Retourne l'id
        if(!$tab){
            return false;
        }else{
            return $tab["id"];
        }
    }


    function getInterlocuteurs(){
        //Rôle : récupérer la liste des interlocuteurs qui ont au moins un message recu de l'utilisateur ou envoyé à l'utilisateur
        //Paramètre : Néant
        //Retour : liste d'objets utilisateurs

        // Construire la requête : SELECT `id`, `nomChamp1`, `nomChamp2`, ... FROM `nomTable` 

        $sql = "SELECT `utilisateur`.`id`, `utilisateur`.`pseudo`  FROM `utilisateur`
        LEFT JOIN `message` ON `utilisateur`.`id` = `message`.`expediteur`
        WHERE `message`.`destinataire` = :id
        GROUP BY `utilisateur`.`id`, `utilisateur`.`pseudo`
        UNION
        SELECT `utilisateur`.`id`, `utilisateur`.`pseudo`  FROM `utilisateur`
        LEFT JOIN `message` ON `utilisateur`.`id` = `message`.`destinataire`
        WHERE `message`.`expediteur` = :id
        GROUP BY `utilisateur`.`id`, `utilisateur`.`pseudo`";
        $param = [':id'=>$this->id()];
        //On récupère le résultat de la requête
        $list = bddGetRecords($sql, $param);
        //si la liste est vide on ramène faux
        if (empty($list)){
            return false;
        }else{
            return $this->listBddToListObj($list);
        }

    }



    function getConversations(){
        //Rôle : récupérer la liste des derniers messages échangés entre l'utilisateur et un interlocuteur donné
        //Paramètre : Néant
        //Retour : liste d'objets messages
        
        $messages=[];
        //Pöur chaque interlocuteur de l'utilisateur
        if($this->getInterlocuteurs()){
            foreach($this->getInterlocuteurs() as $interlocuteur){
                //On liste le dernier message
                $messages[$interlocuteur->id()] = new message();
                $messages[$interlocuteur->id()]->lastMessage($this->id(),$interlocuteur->id());
            }
        }
        return $messages;
    }
}