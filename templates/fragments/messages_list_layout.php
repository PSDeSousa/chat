
<?php

/*

Template de fragment de page :
rôle : liste des messages

Paramètres : 
    $messages : liste des messages de l'utilisateur connecté avec son interlocuteur
    $interlocuteur : interlocuteur avec lequel l'utilisateur échange

*/


?>


<!-------------------------------------------- structure HTML --------------------------------------------------------------------->




<!--------------- Afficher une ligne pour chaque conversation ------------------->

<h3><?= htmlentities($interlocuteur->get("pseudo")) ?></h3>
<div  class="content">
    <?php
        //Pour chaque message de la liste
        if(!empty($messages)){
            foreach($messages as $message){
                
                //On affiche le message
                include "templates/fragments/message_layout.php";
            }
        }
    ?>
</div>