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
        <?php
        // permet de récuperer l'article selectionné sur la page index.php
        $req = $bdd->prepare('SELECT id, photo, titre, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article WHERE id = ?');
        $req->execute(array($_GET['article'])); // permet de récuperer l'id qui est sur la page index.
        $donnees = $req->fetch();
        ?>
        <div class="centre">
            <h5 class="text-center mt-5"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
            <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
            <img class="img-responsive ml-5 img_article" src="images/<?= htmlspecialchars($donnees['photo']) ?>" alt="photos">
            <p class="mt-3"><?= htmlspecialchars($donnees['contenu']) ?> </p>
        </div>


        <!-- FORMULAIRE DE MODIFICATION -->
        <h2 class="mt-5">Modifier l'article</h2>

        <form action="article_modif1.php?article=<?= $donnees['id']; ?>" method="post">

            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control form-control-sm barre" name="id" value="<?= $donnees['id']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="titre" class="col-sm-2 col-form-label col-form-label-sm">Titre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm barre" name="titre" value="<?= $donnees['titre']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="contenu" class="col-sm-2 col-form-label col-form-label-sm">Contenu</label>
                <div class="col-sm-10">
                    <textarea name="contenu" class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?= $donnees['contenu']; ?>"><?= $donnees['contenu']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="photo" class="col-sm-2 col-form-label col-form-label-sm">Photo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm barre" name="photo" value="<?= $donnees['photo']; ?>">
                    <small class="form-text text-muted">Vous devez renseigner le nom et l'extension de la photo</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <?php
    include 'footer.php';
    ?>