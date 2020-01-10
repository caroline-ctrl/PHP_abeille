<?php
session_start();
include('connection_bdd.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Commentaires</title>
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
        <h1>Vive les abeilles !!!</h1>
    </div>


    <!-- navbar -->
    <?php
    include('navbar.php');
    ?>


    <a href="index.php">Retour à la page d'accueil</a>

    <div class="container">
            <?php
            // permet de récuperer l'article selectionné sur la page index.php
            $req = $bdd->prepare('SELECT id, titre, photo, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article WHERE id = ?');
            $req->execute(array($_GET['article'])); // permet de récuperer l'id qui est sur la page article.
            $donnees = $req->fetch();

            //verifie que l'article demandé existe, si oui les commentaires sont visibles ainsi que le formulaire sinon, message d'erreur
            if (empty($donnees)) {
                echo "<br><strong>Ce billet n'existe pas</strong>";
            } else {
            ?>
                <div class="centre">
                    <h5 class="text-center"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
                    <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
                    <img class="img-responsive ml-5 img_article" src="images/<?= $donnees['photo'] ?>" alt="photos">
                    <p class="mt-3"><?= htmlspecialchars($donnees['contenu']) ?> </p>
                </div>


        <h2 class="mt-5">Commentaires</h2>
        <?php
                $req->closeCursor();
                // affiche les commentaires liés à l'article selectionné
                $com = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, "%d/%m/%Y à %Hh%imin%ss") AS date_com FROM commentaire WHERE id_article = ? ORDER BY date_commentaire DESC LIMIT 0, 5');
                $com->execute(array($_GET['article']));
                while ($essaie = $com->fetch()) {
        ?>
            <p><strong><?= htmlspecialchars($essaie['auteur']) ?></strong> le <?= htmlspecialchars($essaie['date_com'])  ?><br>
                <?= htmlspecialchars($essaie['commentaire']) ?></p>

        <?php
                }
                $req->closeCursor();
        ?>


        <!-- formulaire permettant d'ajouter un commentaire à l'article -->
        <h2 class="mt-5">Ajouter un commentaire au billet</h2>

        <form action="commentaire_post.php?article=<?= $donnees['id']; ?>" method="post">

            <div class="form-group row">
                <label for="nom" class="col-sm-2 col-form-label col-form-label-sm">Votre nom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm barre" name="auteur">
                </div>
            </div>
            <div class="form-group row">
                <label for="commentaire" class="col-sm-2 col-form-label col-form-label-sm">Votre commentaire</label>
                <div class="col-sm-10">
                    <textarea name="commentaire" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control form-control-sm barre" name="id_article" value="<?= $donnees['id']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>


    <?php
            }
    ?>
    </div>
    <?php
    include('footer.php');
    ?>