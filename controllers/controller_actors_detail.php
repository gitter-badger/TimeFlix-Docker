<?php 

$id_actors = core_encrypt_decrypt('decrypt',$_GET['id_actors']);
$data = get_data('actors',"WHERE id_movie_db_actor=$id_actors");
$actors = json_decode($data['0']['data']);
$images = get_images_actors($id_actors);
include_once('views/view_actors_detail.php');
