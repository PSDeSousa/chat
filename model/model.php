<?php

/* Classe _model : manipulation d'un objet générique du MCD */
//La clé prmiaire s'appelle id dans toutes les tables, sinon il faut une variable clé primaire protected $clePrimaire

class _model {

    // Décrire l'objet réel : attributs pour décrire l'objet réel
    protected $table = "";
    protected $fields = [];     // Liste simple des champs, sauf l'id
    protected $links = [];     // Liste des liens

    protected $values = [];    // stockage des valeurs des attributs (quand remplis) [ "champ1" = "valeur1", "champ2" => "valeur2" ]
    protected $id;              //Stockage de l'id

    function is() {
        //Rôle : vérifier si l'objet est chargé dans la bdd
        //Paramètres : Aucun
        //Retour : vrai si chargé, faux sinon
        return !empty($this->id);
        
    }

    function id() {
        //Rôle : retourner la valeur de l'id
        //Paramètres : Aucun
        //Retour : l'id ou 0 si pas d'id
        
        //si l'objet est chargé, on retourne l'id
        if($this->is()){
            return $this->id;
        }else{
            return 0;
        }
    }

    //Getter
    function get($nom) {
        //Rôle : retourner la valeur du champ demandé en paramètre
        //paramètre : $nom (nom du champ dont on veut retourner la valeur)
        //Retour : valeur du champ pour un champ simple ou l'objet pointé si le champ est lié à un objet
        // ou chaine vide si on ne parvient pas à retourner la valeur du champ

        //Si le paramètre est un champ de l'objet
        if(in_array($nom, $this->fields)){
            //Si le champ est un objet
            if(array_key_exists($nom,$this->links)){
                //Si oui, on charge l'objet
                $objet = new $this->links[$nom]();
                $objet->loadFromId($this->values[$nom]);
                //Puis on retourne l'objet
                return $objet;
            //Si le champ n'est pas un objet
            }else{
                //si le champ est renseigné
                if(isset($this->values[$nom])){
                    //On renvoie la valeur du champ
                    return $this->values[$nom];
                }else{
                    //Sinon on ramène vide
                    return "";
                }
            }

        }else{
            //si le paramètre n'est pas un champ, on ramène vide
            return "";
        }
    }


    // Setters

    function set($nom,$valeur) {
        //Rôle : alimenter la valeur d'un champ à partir des paramètres
        //paramètre : 
        //          _ $nom (nom du champ dont on veut alimenter la valeur)
        //          _ $valeur (valeur avec laquelle on veut alimenter le champ)
        //Retour : vrai si la valeur du champ a été mise à jour, faux sinon

        //Si le paramètre est un champ de l'objet
        if(in_array($nom, $this->fields)){
            //On modifie la valeur du champ
            $this->values[$nom] = $valeur;

            return true;
        }else{
            //Sinon on ramène faux
            return false;
        }
    }

    // Méthodes d'accés à la base de donnés
    //  loadFromId
    
    function loadFromId($id) {
        //Rôle : charger un objet avec les données de la bdd d'après son id
        //paramètre : 
        //          _ $id (id de l'objet)
        //Retour : vrai si l'objet est chargé, faux sinon


        //On crée la requête sql qui récupère la valeur de chaque champ pour l'id en paramètre
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE `id` = :id";
        //On récupère le résultat (1 ligne) de la requête
        $tab = bddGetRecord($sql, [":id"=>$id]);
        //si la requète ramène faux, on ramène faux
        if($tab==false){
            //On met des valeurs par défaut vides
            $this->values = [];
            $this->id = null;
            return false;
        }
        //On alimente les valeurs de l'objet à partir de $tab
        $this->loadFromTab($tab);
        $this->id=$id;
        return true;       

    }
    


    //  insert
    function insert(){
        //Rôle : insérer les valeurs d'un objet dans la bdd
        //paramètre : aucun
        //Retour : vrai si l'objet est inséré, faux sinon et on alimente l'id de l'objet
        
        //On vérifie si l'objet existe dans la bdd
        if($this->is()){
            //Si oui, on n'insert pas les données
            return false;
        }else{
            //Si non on lance la fonction d'insertion pour l'objet et récupère l'id
            $id = bddInsert($this->table, $this->values);
            //si l'id est vide on retourne faux
            if(empty($id)){
                return false;
            }else{
                //Sinon on enregistre l'id de l'objet
                $this->id=$id;
                return true;
            }
        }
    }

    //  update
    function update(){
        //Rôle : mettre à jour les valeurs des champs d'un objet dans la bdd
        //paramètre : aucun
        //Retour : vrai si l'objet est mis à jour, faux sinon
        
        //On vérifie si l'objet existe dans la bdd
        if($this->is()){
            //Si oui, on lance la fonction de mise à jour les données
            $cr = bddUpdate($this->table, $this->values, $this->id());
            //On retourne le cr de la fonction mise à jour
            return $cr;
        }else{
            //sinon on retourne faux
            return false;
        }
    }

    //  delete
    function delete(){
        //Rôle : Supprimer un objet de la bdd
        //paramètre : aucun
        //Retour : vrai si l'objet est supprimé, faux sinon
        
        //On vérifie si l'objet existe dans la bdd
        if($this->is()){
            //Si oui, on lance la fonction de suppression des données
            $cr = bddDelete($this->table, $this->id());
            //On retourne le cr de la fonction mise à jour
            //Si le résultat de la fonction suppression est vrai : on supprime l'id
            if($cr){
                $this->id = null;
                return true; 
            }else{
                //sinon on retourne faux
                return false;
            }
        }else{
            return false;
        }
    }

    //  listAll
    function listAll(){
        //Rôle : lister tous les objets de la classe en cours depuis la bdd
        //paramètre : aucun
        //Retour : liste d'objets de la classe en cours

        //On crée la requête sql qui récupère la valeur de chaque champ pour l'id en paramètre
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE 1";
        //On récupère le résultat de la requête
        $list = bddGetRecords($sql);
        //si la liste est vide on ramène faux
        if (empty($list)){
            return false;
        }else{
            return $this->listBddToListObj($list);
        }
    }



    // Méthodes utilitaires
    //   loadFromTab
    function loadFromTab($tab){
        //Rôle : charger l'objet à partir d'une table
        //Paramètres : $tab (table contenant les noms de champs en index et les valeurs)
        //Retour : true si la table a été chargée, false sinon

        //Pour chaque champ de tab
        foreach($tab as $field=>$value){
                //Si la table contient une valeur pour le champ
                if(isset($tab[$field])){
                    //On alimente la valeur avec la valeur du résultat de la requête
                    $this->set($field,$value);
                }
            }
        return true;

    }

    //ListBddToListObj
    function listBddToListObj($tab ){
        //Rôle : transformer une table simple dont chaque valeur est une table indexée (résultat d'une requète sql)
        // en tableau d'objets de la classe en cours indexée par l'id de l'objet
        //Paramètres : $tab (table issue de la bdd)
        //Retour : table indexée par l'id de l'objet

        //On initialise la teble $resultat
        $resultat = [];
        //Pour chaque ligne de la table
        foreach($tab as $value){
            //On ajoute un index égal à l'id de la ligne et ayant pour valeur les valeurs de la table $tab
            $resultat[$value["id"]] = new static();
            $resultat[$value["id"]]->id = $value["id"];
            $resultat[$value["id"]]->loadFromTab($value);
        }
        return $resultat;
    }




    function listeFiltree($filtres = [], $tri = []) {
        //Rôle : lister les objets de la classe en cours depuis la bdd en appliquant des filtres et des tris
        //paramètre : $filtres (tableau qui indique les filtres - sous forme d'une table à 3 champs :
        //                                          _ field (le nom du champ dans la bdd)
        //                                          _ operator (l'opérateur à mettre dans la requète "=", "LIKE" ...)
        //                                          _ value (la valeur à filtrer)
        //Retour : liste d'objets de la classe en cours ou liste vide

        //On crée la requête sql qui récupère la valeur de chaque champ pour l'id en paramètre
        $sql = "SELECT " . $this->listeChampsPourSelect() . " FROM `$this->table` WHERE 1";
        $param=[];
        
        //Pour chaque filtre de $filtres
        foreach($filtres as $index=>$filtre){
            //Si le champ est dans les champs de l'objet
            if(in_array($filtre["field"],$this->fields)){
                //On ajoute à la requête le filtre
                $nomChamp = $filtre['field'];
                $operateur = $filtre['operator'];
                $val = $filtre['value'];
                $sql .= " AND `$nomChamp` $operateur :$nomChamp";
                //On ajoute la valeur en paramètre
                //Si l'opérateur est "LIKE" on ajoute "%"
                if($filtre['operator'] == "LIKE"){
                    $param[":$nomChamp"]="%" . $val . "%";
                }else{
                    $param[":$nomChamp"]=$val;
                }
            }
        }
        //Init critères de tri
        $criteres = [];
        //Pour chaque tri
        foreach($tri as $NomChamp){
            //On vérifie que le champs trié est dans fields
                if(in_array($NomChamp,$this->fields)){
                 //Si oui, on ajoute NomChamp ASC au tableau de tri pour l'intégrer ensuite dans la requête
                    $criteres[] = "`$NomChamp` ASC";
                }
            }
        //Si le tableau des critères de tri est non vide
        if(!empty($criteres)){
            //On ajoute les critères de tri à la requête
            $sql = $sql . " ORDER BY " . implode(',',$criteres);
        }


        //On récupère le résultat de la requête
        $list = bddGetRecords($sql, $param);
        //si la liste est vide on ramène faux
        if (empty($list)){
            return [];
        }else{
            return $this->listBddToListObj($list);
        }
    }




    function listeChampsPourSelect() {
        //Rôle : créer une chaine de caractère représentant les champs de l'objet séparés par des virgules pour les insérer dans une requète
        //Paramètres : aucun
        //Retour : chain de caractère représentant les champs séparés par une virgule
        
        //On retourne résultat à partir des champs de l'objet en les séparants par `,`

        return "`id`,`" . implode("`,`", $this->fields) . "`";

    }
}