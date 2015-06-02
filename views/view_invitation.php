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

 <center><p style="font-size:50px;text-transform: uppercase;font-weight: 300;padding: 1%;color:white;text-shadow: 0 3px 0 #000;"><span class="fa fa-star"></span> Invitation Beta ! </p></center>
<div style="width: 900px;margin-left: auto;margin-right:auto;background-color: white;height:380px;border-radius: 10px;box-shadow: 1px 1px 8px #000;margin-top:1%;">
  <div class="col-md-2" style="float:left;margin-right:2%;width:600px;height:380px;
      margin-bottom:2%;border-top-left-radius: 10px;border-bottom-left-radius: 10px;box-shadow: 1px 1px 8px #000;background-image: url('https://33.media.tumblr.com/07fed17d5fd7e27860810e8836526154/tumblr_miqpathG9c1qg2jf6o1_400.gif'); background-size: cover;">
      </div>
      <div style="float:left;width:250px;">
      <p style="font-size:20px;text-transform: uppercase;font-weight: 300;padding: 3%">
      <span class="fa fa-edit"></span>&nbsp;&nbsp;Paramétrage du compte </p>
      <br></br>
            <form method="post" action="">
     <label for="login">Votre login </label>
      <input type="email" name="email" class="form-control" id="exampleInputPassword1" value="<?php echo $invit['0']['email']; ?>">
      </br>
      <div class="form-group">
      <label for="password">Mot de passe </label>
      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe ">
      </div>
      <center><button class="btn btn-success" type="submit" style="margin-top:30%;float:right;"><span class="fa fa-thumbs-up"> Je valide mon compte !</a></center>
      </form>
      </div>
      </div>
</body>