<?php

/*
Controleur get_film - Gère le traitement des informations récupérer par le modèle.  
*/

$films = get_data('movies',"
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies");
foreach($films as $cle => $film)
{
    $films[$cle]['synopsis'] = htmlspecialchars($film['synopsis']);
}
$views = get_data('movies_views','WHERE id_users='.$_SESSION['id_users'].'');
$list_id = array();
foreach ($views as $k)
{
	$list_id[$k['id_movie']] = $k['id_movie'];
}
$id_users = $_SESSION['id_users'];
include_once('views/view_goflix.php');

