<?php
// Connexion SQL
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=timeflix', 'root', 'timeflix2015');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

$revision =  '1.0 Beta';
$url ="index.php";
$title="TimeFlix";
$imageslink = "images/";
$videolink = "//timeflix.net/downloads/";
$serie = '/var/www/timeflix.net/web/downloads/';
$sabnapi = '42ef35dda9ba40faf0137ff80e9b74e3';
$saburl = '62.210.136.116:8080';
$key_crypt = '*mr6dRQ9T/@5Gn9c!5S-';
?>
