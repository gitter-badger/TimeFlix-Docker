<?php

/*
Controleur add_movie - Gère le traitement des informations récupérer par le modèle.  
*/
if(!isset($_SESSION))
{
	exit;
}
header('Content-Type: text/html; charset=utf-8');
require_once 'library/transmission/vendor/autoload.php';
use Transmission\Client;
use Transmission\Model\File;
use Transmission\Transmission;


$client = new Client();
$client->authenticate('admin', 'timeflix');
$transmission = new Transmission();
$transmission->setClient($client);
$queue = $transmission->all();
if (isset($_FILES["torrent"]))
{
	$filesTorrent = fopen($_FILES["torrent"]["tmp_name"], 
		"rb") or die(" File check error");
	$filesTorrentSize = filesize($_FILES["torrent"]["tmp_name"]);
	$alltorrent = fread($filesTorrent, $filesTorrentSize);
	//checktorrent($alltorrent);
	$_GET['hash'] = core_encrypt_decrypt('encrypt',strtoupper(calchash($alltorrent)));
	$name = parcourirtorrent($filesTorrentSize,$alltorrent);
	foreach (parcourirtorrent($filesTorrentSize,$alltorrent) as $key => $value) 
	{
		if(strpos($name['name'],'avi') !== false OR strpos($name['name'],'mkv') !== false OR strpos($name['name'],'mp4') !== 		false)
		{
			$name_file = ''.$name['name'].'';
			$add = $_FILES["torrent"]["tmp_name"];
			$status = 1;
			move_uploaded_file($_FILES["torrent"]["tmp_name"], 'data/downloads/'.calchash($alltorrent).'.torrent');
			$add = '/var/www/time/data/downloads/'.calchash($alltorrent).'.torrent';
			continue;
		}
		if(strpos($value,'avi') !== false OR strpos($value,'mkv') !== false OR strpos($value,'mp4') !== false)
		{
			$name_file = ''.$name['name'].'\\'.substr($value,0,-4).'';
			$add = $_FILES["torrent"]["tmp_name"];
			$status = 1;
			move_uploaded_file($_FILES["torrent"]["tmp_name"], 'data/downloads/'.calchash($alltorrent).'.torrent');
			$add = '/var/www/time/data/downloads/'.calchash($alltorrent).'.torrent';
			exec('chmod -R 777 /var/www/time/data/downloads/'.calchash($alltorrent).'.torrent');
		}
	}
}
if(!empty($_GET['id_movie']) AND !empty($_GET['hash']))
{
	$id_movie = core_encrypt_decrypt('decrypt', $_GET['id_movie']);
	$hash = core_encrypt_decrypt('decrypt', $_GET['hash']);
	$data = search_movie_detail_db($id_movie);
	$budget = number_format($data->budget, 2,'.', ',').' $';
	$revenue = number_format($data->revenue, 2,'.', ',').' $';
	$datetime = date('Y-m-d H:i:s');
	$production = NULL;
	$i=0;
	if(!isset($_FILES["torrent"]))
	{
		$json = file_get_contents('https://getstrike.net/api/v2/torrents/info/?hashes='.$hash.''); 
		$torrent = json_decode($json);
		$status = 0;
		foreach($torrent->torrents['0']->file_info->file_names as $file)
		{
			if(strpos($file,'.avi') !== false OR strpos($file,'.mkv') !== false OR strpos($file,'.mp4') !== false)
			{
		    	$name_file = $file;
		    	$status = 1;
			}
		}
	}
	if($status == 1)
	{
		foreach($data->production_countries as $pays)
		{	
			if($i == 0)
			{
			$production = $production.''.$pays->name;
			$i++;
			continue;	
			}
		 	$production = $production.', '.$pays->name;
		 	$i++;
		}
		$prod = NULL;
		$i=0;
		foreach($data->production_companies as $prd)
		{	
			if($i == 0)
			{
			$prod = $prod.''.$prd->name;
			$i++;
			continue;	
			}
		 	$prod = $prod.', '.$prd->name;
		 	$i++;
		}
		$tags = NULL;
		$i=0;
		foreach($data->genres as $tag)
		{	
			if($i == 0)
			{
				$tags = $tags.''.$tag->name;
				$i++;
				continue;	
			}
		 	$tags = $tags.','.$tag->name;
		 	$i++;
		}
		$req = $bdd->prepare("INSERT INTO `movies` 
			(`id_movies`, `title`, `synopsis`, `budget`, `returned`, `production`, `country_of_production`,`tags`, `id_moviedb`, `release_date`, `note`, `status`, `date_add`) 
			VALUES
			('',:name,:synopsis,:budget,:revenue,:prod,:pays,:tags,:id_movie,:release_date,:note,'1',:datetime)");
		
		$req->bindParam(':name', $data->title);
		$req->bindParam(':synopsis',utf8_decode($data->overview));
		$req->bindParam(':budget', $budget);
		$req->bindParam(':revenue', $revenue);
		$req->bindParam(':id_movie', $data->id);
		$req->bindParam(':release_date', $data->release_date);
		$req->bindParam(':note', $data->vote_average);
		$req->bindParam(':datetime', $datetime);
		$req->bindParam(':pays', $production);
		$req->bindParam(':prod', $prod);
		$req->bindParam(':tags', $tags);
		//$req->debugDumpParams();
		$req->execute();
		$last_id = $bdd->lastInsertId();
		$req = $bdd->prepare("INSERT INTO `files_movies` 
			(`id_file_movies`, `name`, `hash`, `add_date`, `encoding_mp4`, `id_movies`, `status`) 
			VALUES
			('',:name,:hash,:add_date,'0',:id_movies,'0')");
		$req->bindParam(':name', $name_file);
		$req->bindParam(':add_date', $datetime);
		$req->bindParam(':hash', $hash);
		$req->bindParam(':id_movies', $last_id);
		//$req->debugDumpParams();
		$req->execute() or die(print_r($req->errorInfo(), true));
		echo exec('wget -O data/posters/'.$data->id.'.jpg https://image.tmdb.org/t/p/w396'.$data->poster_path.'&');
		//echo "Downloading to: {$transmission->getSession()->getDownloadDir()}\n";
		if(empty($add))
		{
			$add = $torrent->torrents[0]->magnet_uri;
		}
		$transmission->add($add);
		//header('Location: index.php'); 
    	$corps = '<h1>'.$data->title.'</h1>
    	'.$data->overview.'';
	} 
	include_once('views/view_add_movie.php');
}
