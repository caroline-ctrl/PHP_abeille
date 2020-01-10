<?php
session_start();

include('connection_bdd.php');


    if (isset($_POST['titre']) AND isset($_POST['contenu']) AND isset($_POST['photo'])){
		if (($_POST['titre'] != NULL) AND ($_POST['contenu'] != NULL) AND ($_POST['photo'] != NULL)){	
			// Requête pour ajouter les infos dans la table
			$bdd->exec("UPDATE article SET titre = '" . $_POST['titre'] . "', contenu = '" . $_POST['contenu'] . "', photo = '" . $_POST['photo'] . "' WHERE id = '" . $_POST['id'] . "'");
       		}else {
            // Alerte si les 2 champs n'ont pas été rempli
			echo "<br>ATTENTION, Vous n'avez pas rempli tous les champs !";
		}
    }

    header('location: index.php');
    
    ?>