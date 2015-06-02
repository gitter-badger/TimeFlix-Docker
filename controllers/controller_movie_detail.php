<?php

/*
Controleur movie_detail - Gère le traitement des informations récupérer par le modèle.  
*/
$id_movie = core_encrypt_decrypt('decrypt',$_GET['id_movie']);
$movie_detail = get_data('movies','
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
	LEFT JOIN movies_views ON movies_views.id_movie =  movies.id_movies
	WHERE movies.id_moviedb='.$id_movie.'');
foreach($movie_detail as $cle => $movie_detail)
{
    $films[$cle]['synopsis'] = htmlspecialchars($movie_detail['synopsis']);
}
$img = rand_local_image($movie_detail['id_moviedb']);
$list_actors = search_movie_actors_db($movie_detail['id_moviedb']);
include_once('views/view_movie_detail.php');
