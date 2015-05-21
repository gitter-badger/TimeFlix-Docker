<div class="bn-container_movie lazy" data-original="//pictures.timeflix.net/<?php echo 'backgrounds'.$img.''; ?>">
<div style="position:absolute;height:100%;width:100%;background:rgba(0,0,0,0.4);z-index:0;">
</div>
    </div>
    <div id="detail_movie" class="row" style="padding-top:2%;">
  <div class="row">
    <div class="col-md-5" style="margin-left: 5%;height:505px;">
      <p style="font-size:60px;text-transform: uppercase;font-weight: 300;">
          <?php echo $movie_detail['title']; ?>
        <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Date de sortie : <?php echo $movie_detail['release_date']; ?>
        </p>
           <p>
          <br><br><br>
        </div>
        <div class="col-md-6" style="text-align:right;padding-top:0%;">
         <p style="font-size:20px;text-transform: uppercase;font-weight: 300;">Information</p>
          Note : <b><?php echo $movie_detail['note']; ?>/10</b><br>
          Budget : <b><?php echo $movie_detail['budget']; ?></b></br>
          Revenue : <b><?php echo $movie_detail['returned']; ?></b></br></br>
          Production : <b>
          <?php
          echo $movie_detail['production']; 
          echo '<br>';
          ?>
          </b>Pays de production : <b><?php 
         echo $movie_detail['country_of_production'];
          ?></b>
          </br></br>
         <?php 
	        $tags = explode(',',$movie_detail['tags']); 
	        foreach($tags as $tag)
	        {
		         echo '<span class="label label-success">'.$tag.'</span>&nbsp;';
	        }
	        ?>
        </div>
        <div class="col-md-12" style="
        padding-left:8%;padding-top:2%;top:10%;background:rgba(0,0,0,0.4);border-bottom:0;
        border-left:0;
        border-right:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
      <div class="col-md-2" style="margin-right:2%;width:250px;height:380px;
      margin-bottom:2%;border-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('//pictures.timeflix.net/<?php echo '/posters/'.$movie_detail['id_moviedb'].'.jpg'; ?>'); background-size: cover;">
      </div>
       <div class="col-md-9">
      <video  id="player" style="width: 100%;border-radius: 10px;box-shadow: 1px 1px 8px #000;" controls preload="none">
  <source src="<?php echo secure_link('/video/'.$movie_detail['hash'].'.mp4'); ?>" type="video/mp4">
</video>
<br><br>
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Synopsis 
      <a href="index.php?view=download&file=<?php echo $movie_detail['hash']; ?>" target="_blank" class="btn btn-sm btn-danger" style="margin-top:1%;float:right;margin-left:1%;">
      <span class="fa  fa-download"> Télecharger (<?php echo format_bytes(filesize('data/public/'.$movie_detail['hash'].'.mp4')); ?>)</a>
      <?php 
      if (file_exists('data/public/x265/'.$movie_detail['hash'].'.mp4')) 
      {?>
  <a href="<?php echo secure_link('/public/x265/'.$movie_detail['hash'].'.mp4'); ?>" target="_blank" class="btn btn-sm btn-warning" style="margin-top:1%;float:right;margin-left:1%;">
      <span class="fa fa-download"> H265 (<?php echo format_bytes(filesize('data/public/x265/'.$movie_detail['hash'].'.mp4')); ?>)</a>
    <?php
      }
      ?>
      <!--  <a href="index.php" class="btn btn-sm btn-warning" style="margin-top:1%;float:right;"><span class="fa  fa-exclamation-triangle"> Signaler</a> -->
      <p>
      <?php echo utf8_encode($movie_detail['synopsis']); ?>
          <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
      <span class="fa fa-user"></span>&nbsp;&nbsp; Acteurs
      <p>
      <?php
      $list_actors = search_movie_actors_db($movie_detail['id_moviedb']);
      $list_actors = array_slice($list_actors->cast,0,10);
      foreach ($list_actors as $actor) 
      {
        if(!empty($actor->profile_path))
        {
          echo '<a href="index.php?view=actors_detail&id_actors='.core_encrypt_decrypt('encrypt',$actor->id).'"><img src="https://image.tmdb.org/t/p/w92'.$actor->profile_path.'" alt="" class="actor"></a>';
        }
      }
      ?>
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;margin-top:2%;">
      <span class="fa fa-picture-o"></span>&nbsp;&nbsp; Vignettes
      <p>
      <div style="box-shadow: 1px 1px 8px #000;margin-right:4px;">
      <?php
      $vignette = get_data('thumbnail','WHERE id_movies='.$movie_detail['id_movies'].'');
      foreach ($vignette as $value) 
      {
        echo '<img src="//pictures.timeflix.net/thumbnail/'.$value['file'].'">';
      }
      ?>
      </div>
      <!-- <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-comments-o"></span>  Commentaire (s)
      <p> -->
            <div style="margin-top:5%;border-left:0;
        border-right:0;
          border-top:0;
        border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;">
        </div>  
        <center style="padding-bottom: 2%;text-transform: uppercase;padding-top:1%;"> Timeflix 2014 - 2015 <br><?php
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
