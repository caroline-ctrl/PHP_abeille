<?php
include ('connection_bdd.php');

//on verifie le chemin
if (htmlspecialchars(isset($_POST['pseudo'])) and htmlspecialchars(isset($_POST['pass']))) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    //recuperation de l'id et du pass de la bdd 
    $req = $bdd->prepare('SELECT id, pass FROM membre WHERE pseudo = :pseudo');
    $req->execute(array(
        'pseudo' => $pseudo
    ));
    $resultat = $req->fetch();
    //compare le passwd renseigné dans le formulaire avec celui de la bdd
    $isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);
    //si le pseudo n'est pas le meme que la bdd
    if (!$resultat) {
        echo 'Mauvais identifiant ou mot de passe !';
    } else {
        //si le pseudo et le passwd sont identique création d'une session pour être connecté.
        if ($isPasswordCorrect) {
            session_start();
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $pseudo;
            echo 'Vous êtes connecté !<br>';
            header('location: index.php');
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    }
}

//création de deux cookies pour que l'utilisateur
if(isset($_POST['connec']) AND isset($_POST['pass'])){
    if($_POST['connec'] == 'valeur1'){
        setcookie('gateauChoco', $_POST['pseudo'], time()+365*24*3600, null, null, false, true);
        $pass_hache = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
        setcookie('gateauVanille', $pass_hache, time()+365*24*3600, null, null, false, true);
    }
}
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <title>Connection</title>
</head>

<body>

    <form action="connexion.php" method="post">
        <div class="form-group row">
            <label for="pseudo" class="col-sm-2 col-form-label col-form-label-sm">Pseudo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm barre" name="pseudo">
            </div>
        </div>
        <div class="form-group row">
            <label for="passwd" class="col-sm-2 col-form-label col-form-label-sm">Mot de passe</label>
            <div class="col-sm-10">
                <input type="password" class="form-control form-control-sm barre" name="pass">
                <!-- <span id="but">voir</span> -->
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">Restez connecté</div>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="connec" value="valeur1">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>


    <?php
include 'footer.php';
?>