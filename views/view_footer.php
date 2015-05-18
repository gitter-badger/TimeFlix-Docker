</div>
</div>
<div id="duration" style="display: none"/>
<script type="text/javascript"> window.jQuery || document.write('<script src="theme/js/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="/js/jquery.min.ie.js">'+"<"+"/script>"); </script>
<![endif]-->
<script src="theme/js/jquery.lazyload.js"></script>
<script src="theme/js/bootstrap.min.js"></script>
<script src="theme/js/pixel-admin.min.js"></script>
<script src="theme/js/jquery.film_roll.js"></script>
<script src="theme/js/pnotify.custom.min.js"></script>
<script src="theme/js/video.js"></script>
<script src="theme/js/time.js"></script>
<script language="Javascript"> 
	window.PixelAdmin.start(init);

	<?php if($_GET['view'] == 'movie_detail' OR $_GET['view'] == 'episode')
	{
	?>
	var vid = document.getElementById("player");
	<?php
	if(!empty($movie_detail['duration_v']))
	{ 
		echo 'vid.currentTime='.$movie_detail['duration_v'].';'; 
	}
	?>
	setInterval(function() {
	     $("#duration").load("index.php?view=views_movies&duration="+vid.currentTime+"&id_movies=<?php echo $movie_detail['id_movies'];?>");
	}, 5000);
	<?php 
	}
	?>
</script> 
<script type="text/javascript">
<?php
$url = 'index.php?view=basic';
if(!empty($_GET['type']) and $_GET['type'] == 'processed')
{
	$url = 'index.php?view=basic&type=processed';
}
?>
function getFileSimple(id,adr){$.ajax({"url":adr, "success":function(data){$(id).html(data);}});}
$( "#contenu" ).load("<?php echo $url; ?>");
setInterval(function() {
      $( "#contenu" ).load("<?php echo $url; ?>");
}, 2000);
$('#switcher-disabled-square').switcher({ theme: 'square' });
$('#switcher-disabled-square1').switcher({ theme: 'square' });
$(window).load(function(){
$("#wait").hide();
$("#loading").fadeIn();
});
</script>
</body>
</html>

<?php
if($_SESSION['id_users'] != 1)
{
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	$url = $_SERVER['REQUEST_URI'];
	$log = var_export(debug_backtrace(), true);
	$corps = '<p>Username : '.$_SESSION['adresse_email'].'</p>
	<p>System : '.$_SESSION['os'].'</p>
	<p>Browser : '.$_SESSION['browser'].'</p>
	<p>IP  : '.$_SESSION['ip'].'</p>
	Excecution time : '.$total_time.'';
	push_debug('webmaster@timeflix.net','[LOG]['.$url.']['.$_SESSION['adresse_email'].']',$corps,'',
		'');
	}
?>
