<?php
session_start();

include('connection_bdd.php');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <style>
        .fakeimg {
            height: 200px;
            background: #aaa;
        }
    </style>
</head>

<body>
    <!-- entete -->
    <div class="jumbotron text-center bg-bleu" style="margin-bottom:0">
        <h1>Mon premier site avec Bootstrap et PHP</h1>
    </div>


    <!-- navbar -->
    <?php
    include('navbar.php');
    ?>



    <div class="container">
        <!-- formulaire permettant d'ajouter un article -->

        <form action="article_ajout.php" method="post">

            <div class="form-group row">
                <label for="titre" class="col-sm-2 col-form-label col-form-label-sm">Titre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm barre" name="titre">
                </div>
            </div>
            <div class="form-group row">
                <label for="contenu" class="col-sm-2 col-form-label col-form-label-sm">Contenu</label>
                <div class="col-sm-10">
                    <textarea name="contenu" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="photo" class="col-sm-2 col-form-label col-form-label-sm">Photo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm barre" name="photo">
                    <small class="form-text text-muted">Vous devez renseigner le nom et l'extension de la photo</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>

        <?php


        //verif que le formulaire est bien rempli
        if (isset($_POST['titre']) and isset($_POST['contenu']) and isset($_POST['photo'])) {
            if (($_POST['titre'] != NULL) and ($_POST['contenu'] != NULL) and ($_POST['photo'] != NULL)) {

                // Requête pour ajouter les infos dans la table
                $req = $bdd->prepare('INSERT INTO article (titre, photo, contenu, date_creation) VALUES (:titre, :photo, :contenu, NOW())');

                $req->execute(array(
                    'titre' => $_POST['titre'],
                    'photo' => $_POST['photo'],
                    'contenu' => $_POST['contenu'],
                ));
            } else  // Alerte si les 3 champs n'ont pas été rempli
            {
                echo "<br>ATTENTION, Vous n'avez pas rempli tous les champs !";
            }
        }


        ?>

</div>

        <?php
        include 'footer.php';
        ?>