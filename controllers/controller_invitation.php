<?php 
if(!empty($_POST['password']))
{
	$password = core_encrypt_decrypt('encrypt',$_POST['password']);
	$uniqueid = $_GET['unique_id'];
	$date_usage = time('Y-m-d H:i:s');
	$req = $bdd->exec("UPDATE invitation SET is_active='1',date_usage=NOW() WHERE unique_id='$uniqueid'");
	$req = $bdd->prepare("INSERT INTO `users` 
	(`adresse_email`, `password_crypt`) 
	VALUES
	(:adresse_email,:password_crypt)");
	$req->bindParam(':adresse_email',$_POST['email']);
	$req->bindParam(':password_crypt',$password);
	$req->debugDumpParams();
	$req->execute();
	header('Location: index.php');  
}
if(!empty($_GET['unique_id']))
{
	$uniqueid = $_GET['unique_id'];
	$invit = get_data('invitation',"WHERE unique_id='$uniqueid' AND is_active=0 LIMIT 1"); 
	if(count($invit) == 0)
	{
		header('Location: index.php');  
	}
}
include_once('views/view_invitation.php');