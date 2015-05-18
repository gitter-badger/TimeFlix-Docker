<meta charset="utf-8">
<link href="theme/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/pixel-admin.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/widgets.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/rtl.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/themes.min.css" rel="stylesheet" type="text/css">
<link href="theme/css/video-js.css" rel="stylesheet" type="text/css">
<link href="theme/css/timeflix.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
<body style="background-image:url(theme/images/black_linen_v2.png);">
	<?php if($status==1)
		{
			?>
 <center><p style="font-size:50px;text-transform: uppercase;font-weight: 300;padding: 1%;color:white;text-shadow: 0 3px 0 #000;">Parfait, <br> Le film est ajouté ! </p></center>
<div style="width: 900px;margin-left: auto;margin-right:auto;background-color: white;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;margin-top:1%;">
  <div class="col-md-2" style="float:left;margin-right:2%;width:250px;height:380px;
      margin-bottom:2%;border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('data/posters/<?php echo $data->id; ?>.jpg'); background-size: cover;">
      </div>
      <div style="float:left;width:600px;">
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;padding: 3%">
      <span class="fa fa-download"></span>&nbsp;&nbsp;Torrent <a href="index.php?type=processed" class="btn btn-success" style="margin-top:1%;float:right;"><span class="fa fa-sign-out"> bibliothèque</a>
      <p>
      <p style="padding-left: 3%;">
      Hash : <?php echo $hash; ?><br>
      Fichier : <?php echo $name_file; ?><br>
      <p style="font-size:30px;text-transform: uppercase;font-weight: 300;padding: 3%">
      <span class="fa fa-info-circle"></span>&nbsp;&nbsp;Synopsis 
      <p style="padding-left: 3%;">
      <?php echo substr($data->overview,0,600); ?> ...
      </p>
      </div>
      </div>
      <?php 
	      }
	     ?>
	     <?php if($status==0)
		{
			?>
 <center><p style="font-size:50px;text-transform: uppercase;font-weight: 300;padding: 1%;color:white;text-shadow: 0 3px 0 #000;">Oups, <br> Une erreur a été détectée. </p></center>
<div style="width: 900px;margin-left: auto;margin-right:auto;background-color: white;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;margin-top:1%;">
  <div class="col-md-2" style="float:left;margin-right:2%;width:650px;height:380px;
      margin-bottom:2%;border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('http://ljdchost.com/MxFZvNI.gif'); background-size: cover;">
      </div>
      <div style="float:left;width:200px;">
      <p style="font-size:20px;text-transform: uppercase;font-weight: 300;padding: 3%">
      <span class="fa fa-bug"></span>&nbsp;&nbsp;information</p>
      Il semblerait que le fichier demandé soit incorrect, ou incomplet pour être ajoutée dans la bibliothèque, un administrateur vient d'être prévenu pour analyser cette erreur.
      <center><a href="index.php" class="btn btn-info" style="margin-top:80%;float:right;"><span class="fa fa-sign-out"> Bibliothèque</a></center>
      </div>
      </div>
      <?php 
	      }
	     ?>
</body>