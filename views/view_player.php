<div id="detail_movie" class="row" style="padding-top:1%;">
	<div class="row">
		<div class="col-md-6" style="margin-left: 2%;">
			<p style="font-size:40px;text-transform: uppercase;font-weight: 600;">
				<?php echo utf8_encode($film['titre']);?>
				<img style="height:25px;" src="theme/assets/images/720p.png"/>
				<p>
					<?php echo substr(utf8_encode($film['syno']),0,345); ?> ...
					<br><br>
					<?php echo utf8_encode($film['acteur']); ?>
				</div>
				<div class="col-md-5" style="text-align:right;">
					<p style="font-size:40px;text-transform: uppercase;font-weight: 600;">Info fichier </p>
					
				<span class="label label-info">Taille : <?php echo utf8_encode($film['taille']); ?> GB</span>
				<span class="label label-warning"><?php echo utf8_encode($film['temps']); ?></span><br>
				<span class="label label-success" style="margin-top:1%;"><?php echo utf8_encode($film['langue']); ?></span>

				</div>
			</div>
			<center><a href="?view=<?php echo base64_encode('play_movie'); ?>&id_movie=<?php echo base64_encode($film['allocine']); ?>"><img style="height:100px;margin-top:10%" src="http://www.trektechblog.com/wp-content/themes/jupiter/images/icon_play.png"/></a></center>
		</div>