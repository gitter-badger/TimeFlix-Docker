<?php

/*
Controleur views_movies - Gère l'avancement de la lecture du fichier :)   
*/

if(!empty($_GET['id_movies']) AND !empty($_GET['duration']))
{
	$id_users = $_SESSION['id_users'];
	$id_movies = $_GET['id_movies'];
	$duration = $_GET['duration'];
	$views = get_data('movies_views',"WHERE id_users=$id_users AND id_movie=$id_movies");
	// si on un résultat on met à jour ce résultat. 
	if(count($views) == 1)
	{
		$req = $bdd->exec("UPDATE movies_views SET duration_v='$duration',date_views=NOW() WHERE id_movie='$id_movies' AND id_users='$id_users'");
		exit;
	}
	// sinon on créer haha :) s
	$req = $bdd->prepare("INSERT INTO `movies_views` 
	(`id_movie`, `id_users`,`duration_v`) 
	VALUES
	(:id_movie,:id_users,:duration_v)");
	$req->bindParam(':id_movie',$id_movies);
	$req->bindParam(':id_users',$id_users);
	$req->bindParam(':duration_v',$duration);
	$req->execute();
}