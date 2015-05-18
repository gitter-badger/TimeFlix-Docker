<div  id="detail_movie" class="row" style="top:10%;left:3%;z-index:1;">
<?php 
if(count($serie) == 0)
{
echo '<center><p style="font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:2%;">LA LISTE EST VIDE ... </p><br>
<img style="border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://31.media.tumblr.com/c1aa669e433bb01fc397abf29da26c56/tumblr_mr1q7mqsWa1rk8p43o1_500.gif"><center>';	
}
foreach($serie as $data_serie)
   {
    	$data = json_decode($data_serie['data']);
    	if(get_count_episode($data->id) >= 1)
    	{
		  echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:2%;width:200px;height:430px;">
		  <div style="position:absolute;height:22px;width:250px;background:rgba(0,128,0,0.6);z-index:1;margin-top:0%;border-top-left-radius: 10px;border-top-right-radius: 10px;">
			<p style="font-size:15px;text-transform: uppercase;text-align:center;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;border-bottom: 1px solid white;">
			'.get_count_episode($data->id).' Épisodes <br></p></div>
	      <a href="index.php?view=serie_detail&id_serie='.core_encrypt_decrypt('encrypt',$data->id).'">
	      <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://image.tmdb.org/t/p/w396'.$data->poster_path.'"/></a>
	      </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->name.'<br> 
	      <span class="label label-success">'.substr($data->first_air_date,0,4).'</span> <span class="label label-info">'.$data->vote_average.'/10</span>
	      <span class="label label-warning">'.$data->number_of_seasons.' Saisons</span>
	      </p></div>'; 
	  	}
    }
?>
 <div style="display: block; clear: both;"></div>
<div style="margin-top:5%;border-left:0;width: 95%;
border-right:0;
  border-top:0;
border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
</div>  
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;"><?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Générer en '.$total_time.' seconds - Mem : '.format_bytes(memory_get_usage()).'';
?></center>
</div>
</div>
