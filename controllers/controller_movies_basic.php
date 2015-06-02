<?php

/*
Controleur get_film - Gère le traitement des informations récupérer par le modèle.  
*/
$value = 'files_movies.encoding_mp4 = 2';
if(!empty($_GET['type']) and $_GET['type'] == 'processed')
{
	$value = 'files_movies.encoding_mp4 != 2';
}
$id_users = $_SESSION['id_users'];
$films = get_data('movies',"
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies 
	WHERE movies.status='1' AND $value ORDER BY movies.date_add DESC");

$views = get_data('movies_views','WHERE id_users='.$_SESSION['id_users'].'');
$list_id = array();
foreach ($views as $k)
{
	$list_id[$k['id_movie']] = $k['id_movie'];
}
foreach($films as $cle => $film)
{
    $films[$cle]['synopsis'] = htmlspecialchars($film['synopsis']);
}

include_once('views/view_movies_basic.php');

