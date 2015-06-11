<div class="row" style="margin-top:0%;margin-left:2%;margin-right:2%;z-index:100;padding-top:5%;">
      <div class="col-md-2" style="float:left;background-color: #fff;padding:0;border-radius: 2px;box-shadow: 1px 1px 8px #000;">
     	 <a href="index.php?view=admin&for=dashboard" class="list-group-item"><i class="fa fa-dashboard list-group-icon"></i>Dashboard</a>
		<a href="index.php?view=admin&for=users" class="list-group-item"><i class="fa fa-users list-group-icon"></i>Utilisateurs</a>
		<a href="index.php?view=admin&for=files" class="list-group-item"><i class="fa fa-tasks list-group-icon"></i>Fichiers</a>
			<a href="index.php?view=admin&for=torrent" class="list-group-item"><i class="fa fa-magnet list-group-icon"></i>Transmission</a>
		<a href="index.php?view=admin&for=stats" class="list-group-item"><i class="fa fa-signal list-group-icon"></i>Statistique</a>
		<a href="index.php?view=admin&for=logs" class="list-group-item"><i class="fa fa-flask list-group-icon"></i>Logs</a>
		<a href="index.php?view=admin&for=config" class="list-group-item"><i class="fa fa-cogs list-group-icon"></i>Configuration TimeFlix</a>
		<a href="index.php?view=admin&for=mail" class="list-group-item"><i class="fa fa-envelope list-group-icon"></i>Information & Configuration Mail</a>
		<a href="index.php?view=admin&for=import_export" class="list-group-item"><i class="fa fa-code-fork list-group-icon"></i>Import & Export</a>
		<a href="index.php?view=admin&for=update" class="list-group-item"><i class="fa fa-cloud-download list-group-icon"></i>Mise à jour</a>
      </div>

<div class="col-md-10" style="background-color: #fff:padding:1%;">
<?php
if(isset($_GET['for']) AND $_GET['for'] == 'dashboard')
	{
		$stock = disk_free_space('/') / disk_total_space('/') * 100;
		if($_GET['service'] == 'encodage')
		{
			if(get_process_admin('php index.php'))
					{
						exec('echo Script encodage stop by admin > logs/system.log');
						exec('killall php');
					}
					else
					{
						exec('php index.php encodage > logs/system.log &');
					}
		}
		?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-dashboard  list-group-icon"></i> Dashboard</span>
		</div>
		<div class="panel-body" style="">
		<script>
					init.push(function () {
						// Easy Pie Charts
						var easyPieChartDefaults = {
							animate: 2000,
							scaleColor: false,
							lineWidth: 6,
							lineCap: 'square',
							size: 125,
							trackColor: '#e5e5e5'
						}
						$('#easy-pie-chart-1').easyPieChart($.extend({}, easyPieChartDefaults, {
							barColor: PixelAdmin.settings.consts.COLORS[1]
						}));
						$('#easy-pie-chart-2').easyPieChart($.extend({}, easyPieChartDefaults, {
							barColor: PixelAdmin.settings.consts.COLORS[1]
						}));
						$('#easy-pie-chart-3').easyPieChart($.extend({}, easyPieChartDefaults, {
							barColor: PixelAdmin.settings.consts.COLORS[1]
						}));
					});
				</script>
				<div class="row">
					<div class="col-xs-2">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<div class="stat-cell bg-primary padding-sm text-xs text-semibold">
									<i class="fa fa-dashboard"></i>&nbsp;&nbsp;Charge système
								</div>
							</div>
							<div class="stat-row">
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<div class="pie-chart" data-percent="<?php echo get_system(); ?>" id="easy-pie-chart-1">
										<div class="pie-chart-label"><?php echo get_system(); ?> %</div>
									</div>
								</div>
							</div>
						</div> 
					</div>
					<div class="row">
					<div class="col-xs-2">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<div class="stat-cell bg-warning padding-sm text-xs text-semibold">
									<i class="fa fa-dashboard"></i>&nbsp;&nbsp;Stockage (Libre)
								</div>
							</div>
							<div class="stat-row">
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<div class="pie-chart" data-percent="<?php echo $stock; ?>" id="easy-pie-chart-2">
										<div class="pie-chart-label"><?php echo format_bytes(disk_free_space('/')); ?></div>
									</div>
								</div>
							</div>
						</div> 
					</div>
					<div class="row">
					<div class="col-xs-2">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<div class="stat-cell bg-danger padding-sm text-xs text-semibold">
									<i class="fa fa-dashboard"></i>&nbsp;&nbsp;RAM
								</div>
							</div>
							<div class="stat-row">
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<div class="pie-chart" data-percent="<?php echo get_memory(); ?>" id="easy-pie-chart-3">
										<div class="pie-chart-label"><?php echo get_memory(); ?>%</div>
									</div>
								</div>
							</div>
						</div> 
					</div>
						<div class="row">
					<div class="col-xs-2">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<div class="stat-cell bg-info padding-sm text-xs text-semibold">
									<i class="fa fa-dashboard"></i>&nbsp;&nbsp;ENCODAGE
								</div>
							</div>
							<div class="stat-row">
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<?php if(get_process_admin('php index.php'))
											{
												echo 'Le service est démmarer </br></br><a class="btn btn-danger" href="index.php?view=admin&for=dashboard&service=encodage">Arreter</a>';
											}
											else
											{
												echo 'Le service est arrêter </br></br><a class="btn btn-success" href="index.php?view=admin&for=dashboard&service=encodage">Démarrer</a>';
											}
											?>
								</div>
							</div>
						</div> 
						</div> 
					</div>
					</div>
					</div>
					</div>
					</div>


	<?php 
}
if(isset($_GET['for']) AND $_GET['for'] == 'torrent')
	{
		if(!empty($_GET['hash']))
		{
			remove_transmission($_GET['hash']);
			echo '<div class="alert alert-success" role="alert">Action effectuée </div>';
		}
	?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-magnet list-group-icon"></i>Transmission</span>
		</div>
		<div class="panel-body">
		<table class="table table-striped">
	<thead>
		<tr>
			<th style="width: 30%;">Name</th>
			<th style="width: 35%;">Pourcent</th>
			<th>Remaining time</th>
			<th>Size</th>
			<th><center>UP / DOWN </center></th>
			<th><center>Action</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
		echo '<p align="right"> <span class="label label-success">DOWN : '.format_bytes(transmission()->getSessionStats()->getdownloadSpeed()).'/s </span>  <span class="label label-danger">UP : '.format_bytes(transmission()->getSessionStats()->getuploadSpeed()).'/s</span><p></br>';
		 foreach (list_get_transmission() as $key => $value)
		 {
		 	echo '<tr>';
		 	echo '<td>'.$value->getName().'</td>';
		 	$download = format_bytes($value->getDownloadRate());
   			$upload = format_bytes($value->getUploadRate());
		 	$label = NULL;
		 	if($value->getstatus() == 0)
			{
					$label = 'progress-bar-success';
			}
		 	echo '<td><div class="progress" style="height:18px;">
				  <div class="progress-bar '.$label.'" role="progressbar" aria-valuenow="'.$value->getPercentDone().'" aria-valuemin="0" aria-valuemax="100" style="width: '.$value->getPercentDone().'%;">
				    '.$value->getPercentDone().'%
				  </div>
				</div></td>';
				//echo $value->size();
			if($value->getPercentDone() == 100)
			{
					echo '<td>Ratio : '.round($value->getuploadRatio(),2).' </td>';
			}
			elseif($value->getPercentDone() == 0)
			{
					echo "<td>En attente</td>";
			}
			else
			{
				echo "<td>". gmdate("H:i:s", $value->getEta()) ." (".count($value->getPeers())." Peers)</td>";
			}
			echo '<td>'.format_bytes($value->getSize()).'</td>';
			echo '<td><center><span class="label label-success">'.$download.'/s</span>  <span class="label label-danger">'.$upload.'/s</span></center></td>';
			echo '<td><a href="index.php?view=admin&for=torrent&hash='.$value->gethash().'" class="btn btn-xs btn-danger">Supprimer</a></td>';
		 	echo '</tr>';
		 } 
		 echo '</tbody></table>';
}
if(isset($_GET['for']) AND $_GET['for'] == 'import_export')
	{?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-code-fork list-group-icon"></i> Import & Export</span>
		</div>
		<div class="panel-body">
		<div class="alert alert-info" role="alert">En cours de développement </div>
	<?php
}
if(isset($_GET['for']) AND $_GET['for'] == 'mail')
	{
		if(!empty($_POST['smtp']) AND !empty($_POST['port']) AND !empty($_POST['email']) AND !empty($_POST['password']))
		{
			$smtp = $_POST['smtp']; 
			$port = $_POST['port']; 
			$email = $_POST['email']; 
			$password = $_POST['password']; 
			$req = $bdd->exec("UPDATE config SET smtp_host='$smtp',smtp_port='$port',smtp_username='$email',smtp_password='$password' WHERE id_config=1");
			// set de nouveau les droits. 
			$right = get_data('config',"WHERE id_config=1");
			$right = array_shift($right);
			$moviedb_api = $right['moviedb_api'];
			echo '<div class="alert alert-success" role="alert"><b>Parfait</b>, Modification effectuée.</div>';
		}
		if(!empty($_GET['test']))
		{
			$message = json_encode(array('email' => ''.$_SESSION['adresse_email'].'','password'=>''.$_SESSION['password_crypt'].''));
			$subject ='Message de test ';
			$req = $bdd->prepare("INSERT INTO `mail` 
			(`to`, `subject`, `message`,`type`) 
			VALUES
			(:to,:subject,:message,:type)");
			$type ='lost';
			$req->bindParam(':to',$_SESSION['adresse_email']);
			$req->bindParam(':subject',$subject);
			$req->bindParam(':message', $message);
			$req->bindParam(':type', $type);
			$req->execute();
			exec('php index.php mail');
			echo '<div class="alert alert-success" role="alert"><b>Excelent ! </b> Messsage de test</div>';
		}
		?>
		<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-envelope  list-group-icon"></i> Configuration Mail</span>
		</div>
		<div class="panel-body">
<legend>Configuration</legend>
	<form method="post" action="index.php?view=admin&for=mail">
<div class="form-group">
							<label  class="col-sm-2 control-label">SMTP</label>
							<div class="col-sm-10"?>
								<input type="text" class="form-control" name="smtp" id="smtp" value="<?php echo $right['smtp_host']; ?>" placeholder="Entrez votre serveur SMTP">
							</div>
						</div>
						<div class="form-group">
						<label  class="col-sm-2 control-label">Port</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="port" id="port" value="<?php echo $right['smtp_port']; ?>" placeholder="Entrez le numéro de port">
							</div>
						</div>
							<div class="form-group">
							<label  class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="email" id="mail" value="<?php echo $right['smtp_username']; ?>" placeholder="Email de login">
							</div>
						</div>
						<div class="form-group">
							<label  class="col-sm-2 control-label">Mot de passe</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="password" id="inputPassword" value="<?php echo $right['smtp_password']; ?>" placeholder="Mot de passe ">
							</div>
						</div>
						<div class="panel-footer text-right">
						<a class="btn btn-warning" href="index.php?view=admin&for=mail&test=1">Tester</a>
						<button type="submit" class="btn btn-primary">Sauvegarder</button></div>
		</form>
		<legend>Mail</legend>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Destinataire</th>
			<th>Sujet</th>
			<th>Date</th>
			<th>Label Status</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$emails = get_data('mail',"ORDER BY date_send DESC");
		if(empty($emails))
		{
			echo '<tr class="warning">
			<td colspan="5"><center>La liste est vide </center></td></tr>';
		}
		foreach($emails as $email)
		{
			if(empty($email['label_status']))
			{
				$email['label_status']  = 'Aucune information';
			}
			if($email['status'] == 'send')
			{
				$info = '<span class="label label-success">Envoyer</span>';
			}
			if($email['status'] == 'wait')
			{
				$info = '<span class="label label-info">En attente</span>';
			}
			if($email['status'] == 'error')
			{
				$info = '<span class="label label-danger">En erreur</span>';
			}

		?>
		<tr>
			<td><?php echo $email['to']; ?></a></td>
			<td><?php echo $email['subject']; ?></td>
			<td><?php echo $email['date_send']; ?></td>
			<td><?php echo $email['label_status']; ?></td>
			<td><?php echo $info; ?></td>
			<td><a class="btn btn-info btn-xs" href="">Visualiser</a></td>
		</tr>
		<?php 
		}
		?>
		</tbody>
</table>
	<?php 
}	
if(isset($_GET['for']) AND $_GET['for'] == 'config')
	{
		if(!empty($_POST['ffmpeg']))
		{
			$ffmpeg = $_POST['ffmpeg'];
			$subliminal = $_POST['subliminal'];
			$moviedb_api = $_POST['api'];
			$addic7ed_username = $_POST['addic7ed-username'];
			$addic7ed_password = $_POST['addic7ed_password'];
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
<div class="col-md-5">
					<div class="panel-heading">
						<span class="panel-title">Système</span>
					</div>
					<div class="panel-body no-padding-hr">
						<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
							<div class="row">
								<label class="col-sm-9 control-label">Activer la recherche GetStrike API :</label>
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
								<label class="col-sm-9 control-label">Activer les inscriptions :</label>
								<div class="col-sm-3">
									<input type="checkbox" name="active_encodage_st" id="active_encodage_st" <?php if($right['encodage_sub'] == 'on') { echo 'checked="checked"'; } ?>>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7">
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
					<div style="display: block; clear: both;"></div>
					<div class="col-md-5">
					<div class="panel-heading">
						<span class="panel-title">Sous-Titre "addic7ed"</span>
					</div>
					<div class="panel-body no-padding-hr">
						<div class="alert alert-warning" role="alert"><b>Attention</b>! Laissez nul si aucun compte.</div><div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
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
	<?php 
}
if(isset($_GET['for']) AND $_GET['for'] == 'logs')
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
	<?php 
}
if(isset($_GET['for']) AND $_GET['for'] == 'update')
	{
		if($_GET['action'] == 'pull')
		{
			$retour = array();
			exec('git pull',$retour);
			?>
			<div class="alert alert-info" role="alert"><b>Rapport de mise à jour ! </b> </br>
			<?php foreach ($retour as  $value) {
				echo $value;
				echo '<br>';
			} ?></div>
			<?php
		}
$xml=simplexml_load_file("https://github.com/Peanuts.atom") or die("Error: Cannot create object");
$update = '<div class="alert alert-warning" role="alert"><b>Attention</b>, Cliquez sur mise à jour si vous avez effectuée aucun modification sur le code. <a href="index.php?view=admin&for=update&action=pull" class="btn btn-xs btn-warning" style="float:right;">
Mettre à jour</a></div>';
echo $update;
?>
<div class="panel widget-messages-alt">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-cloud-download list-group-icon"></i> Update</span>
					</div> <!-- / .panel-heading -->
					<div class="panel-body padding-sm">
						<div class="messages-list">
						<?php
					foreach ($xml->entry as $key => $value) {
						?>
							<div class="message">
								<img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/128/Apps-system-software-update-icon.png" alt="" class="message-avatar">
								<a href="#" class="message-subject"></a>
								<div class="message-description" style="color:#555;">
									<?php echo $value->content; ?>
									from <a href="#"><?php echo $value->author->name; ?></a>
									&nbsp;&nbsp;·&nbsp;&nbsp;
									<?php echo temps_ecoule($value->updated,'date'); ?>
								</div> 
							</div> 

							<?php } ?>
						</div>
	<?php 
}
	 if(isset($_GET['for']) AND $_GET['for'] == 'stats')
{
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

<?php
}
if(isset($_GET['for']) AND $_GET['for'] == 'users' OR empty($_GET['for']))
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
		<p>L\administrateur vous fait parvenir une invitation pour tester TimeFlix !
		<br> A très vite ! </p>';
		$affiche="http://rails.blog.lemonde.fr/files/2011/04/3907950513_4ca17bcb38.1302524350.jpg";
		echo push_email($_POST['email'],'TimeFlix - Inviation ',$corps,$affiche,$link);
	}
	if(!empty($_GET['id_users']) AND $_GET['action'] == 'valide')
	{
			$iduse = $_GET['id_users'];
			$user = get_data('users',"WHERE id_users=$iduse");
			if(!empty($user))
			{
				$message = json_encode(array('email' => ''.$user[0]['adresse_email'].'','password'=>''.$user[0]['password_crypt'].''));
				$subject ='[TimeFlix] - Validation inscription';
				$req = $bdd->exec("UPDATE users SET status='actif' WHERE id_users=$iduse");
				$req = $bdd->prepare("INSERT INTO `mail` 
				(`to`, `subject`, `message`,`type`) 
				VALUES
				(:to,:subject,:message,:type)");
				$type ='new';
				$req->bindParam(':to',$user[0]['adresse_email']);
				$req->bindParam(':subject',$subject);
				$req->bindParam(':message', $message);
				$req->bindParam(':type', $type);
				$req->execute();
				exec('php index.php mail');
				echo '<div class="alert alert-success" role="alert"><b>Excelent ! </b> Compte activé, un mail est envoyée. </div>';
			}
	}
	if(!empty($_GET['id_users']) AND $_GET['action'] == 'lost')
	{
			$iduse = $_GET['id_users'];
			$user = get_data('users',"WHERE id_users=$iduse");
			if(!empty($user))
			{
				$message = json_encode(array('email' => ''.$user[0]['adresse_email'].'','password'=>''.$user[0]['password_crypt'].''));
				$subject ='[TimeFlix] - Mot de passe oublié ? ';
				$req = $bdd->prepare("INSERT INTO `mail` 
				(`to`, `subject`, `message`,`type`) 
				VALUES
				(:to,:subject,:message,:type)");
				$type ='lost';
				$req->bindParam(':to',$user[0]['adresse_email']);
				$req->bindParam(':subject',$subject);
				$req->bindParam(':message', $message);
				$req->bindParam(':type', $type);
				$req->execute();
				exec('php index.php mail');
				echo '<div class="alert alert-success" role="alert"><b>Excelent ! </b> Renvoi identifiant effectuée</div>';
			}
	}
	?>
	<form method="post" action="index.php?view=admin&for=users">
	<div class="panel">
					<div class="panel-heading">
						<span class="panel-title">Utilisateurs</span>
					</div>
					<div class="panel-body">
<!-- <legend>Envoyer une invitation</legend>
<div class="alert alert-warning" role="alert"><b>Attention !</b>  Cette fonctionnalité nécessite une configuration mail valide</div>
  <div class="form-group">
    <label for="exampleInputEmail1">Adresse email</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entrez un email valide">
  </div>
  <button style="float:right;" type="submit" class="btn btn-success">Générer</button>
</form> -->
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
			<th>Notification email</th>
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
			$connexion = 'Aucune données - Registered -> '.temps_ecoule($user['registered'],'date');
			if(!empty($log[0]['date_add']))
			{
				$connexion = temps_ecoule($log[0]['date_add'],'date');
			}
		?>
		<tr>
			<td><?php echo $user['adresse_email']; ?></td>
			<td><?php //echo core_encrypt_decrypt('decrypt',$user['password_crypt']); ?><span class="label label-warning">Crypter</span> <a href="index.php?view=admin&for=users&id_users=<?php echo $user['id_users']; ?>&action=lost">(Renvoyer en clair)</a></td>
			<td><?php echo $connexion; ?></td>
			<td><?php echo $log[0]['useragent']; ?></td>
			<td><?php echo $log[0]['adresse_ip']; ?> <span class="label label-info"><?php echo utf8_encode($record->city); ?></span></td>
			<td><?php echo get_data_usage($user['id_users']); ?></td>
			<td><?php echo $user['notif_email']; ?></td>
			<td><?php echo $user['status'];  if($user['status'] == 'attente') { echo ' <a href="index.php?view=admin&for=users&id_users='.$user['id_users'].'&action=valide">(Confirmer)</a>'; } ?></td>
		</tr>
		<?php
	}
	?>
</table>
	<?php
		}
		if(isset($_GET['for']) AND $_GET['for'] == 'files' AND isset($_GET['id_movies']))
{
?>
<form method="post" action="index.php?view=admin&for=files&id_movies=<?php echo $_GET['id_movies']; ?>">
<div class="panel">
<div class="panel-heading">
	<span class="panel-title"><i class="fa fa-tasks list-group-icon"></i>Détail film</span>
</div>
<div class="panel-body">
<?php 
		$id = $_GET['id_movies'];
		if($_GET['action'] == 'delete')
		{
			$bdd->exec("DELETE FROM files_movies WHERE id_movies=$id");
			$bdd->exec("DELETE FROM movies WHERE id_movies=$id");
			if(!empty($_GET['hash']))
			{
				exec('rm data/public/'.$_GET['hash'].'.mp4');
				header('Location: index.php?view=admin&for=files');     
			}
		}
		if(!empty($_POST))
		{
			$synopsis = utf8_decode($_POST['syno']);
			$encodage = $_POST['encodage'];
			$file = $_POST['file'];
			//$bdd->exec("UPDATE movies SET synopsis=$synopsis' WHERE id_movies=$id");
			$bdd->exec("UPDATE files_movies SET encoding_mp4='$encodage',name='$file' WHERE id_movies=$id");
			echo '<div class="alert alert-success" role="alert"><b>Parfait</b>, Modification effectuée.</div>';
		}
		$films = get_data('movies',"
		INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
		WHERE movies.id_movies='$id'");
		$film = array_shift($films);
		$back = get_data('backgrounds','WHERE id_movies='.$film['id_moviedb'].'');
		$check = NULL;
		if($film['encoding_mp4'] == 2)
		{
			$check='selected';
		}
?>
<legend><?php echo $film['title']; ?><a style="float:right" class="btn btn-danger btn-xs" href="index.php?view=admin&for=files&id_movies=<?php echo $id; ?>&action=delete&hash=<?php echo $film['hash']; ?>">Supprimer</a></legend>
<div class="form-group">
						<div class="form-group">
							<label for="asdasdas" class="col-sm-2 control-label">Synopsis</label>
							<div class="col-sm-10">
								<textarea name="syno" rows="5" class="form-control"><?php echo utf8_encode($film['synopsis']); ?></textarea>
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
	<!-- 					<div class="form-group">
							<label class="col-sm-2 control-label">En ligne </label>
							<div class="col-sm-10">
								<input name="status" type="checkbox" id="status" checked="checked">&nbsp;&nbsp;
						</div>  -->
					
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
if(isset($_GET['for']) AND $_GET['for'] == 'files' AND !isset($_GET['id_movies']))
{
		$id = $_GET['id_episode'];
		if($_GET['action'] == 'delete')
		{
			$bdd->exec("DELETE FROM episode_serie WHERE id_episode=$id");
			if(!empty($_GET['hash']))
			{
				exec('rm data/public/'.$_GET['hash'].'.mp4');
				header('Location: index.php?view=admin&for=files');     
			}
		}
	?>
<div class="panel">
<div class="panel-heading">
	<span class="panel-title"><i class="fa fa-tasks list-group-icon"></i> Fichiers</span>
</div>
<div class="panel-body">
<legend>Films</legend>
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
		if(empty($films))
		{
			echo '<tr class="warning">
			<td colspan="4"><center>La liste est vide </center></td></tr>';
		}
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
			if($pourcent > 80 AND $pourcent < 100)
			{
				$label = 'warning';
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
		</tbody>
</table>
<legend>Episodes</legend>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Type</th>
			<th>Hash</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$episodes = get_data('episode_serie',"ORDER BY file ASC");
		if(empty($episodes))
		{
			echo '<tr class="warning">
			<td colspan="5"><center>La liste est vide </center></td></tr>';
		}
		foreach($episodes as $episode)
		{
			if($episode['status'] == 0 OR $episode['encoding_mp4'] == 0)
	      	{
	        $percent = get_transmission_serie($episode['id_episode']);
	        $status = 'DL : '.$percent['percent'].'%';
	      	}
	      	if($episode['status'] == 1 AND $episode['encoding_mp4'] == 1)
	      	{
	        $status = 'Encodage en cours '.ffmpeg_pourcentage('data/log/'.$episode['hash'].'.log');
	      	}
	      	if($episode['status'] == 1 AND $episode['encoding_mp4'] == 2)
	      	{
	        $status = 'Disponible';
	      	}
		?>
		<tr>
			<td><?php echo $episode['file']; ?></a></td>
			<td><?php echo $episode['type']; ?></td>
			<td><?php echo $episode['hash']; ?></td>
			<td><?php echo $status; ?></td>
			<td><a class="btn btn-danger btn-xs" href="index.php?view=admin&for=files&action=delete&id_episode=<?php echo $episode['id_episode']; ?>&hash=<?php echo $episode['hash']; ?>">Supprimer</a></td>
		</tr>
		<?php 
		}
		?>
		</tbody>
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
<div style="margin-top:5%;border-left:0;width: 100%;
border-right:0;
  border-top:0;
border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
</div>  
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;font-size:15px;color:white;">
        TIMEFLIX<br><?php
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
