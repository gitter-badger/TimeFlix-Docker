<div class="row" style="margin-top:0%;margin-left:2%;margin-right:2%;z-index:100;padding-top:4%;">
      <div class="col-md-2" style="float:left;background-color: #fff;padding:0;border-radius: 2px;box-shadow: 1px 1px 8px #000;">
		<a href="index.php?view=admin&for=users" class="list-group-item"><i class="fa fa-users list-group-icon"></i>Utilisateurs</a>
		<a href="index.php?view=admin&for=files" class="list-group-item"><i class="fa fa-tasks list-group-icon"></i>Fichiers</a>
		<a href="index.php?view=admin&for=stats" class="list-group-item"><i class="fa fa-signal list-group-icon"></i>Statistique</a>
		<a href="index.php?view=admin&for=config" class="list-group-item"><i class="fa fa-cogs list-group-icon"></i>Configuration</a>
		<a href="index.php?view=admin&for=update" class="list-group-item"><i class="fa fa-cloud-download list-group-icon"></i>Mise à jour</a>
      </div>

<div class="col-md-10" style="background-color: #fff:padding:1%;">
<?php 
if($_GET['for'] == 'config')
	{?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-cogs list-group-icon"></i> Configuration</span>
		</div>
		<div class="panel-body">
			<!-- <div class="note note-info">More info and examples at <a href="http://www.oesmith.co.uk/morris.js/" target="_blank">http://www.oesmith.co.uk/morris.js/</a></div> -->

			<div class="graph-container">
				<div id="connexion-graph" class="graph"></div>
			</div>
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
			<div class="alert alert-success" role="alert"><b>Parfait</b>,TimeFlix est à jour. [1.0 beta]</div>

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
if($_GET['for'] == 'users')
{
	?>
	<form method="post" action="index.php?view=admin&for=users">
	<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Utilisateurs</span>
					</div>
					<div class="panel-body">
<legend>Envoyer une invitation</legend>
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
		</tr>
		<?php
	}
	?>
</table>
<div class="graph-container">
							<div id="connexion-graph" class="graph"></div>
						</div>
					</div>
				</div>
	<?php
		}
if($_GET['for'] == 'files')
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
			$p_movie = substr(get_data_movie($film['hash']),0,-3);
			$t_movie = substr(format_bytes(filesize('data/public/'.$film['hash'].'.mp4')),0,-3);
			$pourcent = $t_movie * $p_movie / 100;
		?>
		<tr>
			<td><?php echo $film['title']; ?></td>
			<td><?php echo $film['type']; ?></td>
			<td><?php echo $film['hash']; ?></td>
			<td><span class="label label-success"><?php echo round($pourcent,1); ?> %</span> (<?php echo format_bytes(filesize('data/public/'.$film['hash'].'.mp4')); ?>)</td>
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
-->
</div>