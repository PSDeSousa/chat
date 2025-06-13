<?php

/*

Template de fragment de page :
rôle : détail d'un message

Paramètres : 
    $message : 1 message


*/

?>


<!-------------------------------------------- structure HTML --------------------------------------------------------------------->

<div class="<?= $message->get("destinataire")->id() == quiEstConnecte()->id() ? 'right-message' : 'left-message' ?>">
    <h4><?= htmlentities($message->get("date")) ?></h4>
    <p><?= htmlentities($message->get("contenu")) ?></p>
</div>