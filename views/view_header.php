<!DOCTYPE html>
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<link href="theme/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/themes.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/video-js.css" rel="stylesheet" type="text/css">
	<link href="theme/css/timeflix.css" rel="stylesheet" type="text/css">
	<link href="theme/css/pnotify.custom.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="theme/favicon.ico" />

</head>

<body class="page-profile theme-default main-menu-animated no-main-menu main-navbar-fixed" style="background-image:url(theme/images/black_linen_v2.png);">
<script>var init = [];</script>

<div id="main-wrapper">
<div id="modal-sizes-1" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Mon compte</h4>
                                       
			</div>
						<div class="modal-body">
                            <div class="row">
     	
          <div class="col-md-2"><img src="theme/images/avatar.png" alt="">
          <?php 
          	if($_SESSION['is_admin'] == 1)
          	{
          		echo '<center><a style="margin-top:5%;" href="index.php?view=admin" class="btn btn-danger"><i class="fa fa-star"></i>&nbsp;&nbsp;Admin</a>&nbsp;&nbsp;</center>';
          	}
          	else
          	{
          		echo '<center><a style="margin-top:5%;" href="index.php?view=user" class="btn btn-info"><i class="fa fa-user"></i>&nbsp;&nbsp;Utilisateur</a>&nbsp;&nbsp;</center>';
          	}
          ?>
             </div>
  <div class="col-md-8">
        <div class="panel panel-transparent">
					<div class="panel-heading">
						<span class="panel-title">Mes informations personnel</span>
					</div>
					<div class="list-group">
					<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-envelope"></i> Email : <p style="float:right"><?php echo $_SESSION['adresse_email']; ?></p></a>
					<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-laptop"></i> Inscrit depuis  : <p style="float:right"><?php echo temps_ecoule($_SESSION['registered'],'date'); ?></p></a>
                    <!--  <a href="#" class="list-group-item"><i class="profile-list-icon fa fa-password"></i> Mot de passe [] : <p style="float:right"><?php echo $_SESSION['password_crypt']; ?></p></a> -->
                    <a href="#" class="list-group-item"><i class="profile-list-icon fa fa-bell"></i> Notification Email <p style="float:right">			<input type="checkbox" id="notif_email" <?php if($_SESSION['notif_email'] =='activer') { echo 'checked="checked"'; }?>></p></a>
					<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-signal"></i> Data consommée : <p style="float:right">			<?php echo get_data_usage($_SESSION['id_users']); ?></p></a>

					</div>
				</div> 
         <div class="panel panel-transparent">
					<div class="panel-heading">
						<span class="panel-title">Dernières connexions</span>
					</div>
					<br>
					<div class="list-group">
					<?php
					$id_user = $_SESSION['id_users'];
					$log = get_data('logs',"WHERE id_users=$id_user ORDER BY date_add DESC LIMIT 0,5"); 
					foreach ($log as $l)
					{
						$record = geoip_record_by_addr($gi,$l['adresse_ip']);
						?>
						<a href="#" class="list-group-item"><i class="profile-list-icon fa fa-log"></i>[<?php echo utf8_encode($record->city); ?>] [<?php echo $l['adresse_ip']; ?>] <?php echo $l['useragent']; ?><p style="float:right"><?php echo temps_ecoule($l['date_add'],'date'); ?></p></a>
					<?php 
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
<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<!-- Main menu toggle -->
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
		
		<div class="navbar-inner">
		
			<div class="navbar-header">
				<a href="?view=goflix" class="navbar-brand"><?php echo $title; ?> <span class="label label-danger"><?php echo file_get_contents('VERSION'); ?></a>
				</a>

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

			</div>

			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
				<div>
	                             <ul class="nav navbar-nav">
	                             		<li>
						<a href="#" data-toggle="modal" data-target="#modal-sizes-1" ><span class="mm-text"><i class="fa fa-user"></i> Mon compte</a>
						</li>
					</ul> 

					<div class="right clearfix">
						<ul class="nav navbar-nav pull-right right-navbar-nav">

							<!-- <li>
					<a href="compte-accueil"><span class="mm-text"><i class="fa fa-film"></i> Bibliothèque </a>
				</li>-->
                <li>
					<a href="index.php?view=goflix"><span class="mm-text"><i class="fa fa-search"></i> GoFlix</a>
				</li>
				<li>
					<a href="index.php"><span class="mm-text"><i class="fa fa-film"></i> Films</a>
				</li>
				<li>
					<a href="index.php?view=serie"><span class="mm-text"><i class="fa fa-video-camera"></i> Séries</a>
				</li>
				<li>
					<a href="index.php?type=processed"><span class="mm-text"><i class="fa fa-exchange"></i> File d'attente</a>
				</li>
<!--                 <li>
					<a href=""><span class="mm-text"><i class="fa fa-folder-open"></i> <?php echo format_bytes(disk_free_space('/')); ?></a>
				</li>  -->
      			<li>
					<a href="logout.php"><span class="mm-text"><i class="fa fa-sign-out"></i> Déconnexion </a>
				</li>
				</ul>
                                           			 
							</li>
						</ul> 
					</div>
				</div>
			</div> 
		</div>      
	</div> 
<div class="row">

