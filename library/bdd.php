<?php

//Librairie de fonctions d'accès à la base de dedonnées
//Les fonctions s'appuient sur $bdd, variable globale contennat un objet PDO initialisa sur la bonne base

function bddRequest($sql, $param){
    //Rôle : préparer et éxécuter une requête, et de retourner false ou un objet "PDOstatement" (requête)
    //Paramètres :
    //              $sql : texte de la commande SQL complète, avec des paramètres : xxx
    //              $param : tableau de valorisation des paramètres :xxx
    //Retour : soit false, soit la requête préparée et exécutée

    global $bdd;

    //prépa requête PDO
    $req = $bdd->prepare($sql);
    if (!$req){
        return false;
        exit;
    }

    //Executer requête
    if (empty($param)){
        if (! $req->execute()){
            echo("Erreur technique sur $sql");
            return false;
            exit;
        }
    }



    if (! $req->execute($param)){
        echo("Erreur technique sur $sql");
        return false;
        exit;
    }else{

    return $req;
    }

}

function bddGetRecord($sql, $param){
    //Rôle : retourne un enregistrement de la bdd (la première ligne récupérée par un select) sous forme d'un tableau indexé
    //Paramètres :
    //              $sql : texte de la commande SQL complète, avec des paramètres : xxx
    //              $param : tableau de valorisation des paramètres :xxx
    //Retour : soit false (si on a aucune ligne), soit la première ligne récupérée (tableau indexé)

    //besoin récupérer la première ligne
    //soit avec fetch -> première ligne ou false directement
    //soit avec fetchAll -> récupère un tableau avec toutes les lignes, extraire la première ligne (la numéro 0 si elle existe)

    //préparer et exécuter la requête à l'aide de la fonction bddRequest
    //Préparer le résultat
    $req=bddRequest($sql, $param);
    if(!$req){
        return false;
    }
    $ligne = $req->fetch(PDO::FETCH_ASSOC);
    if (empty($ligne)){
        return false;
    }else{
        return $ligne;
    }
}

function bddGetRecords($sql, $param=[]){
    //Rôle : retourne les lignes récupérées par un select
    //Paramètres :
    //              $sql : texte de la commande SQL complète, avec des paramètres : xxx
    //              $param : tableau de valorisation des paramètres :xxx
    //Retour : un tableau comprenant des tableaux indexés par les noms de colonnes

    //On initialise un tableau de tableaux indexés
    $resultat = [];
    //préparer et exécuter la requête tant que l'on retourne une valeur
    $req=bddRequest($sql, $param);
    //On vérifie si erreur et dans ce cas, on retourne un tableau vide
    if(!$req){
        return $resultat;
    }
    //on enregistre chaque ligne du résultat de la requête
    
    $ligne = "";
    while ($ligne !== false){
        //Récupère la valeur de la ligne
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        //Ajouter la ligne (tableau indexé) au résultat (tableau de tableaux)
        if (!empty($ligne)){
            $resultat[] = $ligne;
        }
    }
    if (empty($resultat)){
        return false;
    }else{
        return $resultat;
    }

}

function bddInsert($table, $valeur){
    //Rôle : Insert un enregistrement dans la bdd et retourne la clé primaire créée
    //Paramètres :
    //              $table : nom de la table dans la bdd
    //              $valeur : tableau donnant les valeurs des champs (colonnes de la table) ["nomchamp" => valeurAdonner, ... ]
    //Retour : 0 en cas d'échec, la clé primaire sinon


    global $bdd;

    //On initialise la requête sql
    $tab = "`" . $table . "`";
    $sql = "INSERT INTO $tab SET ";
    
    //on initialise un flag $premier qui dit si on est sur la première ligne ou non

    $premier = true;
    //Pour chaque valeur du tableau $valeur
    foreach ($valeur as $index => $val){
        //On ajoute le nom du champ et la valeur du champ dans la table paramètre
        $param[":" . $index] = $val;
        //On ajoute à la requête sql le champ que l'on veut alimenter
        if(!$premier){
            //Si pas premier paramètre, on met une virgule au début de l'expression
            $sql = $sql . ", `" . $index . "`". " = :" . $index ;
        }else{
            //Si premier paramètre, on n'a pas de virgule au début de l'expression
            $sql = $sql . " `" . $index . "`" . " = :" . $index ;
            $premier = false;
        }

    }
    //Préparer le résultat
    $reussite = bddGetRecord($sql, $param);
    if(isset($reussite)){
        $id = $bdd->lastInsertId();
        return $id;
    }

}


function bddUpdate($table, $valeurs, $id) {
    // Rôle : Mettre à jour un enregistrement dans la base de données
    // Paramètres :
    //      $table : nom de la table dans la BDD
    //      $valeurs : tableau donnant les nouvelles valeurs des champs (colonnes de la table) [ "nomChamp1" => valeurAdonner, ... ]
    //      $id : valeur de la clé primaire (la clé primaire doit s'appeler id)
    // Retour : true si ok, false sinon

    // Construire la requête SQL et le tableau de paramètres
    //  UPDATE nom de la table SET (pour chaque champ `nomChamp` = :nomChamp ) WHERE id = :id
    //          et pour chaque champ mettre dans la tableau des paramètre l'entrée d'index :nomChamp avec la valeur à donner au champ, 
    $sql = "UPDATE `$table` ";
    // Préparer le tabeau de paramètres 
    $param = [];
    // on doit ajouter pour chque champ de valeurs le texte "`nomChamp` = :nomChamp", en les séparant par une vigule
    // Et ajouter dans le tablea des paramètres : :nomChamp => valeur
    // Pour la partie texte :
    /// On prépare un tabelau des textes "`nomChamp` = :nomChamp", puis on concataène les élémnts séparés par une virgule
    // Préparer le tableau des extarits SQL
    $tab = [];
    foreach($valeurs as $nomChamp => $valeurChamp) {
        $tab[] = "`$nomChamp` = :$nomChamp";
        $param[":$nomChamp"] = $valeurChamp;
    }
    // Concatener les éléments de $tab (dans $sql)
    $sql .= " SET " . implode(", ", $tab);

    // Ajouter la clasue WHERE et le parametre :id
    $sql .= " WHERE `id` = :id";
    $param[":id"] = $id;

    // préparer / exécuter la requête : utiliser la fonction bddRequest
    $req = bddRequest($sql, $param);

    // si on récupère false : on retourne false
    if ($req == false) {
        return false;
    } else { // Sinon retourner true
        return true;
    }

}


function bddDelete($table, $id){
    //Rôle : Supprimer un enregistrement dans la bdd
    //Paramètres :
    //              $table : nom de la table dans la bdd
    //              $valeur : tableau donnant les valeurs des champs (colonnes de la table) ["nomchamp" => valeurAdonner, ... ]
    //              $id : valeur de la clé primaire ( la clé primaire doit s'appeler id)
    //Retour : 0 en cas d'échec, la clé primaire sinon


    //On initialise la requête sql
    $tab = "`" . $table . "`";
    $sql = "DELETE FROM $tab WHERE `id` = :id";
    
    
    //On initialise le paramètre id
    $param[":id"] = $id;


    //Préparer le résultat
    $reussite = bddGetRecord($sql, $param);

}