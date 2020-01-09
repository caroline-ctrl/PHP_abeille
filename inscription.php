<?php
include('connection_bdd.php');

if (isset($_POST['pseudo']) and isset($_POST['passwd']) and isset($_POST['passwd2']) and isset($_POST['mail'])) {

    //compte le nombre d'id qui ont le meme pseudo que celui rentré dans le formulaire
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $req = $bdd->prepare('SELECT COUNT(id) AS id_pseudo FROM membre WHERE pseudo = ?');
    $req->execute(array($pseudo));
    $verif = $req->fetch();
    // echo $verif['id_pseudo']; 
    //si le nbr d'id ayant le meme pseudo est = à 0 ca veut dire que le pseudo est libre
    if ($verif['id_pseudo'] == 0) {
        // echo 'pseudo libre';
    } elseif ($verif['id_pseudo'] > 0) {
        echo 'Désolée, le pseudo est déjà pris.';
    }



    //verifie que le passwd est identique
    // protection des donnees rentrees
    $_POST['passwd'] = htmlspecialchars($_POST['passwd']);
    $_POST['passwd2'] = htmlspecialchars($_POST['passwd2']);
    if ($_POST['passwd'] != $_POST['passwd2']) {
        echo "<br>les mots de passe ne sont pas identiques";
    } else {
        // echo "<br>psswd ok";
    }
    // Hachage du mot de passe
    $pass_hache = password_hash($_POST['passwd'], PASSWORD_DEFAULT);



    //verifie que le mail est bon
    // protection des donnees rentrees
    $mail = htmlspecialchars($_POST['mail']);
    if (preg_match("#^[a-z0-9._-]{1,}@+[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)) {
        // echo '<br>L\'adresse ' . $mail . ' est valide !<br>';
    } else {
        echo '<br>L\'adresse ' . $mail . ' n\'est pas valide, recommencez !<br>';
    }




    //Insertion dans la base de données
    if (($verif['id_pseudo'] == 0) and ($_POST['passwd'] == $_POST['passwd2']) and (preg_match("#^[a-z0-9._-]{1,}@+[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail))) {

        $req = $bdd->prepare('INSERT INTO membre(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, NOW())');
        $req->execute(array(
            'pseudo' => $pseudo,
            'pass' => $pass_hache,
            'email' => $mail
        ));
        echo 'Vous êtes inscrit.';
        
        //creation de session
        if ($pass_hache) {
            session_start();
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $pseudo;
            echo 'Vous êtes connecté !<br>';
            header('location: index.php');
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }

        //creation de cookies
        if (isset($_POST['connec']) and isset($_POST['passwd'])) {
            if ($_POST['connec'] == 'valeur1') {
                setcookie('gateauChoco', $_POST['pseudo'], time() + 365 * 24 * 3600, null, null, false, true);
                $pass_hache = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
                setcookie('gateauVanille', $pass_hache, time() + 365 * 24 * 3600, null, null, false, true);
            }
        }
        header('location: index.php');
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
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>

<body>

    <form action="inscription.php" method="post">
        <div class="form-group row">
            <label for="pseudo" class="col-sm-2 col-form-label col-form-label-sm">Pseudo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm barre" name="pseudo">
            </div>
        </div>
        <div class="form-group row">
            <label for="passwd" class="col-sm-2 col-form-label col-form-label-sm">Mot de passe</label>
            <div class="col-sm-10">
                <input type="password" class="form-control form-control-sm barre" name="passwd">
                <!-- <span id="but">voir</span> -->
            </div>
        </div>
        <div class="form-group row">
            <label for="passwd2" class="col-sm-2 col-form-label col-form-label-sm">Retapez votre mot de passe</label>

            <div class="col-sm-10">
                <input type="password" class="form-control form-control-sm barre" name="passwd2">
                <!-- <span id="but">voir</span> -->
            </div>
        </div>
        <div class="form-group row">
            <label for="mail" class="col-sm-2 col-form-label col-form-label-sm">Adresse email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control form-control-sm barre" name="mail">
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

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>