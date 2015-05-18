<?php 
$saison_list = get_saison($_GET['serie_id'],$_GET['saison']);
$id_serie = $_GET['serie_id'];
$name = core_encrypt_decrypt('decrypt',$_GET['name']);
include_once('views/view_episode_detail.php');