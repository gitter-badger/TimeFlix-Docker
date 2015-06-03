<?php 

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
$id_episode = core_encrypt_decrypt('decrypt', $_GET['id_episode']);
$search = core_encrypt_decrypt('decrypt', $_GET['search']);
$id_serie = $_GET['serie_id'];
print_r($id_episode);
echo '<br>';
echo $search;
$mail_arg = json_encode(array('id_episode'=>$_GET['episode'],'id_saison'=>$_GET['id_saison']));
$get = search_serie_torrent($search); 
$seed = 0;
foreach ($get->torrents as $key => $value)
{
	if($value->seeds > $seed)
	{
		$seed = $value->seeds;
		$hash = $value->torrent_hash;
		$magnet = $value->magnet_uri;
	}
}
echo '<br>';
$json = file_get_contents('https://getstrike.net/api/v2/torrents/info/?hashes='.$hash.''); 
$torrent = json_decode($json);
foreach($torrent->torrents['0']->file_info->file_names as $file)
{
	$status = 0;
	if(strpos($file,'avi') !== false OR strpos($file,'mkv') !== false OR strpos($file,'mp4') !== false)
	{
    	$name_file = $file;
    	$status = 1;
	}
}
echo $name_file;
$name_file = trim($name_file);
$req = $bdd->prepare("INSERT INTO `episode_serie` 
	(`id_episode`,`id_serie`, `file`, `hash`,`search`,`mail_json`) 
	VALUES
	(:id_episode,:id_serie,:file,:hash,:search,:mail_json)");
$req->bindParam(':id_episode', $id_episode);
$req->bindParam(':file', $name_file);
$req->bindParam(':id_serie', $id_serie);
$req->bindParam(':hash', $hash);
$req->bindParam(':search', $search);
$req->bindParam(':mail_json', $mail_arg);
//$req->debugDumpParams();
$req->execute();
$transmission->add($magnet);
//header("location:".  $_SERVER['HTTP_REFERER']); 
