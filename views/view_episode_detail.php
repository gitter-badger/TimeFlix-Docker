  <?php 
  foreach ($saison_list->episodes as $key => $episodes)
  {
    $back = 'http://static.eu2013.lt/uploads/news/images/584x387_crop/image-not-found.png';
    if(!empty($episodes->still_path))
    {
      $back = 'https://image.tmdb.org/t/p/w396'.$episodes->still_path.'';
    }
    $syno = 'Contenu indisponible';
    $episodes_detail = get_data('episode_serie',' WHERE id_episode='.$episodes->id.'');
    if(!empty($episodes_detail))
    {
      if($episodes_detail['0']['status'] == 0 OR $episodes_detail['0']['encoding_mp4'] == 0)
      {
        $percent = get_transmission_serie($episodes->id);
      }
    }
    if(!empty($episodes->overview))
    {
      $syno = $episodes->overview;
    }
    ?>
  <div class="col-md-2" style="width:396px;height:210px;
border-radius: 10px;box-shadow: 1px 1px 8px #000;padding-left: 0%;">
  <?php 
  if(empty($episodes_detail))
  {
    if(!empty($_GET['surchage']))
    {
      $args = $_GET['surchage'];
    }
    $args = 'HDTV';
    ?>
  <div style="position:absolute;height:210px;width:396px;background:rgba(0,0,0,0.6);z-index:1;border-radius: 10px;">
  <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 18%;">
  Télécharger <br>
  <a class="btn btn-warning" href="javascript:getFileSimple('.chargement','index.php?view=add_serie&episode=<?php echo $episodes->episode_number; ?>&id_saison=<?php echo $_GET['saison']; ?>&serie_id=<?php echo $id_serie; ?>&id_episode=<?php echo core_encrypt_decrypt('encrypt',$episodes->id); ?>&search=<?php echo core_encrypt_decrypt('encrypt',generate_stike($name,$_GET['saison'],$episodes->episode_number,$args));?>')">
  <span class="fa fa-cloud-download"></span></a>
 </p>
</div>
<?php
}
if(!empty($percent) AND $percent['percent'] <= 99 AND $episodes_detail['0']['encoding_mp4'] == 0)
  {?>
  <div style="position:absolute;height:210px;width:396px;background:rgba(0,0,0,0.6);z-index:1;border-radius: 10px;">
  <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 10%;">
  <span class="fa fa-cloud-download"></span> Téléchargement<br>
  <?php echo $percent['percent']; ?> %
  <p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:5%;">
<span class="fa fa-arrow-circle-o-down"></span> <?php echo $percent['download']; ?>/s&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-up"></span> <?php echo $percent['upload']; ?>/s
</br></br><span class="fa fa-user"></span> <?php echo $percent['peers']; ?> peers</p>
  </a>
 </p>
</div>
<?php
}
$episodes_detail = get_data('episode_serie',' WHERE id_episode='.$episodes->id.'');
if(!empty($episodes_detail) AND $episodes_detail['0']['encoding_mp4'] == 1)
{
  ?>
  <div style="position:absolute;height:210px;width:396px;background:rgba(0,0,0,0.6);z-index:1;border-radius: 10px;">
  <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 20%;">
  <span class="fa fa-cogs"></span> Encodage<br>
  <?php echo ffmpeg_pourcentage('data/log/'.$episodes_detail['0']['hash'].'.log'); ?> %</p>
  </a>
 </p>
</div>
  <?php
}
 if(isset($percent['percent']) AND $percent['percent'] == 100 AND $episodes_detail['0']['encoding_mp4'] == 0)
{
  ?>
  <div style="position:absolute;height:210px;width:396px;background:rgba(0,0,0,0.6);z-index:1;border-radius: 10px;">
  <p style="font-size:25px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 15%;">
  <span class="fa fa-cogs"></span><br>
  En attente d'encodage </p>
  </a>
 </p>
</div>
  <?php
}
if(isset($episodes_detail['0']['encoding_mp4']) AND $episodes_detail['0']['encoding_mp4'] == 2)
{
	$movie_detail = get_data('movies_views','
	INNER JOIN episode_serie ON episode_serie.id_episode = movies_views.id_movie
	WHERE episode_serie.id_episode='.$episodes->id.' AND movies_views.id_users='.$_SESSION['id_users'].'');
	if(!empty($movie_detail))
	{
	$movie_detail = array_shift($movie_detail);
	$pourcent = $movie_detail['duration_v'] / $movie_detail['duration'] * 100;
	if($pourcent < 98)
	{
	?><div style="position:absolute;height:22px;width:396px;background:rgba(255,165,0,0.7);z-index:1;margin-top:0%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
		<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;border-bottom: 1px solid white;">
		En cours (<?php echo round($pourcent,1); ?> %)<br></p>
		 <p style="font-size:25px;text-transform: uppercase;text-align:right;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 2%;padding-right: 3%;">
  <a target="_blank" href="index.php?view=webplayer&id_episode=<?php echo $episodes->episode_number; ?>&id_serie=<?php echo $_GET['serie_id'] ?>&season=<?php echo $_GET['saison'] ?>&hash=<?php echo core_encrypt_decrypt('encrypt',$episodes_detail['0']['hash']); ?>" style="color:white;"><span class="fa fa-play"></span> Reprendre<br></a>
  </p>

		</div><?php
	}
	if($pourcent > 98)
	{
		?><div style="position:absolute;height:22px;width:396px;background:rgba(0,128,0,0.6);z-index:1;margin-top:0%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
		<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;border-bottom: 1px solid white;">
		Déja vu !<br></p></div><?php
			}
	}
	else
	{
  ?>
  <div style="position:absolute;height:210px;width:396px;background:rgba(0,0,0,0.2);z-index:1;border-radius: 10px;">
  <p style="font-size:25px;text-transform: uppercase;text-align:right;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding-top: 2%;padding-right: 3%;">
  <a target="_blank" href="index.php?view=webplayer&id_episode=<?php echo $episodes->episode_number; ?>&id_serie=<?php echo $_GET['serie_id'] ?>&season=<?php echo $_GET['saison'] ?>&hash=<?php echo core_encrypt_decrypt('encrypt',$episodes_detail['0']['hash']); ?>" style="color:white;"><span class="fa fa-play"></span> Lire<br></a>
  </p>
  </a>
 </p>
</div>
  <?php
	  }
}
?>

<img style="border-radius: 10px;width:396px;height:210px;" src="<?php echo $back; ?>"/>
</div>
 <div class="col-md-7" style="min-height: 260px;margin-left:2%;">
  <?php
    echo '
    <legend style="color:white;">Episode '.$episodes->episode_number.' - '.$episodes->name.' <span style="float:right" class="label label-success">'.$episodes->air_date.'</span></legend>
    <span>'.$syno.'</span>
  </div>
     ';
     unset($percent);
   }
  ?>