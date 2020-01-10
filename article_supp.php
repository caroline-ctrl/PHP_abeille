<?php
session_start();

include('connection_bdd.php');


//requete permettant de supprimer un billet en fonction de son id
$req = $bdd->prepare('DELETE FROM article WHERE id = ?');
$req->execute(array($_GET['article']));

header('location: index.php');

?>

