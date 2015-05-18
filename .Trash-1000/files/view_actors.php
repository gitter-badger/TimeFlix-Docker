<div  id="detail_movie" class="row" style="top:10%;left:4%;z-index:1;">

<?php 
foreach($actors as $data_serie)
   {
    	$data = json_decode($data_serie['data']);
    	//print_r($data);
		  echo '<div class="col-md-1" style="margin-left:6%;margin-bottom:1%;width:200px;height:410px;">
	      <a href="index.php?view=actors_detail&id_actors='.core_encrypt_decrypt('encrypt',$data->id).'">
	      <img style="width:250px;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="//pictures.timeflix.net/actors/'.$data->id.'.jpg"/></a>
	      </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data->name.'</p>
	      </p></div>'; 
    }
?>
</div>