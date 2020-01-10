<?php
session_start();
include('connection_bdd.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet" media="screen" type="text/css" />
    <title>Ajout un commentaire</title>
</head>

<body>
    <?php
    //verif que le formulaire est bien rempli
    if (isset($_POST['auteur']) AND isset($_POST['commentaire']))
	{
		if (($_POST['auteur'] != NULL) AND ($_POST['commentaire'] != NULL))
		{	
			// Requête pour ajouter les infos dans la table
			$req = $bdd->prepare('INSERT INTO commentaire (id_article, auteur, commentaire, date_commentaire) VALUES (:id_article, :auteur, :commentaire, NOW())');
    
    $req->execute(array(
        'id_article'=> $_POST['id_article'], 
        'auteur'=> $_POST['auteur'], 
        'commentaire'=> $_POST['commentaire'],
    ));

   		}
		else  // Alerte si les 2 champs n'ont pas été rempli
		{
			echo "<br>ATTENTION, Vous n'avez pas rempli tous les champs !";
		}
    }
 
    
    include('footer.php');
    header('location: index.php');

	?>