<?php

/*
Controleur get_film - Gère le traitement des informations récupérer par le modèle.  
*/

$films = get_data('movies',"
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
	WHERE movies.status='1' ORDER BY movies.date_add DESC LIMIT 0,5");
foreach($films as $cle => $film)
{
    $films[$cle]['synopsis'] = htmlspecialchars($film['synopsis']);
}
$id_users = $_SESSION['id_users'];
include_once('views/view_goflix.php');

