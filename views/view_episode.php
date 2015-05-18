<div class="bn-container_movie lazy" data-original="https://image.tmdb.org/t/p/original<?php echo $episode->still_path; ?>">
<div style="position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.4);z-index:0;">
</div>
    </div>
    <div id="detail_movie" class="row" style="padding-top:2%;">
  <div class="row">
    <div class="col-md-7" style="margin-left: 5%;height:505px;">
      <p style="font-size:60px;text-transform: uppercase;font-weight: 300;">
          <?php echo 'Episode '.$episode->episode_number.' - '.$episode->name.''; ?>
        <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Date de sortie : <?php echo $episode->air_date; ?>       </p>
       <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Note : <?php echo round($episode->vote_average,2); ?> / 10
        </p>
           <p>
          <br><br><br>
        </div>
        <div class="col-md-12" style="
        padding-left:8%;padding-top:2%;top:10%;background:rgba(0,0,0,0.4);border-bottom:0;
        border-left:0;
        border-right:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
       <div class="col-md-11">
        <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Synopsis
      <p>
            <?php echo $episode->overview; ?>
        <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
      <span class="fa fa-user"></span>&nbsp;&nbsp; Guest acteurs
      <p>
      <?php
      foreach ($episode->guest_stars as $actor) 
      {
        if(!empty($actor->profile_path))
        {
          echo '<img src="https://image.tmdb.org/t/p/w45'.$actor->profile_path.'" alt="" class="actor">';
        }
      }
      ?>
      <video  id="player" style="width: 100%;border-radius: 10px;box-shadow: 1px 1px 8px #000;margin-top: 2%" controls>
  <source src="<?php echo secure_link('/public/'.core_encrypt_decrypt('decrypt',$_GET['hash']).'.mp4'); ?>" type="video/mp4">
</video>

            <div style="margin-top:5%;border-left:0;
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
echo 'Générer en '.$total_time.' seconds';
?></center>
      </div>
                  </div>
