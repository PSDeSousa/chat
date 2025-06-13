
<?php

/*

Template de fragment de page :
rôle : liste des conversations

Paramètres : 
    $conversations : liste des conversations de l'utilisateur connecté

*/


?>


<!-------------------------------------------- structure HTML --------------------------------------------------------------------->




<!--------------- Afficher une ligne pour chaque conversation ------------------->
<?php
    //Pour chaque conversation de la liste

    foreach($conversations as $idInterlocuteur=>$conversation){
        
        //On affiche la liste des conversations
        //Préparer les paramètres
        include "templates/fragments/tr_conversation.php";
    }
?>