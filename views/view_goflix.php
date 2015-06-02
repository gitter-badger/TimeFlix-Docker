<div  id="detail_movie" class="row" style="top:8%;z-index:1;width: 45%;margin-right:auto;margin-left:auto;height:46px;">
<center><p style="font-size:60px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:2%;"><i class="fa fa-download"></i> GoFlix !</p></center>
<form class="ajax" id="goflix" method="get" class="search-form" style="box-shadow: 1px 1px 8px #000;">
	<div class="input-group input-group-lg">
		<span class="input-group-addon no-background"><span class="fa fa-search" style="text-shadow: none;"></span></span>
		<input class="form-control" type="text" name="q" id="q" style="border:1px solid #eee;" placeholder="Entre le nom d'un film ...">
	</div> <!-- / .input-group -->
		<div class="alert alert-success" role="alert" style="margin-top:1%;text-shadow: 0px 0px #000;">Astuce : Vous souhaitez filtrer votre bibliotèque ? Tapez @ suivis de votre mot clé ! </div>	
</form>
</div>
<div id="results" style="padding-top: 14%;">
<?php
if(count($films) != 0)
{
	echo '
<div  class="row" style="padding-top:8%;margin-left: 3%;margin-right: auto;color:white;">
<p style="font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-bottom:2%;margin-left: 6%;"><i class="fa fa-star"></i> Derniers ajouts</p>';
} 
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
	echo '<img style="position:relative;width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="data/posters/'.$film['id_moviedb'].'.jpg"/>
	</a></br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;">'.$film['title'].'<br>
	<span class="label label-success">'.substr($film['release_date'],0,4).'</span> <span class="label label-info">'.$film['note'].'/10</span> <span class="label label-warning">'.$film['type'].'</span></p></div>'; 
}
?></div>
<div style="display: block; clear: both;"></div>
