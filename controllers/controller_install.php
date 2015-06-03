<?php 
if(!empty($_POST['inc_username']) AND !empty($_POST['inc_password']))
{
	$req = $bdd->prepare("INSERT INTO `users` 
	(`adresse_email`, `password_crypt`, `status`,`is_admin`) 
	VALUES
	(:adresse_email,:password_crypt,:status,:is_admin)");
	$_POST['inc_password'] = core_encrypt_decrypt('encrypt',$_POST['inc_password']);
	$status = 'actif';
	$droit = 1;
	$req->bindParam(':adresse_email', $_POST['inc_username']);
	$req->bindParam(':password_crypt',$_POST['inc_password']);
	$req->bindParam(':status', $status);
	$req->bindParam(':is_admin', $droit);
	try {
		$req->execute();
		header('Location: index.php');
	} catch (Exception $e) {
	    header('Location: index.php?msg=erreur');
	}
}
include_once('views/view_install.php');