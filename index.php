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
                    if(isset($_COOKIE['gateauChoco'])){
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

    <!-- presentation -->
    <div class="container bg-blanc" style="margin-top:30px">
        <div class="row">
            <div class="col-sm-4">
                <h2>Maïa la petite abeille !</h2>
                <h5>Ma photo :</h5>
                <img class="img-responsive img_pres" src="images/bee4.jpg" alt="ma photo">
                <p>Je suis une petite abeille qui apprends à butiner sans gaspillage.</p>



    <!-- articles -->
            </div>
            <div class="offset-sm-1 col-sm-7">
                <h2 id="articles">Voici les articles que j'ai écrits.</h2>

                <?php
                $req = $bdd->query('SELECT id, titre, photo, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article ORDER BY date_creation DESC LIMIT 0, 3');
                while ($donnees = $req->fetch()) {
                ?>
                    <br>
                    <div class="centre">
                        <h5 class="text-center"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
                        <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
                        <img class="img-responsive ml-5 img_article" src="<?= $donnees['photo'] ?>" alt="photos">
                        <p><?= htmlspecialchars($donnees['contenu']) ?> </p>
                        <!-- pour cacher "commentaire" quand on est pas connecté-->
                    <?php
                    if(isset($_COOKIE['gateauChoco'])){
                        ?>
                        <a href="commentaire.php?article=<?= $donnees['id']; ?>">Commentaires</a>
                        <?php
                    }
                    ?>
                        <hr>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>


    <?php
    include 'footer.php';
    ?>