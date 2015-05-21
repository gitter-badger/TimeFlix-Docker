<div class="row" style="margin-top:0%;margin-left:2%;margin-right:2%;z-index:100;padding-top:4%;">
      <div class="col-md-2" style="float:left;background-color: #fff;padding:0;border-radius: 2px;box-shadow: 1px 1px 8px #000;">
		<a href="index.php?view=admin&for=users" class="list-group-item"><i class="fa fa-users list-group-icon"></i>Utilisateurs</a>
		<a href="index.php?view=admin&for=files" class="list-group-item"><i class="fa fa-tasks list-group-icon"></i>Fichiers</a>
		<a href="index.php?view=admin&for=stats" class="list-group-item"><i class="fa fa-signal list-group-icon"></i>Statistique</a>
		<a href="index.php?view=admin&for=logs" class="list-group-item"><i class="fa fa-flask list-group-icon"></i>Logs</a>
		<a href="index.php?view=admin&for=config" class="list-group-item"><i class="fa fa-cogs list-group-icon"></i>Configuration TimeFlix</a>
		<a href="index.php?view=admin&for=update" class="list-group-item"><i class="fa fa-cloud-download list-group-icon"></i>Mise à jour</a>
      </div>

<div class="col-md-10" style="background-color: #fff:padding:1%;">
<?php 
if($_GET['for'] == 'config')
	{
		if(!empty($_POST['ffmpeg']))
		{
			$ffmpeg = $_POST['ffmpeg'];
			$subliminal = $_POST['subliminal'];
			$moviedb_api = $_POST['api'];
			if($_POST['active_torrent'])
			{
				$req = $bdd->exec("UPDATE config SET torrent_active='on' WHERE id_config=1");
			}
			else
			{
				$req = $bdd->exec("UPDATE config SET torrent_active='off' WHERE id_config=1");
			}
			if($_POST['active_encodage'])
			{
				$req = $bdd->exec("UPDATE config SET encodage_mp4='on' WHERE id_config=1");
			}
			else
			{
				$req = $bdd->exec("UPDATE config SET encodage_mp4='off' WHERE id_config=1");
			}
			if($_POST['active_encodage_st'])
			{
				$req = $bdd->exec("UPDATE config SET encodage_sub='on' WHERE id_config=1");
			}
			else
			{
				$req = $bdd->exec("UPDATE config SET encodage_sub='off' WHERE id_config=1");
			}
			$req = $bdd->exec("UPDATE config SET ffmpeg='$ffmpeg',subliminal='$subliminal',moviedb_api='$moviedb_api' WHERE id_config=1");
			// set de nouveau les droits. 
			$right = get_data('config',"WHERE id_config=1");
			$right = array_shift($right);
			$moviedb_api = $right['moviedb_api'];
			echo '<div class="alert alert-success" role="alert"><b>Parfait</b>, Modification effectuée.</div>';
		}
		?>
	<form method="post" action="index.php?view=admin&for=config">
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-cogs list-group-icon"></i> Configuration TimeFlix</span>
		</div>
		<div class="panel-body">
<div class="col-md-4">
					<div class="panel-heading">
						<span class="panel-title">Encodage</span>
					</div>
					<div class="panel-body no-padding-hr">
						<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
							<div class="row">
								<label class="col-sm-9 control-label">Activer la recherche torrent :</label>
								<div class="col-sm-3">
									<input type="checkbox" name="active_torrent" id="active_torrent" <?php if($right['torrent_active'] == 'on') { echo 'checked="checked"'; } ?>>
								</div>
							</div>
						</div>
						<div class="form-group no-margin-hr no-margin-b panel-padding-h">
							<div class="row">
								<label class="col-sm-9 control-label">Activer l'encodage vidéo :</label>
								<div class="col-sm-3">
									<input type="checkbox" name="active_encodage" id="active_encodage" <?php if($right['encodage_mp4'] == 'on') { echo 'checked="checked"'; } ?>>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group no-margin-hr no-margin-b panel-padding-h">
							<div class="row">
								<label class="col-sm-9 control-label">Activer l'encodage video sous-titre :</label>
								<div class="col-sm-3">
									<input type="checkbox" name="active_encodage_st" id="active_encodage_st" <?php if($right['encodage_sub'] == 'on') { echo 'checked="checked"'; } ?>>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8">
					<div class="panel-heading">
						<span class="panel-title">Lien logiciel</span>
					</div>
					<div class="panel-body no-padding-hr">
						<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
							<div class="row">
								<label class="col-sm-4 control-label">Lien FFMPEG :</label>
								<div class="col-sm-8">
									<input type="text" name="ffmpeg" class="form-control" value="<?php echo $right['ffmpeg']; ?>">
								</div>
							</div>
						</div>
						<div class="form-group no-margin-hr no-margin-b panel-padding-h">
							<div class="row">
								<label class="col-sm-4 control-label">Lien SUBLIMINAL :</label>
								<div class="col-sm-8">
									<input type="text" name="subliminal" class="form-control" value="<?php echo $right['subliminal']; ?>">
								</div>
							</div>
						</div>
					</div>
							<div class="form-group no-margin-hr no-margin-b panel-padding-h">
							<div class="row">
								<label class="col-sm-4 control-label">CLE API MovieDB :</label>
								<div class="col-sm-8">
									<input type="text" name="api" class="form-control" value="<?php echo $right['moviedb_api']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
					<div class="panel-heading">
						<span class="panel-title">Sous-Titre "addic7ed"</span>
					</div>
					<div class="panel-body no-padding-hr">
						<div class="alert alert-info" role="alert"><b>Pourquoi "addic7ed"</b>, Sous-titre de qualité et surtout sans décalage et de traduction version google traduction !</div>
						<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
							<div class="row">
								<label class="col-sm-4 control-label">Username :</label>
								<div class="col-sm-8">
									<input type="text" name="addic7ed-username" class="form-control" value="<?php echo $right['addic7ed-username']; ?>">
								</div>
							</div>
						</div>
						<div class="form-group no-margin-hr no-margin-b panel-padding-h">
							<div class="row">
								<label class="col-sm-4 control-label">Password :</label>
								<div class="col-sm-8">
									<input type="password" name="addic7ed-password" class="form-control" value="<?php echo $right['addic7ed-password']; ?>">
								</div>
							</div>
						</div>
					</div>
					</div>

					<div style="display: block; clear: both;"></div>
					<div class="panel-footer text-right">
						<button class="btn btn-primary">Sauvegarder</button>
					</div>
					</form>
</div>

		</div>
				</div>
	<?php 
}
if($_GET['for'] == 'logs')
	{?>
<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-flask list-group-icon"></i> CORE_ENCODAGE</span>
		</div>
		<div class="panel-body" style="background: #000;">
		<p style="color: #63de00!important;font-family: Andale Mono, monospace;"><?php 
		exec('tail -n 20 logs/system.log',$acces);

		foreach ($acces as $value) {
			echo $value.'<br>';
		}
		?></p>
		</div>
				</div>

		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-flask list-group-icon"></i> Nginx - Accès vidéo</span>
		</div>
		<div class="panel-body" style="background: #000;">
		<p style="color: #63de00!important;font-family: Andale Mono, monospace;"><?php
				unset($acces); 
		exec('tail -n 20 /var/log/video.nginx.access.log',$acces);

		foreach ($acces as $value) {
			echo $value.'<br>';
		}
		?></p>
		</div>
				</div>
	<?php 
}
if($_GET['for'] == 'update')
	{?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-cloud-download list-group-icon"></i> Update</span>
		</div>
		<div class="panel-body">
			<div class="alert alert-success" role="alert"><b>Parfait</b>,TimeFlix est à jour. [<?php echo file_get_contents('VERSION'); ?>]</div>

			<div class="graph-container">
				<div id="connexion-graph" class="graph"></div>
			</div>
		</div>
				</div>
	<?php 
}
	 if($_GET['for'] == 'stats')
{
	if(!empty($_POST['email']))
	{
		$req = $bdd->prepare("INSERT INTO `invitation` 
		(`email`, `unique_id`, `users_id`) 
		VALUES
		(:email,:unique_id,:users_id)");
		$uniqueid = uniqid();
		$req->bindParam(':email',$_POST['email']);
		$req->bindParam(':unique_id',$uniqueid);
		$req->bindParam(':users_id', $_SESSION['id_users']);
		$req->execute();
		$link = 'http://beta.timeflix.net/index.php?view=invitation&unique_id='.$uniqueid;
		$corps = '<h1>Invitation</h1>
		<p>Jack vous fait parvenir une invitation pour tester la nouvelle version de TimeFlix !
		<br> A très vite ! </p>';
		$affiche="http://rails.blog.lemonde.fr/files/2011/04/3907950513_4ca17bcb38.1302524350.jpg";
		echo push_email($_POST['email'],'TimeFlix - Beta ',$corps,$affiche,$link);
	}
	?>
	<script>
					init.push(function () {
						var tax_data = [
				<?php 
					foreach (get_stats() as $key => $stats) 
	{
		echo '{"period": "'.$stats['date'].'", "connexion": '.$stats['connexion'].'},';
	}
	?>
						];
						Morris.Line({
							element: 'connexion-graph',
							data: tax_data,
							xkey: 'period',
							ykeys: ['connexion'],
							labels: ['Connexion'],
							lineColors: PixelAdmin.settings.consts.COLORS,
							lineWidth: 2,
							pointSize: 4,
							gridLineColor: '#cfcfcf',
							resize: true
						});
					});
				</script>
				<!-- / Javascript -->

				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Connexions / Jour</span>
					</div>
					<div class="panel-body">
						<!-- <div class="note note-info">More info and examples at <a href="http://www.oesmith.co.uk/morris.js/" target="_blank">http://www.oesmith.co.uk/morris.js/</a></div> -->

						<div class="graph-container">
							<div id="connexion-graph" class="graph"></div>
						</div>
					</div>
				</div>
				<script>
					init.push(function () {
						var tax_data = [
				<?php 
				unset($stats);
					foreach (get_requete() as $key => $stats) 
	{
		echo '{"period": "'.$stats['date'].'", "requete": '.$stats['requete'].'},';
	}
	?>
						];
						Morris.Line({
							element: 'requete-graph',
							data: tax_data,
							xkey: 'period',
							ykeys: ['requete'],
							labels: ['Requêtes'],
							lineColors: PixelAdmin.settings.consts.COLORS,
							lineWidth: 2,
							pointSize: 4,
							gridLineColor: '#cfcfcf',
							resize: true
						});
					});
				</script>
				<!-- / Javascript -->

				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Requêtes</span>
					</div>
					<div class="panel-body">
						<!-- <div class="note note-info">More info and examples at <a href="http://www.oesmith.co.uk/morris.js/" target="_blank">http://www.oesmith.co.uk/morris.js/</a></div> -->

						<div class="graph-container">
							<div id="requete-graph" class="graph"></div>
						</div>
					</div>
				</div>

<?php
}
if($_GET['for'] == 'users' OR empty($_GET['for']))
{
	?>
	<form method="post" action="index.php?view=admin&for=users">
	<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Utilisateurs</span>
					</div>
					<div class="panel-body">
<legend>Envoyer une invitation</legend>
<div class="alert alert-warning" role="alert"><b>Attention !</b>,  Cette fonctionnalité nécessite configuration mail.</div>
  <div class="form-group">
    <label for="exampleInputEmail1">Adresse email</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entrez un email valide">
  </div>
  <button style="float:right;" type="submit" class="btn btn-success">Générer</button>
</form>
<legend>Gérer les utilisateurs</legend>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Email</th>
			<th>Password</th>
			<th>Last connexion</th>
			<th>User agent</th>
			<th>IP</th>
			<th>Data usage</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$users = get_data('users',"");
		foreach($users as $user)	
		{
			$log = get_data('logs',"WHERE id_users='".$user['id_users']."' ORDER BY date_add DESC LIMIT 1");
			$record = geoip_record_by_addr($gi,$log[0]['adresse_ip']);
		?>
		<tr>
			<td><?php echo $user['adresse_email']; ?></td>
			<td><?php echo $user['password_crypt'];//core_encrypt_decrypt('decrypt',$user['password_crypt']); ?></td>
			<td><?php echo temps_ecoule($log[0]['date_add'],'date'); ?></td>
			<td><?php echo $log[0]['useragent']; ?></td>
			<td><?php echo $log[0]['adresse_ip']; ?> <span class="label label-info"><?php echo utf8_encode($record->city); ?></span></td>
			<td><?php echo get_data_usage($user['id_users']); ?></td>
			<td><?php echo $user['status']; ?></td>
		</tr>
		<?php
	}
	?>
</table>
</div>
	<?php
		}
if($_GET['for'] == 'files' AND isset($_GET['id_movies']))
{
		print_r($_POST);
		$id = $_GET['id_movies'];
		$films = get_data('movies',"
		INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
		WHERE movies.id_movies='$id'");
		$film = array_shift($films);
		$back = get_data('backgrounds','WHERE id_movies='.$film['id_moviedb'].'');
		$check = NULL;
		if($film['encoding_mp4'] == 2)
		{
			$check='checked';
		}
?>
<form method="post" action="index.php?view=admin&for=files&id_movies=<?php echo $id; ?>">
<div class="panel">
<div class="panel-heading">
	<span class="panel-title"><i class="fa fa-tasks list-group-icon"></i>Détail film</span>
</div>
<div class="panel-body">
<legend><?php echo $film['title']; ?></legend>
<div class="form-group">
						<div class="form-group">
							<label for="asdasdas" class="col-sm-2 control-label">Synopsis</label>
							<div class="col-sm-10">
								<textarea name="syno" class="form-control"><?php echo utf8_encode($film['synopsis']); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail2" class="col-sm-2 control-label">Lien fichier</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="file" value="<?php echo $film['name']; ?>">
							</div>
						</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Encoder </label>
							<div class="col-sm-10">
												<?php if (file_exists('data/public/'.$film['hash'].'.mp4')) 
								{
								echo '<p class="help-block" style="color:green;">Le ficher est disponible !</p>';
								}
								else
								{
									echo '<p class="help-block" style="color:red;">Le ficher est indisponible ! </p>';
								}
								?>
									<select name="encodage" class="form-control form-group-margin">
										<option value="0">En attente encodage</option>
										<option value="2" <?php echo $check; ?>>Fichier encoder</option>
									</select>
							</div>
							</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">En ligne </label>
							<div class="col-sm-10">
								<input name="status" type="checkbox" id="status" checked="checked">&nbsp;&nbsp;
						</div> 
					
</div>
<legend>Images</legend>
<?php 
foreach ($back as $key => $value) 
{
	echo '<img style="height:250px;margin:1%;" src="data/backgrounds'.$value['file'].'" alt="..." class="img-thumbnail">';
}
?>
</div>
<div class="panel-footer text-right">
		<button type="submit" class="btn btn-primary">Sauvegarder</button>
</div>
</form>
<?php
}
if($_GET['for'] == 'files' AND !isset($_GET['id_movies']))
{
	?>
<div class="panel">
<div class="panel-heading">
	<span class="panel-title"><i class="fa fa-tasks list-group-icon"></i> Fichiers</span>
</div>
<div class="panel-body">
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Type</th>
			<th>Hash</th>
			<th>Ratio %</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$films = get_data('movies',"
		INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
		WHERE movies.status='1' ORDER BY files_movies.encoding_mp4 DESC");
		foreach($films as $film)
		{
			$p_movie = get_data_movie_bits($film['hash']);
			//echo $p_movie;
			//$p_movie = str_replace('.',',',$p_movie);
			$t_movie = filesize('data/public/'.$film['hash'].'.mp4');
			//echo $t_movie;
			//$t_movie = str_replace('.',',',$t_movie);
			$pourcent = $p_movie / $t_movie * 100;
			$label = 'success';
			if($pourcent < 100)
			{
				$label = 'danger';
			}
		?>
		<tr>
			<td><a href="index.php?view=admin&for=files&id_movies=<?php echo $film['id_movies']; ?>"><?php echo $film['title']; ?></a></td>
			<td><?php echo $film['type']; ?></td>
			<td><?php echo $film['hash']; ?></td>
			<td><span class="label label-<?php echo $label; ?>"><?php echo round($pourcent,1); ?> %</span> (<?php echo format_bytes(filesize('data/public/'.$film['hash'].'.mp4')); ?>) -> <?php echo get_data_movie($film['hash']); ?> </td>
		</tr>
		<?php 
		}
		?>
</table>
<?php
}
?>

<!--
<div style="position: fixed;
    bottom: 0;width:100%;margin-left: auto;margin-right:auto;background-color: white;height:50px;box-shadow: 1px 1px 8px #000;margin-top:1%;padding:10px;">
<button type="button" class="btn btn-default">Invitation</button>
<button type="button" class="btn btn-default">Users</button>
</div>
--></div></div>
<div style="display: block; clear: both;"></div>
<div style="margin-top:5%;border-left:0;width: 95%;
border-right:0;
  border-top:0;
border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
</div>  
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;font-size:15px;color:white;">
        Timeflix 2014 - 2015 <br><?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p style=" font-size:9px;">';
echo 'Générer en '.$total_time.' seconds - Mem : '.format_bytes(memory_get_usage(true)).'</p>';
?></center>
      </div>
</div></div>
</div>
