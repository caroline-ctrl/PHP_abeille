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
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">* HELLO
            <?php
            if (isset($_COOKIE['gateauChoco'])) {
                echo $_COOKIE['gateauChoco'];
            }
            ?>
            *</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Connection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion.php">Deconnection</a>
                    </li>
            </div>
            <div class="navbar-nav">
                <li class="nav-item">
                    <!-- pour cacher "ecrire un article" quand on est pas connecté-->
                    <?php
                    if (isset($_COOKIE['gateauChoco'])) {
                    ?>
                        <a class="nav-link text-right" href="article.php">Ecrire un article</a>
                    <?php
                    }
                    ?>
                </li>
            </div>
            </ul>
        </div>
    </nav>


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

        <!-- <form action="article_ajout.php" method="post">

        <br><label for="titre">Titre</label>
        <input type="text" name="titre"><br><br>

        <label for="contenu">Contenu</label>
        <textarea name="contenu"></textarea><br><br>

        <input type="submit">
    </form> -->

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