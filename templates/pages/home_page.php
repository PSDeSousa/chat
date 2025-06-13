<?php

/*

Rôle : Template de page complète : met en forme la page principale de la messagerie

Paramètres :
            $conversations : liste des conversations de l'utilisateur connecté

*/

?>

<!-------------------------------------------- Liens de navigation --------------------------------------------------------------------->


<!-------------------------------------------- Liens de navigation --------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">
	<?php 
		//inclure le "head"
		$titre = "Messagerie";	//Valoriser la variable $titre attendue par le fragment
		include "templates/fragments/head.php";
		//pas once car à chaque fois aura besoin
	?>
    <body>
        <?php 
            //inclure le "header"
            include "templates/fragments/header.php";
            //pas once car à chaque fois aura besoin
        ?>
        <main>
            <div class="container">
                <div class="grid-row">
                    <div class="column">                      
                        <div class="bloc">
                            <h1>Conversations</h1>
                            <form action="check_pseudo.php" id="rechercheForm" class="form">
                                <div class="form-row">
                                <div class="form-column">
                                    <label>Recherche interlocuteur</label>
                                    <input type="text" id="pseudoRecherche" name="pseudo" class="right-message">
                                </div>
                                    <button type="submit" class="primary-button">
                                        <p>Rechercher</p>
                                    </button>
                                </div>
                            </form>  
                            <table>
                                <thead>
                                    <tr>
                                        <th>Interlocuteur</th>
                                        <th>Dernier message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody id="listeConversations"  class="content">
                                    <!--------------- Afficher une ligne pour chaque conversation ------------------->
                                    <?php
                                        //Pour chaque conversation de la liste
                                        foreach($conversations as $idInterlocuteur=>$conversation){
                                            //On affiche la liste des conversations
                                            //Préparer les paramètres
                                            include "templates/fragments/tr_conversation.php";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="detail" class="column">
                        <div class="bloc">
                            <h2>Messages</h2>
                            <form id="messageForm" class="form">
                                <div class="form-row">
                                    <div class="form-column">
                                        <label>Nouveau message</label>
                                            <input type="hidden" id="interlocuteur" name="destinataire" value="">
                                            <input type="text" id="nouveauContenu" name="contenu" class="left-message">
                                    </div>
                                    <button type="submit" class="primary-button">
                                        <p>Envoyer</p>
                                    </button>
                                </div>
                            </form>
                            <div id="listeMessages">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
        </footer>
        <script src="js/fonctions.js"></script>
    </body>
</html>