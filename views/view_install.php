<meta charset="utf-8">
<link href="theme/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/pixel-admin.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/widgets.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/rtl.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/themes.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/video-js.css" rel="stylesheet" type="text/css">
<link href="theme/css/timeflix.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
<body style="background-image:url(theme/images/black_linen_v2.png);">

 <center><p style="font-size:50px;text-transform: uppercase;font-weight: 300;padding: 1%;color:white;text-shadow: 0 3px 0 #000;"><span class="fa fa-cogs"></span> Configuration</p></center>
<div style="width: 500px;margin-left: auto;margin-right:auto;">
<div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-user list-group-icon"></i>Création Administrateur </span>
    </div>
    <div class="panel-body">
<!--
    <legend>Vérification droits</legend>
    <?php 
	   if(substr(sprintf('%o', fileperms('data/')), -4) == '0777')
	   {
		   echo '<div class="alert alert-success" role="alert"><b> Accès OK </b> - Répertoire data</div>';
	   }
	   if(substr(sprintf('%o', fileperms('logs/')), -4) == '0777')
	   {
		   echo '<div class="alert alert-success" role="alert"><b> Accès OK </b> - Répertoire logs</div>';
	   }
	   else
	   {
		  echo '<div class="alert alert-danger" role="alert"><b>Droit insuffisant !</b> Répertoire logs</div>';
		} 

	   ?>
-->
		<div class="alert alert-info" role="alert"><center><b> Version DOCKER </b></center></br> Aucun réglages supplémentaire est nécessaire, il faudra juste pense à configurer votre cle api <b><a href="https://www.themoviedb.org/documentation/api">MovieDB</a></b></div>
	   <form action="" method="post" id="signin-form_new">
	   <div class="form-group">
			<input type="text" name="inc_username" id="inc_username" class="form-control input-lg" placeholder="Votre adresse mail">
		</div> <!-- / Username -->

		<div class="form-group signin-password">
			<input type="password" name="inc_password" id="inc_password" class="form-control input-lg" placeholder="Votre mot de passe">
			<!-- <a href="#" class="forgot">Perdu ? </a>-->
		</div> <!-- / Password -->

		<div class="form-actions">
			<div class="panel-footer text-right">
			<input type="submit" value="Valider" class="btn btn-success btn-lg">
			</div>
		</div>
		</form>
    </div>
        </div>
</body>