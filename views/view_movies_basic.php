<div  id="detail_movie" class="row" style="top:10%;left:3%;z-index:1;">
<?php 
//print_r(generateCallTrace());
$t_films = count($films);
if($t_films == 0)
{
echo '<center><p style="font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:10%;">Votre bibliothèque est vide... </p><br>
<img style="border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://31.media.tumblr.com/c1aa669e433bb01fc397abf29da26c56/tumblr_mr1q7mqsWa1rk8p43o1_500.gif"><center>';	
}
foreach ($films as $key => $film) 
{
	$id_movies = $film['id_movies'];
	$views = get_data('movies_views',"WHERE id_users=$id_users AND id_movie=$id_movies");
	$views = array_shift($views);
	$info['percent'] = 100;
	if($film['encoding_mp4'] == 0)
	{
		$info = get_transmission($film['hash']);
	}
	echo '<div id="affiche" class="col-md-1" style="margin-left:6%;margin-bottom:3%;width:200px;height:430px;">
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
	?>
	<div style="position:absolute;height:50px;width:250px;padding:4%;z-index:1;margin-top:165%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
		        <?php
        if($film['type'] == '1080p')
        {
          echo '<img style="float:right;height:30px;" src="theme/images/hdtv.png">';
        }
        if($film['type'] == '720p')
        {
          echo '<img style="float:right;height:35px;" src="theme/images/720p.png">';
        }
        ?>
</div>
	<?php 
	echo '<img style="position:relative;width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="//pictures.timeflix.net/posters/'.$film['id_moviedb'].'.jpg"/>
	</a></br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;">'.$film['title'].'<br>
	<span class="label label-success">'.substr($film['release_date'],0,4).'</span> <span class="label label-info">'.$film['note'].'/10</span>  <span class="label label-warning"><span class="fa fa-eye"></span> '.get_view_movies($id_movies).'</span></p></div>'; 
}
?>
<div style="display: block; clear: both;"></div>
<div style="margin-top:5%;border-left:0;width: 95%;
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
echo 'TIMEFLIX - Générer en '.$total_time.' seconds - (Mem : '.format_bytes(memory_get_usage()).')';
?></center>
      </div>
</div>
</div>

