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
        <h1>Mon premier site avec Bootstrap et PHP</h1>
    </div>

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
                    <a class="nav-link text-right" href="article.php">Ecrire un article</a>
                </li>
            </div>
            </ul>
        </div>
    </nav>

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
            <form action="admin_ajout.php">
                <label>Ajouter un article :</label>
                <input type="submit" value="Ajout"><br><br>
            </form>


            <?php
            //recuperer les billets
            $req = $bdd->query('SELECT id, titre, photo, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article ORDER BY date_creation DESC');
            while ($donnees = $req->fetch()) {
            ?>
                <div class="bg-info">
                    <h5 class="text-center"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
                    <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
                    <img class="img-responsive ml-5 img_article" src="<?= $donnees['photo'] ?>" alt="photos">
                    <p><?= htmlspecialchars($donnees['contenu']) ?> </p><hr>
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