</div>
</div>
<div id="duration" style="display: none"/>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="/js/jquery.min.ie.js">'+"<"+"/script>"); </script>
<![endif]-->
<script src="theme/js/jquery.lazyload.js"></script>
<script src="theme/js/bootstrap.min.js"></script>
<script src="theme/js/pixel-admin.min.js"></script>
<script src="theme/js/pnotify.custom.min.js"></script>
<script src="theme/js/srt.js"></script>
<script src="theme/js/time.js"></script>
<script language="Javascript">
	window.PixelAdmin.start(init);

	<?php if(isset($_GET['view']) AND $_GET['view'] == 'movie_detail' OR $_GET['view'] == 'episode')
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
$('#active_torrent').switcher({ theme: 'square' });
$('#active_encodage').switcher({ theme: 'square' });
$('#active_encodage_st').switcher({ theme: 'square' });
$('#notif_email').switcher({ theme: 'square' });
$('#status').switcher({
				theme: 'square',
				on_state_content: '<span class="fa fa-check"></span>',
				off_state_content: '<span class="fa fa-times"></span>'
			});
$( "#notif_email" ).change(function() {
  $("#duration").load("index.php?view=change");
});
$(window).load(function(){
$("#wait").hide();
$("#loading").fadeIn();
});
</script>
</body>
</html>

