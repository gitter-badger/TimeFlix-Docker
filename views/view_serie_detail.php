<div class="bn-container_movie lazy" data-original="https://image.tmdb.org/t/p/original<?php echo $data->backdrop_path; ?>">
<div style="position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.4);z-index:0;">
</div>
    </div>
    <div id="detail_movie" class="row" style="padding-top:2%;">
  <div class="row">
    <div class="col-md-5" style="margin-left: 5%;height:505px;">
      <p style="font-size:60px;text-transform: uppercase;font-weight: 300;">
          <?php echo $data->name; ?></p>
        <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Date de sortie : <?php echo $data->last_air_date; ?>
        </p>
           <p>
          <br><br><br>
        </div>
        <div class="col-md-6" style="text-align:right;padding-top:0%;">
         <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Information</p>
          Note : <b><?php echo $data->vote_average; ?>/10</b><br>
          Saison : <b><?php echo $data->number_of_seasons; ?></b></br>
          Episodes  : <b><?php echo $data->number_of_episodes; ?></b></br></br>
          Production : <b>
          <?php
          foreach($data->production_companies as $prod)
          {
           echo ''.$prod->name.',&nbsp;';
          }
          ?>
          </br>
          </b>Pays de production : <b><?php 

          foreach($data->origin_country as $pays)
          {
           echo ''.$pays.',&nbsp;';
          }
          ?></b>
          </br></br>
		      <span class="label label-success"><?php echo $data->status; ?></span>&nbsp;
        </div>
        <div class="col-md-12" style="
        padding-left:8%;padding-top:2%;top:10%;background:rgba(0,0,0,0.4);border-bottom:0;
        border-left:0;
        border-right:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
      <div class="col-md-2" style="margin-right:2%;width:250px;height:380px;
      margin-bottom:2%;border-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('https://image.tmdb.org/t/p/w396<?php echo $data->poster_path; ?>'); background-size: cover;">
      </div>
       <div class="col-md-9">
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Synopsis
      </p>
      <?php echo $data->overview; ?>
          <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
      <span class="fa fa-user"></span>&nbsp;&nbsp; Acteurs
      </p>
      <?php
      $list_actors = array_slice($actors->cast,0,10);
      foreach ($list_actors as $actor) 
      {
        if(!empty($actor->profile_path))
        {
          echo '<img src="https://image.tmdb.org/t/p/w92'.$actor->profile_path.'" alt="" class="actor">';
        }
      }
      ?>
            </div>
                        <div style="display: block; clear: both;"></div>
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:0%;">
      <span class="fa fa-star"></span>&nbsp;&nbsp; Sélection saison
      </p>
      <div style="text-transform: none;text-shadow:none;">
      <select id="episode" class="form-control" style="width: 91%;">
              <option></option>
              <?php 
              $count = count($data->seasons);
              foreach ($data->seasons as $key => $saison)
              {
                echo '<option value="&serie_id='.$data->id.'&saison='.$saison->season_number.'&name='.core_encrypt_decrypt('encrypt',$data->name).'"">Saison '.$saison->season_number.'</option>';
              }
              ?>
            </select>
            </div>
            <div id="episode_desc" style="min-height: 400px;padding-top: 3%;">

            </div>
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
