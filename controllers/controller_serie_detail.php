<?php

/*
Controleur movie_detail - Gère le traitement des informations récupérer par le modèle.  
*/
$id_serie = core_encrypt_decrypt('decrypt',$_GET['id_serie']);
if(isset($_GET['favorie']) AND $_GET['favorie'] == 'add')
{
	$req = $bdd->prepare("INSERT INTO `favoris` 
		(`id_users`, `id_series`)
		VALUES
		(:id_users,:id_series)");
	$req->bindParam(':id_users',$_SESSION['id_users']);
	$req->bindParam(':id_series', $id_serie);
	
	$req->execute();
}
if(isset($_GET['favorie']) AND $_GET['favorie'] == 'remove')
{
	$bdd->exec('DELETE FROM favoris WHERE id_users='.$_SESSION['id_users'].' AND id_series='.$id_serie.'');
}
if(get_serie_exist($id_serie) == 0)
{
	$data = search_serie_detail_db($id_serie);
	if(!empty($data))
	{
		$req = $bdd->prepare("INSERT INTO `series` 
			(`id_serie_db`, `data`)
			VALUES
			(:id_serie_db,:data)");
		$req->bindParam(':id_serie_db',$id_serie);
		$req->bindParam(':data', json_encode($data));
		$req->execute() or die(print_r($req->errorInfo(), true));
	}
}
else
{
	$data = get_data('series',"WHERE id_serie_db=$id_serie");
	$data = json_decode($data['0']['data']);
}
$actors = search_serie_actors_db($id_serie);
// $movie_detail = get_data('movies','
// 	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
// 	LEFT JOIN movies_views ON movies_views.id_movie =  movies.id_movies
// 	WHERE movies.id_moviedb='.$id_movie.'');
// foreach($movie_detail as $cle => $movie_detail)
// {
//     $films[$cle]['synopsis'] = htmlspecialchars($movie_detail['synopsis']);
// }
// $img = rand_local_image($movie_detail['id_moviedb']);
// $list_actors = search_movie_actors_db($movie_detail['id_moviedb']);
include_once('views/view_serie_detail.php');
