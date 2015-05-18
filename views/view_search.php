<div class="row" style="padding:6%;z-index: 1;color;padding-top: 8%">
    <?php
    if(isset($_GET['recherche']))
    {
        if (preg_match("`^@`",$_GET['recherche']))
        {
          $_GET['recherche'] = substr($_GET['recherche'],1);
          $films = get_search($_GET['recherche']);
          foreach ($films as $key => $film) 
          {
           	$info['percent'] = 100;
			if($film['encoding_mp4'] == 0)
			{
				$info = get_transmission($film['hash']);
			}
            $id_movies = $film['id_movies'];
			$views = get_data('movies_views',"WHERE id_users=$id_users AND id_movie=$id_movies");
			$views = array_shift($views);
            echo '<div id="affiche" class="col-md-1" style="margin-left:6%;margin-bottom:3%;width:200px;height:430px;color:white;">
            <a href="?view=movie_detail&id_movie='.core_encrypt_decrypt('encrypt',$film['id_moviedb']).'">';
            
            if($info['percent'] < 100 AND $film['status'] == 0)
            { 
              ?><div style="position:absolute;height:380px;width:250px;background:rgba(0,0,0,0.6);z-index:1;padding-top:55%;padding-left:5%;border-radius: 10px;">
              <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:10%;">
              <span class="fa fa-download"></span><br>Téléchargement en cours ...<br><?php echo $info['percent']; ?>%</p>
              <p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:10%;">
              <span class="fa fa-arrow-circle-o-down"></span> <?php echo $info['download']; ?>/s&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-up"></span> <?php echo $info['upload']; ?>/s
              </br></br><span class="fa fa-user"></span> <?php echo $info['peers']; ?> peers</p>
               </div><?php
            }
            if($info['percent'] == 100 AND $film['status'] == 1 AND $film['encoding_mp4'] == 1)
            { 
              ?><div style="position:absolute;height:380px;width:250px;background:rgba(0,0,0,0.6);z-index:1;padding-top:55%;padding-left:5%;border-radius: 10px;">
              <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:10%;">
              <span class="fa fa-cogs"></span><br>Encodage en cours ...<br><?php echo ffmpeg_pourcentage('data/log/'.$film['hash'].'.log'); ?>%</p></div><?php
            }
            if($info['percent'] == 100 AND $film['status'] == 1 AND $film['encoding_mp4'] == 0)
            { 
              ?><div style="position:absolute;height:380px;width:250px;background:rgba(0,0,0,0.6);z-index:1;padding-top:55%;padding-left:5%;border-radius: 10px;">
              <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:10%;">
              <span class="fa fa-spinner"></span><br>En attente encodage ...<br></p></div><?php
            }
            if(!empty($views['duration_v']))
			{
				$pourcent = $views['duration_v'] / $film['duration'] * 100;
				if($pourcent < 90)
				{
				?><div style="position:absolute;height:22px;width:250px;background:rgba(255,165,0,0.7);z-index:1;margin-top:0%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
				<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;border-bottom: 1px solid white;">
				En cours (<?php echo round($pourcent,1); ?> %)<br></p></div><?php
				}
				else
				{
				?><div style="position:absolute;height:22px;width:250px;background:rgba(0,128,0,0.6);z-index:1;margin-top:0%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
				<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;border-bottom: 1px solid white;">
				Déja vu !<br></p></div><?php
				}
			}   
            echo '<img style="position:relative;width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="//pictures.timeflix.net/posters/'.$film['id_moviedb'].'.jpg"/>
            </a></br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;">'.$film['title'].'<br>
            <span class="label label-success">'.substr($film['release_date'],0,4).'</span> <span class="label label-info">'.$film['note'].'/10</span> <span class="label label-warning">'.$film['type'].'</span></p></div>'; 

          unset($_GET['recherche']);
          unset($films);
        }
      }
       if (preg_match("`^acteur:`",$_GET['recherche']))
       {
        $_GET['recherche'] = substr($_GET['recherche'],7);
        echo  $_GET['recherche'];
        $actors = get_data('actors','WHERE data like \'%'.$_GET['recherche'].'%\'');
        foreach($actors as $data_serie)
         {
            $data = json_decode($data_serie['data']);
            //print_r($data);
            echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:1%;width:200px;height:410px;">
              <a href="index.php?view=actors_detail&id_actors='.core_encrypt_decrypt('encrypt',$data->id).'">
              <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="//pictures.timeflix.net/actors/'.$data->id.'.jpg"/></a>
              </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->name.'</p>
              </p></div>'; 
          }
        unset($_GET['recherche']);
       }
  }

    if(isset($_GET['recherche']) AND $_GET['recherche'] == NULL)
    {
    	echo '<center><p style="font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:2%;margin-bottom: 2%;">Oups, il manque votre recherche .. </p></center>';
    }
    if(isset($_GET['recherche']) AND $_GET['recherche'] != NULL)
    {
      $data = search_movie_db($_GET['recherche']);    	
    ?>
  <?php
  $t_count = count($data->results);
  if($t_count ==0)
  {
  	echo '<center><p style="font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:1%;">Aucun résultat trouvé... </p><br>
<img style="border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="http://media.giphy.com/media/7KMxzeirQvRUQ/giphy.gif"><center>';	
  }
    foreach($data->results as $data)
    {
      if($data->media_type == 'movie')
      {
      	if($data->popularity > 0.2 AND $data->vote_average > 0)
      	{
          if(get_movie_exist($data->id) <= 0)
          {
        	    echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:2%;width:200px;height:430px;">
              <a href="index.php?view=search&id_movie='.core_encrypt_decrypt('encrypt',$data->id).'">
              <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;opacity: 0.4;" src="https://image.tmdb.org/t/p/w396'.$data->poster_path.'"/></a>
              </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->title.'<br> 
              <span class="label label-success">'.substr($data->release_date,0,4).'</span> <span class="label label-info">'.$data->vote_average.'/10</span></p></div>'; 
          }   
          else 
          {
              echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:2%;width:200px;height:430px;">
              <a href="index.php?view=movie_detail&id_movie='.core_encrypt_decrypt('encrypt',$data->id).'">
              <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://image.tmdb.org/t/p/w396'.$data->poster_path.'"/></a>
              </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->title.'<br> 
              <span class="label label-success">'.substr($data->release_date,0,4).'</span> <span class="label label-info">'.$data->vote_average.'/10</span> 
              </p></div>';
          }
        }
      }
      if($data->media_type == 'tv')
      { 
        if($data->popularity > 0.2 AND $data->vote_average > 0)
        {
        echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:2%;width:200px;height:430px;">
              <a href="index.php?view=serie_detail&id_serie='.core_encrypt_decrypt('encrypt',$data->id).'">
              <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://image.tmdb.org/t/p/w396'.$data->poster_path.'"/></a>
              </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->name.'<br> 
              <span class="label label-success">'.substr($data->first_air_date,0,4).'</span> <span class="label label-info">'.$data->vote_average.'/10</span> 
              </p></div>';
        }
      }
    }
    echo '</div>';
    } 
echo '</div>';
    // if ID 
    if(isset($_GET['id_movie']))
    {
	    $_GET['id_movie'] = core_encrypt_decrypt('decrypt',$_GET['id_movie']);
        $data = search_movie_detail_db($_GET['id_movie']);
        $img = search_movie_images_db($_GET['id_movie']);
        $key = array_rand($img->backdrops,1);
    ?>
    <div class="bn-container_movie lazy" data-original='https://image.tmdb.org/t/p/original<?php echo $img->backdrops[$key]->file_path; ?>'>
<div style="position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.4);z-index:0;">
</div>
    </div>
    <div id="detail_movie" class="row" style="padding-top:2%;">
	<div class="row">
		<div class="col-md-5" style="margin-left: 5%;height:505px;">
			<p style="font-size:40px;text-transform: uppercase;font-weight: 300;">
				<?php echo $data->title; ?>
        <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Date de sortie : <?php echo $data->release_date; ?></p>
				<p>
          <br><br><br>
				</div>
				<div class="col-md-6" style="text-align:right;padding-top:0%;">
         <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Information</p>
					Budget : <b><?php echo number_format($data->budget, 2,'.', ','); ?> $</b></br>
          Revenue : <b><?php echo number_format($data->revenue, 2,'.', ','); ?> $</b></br></br>
					Production : <b>
					<?php 
		            foreach($data->production_companies as $production)
		            {
		             echo ''.$production->name.',&nbsp;';
		            }
		            echo '<br>';
                ?>
                </b>Pays de production : <b><?php 
                foreach($data->production_countries as $pays)
                {
                 echo ''.$pays->name.',&nbsp;';
                }
                echo '</b><br><br>';
		            foreach($data->genres as $genre)
		            {
		             echo '<span class="label label-success">'.$genre->name.'</span>&nbsp;';
		            }
		            ?>
				</div>
        <div class="col-md-12" style="
            padding-left:8%;padding-top:2%;top:10%;background:rgba(0,0,0,0.4);border-bottom:0;
        border-left:0;
        border-right:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
         <div class="col-md-2" style="margin-right:2%;width:250px;height:380px;
      margin-bottom:2%;border-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('https://image.tmdb.org/t/p/w396<?php echo $data->poster_path; ?>'); background-size: cover;">
      </div>
       <div class="col-md-9">
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Synopsis
      <p>
      <?php echo $data->overview; ?>
          <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
      <span class="fa fa-user"></span>&nbsp;&nbsp;Acteurs
      <p>
      <?php
      $list_actors = search_movie_actors_db($_GET['id_movie']);
      $list_actors = array_slice($list_actors->cast,0,10);
      foreach ($list_actors as $actor) 
      {
        if(!empty($actor->profile_path))
        {
          echo '<img src="https://image.tmdb.org/t/p/w45'.$actor->profile_path.'" alt="" class="actor">';
        }
      }
      ?>
       <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
        <span class="fa fa-cloud-download"></span>&nbsp;&nbsp;Téléchargement (Titre francais)
      <p>
<?php 
    if(!empty($_GET['surcharge']))
    {
      $data->original_title = $_GET['surcharge'];
    }
    $torrent_list = search_movie_torrent($data->original_title,'FRENCH'); 
   if($torrent_list != FALSE)
       {

            echo '<table class="table">
              <thead>
                <tr>
                  <th>Nom du fichier</th>
                  <th>Taille</th>
                  <th>Seeders</th>
                  <th>Leechers</th>
                  <th>Télécharger</th>
                   <th>Action</th>
                </tr>
              </thead>
              <tbody>
';
            foreach ($torrent_list->torrents as $torrent)
            {
              //print_r($torrent);
              echo '<tr>
              <td>'.$torrent->torrent_title.'</td>
              <td>'.format_bytes($torrent->size).'</td>
              <td>'.$torrent->seeds.'</td>
              <td>'.$torrent->leeches.'</td>
              <td>'.$torrent->download_count.'</td>
              <td><a  href="?view=add_movie&hash='.core_encrypt_decrypt('encrypt',$torrent->torrent_hash).'&id_movie='.core_encrypt_decrypt('encrypt',$_GET['id_movie']).'" class="btn btn-success"><span class="fa fa-plus"></span> Ajouter</a></td>
            </tr>
          ';
            }
            echo '
              </tbody></table>';
}
else
{
  echo '<center style="text-transform: uppercase;font-weight: 300;">Aucune données de disponible ..</center>';
}
if($_SESSION['id_users'] == 1)
              {
              ?> 
                     <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
        <span class="fa  fa-cloud-upload"></span>&nbsp;&nbsp;Envoyer votre torrent
      <p>
<form enctype="multipart/form-data" action="?view=add_movie&id_movie=<?php echo core_encrypt_decrypt('encrypt',$_GET['id_movie']); ?>" method="post">
 <div class="form-group" style="text-transform: none;text-shadow:none;">
    <input type="file" name="torrent" type="file" id="styled-finputs-example">
  </div>
          <input style="float:right" type="submit" class="btn btn-default" name="upload_ok" value="Ajouter"/>

</form>

              <?php
            }
?>            <div style="margin-top:5%;border-left:0;
        border-right:0;
          border-top:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
        </div>  
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;"><?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'TIMEFLIX - Générer en '.$total_time.' seconds';
?></center>
	</div>
  <?php
    }
    ?>
