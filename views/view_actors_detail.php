   <div class="bn-container_movie lazy" data-original="https://image.tmdb.org/t/p/original<?php echo $url[$key]; ?>">
<div style="position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.4);z-index:0;">
</div>
    </div>
    <div id="detail_movie" class="row" style="padding-top:2%;">
  <div class="row">
    <div class="col-md-5" style="margin-left: 5%;height:505px;">
      <p style="font-size:60px;text-transform: uppercase;font-weight: 300;">
          <?php echo $actors->name; ?>           <p>
        <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Date de naissance : <?php echo $actors->birthday; ?>
        </p>
        <p style="font-size:15px;text-transform: uppercase;font-weight: 300;"><b>A <?php echo $actors->place_of_birth; ?></b>
        </p>
          <br><br><br>
        </div>
        <div class="col-md-12" style="
        padding-left:8%;padding-top:2%;top:10%;background:rgba(0,0,0,0.4);border-bottom:0;
        border-left:0;
        border-right:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
      <div class="col-md-2" style="margin-right:2%;width:250px;height:380px;
      margin-bottom:2%;border-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('<?php echo secure_link('/actors/'.$id_actors.'.jpg');?>'); background-size: cover;">
      </div>
       <div class="col-md-9">
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Biographie 
      <p>
      <?php
       echo utf8_encode($actors->biography); ?>
          <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;padding-bottom: 1%;">
      <span class="fa fa-film"></span>&nbsp;&nbsp; Filmographie
      <p>
      <?php  
            $movies = get_movies_actors($id_actors);
       foreach($movies->cast as $data_movie)
         {
            //print_r($data);
            if(!empty($data_movie->poster_path))
            {
                echo '<div class="col-md-1" style="margin-left:2%;margin-bottom:5%;width:185px;height:278px;">
                   <a href="index.php?view=search&id_movie='.core_encrypt_decrypt('encrypt',$data_movie->id).'">
                <img style="width:185px;height:278px;border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="https://image.tmdb.org/t/p/w396'.$data_movie->poster_path.'"/></a>
                </br><p style="margin-left:10px;margin-top:5px;text-shadow: 0 2px 0 #000;font-weight: bold;text-transform: uppercase;color:#FFF;">'.$data_movie->original_title.'</p>
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
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;">
 Timeflix 2014 - 2015 <br><?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<p style=" font-size:9px;">';
echo 'Générer en '.$total_time.' seconds - Mem : '.format_bytes(memory_get_usage(true)).'</p>';
?></center>
      </div>
      </div>