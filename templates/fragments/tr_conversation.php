<?php

/*

Template de fragment de page :
rôle : détail d'une conversation (tr)

Paramètres : 
    $conversation : 1 conversation (dernier message partagé entre un utilisateur et son interlocuteur)

*/


?>


<!-------------------------------------------- structure HTML --------------------------------------------------------------------->
<tr onclick="getMessages(<?= $idInterlocuteur ?>)">
    <td><?= $conversation->get("destinataire")->id() == $idInterlocuteur ? htmlentities($conversation->get("destinataire")->get("pseudo")) : htmlentities($conversation->get("expediteur")->get("pseudo")) ?></td>
    <td><?= htmlentities(substr($conversation->get("contenu"),0 ,50)) ?></td>
    <td><?= htmlentities($conversation->get("date")) ?></td>
</tr>