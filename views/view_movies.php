<?php 

/*
Vue film - Affichage la liste des films en ligne. 
*/
?>
<div id="bloc_movies" style="height: 100%;">
</div>
<div id="film_roll">
<?php 
$id_serie=$_GET['id_serie'];
$season=$_GET['season'];
$json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id_serie.'/season/'.$season.'?api_key=c61458343dec48dd506164bb1a15dda9&language=en'); 
$data = json_decode($json);
$serie = get_data('series',"WHERE id_serie_db=$id_serie");
$affiche = json_decode($serie['0']['data'])->backdrop_path;
	foreach($data->episodes as $film)
{

	//print_r($film);
	echo '<div class=\'film_roll_child\' id="&id_episode='.$film->episode_number.'&saison='.$data->season_number.'&id_serie='.$id_serie.'"><div style="position:absolute;width:396px;background:rgba(0,0,0,0.6);
	z-index:1;margin-top:49%;box-shadow: 1px 1px 8px #000;">
				<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;padding:1%;">
				SAISON '.$data->season_number.' Épisodes '.$film->episode_number.'<br></p></div><div id="image" style="background-size: cover;height:223px;width:396px;background-image:url(\'https://image.tmdb.org/t/p/w396'.$film->still_path.'\');"></div></div>';
}
?>
</div>
<script src="theme/js/jquery.film_roll.js"></script>
<script type="text/javascript">
$(function()
{
	var film_roll = new FilmRoll(
	{
		container: '#film_roll',
		vertical_center: true,
		pager:false,
		scroll: false,
		prev: false,
		next: false
	});
	film_roll.moveToIndex("<?php echo $_GET['id_episode']-1; ?>");
	$("body").css("background-image","url('https://image.tmdb.org/t/p/original/<?php echo $affiche; ?>')");
	var last_active_id = 0;

	$('#film_roll').on('film_roll:moving', function(event)
	{
		var movieBut = $('.film_roll_child.active');
		
		$('.film_roll_child').animate({opacity: .5});
		movieBut.animate({opacity: 1});

		var movieId = movieBut.attr('id');
		var cont = $('.bn-container');
		if (!cont.hasClass('active'))
		{
			cont.addClass('active');
			last_active_id = film_roll.index;
			return true;
		}
	});
	setTimeout(function()
	{
		var movieBut = $('.film_roll_child.active');
		var movieId = movieBut.attr('id');
		$("#bloc_movies").load("index.php?view=player"+movieId+"").fadeIn('600');
	}, 1000);

	$('.film_roll_child').click(function()
	{
		move = $(this).data('film-roll-child-id');
		film_roll.moveToIndex(move);
		var movieBut = $('.film_roll_child.active');
		var movieId = movieBut.attr('id');
		$("#bloc_movies").load("index.php?view=player"+movieId+"").fadeIn('600');
	});
});
</script>