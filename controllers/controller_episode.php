<?php 
// $saison_list = get_saison($_GET['serie_id'],$_GET['saison']);
// $name = core_encrypt_decrypt('decrypt',$_GET['name']);
$episode = get_episode($_GET['id_serie'],$_GET['id_saison'],$_GET['id_episode']);
$id_serie = $_GET['id_serie'];
$movie_detail['id_movies'] =$episode->id;
$data = get_data('series',"WHERE id_serie_db=$id_serie");
$data = json_decode($data['0']['data']);
include_once('views/view_episode.php');
