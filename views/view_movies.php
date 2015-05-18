<?php 

/*
Vue film - Affichage la liste des films en ligne. 
*/
?>
 <div id="wait"><center><img src="theme/images/loader_main.gif" alt="loading" style="padding-top:5%;height:200px;" /><p style="font-size:30px;text-transform: uppercase;font-weight: 300;">Récupération de la bibliothèque</p></center></div>
<div id="loading" style="display:none;">
<div id="container">
<div id="bloc_movies" style="height:100%;padding-top:2%;">

</div>
<div id="film_roll">
<?php 
	foreach($films as $film)
{
	echo '<div class=\'film_roll_child\' id="'.$film['allocine'].'"><img style="height:250px" src="theme/images/'.$film['allocine'].'.jpg"> </div>';
}
?>
</div>
   <div style="display: inline-block;"></div>
</div>
</div>