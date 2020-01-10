<?php
session_start();
include('connection_bdd.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Article</title>
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

    <div class="jumbotron text-center bg-bleu" style="margin-bottom:0">
        <h1>Vive les abeilles !!!</h1>
    </div>

    <!-- navbar -->
    <?php
    include('navbar.php');
    ?>

    <div class="container bg-blanc" style="margin-top:30px">

        <?php
            //recupère id, pseudo et id_type en fonction du pseudo dans le cookie
            $req = $bdd->prepare('SELECT id, pseudo, id_type FROM membre WHERE pseudo = ?');
            $req->execute(array($_COOKIE['gateauChoco']));
            $verif = $req->fetch();
            //si le pseudo a le type_genre = à 2 autorisé à modifier les articles
                if($verif['id_type'] == 2){
                    ?>
                    <!-- pour ajouter un billet -->
            <form action="article_ajout.php">
                <button type="submit" class="btn btn-link bg-dark-1-warning">Ajouter un article</button>
            </form>


            <?php
            //recuperer les billets
            $req = $bdd->query('SELECT id, titre, photo, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article ORDER BY date_creation DESC');
            while ($donnees = $req->fetch()) {
            ?>
                <div class="rounded mt-5 bg-jaune centre">
                    <h5 class="text-center"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
                    <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
                    <img class="img-responsive ml-5 img_article" src="images/<?= $donnees['photo'] ?>" alt="photos">
                    <p><?= htmlspecialchars($donnees['contenu']) ?> </p>
                    <a href="article_modif.php?article=<?= $donnees['id']; ?>">Modifier</a><br><a href="article_supp.php?article=<?= $donnees['id']; ?>">Supprimer</a></p>
                </div>
        <?php
            }
            $req->closeCursor();
        } else {
            echo 'Vous n\'avez pas les droits pour agir sur les articles.';
        }
    
            



        ?>
       


    </div>

    <?php
    include 'footer.php';
    ?>