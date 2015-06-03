<?php
// Connexion SQL
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=timeflix', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$revision =  '1.0 Beta';
$url ="index.php";
$title="TimeFlix";
$key_crypt = '';
?>
