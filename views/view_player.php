<?php
$episode = get_episode($_GET['id_serie'],$_GET['saison'],$_GET['id_episode']);
$id_serie = $_GET['id_serie'];
$movie_detail['id_movies'] =$episode->id;
$id_episode = $episode->id;
$data = get_data('episode_serie',"WHERE id_episode=$id_episode");
?>
<div id="detail_movie" class="row" style="padding-top:1%;height:80%;background:rgba(0,0,0,0.2)">
	<div class="row">
			<br>
			<?php if(empty($data))
			{?>
			<div class="col-md-3"></div>
			<div class="col-md-6" style="float:left;padding-left: 2%;background:rgba(0,0,0,0.6);border-radius: 5px;padding-top:1%;padding-bottom: 0%;">
			<p style="font-size:40px;text-transform: uppercase;font-weight: 300;"><?php echo 'épisode '.$episode->episode_number.' - '.$episode->name.''; ?></p>
			<?php echo $episode->overview; ?>
			</br>	</br>			</div>
			<div style="display: block; clear: both;"></div>
			<div class="col-md-3"></div>
			<div class="col-md-6" style="float:left;padding-left: 2%;background:rgba(0,0,0,0.6);border-radius: 5px;padding:1%;margin-top:1%;">
			<center>L'épisode n'est pas disponible en base</center>
			</div>
			<?php }
			else
			{
			?>
				<div class="col-md-10" style="height:10px;"></div>
			<div class="col-md-6" style="float:right;padding-bottom: 1%;">
		<video id="player" style="width:80%;float:left;border-radius: 5px;box-shadow: 1px 1px 8px #000;" controls>
			  <source src="<?php echo secure_link('/video/'.$data['0']['hash'].'.mp4'); ?>" type="video/mp4">
  <track kind="captions" src="data/subtiles/<?php echo $data['0']['hash']; ?>.vtt" srclang="en" label="French Subtitles" default/>
</video>
</div>
<div class="col-md-2" style="height:50px;"></div>
<div class="col-md-4" style="float:left;padding-left: 2%;background:rgba(0,0,0,0.6);border-radius: 5px;padding-top:1%;padding-bottom: 2%;margin-top:0%;">
<p style="font-size:40px;text-transform: uppercase;font-weight: 300;"><?php echo ''.$episode->name.''; ?></p></p>
<?php echo $episode->overview; ?>
</div>
<?php
}?>
</center>
</div>
<div id="playerduration" style="display: none"/>
<script language="Javascript">
	var vid = document.getElementById("player");
	setInterval(function() {
	     $("#playerduration").load("index.php?view=views_movies&duration="+vid.currentTime+"&id_movies=<?php echo $id_episode;?>");
	}, 4000);
</script> 