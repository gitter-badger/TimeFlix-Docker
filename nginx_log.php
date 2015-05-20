<?php
error_reporting(0);
define('CRYPT_KEY', '*mr6dRQ9T/@5Gn9c!5S-');

include_once('config/config.php');
include_once('core/core.crypt.php');
include_once('core/core_get_data.php');
include_once('core/core_get_moviedb.php');
echo 'Starting daemon apache_log'.PHP_EOL;
$fichier_log = '/var/log/video.nginx.access.log';
while(1)
{
	$handle = fopen($fichier_log, 'r');
	$i=0;
	if ($handle)
	{
		echo 'Working apache_log - '.date("H:i").PHP_EOL;
		while (!feof($handle))
		{
			$buffer = fgets($handle);
			$data = explode(':', $buffer);
			if(!empty($data['0']) AND !empty($data['1']) AND !empty($data['2']))
			{
				$req = $bdd->prepare("INSERT INTO `apache_log` 
					(`adresse_ip`, `bits`, `file`) 
					VALUES
					(:adresse_ip,:bits,:file)");
				$req->bindParam(':adresse_ip', $data['0']);
				$req->bindParam(':bits', $data['1']);
				$req->bindParam(':file', $data['2']);
				$req->execute() or die(print_r($req->errorInfo(), true));
				$i++;
			}
		}
		echo 'End apache_log ('.$i.')'.PHP_EOL;
		fclose($handle);
		echo 'Working users/data'.PHP_EOL;
		file_put_contents($fichier_log, '');
		$association = get_data('apache_log',"WHERE id_users IS NULL");
		foreach($association as $assoc)
		{
			$ip = $assoc['adresse_ip'];
			$id = $assoc['id_apache_log'];
			$id_users = get_data('logs',"WHERE adresse_ip='$ip' ORDER BY date_add DESC LIMIT 0,1");
			$id_user = $id_users['0']['id_users'];
			$bdd->exec("UPDATE apache_log SET id_users='$id_user' WHERE id_apache_log='$id'");
		}
		echo 'End users/data'.PHP_EOL;
	}
	sleep(120);
}
?>
