<?php

/*
Controleur login 
*/
$affiche = get_data('movies',"");
$affiche = array();
if(count($affiche) == 0)
{
	$img = '/default.jpg';
}
else
{
	$number = rand(0,count($affiche) -1);
	$img = rand_local_image($affiche[$number]['id_moviedb']);
}
$user_os =  getOS();
$user_browser = getBrowser();
if($user_browser == 'Handheld Browser')
{
	header('Location: index.php?view=mobile');
	exit();
}
if(!empty($_POST['inc_username']) AND !empty($_POST['inc_password']))
{
	$req = $bdd->prepare("INSERT INTO `users` 
	(`adresse_email`, `password_crypt`, `status`) 
	VALUES
	(:adresse_email,:password_crypt,:status)");
	$_POST['inc_password'] = core_encrypt_decrypt('encrypt',$_POST['inc_password']);
	$status = 'attente';
	$req->bindParam(':adresse_email', $_POST['inc_username']);
	$req->bindParam(':password_crypt',$_POST['inc_password']);
	$req->bindParam(':status', $status);
	try {
		$req->execute();
		header('Location: index.php?msg=attente');
	} catch (Exception $e) {
	    header('Location: index.php?msg=erreur');
	}
}
if(!empty($_POST['username']) AND !empty($_POST['password']))
{	
	$data = get_data('users','WHERE adresse_email = "'.$_POST['username'].'" AND password_crypt="'.core_encrypt_decrypt('encrypt',$_POST['password']).'" LIMIT 1');
	if(empty($data))
	{
		header('Location: index.php?msg=auth_fail');
		exit;
	}
	if($data['0']['status'] == 'attente')
	{
		header('Location: index.php?msg=attente');
		exit;
	}
	$_SESSION['id_users'] = $data['0']['id_users'];
	$_SESSION['adresse_email'] = $data['0']['adresse_email'];
	$_SESSION['password_crypt'] = $data['0']['password_crypt'];
	$_SESSION['registered'] = $data['0']['registered'];
	$_SESSION['etat'] = $data['0']['status'];
	$_SESSION['is_admin'] = $data['0']['is_admin'];
	$_SESSION['notif_email'] = $data['0']['notif_email'];
	$_SESSION['bdd'] = get_bdd();
	$_SESSION['os'] = $user_os;
	$_SESSION['browser'] = $user_browser;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$req = $bdd->prepare("INSERT INTO `logs` 
	(`id_users`, `useragent`, `adresse_ip`) 
	VALUES
	(:id_users,:useragent,:adresse_ip)");
	$user_agent =  $user_os.' - '.$user_browser;
	$req->bindParam(':id_users', $_SESSION['id_users']);
	$req->bindParam(':useragent', $user_agent);
	$req->bindParam(':adresse_ip', $_SERVER['REMOTE_ADDR']);
	$req->execute();
	header('Location: index.php?view=goflix');  
}
include_once('views/view_login.php');
