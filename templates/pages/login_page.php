<?php

/*

Rôle : Template de page complète : met en forme la page affichant le formulaire de connexion utilisateur

Paramètres :
            _ résultat de la verification du mot de passe : $connexionFailed (BOOLEAN) vrai par défaut

*/

?>

<!-------------------------------------------- Liens de navigation --------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">
	<?php 
		//inclure le "head"
		$titre = "Connexion";	//Valoriser la variable $titre attendue par le fragment
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
                    <h1>Connexion</h1>
                    <form action='check_connexion.php' method="POST" class="form">
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
                            <label>
                                <?php
                                    if(!$connexionFailed){
                                        echo("Utilisateur ou mot de passe erroné");
                                    }
                                ?>
                            </label>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <button type="submit" class="primary-button">
                                    <p>Connexion</p>
                                </button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <a href="create_account.php" title="créer un compte" class="primary-button">
                                    <p>Créer compte</p>
                                </a>
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