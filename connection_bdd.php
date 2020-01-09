<?php
$server = 'localhost';
$login = 'root';
$pass = '';
//pour la connection a la BD
try {
    $bdd = new PDO("mysql:host=$server;dbname=bee_abeille", $login, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'connection ok';
} catch (PDOException $e) {
    echo 'Echec connection' . $e->getMessage();
}
?>