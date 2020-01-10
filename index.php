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
        <h1>Vive les abeilles !!!</h1>
    </div>


    <!-- navbar -->
    <?php
    include('navbar.php');
    ?>


    <!-- presentation -->
    <div class="container bg-blanc" style="margin-top:30px">
        <div class="row">
            <div class="col-sm-4">
                <h2>Maïa la petite abeille !</h2>
                <h5>Ma photo :</h5>
                <img class="img-responsive img_pres" src="images/bee4.jpg" alt="ma photo">
                <p class="mb-5">Je suis une petite abeille qui apprends à butiner sans gaspillage.</p>

                <div class="bg-light-4-warning">
                    <h3 class="mt-3">Boutique</h3>
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link color_a" href="#">Miel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color_a" href="#">Cire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color_a" href="#">Polen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color_a" href="#">Gelée royale</a>
                        </li>
                    </ul>
                    <hr class="d-sm-none">
                </div>

                <!-- articles -->
            </div>
            <div class="offset-sm-1 col-sm-7">
                <h2 id="articles">Voici les articles que j'ai écrits.</h2>

                <?php
                //Récupère la page via une requête GET, s'il n'existe pas par défaut la page à 1
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                // Nombre de billets a afficher sur chaque page
                $records_per_page = 3;
                // afficher les billets par le titre, la date et l'heure dans l'ordre descendant et limité a 5

                $req = $bdd->prepare('SELECT id, titre, photo, contenu, DATE_FORMAT(date_creation, "%d/%m/%Y à %Hh%imin%ss") AS date_crea FROM article ORDER BY date_creation DESC LIMIT :current_page, :record_per_page');
                $req->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
                $req->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
                $req->execute();

                while ($donnees = $req->fetch()) {
                ?>
                    <br>
                    <div class="centre">
                        <h5 class="text-center"><strong><?= htmlspecialchars($donnees['titre']) ?></strong></h5>
                        <p class="text-center"><i> le <?= htmlspecialchars($donnees['date_crea'])  ?></i></p>
                        <img class="img-responsive ml-5 img_article" src="images/<?= $donnees['photo'] ?>" alt="photos">
                        <p><?= htmlspecialchars($donnees['contenu']) ?> </p>
                        <!-- pour cacher "commentaire" quand on est pas connecté-->
                        <?php
                        if (isset($_COOKIE['gateauChoco'])) {
                        ?>
                            <a href="commentaire.php?article=<?= $donnees['id']; ?>">Commentaires</a>
                        <?php
                        }
                        ?>
                        <hr>
                    </div>
                <?php
                }
                $req->closeCursor();
                // permet d'obtenir le nombre total de billets
                $num_contacts = $bdd->query('SELECT COUNT(*) FROM article')->fetchColumn();
                ?>

                <!-- petit simbole en bas pour tourner les pages de billet -->
                <div class="pagination">
                    <?php if ($page > 1) : ?>
                        <a href="index.php?page=<?= $page - 1 ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                    <?php endif; ?>
                    <?php if ($page * $records_per_page < $num_contacts) : ?>
                        <a href="index.php?page=<?= $page + 1 ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>


    <?php
    include 'footer.php';
    ?>