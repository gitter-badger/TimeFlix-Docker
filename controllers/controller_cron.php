<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
echo 'Starting Timeflix daemon'.PHP_EOL;
echo 'Waiting task'.PHP_EOL;
function check()
{
	global $bdd;	
	$list_file = get_data('movies',"
	INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies WHERE files_movies.status=0");
	$episode_serie = get_data('episode_serie','WHERE status="0"');
	foreach ($list_file as $key => $file) 
	{
		$status = get_transmission($file['hash']);
		if($status['percent'] == 100)
		{
			$hash = $file['hash'];
			$id_moviedb = $file['id_moviedb'];
			$id = $file['id_file_movies'];
			$file=str_replace("\\", "/",$file['name']);
			$file=str_replace(" ", "\\ ",$file);
			$file=str_replace(")", "\)",$file);
			$file=str_replace("(", "\(",$file);
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
while(1)
{
	check();
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
		echo exec('ffmpeg -y -i  data/downloads/'.$file.' '.$args.' -codec:a libvorbis -b:a 320k -c:a libfaac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');
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
		$id = $encoding['id_episode'];
		$file=str_replace("\\", "/",$encoding['file']);
		$file=str_replace(" ", "\\ ",$file);
		$file=str_replace(")", "\)",$file);
		$file=str_replace("(", "\(",$file);
		$req = $bdd->exec("UPDATE episode_serie SET encoding_mp4='1' WHERE id_episode=$id");
		$args = '-c:v libx264';
		if (strpos($file,'VOSTFR') !== false)
		{
			echo 'starting encoging ['.$args.']: '.$file.PHP_EOL;
			echo exec('ffmpeg -y -i  data/downloads/'.$file.' '.$args.' -vf subtitles='.$sub.' -codec:a libvorbis -b:a 320k -c:a libfaac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');
			$req = $bdd->exec("UPDATE episode_serie SET encoding_mp4='2' WHERE id_episode=$id");
		}
		else
		{
			echo 'Check soustitre'.$file.PHP_EOL;
			echo exec("/usr/local/bin/subliminal $serie$lien/$file -l fr -p addic7ed --addic7ed-username peanutzer --addic7ed-password az01-er02");
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
			echo 'UTF8 converting task'.PHP_EOL;
			//file_put_contents($sub, utf8_encode(file_get_contents($sub)));
			echo 'starting encoging ['.$args.']: '.$file.PHP_EOL;
			echo exec('ffmpeg -y -i  data/downloads/'.$file.' '.$args.' -vf subtitles='.$sub.' -codec:a libvorbis -b:a 320k -c:a libfaac data/public/'.$encoding['hash'].'.mp4 2> data/log/'.$encoding['hash'].'.log');
			$req = $bdd->exec("UPDATE episode_serie SET encoding_mp4='2' WHERE id_episode=$id");
			exec('rm '.$sub.'');
		}
		// $shot = array('10','15','20','30','40','50','55','60','70','80','90','100');
		// foreach ($shot as $value)
		// {
		// 	$file = ''.$encoding['id_movies'].'_'.$value.'.jpg';
		// 	exec('ffmpegthumbnailer -i data/public/'.$encoding['hash'].'.mp4 -o data/thumbnail/'.$file.' -s 320 -q 10 -t '.$value.'');
		// 	$req = $bdd->prepare("INSERT INTO `thumbnail` 
		// 	(`id_movies`, `file`) 
		// 		VALUES
		// 		(:id_movies,:file)");
		// 		$req->bindParam(':id_movies',$encoding['id_movies']);
		// 		$req->bindParam(':file',$file);
		// 		$req->execute() or die(print_r($req->errorInfo(), true));
		// }
		remove_transmission($encoding['hash']);
		echo 'End encoging : '.$file.PHP_EOL;
		echo 'Waiting task'.PHP_EOL;
	}
	sleep(10);
}
?>

Daredevil.S01E03.720p.WEBRip.x264-SNEAkY.fr.srt