<html class="gt-ie8 gt-ie9 not-ie">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>TimeFlix</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
	<link rel="icon" href="theme/images/favicon.ico" />
	<link href="theme/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/pages.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/themes.min.css" rel="stylesheet" type="text/css">
	<link href="theme/css/animate.css" rel="stylesheet" type="text/css">



</head>

<body class="theme-frost page-signin-alt lazy" data-original="//pictures.timeflix.net/backgrounds<?php echo $img; ?>" style="background-attachment: fixed;background-size: cover;background-color: white;">
<div id="login">
        <form action="" method="post" id="signin-form_id" class="panel" style="float:right;margin-right: 5%;box-shadow: 1px 1px 12px rgba(0,0,0,1);margin-top:18%;background:rgba(0,0,0,0.8);border:0;">
<!--         		<p style="font-size:30px;text-transform: uppercase;font-weight: 300;color:white;text-shadow: 0 2px 0 #000;text-align: center;">
				Authentification 
				<p> -->
	<?php 
	if(isset($auth) and $auth == 'NOK')
	{
		echo '<div class="alert alert-danger">Utilisateur / Mot de passe incorrect </div>';
	}
	?>
		<div class="form-group">
			<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Email">
		</div> <!-- / Username -->

		<div class="form-group signin-password">
			<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
			<!-- <a href="#" class="forgot">Perdu ? </a>-->
		</div> <!-- / Password -->

		<div class="form-actions">
			<input type="submit" value="Connexion" class="btn btn-primary btn-block btn-lg">
		</div> <!-- / .form-actions -->
	</form>
	<div style="float:right;margin-top: 20.5%;margin-right: 2%;">
	<p style="font-size:80px;text-transform: uppercase;font-weight: 300;color:white;text-shadow: 0 2px 0 #000;text-align: center;">
				TIMEFLIX 
				<p>

</div>
	</div>
	<!-- / Form -->


<div style="position:fixed;height:25px;bottom:0px;left:0px;right:0px;margin-bottom:0px;">
<p style="font-size:13px;text-transform: uppercase;font-weight: 300;color:white;text-shadow: 0 2px 0 #000;text-align: left;padding-bottom: 2%;padding-left: 0.5%;">
				TIMEFLIX 2015 - Version 1.0
				<p>
    </div>

<script type="text/javascript"> window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>


<script src="theme/js/jquery.lazyload.js"></script>
<script src="theme/js//bootstrap.min.js"></script>
<script src="theme/js/pixel-admin.min.js"></script>
<div id="size" style="display:none;"></div>
<script type="text/javascript">
$("body.lazy").lazyload({
effect : "fadeIn"
});
</script>

</body>
</html>
