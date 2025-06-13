<?php

/*

Rôle : Template de page complète : met en forme la page affichant le formulaire de création d'un compte utilisateur

Paramètres :
            _ résultat de la verification de l'existence de l'utilisateur et que le contrôel du mot de passe est ok : $registerFailed (BOOLEAN) vrai par défaut

*/

?>

<!-------------------------------------------- Liens de navigation --------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">
	<?php 
		//inclure le "head"
		$titre = "Création de compte";	//Valoriser la variable $titre attendue par le fragment
		include "templates/fragments/head.php";
		//pas once car à chaque fois aura besoin
	?>
    <body>
        <?php 
            //inclure le "header"
            include "templates/fragments/header.php";
        ?>
        <main>
            <div class="container">
                <div class="row">
                    <h1>Création de compte</h1>
                    <form action='save_account.php' method="POST" class="form">
                        <div class="form-row">
                            <div class="form-column">
                                <label>Pseudo</label>
                                <input type="text" name="pseudo" value="<?= isset($_POST["pseudo"]) ? $_POST["pseudo"] : "" ?>">
                            </div>
                            <div class="form-column">
                                <label>Mot de passe</label>
                                <input type="password" name="password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                            </div>
                            <div class="form-column">
                                <label>Mot de passe (vérification)</label>
                                <input type="password" name="passwordCheck">
                            </div>
                        </div>
                        <div class="form-row">
                            <label>
                                <?php
                                    if($registerFailed !=""){
                                        echo($registerFailed);
                                    }
                                ?>
                            </label>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <button type="submit" class="primary-button">
                                    <p>Enregistrer</p>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>          
            </div>
        </main>
        <footer>
        </footer>
        <script src="script.js"></script>
    </body>
</html>