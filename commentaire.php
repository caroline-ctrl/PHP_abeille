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
                    <img class="img-responsive ml-5 img_article" src="<?= $donnees['photo'] ?>" alt="photos">
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
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control form-control-sm barre" name="id_article" value="<?= $donnees['id']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>

        <!-- <form action="commentaire_post.php?article=?= $donnees['id']; ?>" method="post">

                <label for="nom">Votre nom</label>
                <input type="text" name="auteur"><br><br>

                <label for="commentaire">Votre commentaire</label>
                <textarea name="commentaire"></textarea><br><br>

                <input type="hidden" name="id_article" value="$donnees['id']; ?>">

                <input type="submit">
            </form> -->
    <?php
            }
    ?>
    </div>
    <?php
    include('footer.php');
    ?>