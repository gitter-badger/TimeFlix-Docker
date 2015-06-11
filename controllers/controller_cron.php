<?php
require('library/srtparser/srtFile.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
array_shift($argv); // remove first argument
$choice = array_shift($argv);
$choice = strtolower(trim($choice));

switch ($choice)
{
	case 'encodage':
		echo 'Starting Timeflix encodage'.PHP_EOL;
		encodage();
		break;
	
	case 'log':
		echo 'Starting Timeflix log'.PHP_EOL;
		log_nginx();
		break;

	case 'mail':
		echo 'Starting Timeflix mail'.PHP_EOL;
		send_email();
		break;
	
	default:
		echo 'Cette action n\'est pas reconnue'.PHP_EOL;
		exit;
		break;
}
exit(0);
function send_email()
{
	global $right;
	global $bdd;
	$mail             = new PHPMailer();
	$mail->CharSet 	  = "UTF-8";
	$mail->IsSMTP();
	$mail->Host       = $right['smtp_host']; 
	$mail->SMTPAuth   = true;                  
	$mail->Host       = $right['smtp_host']; 
	$mail->Port       = $right['smtp_port'];            
	$mail->Username   = $right['smtp_username']; 
	$mail->Password   = $right['smtp_password'];

	$mail_attente = get_data('mail',"WHERE status ='wait'");
	foreach ($mail_attente as $key => $mail_traitement)
	{
		$id = $mail_traitement['id_mail'];
		$mail->Subject = $mail_traitement['subject'];
		if($mail_traitement['type'] == 'new')
		{
			 $info = json_decode($mail_traitement['message']);
 			 $message = file_get_contents('library/phpmailer/news.html');
 			 $message = str_replace('%username%', $info->email, $message); 
			 $message = str_replace('%password%', core_encrypt_decrypt('decrypt',$info->password), $message);   
		}
		if($mail_traitement['type'] == 'lost')
		{
			 $info = json_decode($mail_traitement['message']);
 			 $message = file_get_contents('library/phpmailer/lost.html');
 			 $message = str_replace('%username%', $info->email, $message); 
			 $message = str_replace('%password%', core_encrypt_decrypt('decrypt',$info->password), $message);  
		}
		if($mail_traitement['type'] == 'serie')
		{
			 $info = json_decode($mail_traitement['message']);
 			 $message = file_get_contents('library/phpmailer/serie.html');
 			 $message = str_replace('%affiche%', $info->affiche, $message); 
			 $message = str_replace('%serie%', $info->serie, $message); 
			 $message = str_replace('%synopsis%', $info->syno, $message);
			 $message = str_replace('%title%', $info->title, $message);
		}
		$mail->SetFrom('noreply@timeflix.net', 'Système TimeFlix');
		$mail->MsgHTML($message);
		$mail->AddAddress($mail_traitement['to'], $mail_traitement['to']);
		if(!$mail->Send()) {
		  $error = $mail->ErrorInfo;
		  $bdd->exec("UPDATE mail SET status='error',label_status='$error',date_send=NOW() WHERE id_mail='$id'");
		} else {
		  $error = 'Message send !';
		  $bdd->exec("UPDATE mail SET status='send',label_status='$error',date_send=NOW() WHERE id_mail='$id'");
		}
	}

}
function log_nginx()
{
	global $bdd;
	$fichier_log = '/var/log/video.nginx.access.log';
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
}
function check()
{
	global $bdd;	
	global $right;
	$list_file = get_data('movies',"
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies WHERE files_movies.status=0");
	$episode_serie = get_data('episode_serie','WHERE status="0"');
	foreach ($list_file as $key => $file) 
	{
		$status = get_transmission($file['hash']);
		if($status['percent'] == 100)
		{
			exec('chmod -R 777 data/');
			$hash = $file['hash'];
			$id_moviedb = $file['id_moviedb'];
			$id = $file['id_file_movies'];
			$file=str_replace("\\", "/",$file['name']);
			$file=str_replace(" ", "\\ ",$file);
			$file=str_replace(")", "\)",$file);
			$file=str_replace("(", "\(",$file);
			$file=str_replace("[", "\[",$file);
			$file=str_replace("]", "\]",$file);
			$url = '/var/www/time/data/downloads/'.$file;
			echo $url;
			$video_info=get_video_info($url);
			print_r($video_info);
			if($video_info['video_codec'] == 'h264' OR $video_info['video_codec'] =='mpeg4' OR $video_info['video_codec'] =='ass')
			{
				$type = 'standard';
				$duration = $video_info['duration'];
				$args ='';
				if($video_info['width'] == 1280)
				{
					$type = '720p';
				}
				if($video_info['width'] == 1920)
				{
					$type = '1080p';
				}
				if($video_info['codec_tag'] == 'XVID')
				{
					$args=",h264_args='-c:v libx264'";
				}
				echo 'Analyse du film '.$id.' - Type: '.$type.PHP_EOL;
				$images_db = search_movie_images_db($id_moviedb);
				foreach($images_db->backdrops as $db)
				{
					if($db->height == 1080)
					{
						if (file_exists('data/backgrounds'.$db->file_path.'')) 
						{
						   continue;
						}
						if(!empty($db->file_path))
						{
							echo 'Add background '.$db->file_path.PHP_EOL;
							exec('wget -O data/backgrounds'.$db->file_path.' https://image.tmdb.org/t/p/original'.$db->file_path.'');
							$req = $bdd->prepare("INSERT INTO `backgrounds` 
							(`id_movies`, `file`) 
							VALUES
							(:id_movies,:file)");
							$req->bindParam(':id_movies',$id_moviedb);
							$req->bindParam(':file',$db->file_path);
							$req->execute() or die(print_r($req->errorInfo(), true));
						}
					}
				}
				$actor = search_movie_actors_db($id_moviedb); 
				foreach ($actor->cast as $key => $value) 
				{
					$data = get_desc_actors($value->id);
					if(!empty($data->profile_path))
					{
						exec('wget -O data/actors/'.$value->id.'.jpg https://image.tmdb.org/t/p/original'.$data->profile_path.'');
					}
					$data = json_encode($data);
					$req = $bdd->prepare("INSERT INTO `actors` 
					(`id_movie_db_actor`, `data`) 
					VALUES
					(:id_movie_db_actor,:data)");
					$req->bindParam(':id_movie_db_actor',$value->id);
					$req->bindParam(':data',$data);
					$req->execute();
				}
				$req = $bdd->exec("UPDATE files_movies SET status='1',type='$type',duration='$duration' $args WHERE id_file_movies=$id");
				stop_transmission($hash);
			}
		}
	}
		foreach ($episode_serie as $key => $file) 
	{
		$status = get_transmission($file['hash']);
		if($status['percent'] == 100)
		{
			$hash = $file['hash'];
			$id = $file['id_episode'];
			$file=str_replace("\\", "/",$file['file']);
			$file=str_replace(" ", "\\ ",$file);
			$file=str_replace(")", "\)",$file);
			$file=str_replace("(", "\(",$file);
			$file=str_replace("[", "\[",$file);
			$file=str_replace("]", "\]",$file);
			$file=str_replace("'", "\'",$file);
			$url = '/var/www/time/data/downloads/'.$file;
			echo $url;
			$video_info=get_video_info($url);
			print_r($video_info);
			if($video_info['video_codec'] == 'h264' OR $video_info['video_codec'] =='mpeg4' OR $video_info['video_codec'] =='aac')
			{
				$type = 'standard';
				$duration = $video_info['duration'];
				$args ='';
				if($video_info['width'] == 1280)
				{
					$type = '720p';
				}
				if($video_info['width'] == 1920)
				{
					$type = '1080p';
				}
				if($video_info['codec_tag'] == 'XVID')
				{
					$args=",h264_args='-c:v libx264'";
				}
				echo 'Analyse du film '.$id.' - Type: '.$type.PHP_EOL;
				$req = $bdd->exec("UPDATE episode_serie SET status='1',type='$type',duration='$duration' $args WHERE id_episode=$id");
				stop_transmission($hash);
			}
		}
	}
}
function encodage()
{
	global $right;
	global $bdd;
	while(1)
	{
		check();
		if($right['encodage_mp4'] != 'on')
		{	
			sleep(60);
			continue;
		}
		$list_encoding = get_data('files_movies','WHERE status="1" AND encoding_mp4="0"');
		$list_encoding_serie = get_data('episode_serie','WHERE status="1" AND encoding_mp4="0"');
		foreach ($list_encoding as $key => $encoding)
		{
			$id = $encoding['id_file_movies'];
			$file=str_replace("\\", "/",$encoding['name']);
			$file=str_replace(" ", "\\ ",$file);
			$file=str_replace(")", "\)",$file);
			$file=str_replace("(", "\(",$file);
			$req = $bdd->exec("UPDATE files_movies SET encoding_mp4='1' WHERE id_file_movies=$id");
			$args = '-vcodec copy';
			if(!empty($encoding['h264_args']))
			{
				$args = $encoding['h264_args'];
			}
			echo 'starting encoging ['.$args.']: '.$file.PHP_EOL;
			echo exec(''.$right['ffmpeg'].' -y -i  data/downloads/'.$file.' '.$args.' -codec:a libvorbis -b:a 320k -c:a libfdk_aac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');
			$req = $bdd->exec("UPDATE files_movies SET encoding_mp4='2' WHERE id_file_movies=$id");
			$shot = array('10','15','20','30','40','50','55','60','70','80','90','100');
			foreach ($shot as $value)
			{
				$file = ''.$encoding['id_movies'].'_'.$value.'.jpg';
				exec('ffmpegthumbnailer -i data/public/'.$encoding['hash'].'.mp4 -o data/thumbnail/'.$file.' -s 320 -q 10 -t '.$value.'');
				$req = $bdd->prepare("INSERT INTO `thumbnail` 
				(`id_movies`, `file`) 
					VALUES
					(:id_movies,:file)");
					$req->bindParam(':id_movies',$encoding['id_movies']);
					$req->bindParam(':file',$file);
					$req->execute() or die(print_r($req->errorInfo(), true));
			}
			echo 'End encoging : '.$file.PHP_EOL;
			echo 'Waiting task'.PHP_EOL;
		}
		foreach ($list_encoding_serie as $key => $encoding)
		{
			print_r($encoding);
			$searchsub = str_replace(" ", "_",$encoding['search']);
			$searchsub = str_replace("'", "_",$searchsub);
			$id = $encoding['id_episode'];
			$file=str_replace("\\", "/",$encoding['file']);
			$file=str_replace(" ", "\\ ",$file);
			$file=str_replace(")", "\)",$file);
			$file=str_replace("(", "\(",$file);
			$file=str_replace("[", "\[",$file);
			$file=str_replace("]", "\]",$file);
			$file=str_replace("'", "\'",$file);

			$bdd->exec("UPDATE episode_serie SET encoding_mp4='1' WHERE id_episode=$id");
			$args = '-c:v copy';
			if(!empty($encoding['h264_args']))
			{
				$args = $encoding['h264_args'];
			}
			if (strpos($file,'VOSTFR') !== false)
			{
				echo 'starting encoging ['.$args.']: '.$file.PHP_EOL;
				echo exec(''.$right['ffmpeg'].' -y -i  data/downloads/'.$file.' '.$args.' -codec:a libvorbis -b:a 320k -c:a libfdk_aac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');
				$req = $bdd->exec("UPDATE episode_serie SET encoding_mp4='2' WHERE id_episode=$id");
			}
			else
			{
				echo 'Check soustitre '.$file.PHP_EOL;
				echo exec(''.$right['subliminal'].' '.$searchsub.' -l fr -p addic7ed --addic7ed-username '.$right['addic7ed-username'].' --addic7ed-password '.$right['addic7ed-password'].'');
				$dir = explode('/',$file);
				$filesub = $file;
				if(count($dir) == 2)
				{
					$filesub = $dir[1];
				}
				if (strpos($file,'mkv') !== false)
				{
				    $sub=str_replace(".mkv", ".fr.srt",$filesub);
				}
				if (strpos($file,'mp4') !== false)
				{
				    $sub=str_replace(".mp4", ".fr.srt",$filesub);
				}
				if (strpos($file,'avi') !== false)
				{
				    $sub=str_replace(".avi", ".fr.srt",$filesub);
				}
				if (!file_exists($searchsub.'.fr.srt')) 
				{
				   echo exec(''.$right['subliminal'].' '.$searchsub.' -l fr');
				}
				try{
				  $srt = new \SrtParser\srtFile(''.$searchsub.'.fr.srt');
				  $srt->setWebVTT(true);
				  $srt->build(true);
				  $srt->save('data/subtiles/'.$encoding['hash'].'.vtt', true);
				  exec('rm '.$searchsub.'.fr.srt');
				}
				catch(Exeption $e){
				  //
				}
				echo PHP_EOL.'starting encoging ['.$args.']: '.$file.PHP_EOL;
				echo exec(''.$right['ffmpeg'].' -y -i  data/downloads/'.$file.' '.$args.' -codec:a libvorbis -b:a 320k -c:a libfdk_aac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');	
				$req = $bdd->exec("UPDATE episode_serie SET encoding_mp4='2' WHERE id_episode=$id");

				if (file_exists('data/public/'.$encoding['hash'].'.mp4') AND $right['smtp_username'] != NULL)
				{
				    	$mail_json = json_decode($encoding['mail_json']);
						$json = get_episode($encoding['id_serie'],$mail_json->id_saison,$mail_json->id_episode);
						$serie = get_data('series','WHERE id_serie_db="'.$encoding['id_serie'].'"');
						$title_serie = json_decode($serie[0]['data']);
						$message = json_encode(array(
							'affiche' => $json->still_path,
							'title'=>'Episode '.$json->episode_number.' - '.$json->name.'',
							'syno'=>$json->overview,
							'serie'=>$title_serie->name));


						$subject ='[NOUVEAU] '.$encoding['search'].'';
						$req = $bdd->prepare("INSERT INTO `mail` 
						(`to`, `subject`, `message`,`type`) 
						VALUES
						(:to,:subject,:message,:type)");
						$type ='serie';
						$req->bindParam(':to',$right['smtp_username']);
						$req->bindParam(':subject',$subject);
						$req->bindParam(':message', $message);
						$req->bindParam(':type', $type);
						$req->execute();
						exec('php index.php mail');
				}
			}
			remove_transmission($encoding['hash']);
			echo 'End encoging : '.$file.PHP_EOL;
			echo 'Waiting task'.PHP_EOL;
		}
		sleep(10);
	}
}
?>
