<div class="row" style=" margin-left: auto;
  margin-right: auto;width: 80%;margin-top:4%;color:white;
  border-top:0;border-right:0;border-left:0;
    border-image: linear-gradient(90deg, #1abc9c 15%, #2ecc71 15%, #2ecc71 12%, #3498db 12%, #3498db 32%, #9b59b6 32%, #9b59b6 35%, #34495e 35%, #34495e 55%, #f1c40f 55%, #f1c40f 59%, #e67e22 59%, #e67e22 63%, #e74c3c 63%, #e74c3c 82%, #ecf0f1 82%, #ecf0f1 92%, #95a5a6 92%);border-image-slice: 1;
  min-height:900px;">

	<div class="col-md-2" style="background-image: url('http://placehold.it/150x200'); background-size: cover;border-radius: 10px;box-shadow: 1px 1px 8px #000;height:350px;">
	</div>
	<div class="col-md-9" style="margin-left:2%;">
	      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-user"></span>&nbsp;&nbsp;Mon compte
      <p>
      <div class="col-md-4">
      Adresse email : <b><?php echo $_SESSION['adresse_email']; ?></b><br>
      Mot de passe : <b><?php echo core_encrypt_decrypt('decrypt',$_SESSION['password_crypt']); ?></b><br><br>
      </div>
      <div class="col-md-5" style="text-align:right;">
      État du compte : <?php 
      if($_SESSION['etat'] == 2)
      {
      		echo '<b style="color:green">Actif</b>';
      }
       ?></p>
    Notification email :<br> <input type="checkbox" id="switcher-disabled-square" checked="checked">

      <br><br>
      </div>
      <!-- <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-film"></span>&nbsp;&nbsp;Mes ajouts
      <p>
       <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-star"></span>&nbsp;&nbsp;Mes favoris
      <p>
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;">
      <span class="fa fa-comments"></span>&nbsp;&nbsp;Commentaires
      <p> -->
	</div>
</div>
<br>
<center style="color:white;">Timeflix -  Copyright 2015 </center>
