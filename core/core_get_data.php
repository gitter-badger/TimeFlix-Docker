<?php

/*
Core - Get_data - Récupère des données en base. 
*/
require_once 'library/transmission/vendor/autoload.php';
use Transmission\Client;
use Transmission\Model\File;
use Transmission\Model\trackerStats;
use Transmission\Transmission;



define("KILO", 1024);
define("MEGA", KILO * 1024);
define("GIGA", MEGA * 1024);
define("TERA", GIGA * 1024);
$user_agent = $_SERVER['HTTP_USER_AGENT'];
function get_data($table,$requete)
{
    global $bdd;
    $bdd->quote($requete);
	$req = $bdd->prepare('SELECT * FROM '.$table.' '.$requete.'');
	$req->execute();
	$data_list = $req->fetchAll();  
	return $data_list;
}
function get_process($proccess)
{
  exec("ps aux | grep -i '$proccess' | grep -v grep", $pids);
  if(empty($pids)) {
          return  '<span class="label label-danger">Hors ligne</span>';
  } else {
          return '<span class="label label-success">En ligne</span>';
  }
}
function get_system()
{
    if ( $_SESSION["cores"] == '')
    {
      exec("grep cores /proc/cpuinfo |head -n 1 |sed 's/.* //'", $out,$rc );
      if ( ereg('^[0-9]+$',$out[0])) $_SESSION["cores"] = $out[0];
    }

    // --- 2/ verifie la charge CPU
    $loadavg =0 ; 
    $fd=@fopen('/proc/loadavg','r');
    if ( $fd ) {
        if ( $loadavg =  fscanf($fd, "%f")) {  // --- lit la charge systeme
            fclose ($fd);

            // ramene en % et divise par le nb de coeurs : 
            $loadavg = ceil( $loadavg[0] *100 /$_SESSION["cores"]  ) ;  

            // si besoin : 
            if ( $loadavg > 200) 
              {       
                echo '<meta http-equiv="refresh" content="0; url=index.php?view=help" />';
              }
            }
    }
    return $loadavg;
}
function get_transmission($hash)
{
    $client = new Client();
    $client->authenticate('admin', 'jackjack');
    $transmission = new Transmission();
    $transmission->setClient($client);
    $torrent = $transmission->get($hash);
    $list['peers'] = count($torrent->getPeers());
    $list['download'] = format_bytes($torrent->getDownloadRate());
    $list['upload'] = format_bytes($torrent->getUploadRate());
    $list['percent'] = $torrent->getPercentDone();
    return $list;
}
function get_transmission_serie($id_episode)
{
    global $bdd;
    $req = $bdd->prepare('SELECT hash FROM episode_serie WHERE id_episode='.$id_episode.' LIMIT 1');
    $req->execute();
    $result = $req->fetchAll();  
    if(count($result) == 1)
    {
      $client = new Client();
      $client->authenticate('admin', 'jackjack');
      $transmission = new Transmission();
      $transmission->setClient($client);
      $torrent = $transmission->get($result['0']['hash']);
      $list['peers'] = count($torrent->getPeers());
      $list['download'] = format_bytes($torrent->getDownloadRate());
      $list['upload'] = format_bytes($torrent->getUploadRate());
      $list['percent'] = $torrent->getPercentDone();
      return $list;
    }
}
function get_search($search)
{
    global $bdd;
    $bdd->quote($search);
    $req = $bdd->prepare('SELECT * FROM movies INNER JOIN files_movies ON files_movies.id_movies = movies.id_movies
    WHERE movies.status=1 AND movies.production LIKE "%'.$search.'%" OR movies.country_of_production LIKE "%'.$search.'%" OR movies.release_date LIKE "%'.$search.'%"
    OR files_movies.type LIKE "%'.$search.'%" OR movies.note LIKE "%'.$search.'%" OR movies.tags LIKE "%'.$search.'%"');
    $req->execute();
    $result = $req->fetchAll();  
    return $result;
}
function stop_transmission($hash)
{
    $client = new Client();
    $client->authenticate('admin', 'jackjack');
    $transmission = new Transmission();
    $transmission->setClient($client);
    $torrent = $transmission->get($hash);
    $transmission->stop($torrent);
    return true;
}
function remove_transmission($hash)
{
    $client = new Client();
    $client->authenticate('admin', 'jackjack');
    $transmission = new Transmission();
    $transmission->setClient($client);
    $torrent = $transmission->get($hash);
    $transmission->remove($torrent, true);
    return true;
}
function generate_stike($name,$season,$episode,$args)
{
  $epis = sprintf("%02d", $episode);
  $sai = sprintf("%02d", $season);
  return $name.' S'.$sai.'E'.$epis.' '.$args.'';
}
function get_movie_exist($value)
{
	global $bdd;
	$req = $bdd->prepare('SELECT COUNT(*) FROM movies WHERE id_moviedb = '.$value.'');
	$req->execute();
	$value = $req->fetchAll();  
	return $value[0]['COUNT(*)'];
}
function get_stats($value)
{
  global $bdd;
  $req = $bdd->prepare('SELECT COUNT(*) AS connexion,DATE(date_add) AS date FROM logs GROUP BY DATE(date_add)');
  $req->execute();
  $value = $req->fetchAll();  
  return $value;
}
function get_requete($value)
{
  global $bdd;
  $req = $bdd->prepare('SELECT COUNT(*) AS requete,DATE(date_add) AS date FROM apache_log GROUP BY DATE(date_add)');
  $req->execute();
  $value = $req->fetchAll();  
  return $value;
}
function get_count_episode($value)
{
  global $bdd;
  $req = $bdd->prepare('SELECT COUNT(*) FROM episode_serie WHERE id_serie = '.$value.'');
  $req->execute();
  $value = $req->fetchAll();  
  return $value[0]['COUNT(*)'];
}
function get_bdd()
{
  global $bdd;
  $req = $bdd->prepare("SELECT SUM(Data_length)
    FROM  INFORMATION_SCHEMA.PARTITIONS
    WHERE TABLE_SCHEMA = 'timeflix'");
  $req->execute();
  $value = $req->fetchAll();  
  return format_bytes($value[0]['SUM(Data_length)']);
}
function get_serie_exist($value)
{
  global $bdd;
  $req = $bdd->prepare('SELECT COUNT(*) FROM series WHERE id_serie_db = '.$value.'');
  $req->execute();
  $value = $req->fetchAll();  
  return $value[0]['COUNT(*)'];
}
function get_view_movies($id_movies)
{
	global $bdd;
	$req = $bdd->prepare('SELECT COUNT(*) FROM movies_views WHERE id_movie = '.$id_movies.'');
	$req->execute();
	$value = $req->fetchAll();  
	return $value[0]['COUNT(*)'];
}
function rand_local_image($id_movies)
{
	global $bdd;
	$req = $bdd->prepare('SELECT file FROM backgrounds WHERE id_movies = '.$id_movies.'');
	$req->execute();
	$value = $req->fetchAll(); 
	$key = array_rand($value,1);
	return $value[$key]['file'];
}
function get_data_usage($id_users)
{
	global $bdd;
	$req = $bdd->prepare('SELECT SUM( bits ) FROM apache_log WHERE id_users = '.$id_users.'');
	$req->execute();
	$value = $req->fetchAll(); 
  $pourcent = format_bytes($value[0][0]); 
  if($pourcent == ' B')
  {
    $pourcent = '0 MB';
  }
	return $pourcent;
}
function get_data_movie_bits($hash)
{
  global $bdd;
  $req = $bdd->prepare('SELECT SUM( bits ) FROM apache_log WHERE file LIKE "%'.$hash.'%"');
  $req->execute();
  $value = $req->fetchAll(); 
  return $value[0][0];
}
function get_data_movie($hash)
{
	global $bdd;
	$req = $bdd->prepare('SELECT SUM( bits ) FROM apache_log WHERE file LIKE "%'.$hash.'%"');
	$req->execute();
	$value = $req->fetchAll(); 
  $pourcent = format_bytes($value[0][0]); 
  if($pourcent == ' B')
  {
    $pourcent = '0 MB';
  }
  return $pourcent;
}
function format_bytes($bytes) 
{
    if ($bytes < KILO) {
        return $bytes . ' B';
    }
    if ($bytes < MEGA) {
        return round($bytes / KILO, 2) . ' KB';
    }
    if ($bytes < GIGA) {
        return round($bytes / MEGA, 2) . ' MB';
    }
    if ($bytes < TERA) {
        return round($bytes / GIGA, 2) . ' GB';
    }
    return round($bytes / TERA, 2) . ' TB';
}
function get_video_info($videofile) 
{
    putenv('LD_LIBRARY_PATH=/home/kouja/lib');
    $ffprobe_path = '~/bin/ffprobe';
    $ffmpeg_path = '~/bin/ffmpeg';
    $ffprobe_cmd =  $ffprobe_path . " -v quiet -print_format json -show_format -show_streams " . $videofile . " 2>&1";
    ob_start();
    passthru($ffprobe_cmd);
    $ffmpeg_output = ob_get_contents();
    ob_end_clean();
    // if file not found just return null
    if(sizeof($ffmpeg_output) == null ) {
        return null;
    }
    $json = json_decode($ffmpeg_output,true);
    //Uncomment below if you want to debug the json output
     // echo "<pre>";
     // echo json_encode($json, JSON_PRETTY_PRINT);
     // echo "</pre>";
    $video_codec=$json['streams'][0]['codec_name'];
    $width=$json['streams'][0]['width'];
    $height=$json['streams'][0]['height'];
    $codec_string=$json['streams'][0]['codec_tag_string'];
    $duration=$json['format']['duration'];
    $resultset = array( 'video_codec' => $video_codec,
                'width' => $width,
                'height' => $height,
                'codec_tag'=>$codec_string,
                'duration'=>$duration
              );
        return  $resultset;   
}
function taille_dossier($rep){
        $racine=@opendir($rep);
        $taille=0;
        while($dossier=@readdir($racine)){
            if(!in_array($dossier, Array("..", "."))){
                if(is_dir("$rep/$dossier")){
                    $taille+=taille_dossier("$rep/$dossier");
                }else{
                    $taille+=@filesize("$rep/$dossier");
                }
            }
        }
        @closedir($racine);
        return $taille;
    }
function ffmpeg_pourcentage($file)
{
    $content = file_get_contents($file);
    if($content){
        //get duration of source
        preg_match("/Duration: (.*?), start:/", $content, $matches);

        $rawDuration = $matches[1];

        //rawDuration is in 00:00:00.00 format. This converts it to seconds.
        $ar = array_reverse(explode(":", $rawDuration));
        $duration = floatval($ar[0]);
        if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
        if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

        //get the time in the file that is already encoded
        preg_match_all("/time=(.*?) bitrate/", $content, $matches);

        $rawTime = array_pop($matches);

        //this is needed if there is more than one match
        if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

        //rawTime is in 00:00:00.00 format. This converts it to seconds.
        $ar = array_reverse(explode(":", $rawTime));
        $time = floatval($ar[0]);
        if (!empty($ar[1])) $time += intval($ar[1]) * 60;
        if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

        //calculate the progress
        $progress = round(($time/$duration) * 100);
        echo $progress;
    }
}
function download($fichier)
{
 $chemin = 'data/public/' . $fichier.'.mp4';
 if(file_exists($chemin))
 {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=' . basename($chemin));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($chemin));
  session_write_close();
  @ob_clean();
  @flush();
  @ob_end_flush();
  readfile($chemin);
  exit;  
 }
 else
  exit;
}
function temps_ecoule($date,$type) {
    if($type == "timestamp") {
      $date2 = $date; // depuis cette date
    } elseif($type == "date") {
      $date2 = strtotime($date); // depuis cette date
    } else {
      return "Non reconnu";
      exit();
    }
    $date1 = date("U"); // à la date actuelle
    $return = "";
    // ########  ANNEE ########
    if((date('Y',$date1 - $date2)-1970) > 0) {
      if((date('Y',$date1 - $date2)-1970) > 1) {
        $echo_annee = (date('Y',$date1 - $date2)-1970)." Anneés";
        $return = $echo_annee.", ";
      } else {
        $echo_annee = (date('Y',$date1 - $date2)-1970)." Année";
        $return = $echo_annee.", ";
      }
    } else {
      $echo_annee = "";
      $return = $return;
    }
    // ########  MOIS ########
    if((date('m',$date1 - $date2)-1) > 0) {
      $echo_mois = (date('m',$date1 - $date2)-1)." Mois ";
      if(!empty($echo_annee)) {
        $return = $echo_annee." et ".$echo_mois;
      } else {
        $return = $echo_mois;
      }
    } else {
      $echo_mois = "";
      $return = $return;
    }
    // ########  JOUR ########
    if((date('d',$date1 - $date2)-1) > 0) {
      if((date('d',$date1 - $date2)-1) > 1) {
        $echo_jour = (date('d',$date1 - $date2)-1)." Jours";
        if(!empty($echo_annee) OR !empty($echo_mois)) {
          $return = $return.$echo_mois." et ".$echo_jour;
        } else {
          $return = $return.$echo_mois.$echo_jour;
        }
      } else {
        $echo_jour = (date('d',$date1 - $date2)-1)." Jour";
        if(!empty($echo_annee) OR !empty($echo_mois)) {
          $return = $return.$echo_mois." et ".$echo_jour;
        } else {
          $return = $return.$echo_mois.$echo_jour;
        }
      }
    } else {
      $echo_jour = "";
      $return = $return;
    }
    // ########  HEURE ########
    if((date('H',$date1 - $date2)-1) > 0) {
      if((date('H',$date1 - $date2)-1) > 1) {
        $echo_heure = (date('H',$date1 - $date2)-1)." Heures";
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour)) {
          $return = $echo_annee.$echo_mois.$echo_jour." et ".$echo_heure;
        } else {
          $return = $echo_annee.$echo_mois.$echo_jour.$echo_heure;
        }
      } else {
        $echo_heure = (date('H',$date1 - $date2)-1)." Heure";
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour)) {
          $return = $echo_annee.$echo_mois.$echo_jour." et ".$echo_heure;
        } else {
          $return = $echo_annee.$echo_mois.$echo_jour.$echo_heure;
        }
      }
    } else {
      $echo_heure = "";
      $return = $return;
    }
    // ########  MINUTE ET SECONDE ########
    $virgule_annee = "";
    $virgule_mois = "";
    $virgule_jour = "";
    if(date('i',$date1 - $date2) > 0) {
      if(date('i',$date1 - $date2) > 1) {
        $echo_minute = round(date('i',$date1 - $date2))." Minutes";
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
          if(!empty($echo_annee)) {
            if(!empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_annee = ", ";
            }
          }
          if(!empty($echo_mois)) {
            if(!empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_mois = ", ";
            }
          }
          if(!empty($echo_jour)) {
            if(!empty($echo_heure)) {
              $virgule_jour = ", ";
            }
          }
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure." et ".$echo_minute;
        } else {
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure.$echo_minute;
        }
      } else {
        $echo_minute = round(date('i',$date1 - $date2))." Minute";
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
          if(!empty($echo_annee)) {
            if(!empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_annee = ", ";
            }
          }
          if(!empty($echo_mois)) {
            if(!empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_mois = ", ";
            }
          }
          if(!empty($echo_jour)) {
            if(!empty($echo_heure)) {
              $virgule_jour = ", ";
            }
          }
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure." et ".$echo_minute;
        } else {
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure.$echo_minute;
        }
      }
    } else {
      if(date('s',$date1 - $date2) > 1) {
        $echo_minute = round(date('s',$date1 - $date2))." Secondes";
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
          if(!empty($echo_annee)) {
            if(!empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_annee = ", ";
            }
          }
          if(!empty($echo_mois)) {
            if(!empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_mois = ", ";
            }
          }
          if(!empty($echo_jour)) {
            if(!empty($echo_heure)) {
              $virgule_jour = ", ";
            }
          }
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure." et ".$echo_minute;
        } else {
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure.$echo_minute;
        }
      } else {
        if(!empty($echo_annee) OR !empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
          if(!empty($echo_annee)) {
            if(!empty($echo_mois) OR !empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_annee = ", ";
            }
          }
          if(!empty($echo_mois)) {
            if(!empty($echo_jour) OR !empty($echo_heure)) {
              $virgule_mois = ", ";
            }
          }
          if(!empty($echo_jour)) {
            if(!empty($echo_heure)) {
              $virgule_jour = ", ";
            }
          }
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure." et ".$echo_minute;
        } else {
          $return = $echo_annee.$virgule_annee.$echo_mois.$virgule_mois.$echo_jour.$virgule_jour.$echo_heure.$echo_minute;
        }
      }
    }
    return $return;
  }
  function getOS() { 

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}
function push_debug($destinataire,$subject,$message)
{
    $sujet = $subject;
    $headers = "From: \"TimeFlix\"<webmaster@timeflix.net>\n";
    $headers .= "Reply-To:webmaster@timeflix.net\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"";
    if(mail($destinataire,$sujet,$message,$headers))
    {
             return true;
    }
    else
    {
            return false;
    }
}
function push_email($destinataire,$subject,$message,$affiche,$link)
{
$codehtml = "
<html>
  <head>
    <title></title>
    <style type=\"text/css\">
@import url(https://fonts.googleapis.com/css?family=Merriweather:400,400italic,700,700italic|Montserrat);
body {
  margin: 0;
  padding: 0;
  min-width: 100%;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
td {
  padding: 0;
  vertical-align: top;
}
.spacer,
.border {
  font-size: 1px;
  line-height: 1px;
}
img {
  border: 0;
  -ms-interpolation-mode: bicubic;
}
.image {
  font-size: 0;
  Margin-bottom: 25px;
}
.image img {
  display: block;
}
.logo img {
  display: block;
}
strong {
  font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
  Margin-top: 0;
}
ol,
ul,
li {
  padding-left: 0;
}
.btn a {
  mso-hide: all;
}
blockquote {
  Margin-top: 0;
  Margin-right: 0;
  Margin-bottom: 0;
  padding-right: 0;
}
.column-top {
  font-size: 42px;
  line-height: 42px;
}
.column-bottom {
  font-size: 17px;
  line-height: 17px;
}
.column {
  text-align: left;
}
.contents {
  width: 100%;
}
.padded {
  padding-left: 40px;
  padding-right: 40px;
}
.wrapper {
  background-color: #eceef1;
  width: 100%;
  min-width: 620px;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
}
table.wrapper {
  table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
  Margin-left: auto;
  Margin-right: auto;
  width: 600px;
}
.one-col p,
.one-col ol,
.one-col ul {
  Margin-bottom: 25px;
}
.two-col p,
.two-col ol,
.two-col ul {
  Margin-bottom: 23px;
}
.two-col .image {
  Margin-bottom: 23px;
}
.two-col .column-bottom {
  font-size: 19px;
  line-height: 19px;
}
.two-col .column {
  width: 300px;
}
.two-col .first .padded {
  padding-left: 40px;
  padding-right: 40px;
}
.two-col .second .padded {
  padding-left: 40px;
  padding-right: 40px;
}
.three-col p,
.three-col ol,
.three-col ul {
  Margin-bottom: 21px;
}
.three-col .image {
  Margin-bottom: 21px;
}
.three-col .column-bottom {
  font-size: 21px;
  line-height: 21px;
}
.three-col .column {
  width: 200px;
}
.three-col .first .padded {
  padding-left: 40px;
  padding-right: 20px;
}
.three-col .second .padded {
  padding-left: 30px;
  padding-right: 30px;
}
.three-col .third .padded {
  padding-left: 20px;
  padding-right: 40px;
}
@media only screen and (max-width: 620px) {
  [class*=wrapper] {
    min-width: 320px !important;
    width: 100%!important;
  }
  [class*=wrapper] .one-col,
  [class*=wrapper] .two-col,
  [class*=wrapper] .three-col {
    width: 320px !important;
  }
  [class*=wrapper] .column {
    display: block;
    float: left;
    width: 320px !important;
  }
  [class*=wrapper] .padded {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }
  [class*=wrapper] .full {
    display: none;
  }
  [class*=wrapper] .block {
    display: block !important;
  }
  [class*=wrapper] .hide {
    display: none !important;
  }
  [class*=wrapper] .image {
    margin-bottom: 25px !important;
  }
  [class*=wrapper] .image img {
    height: auto !important;
    width: 100% !important;
  }
}
.wrapper h1 {
  font-weight: 500;
}
.wrapper h2 {
  font-weight: 500;
}
.wrapper h3 {
  font-weight: 700;
  letter-spacing: 0.03em;
  -webkit-font-smoothing: antialiased;
}
.wrapper p,
.wrapper ol,
.wrapper ul {
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
}
.wrapper blockquote {
  font-style: italic;
}
.three-col h3 {
  letter-spacing: 0;
}
.feature .one-col h3 {
  font-weight: 500;
  text-transform: none;
}
.preheader {
  font-size: 10px;
  font-style: italic;
  line-height: 14px;
}
.preheader .title {
  background-color: #e7e9ec;
  color: #8e8e8e;
  padding: 9px;
  text-align: left;
  width: 50%;
}
.preheader .webversion {
  background-color: #e4e6e9;
  color: #8e8e8e;
  padding: 9px;
  text-align: right;
  width: 50%;
}
.divider {
  width: 100%;
}
.hr {
  font-size: 3px;
  line-height: 3px;
}
.hr hr {
  border: 0;
  height: 3px;
  width: 60px;
  color: #eceef1;
  background-color: #eceef1;
  display: block;
}
.one-col .hr {
  padding-bottom: 25px;
}
.two-col .hr {
  padding-bottom: 23px;
}
.three-col .hr {
  padding-bottom: 21px;
}
.feature .hr {
  padding-bottom: 36px;
}
.feature .hr hr {
  background-color: #e1e3e6;
  color: #e1e3e6;
}
.wrapper {
  background-color: #eceef1;
}
.wrapper h1,
.wrapper p,
.wrapper ol,
.wrapper ul,
.wrapper .preheader,
.wrapper .btn a,
.wrapper .logo,
.wrapper .footer div,
.wrapper .footer .social .facebook,
.wrapper .footer .social .twitter,
.wrapper .footer .social .forward {
  font-family: Georgia, serif;
}
@media screen and (min-width: 0) {
  .wrapper h1,
  .wrapper p,
  .wrapper ol,
  .wrapper ul,
  .wrapper .preheader,
  .wrapper .btn a,
  .wrapper .logo,
  .wrapper .footer div,
  .wrapper .footer .social .facebook,
  .wrapper .footer .social .twitter,
  .wrapper .footer .social .forward {
    font-family: Merriweather, Georgia, serif !important;
  }
}
.wrapper h2,
.wrapper h3 {
  font-family: sans-serif;
}
@media screen and (min-width: 0) {
  .wrapper h2,
  .wrapper h3 {
    font-family: Montserrat, Avenir, sans-serif !important;
  }
}
.wrapper a {
  border-bottom: 1px solid transparent;
  text-decoration: none;
}
.wrapper a:hover {
  border-bottom-color: transparent !important;
}
.wrapper h1 {
  color: #202020;
}
.wrapper h2 {
  color: #333333;
}
.wrapper h3 {
  color: #555555;
}
.wrapper p,
.wrapper ol,
.wrapper ul {
  color: #8e8e8e;
  text-rendering: optimizeLegibility;
}
.wrapper blockquote {
  border-left: 5px solid transparent;
  Margin: 0;
  padding-right: 0;
}
.btn {
  Margin-bottom: 25px;
  text-align: left;
}
.btn a {
  border-radius: 8px;
  display: inline-block;
  font-size: 14px;
  font-weight: 700;
  line-height: 18px;
  padding: 13px 18px;
  text-align: center;
  text-decoration: none;
  -webkit-font-smoothing: antialiased;
}
.one-col,
.two-col,
.three-col {
  background-color: #ffffff;
}
.one-col h1 a,
.two-col h1 a,
.three-col h1 a,
.one-col h2 a,
.two-col h2 a,
.three-col h2 a,
.one-col h3 a,
.two-col h3 a,
.three-col h3 a {
  border: none;
  text-decoration: none;
}
.one-col h1 a,
.two-col h1 a,
.three-col h1 a {
  color: #202020;
}
.one-col h2 a,
.two-col h2 a,
.three-col h2 a {
  color: #333333;
}
.one-col h3 a,
.two-col h3 a,
.three-col h3 a {
  color: #555555;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 25px;
}
.one-col h1 {
  font-size: 36px;
  line-height: 44px;
  Margin-bottom: 18px;
}
.one-col h2 {
  font-size: 24px;
  line-height: 32px;
  Margin-bottom: 12px;
}
.one-col h3 {
  font-size: 14px;
  line-height: 22px;
  Margin-bottom: 10px;
}
.one-col p,
.one-col ol,
.one-col ul {
  font-size: 16px;
  line-height: 25px;
}
.one-col ol,
.one-col ul {
  Margin-left: 17px;
}
.one-col li {
  padding-left: 4px;
}
.one-col a {
  border-bottom-color: #fc9c2a;
  color: #fc9c2a;
}
.one-col .btn a {
  border: 1px solid #fc9c2a;
}
.one-col .btn a:hover {
  border: 1px solid #fc9c2a !important;
}
.wrapper .one-col blockquote {
  border-left-color: #fc9c2a;
  padding-left: 16px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 23px;
}
.two-col a {
  border-bottom-color: #7bc142;
  color: #7bc142;
}
.two-col h1 {
  font-size: 26px;
  line-height: 34px;
  Margin-bottom: 14px;
}
.two-col h2 {
  font-size: 18px;
  line-height: 26px;
  Margin-bottom: 10px;
}
.two-col h3 {
  font-size: 12px;
  line-height: 20px;
  Margin-bottom: 8px;
}
.two-col p,
.two-col ol,
.two-col ul {
  font-size: 14px;
  line-height: 23px;
}
.two-col ol,
.two-col ul {
  Margin-left: 15px;
}
.two-col li {
  padding-left: 3px;
}
.two-col .btn {
  Margin-bottom: 23px;
}
.two-col .btn a {
  border: 1px solid #7bc142;
  color: #7bc142;
  font-size: 12px;
  line-height: 14px;
  padding: 13px 10px;
}
.two-col .btn a:hover {
  border: 1px solid #7bc142 !important;
}
.wrapper .two-col blockquote {
  border-left-color: #7bc142;
  border-left-width: 4px;
  padding-left: 13px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 21px;
}
.three-col a {
  border-bottom-color: #0e7ac4;
  color: #0e7ac4;
}
.three-col h1 {
  font-size: 18px;
  line-height: 26px;
  Margin-bottom: 12px;
}
.three-col h2 {
  font-size: 16px;
  line-height: 24px;
  Margin-bottom: 8px;
}
.three-col h3 {
  font-size: 12px;
  line-height: 20px;
  Margin-bottom: 6px;
}
.three-col p,
.three-col ol,
.three-col ul {
  font-size: 12px;
  line-height: 21px;
}
.three-col ol,
.three-col ul {
  Margin-left: 15px;
}
.three-col li {
  padding-left: 4px;
}
.three-col .btn {
  Margin-bottom: 21px;
}
.three-col .btn a {
  border: 1px solid #0e7ac4;
  color: #0e7ac4;
  font-size: 10px;
  line-height: 13px;
  padding: 9px 11px 7px;
}
.three-col .btn a:hover {
  border: 1px solid #0e7ac4 !important;
}
.wrapper .three-col blockquote {
  border-left-color: #0e7ac4;
  border-left-width: 3px;
  padding-left: 13px;
}
.wrapper .feature a {
  border-bottom-color: #222222;
  color: #222222;
}
.wrapper .feature a:hover {
  color: #404040;
}
.feature .padded {
  padding-left: 20px;
  padding-right: 20px;
}
.feature .one-col {
  background-color: #eceef1;
}
.feature .one-col .image {
  Margin-bottom: 36px;
}
.feature .one-col h1,
.feature .one-col h2,
.feature .one-col h3,
.feature .one-col p {
  text-align: center;
}
.feature .one-col h1 {
  font-size: 42px;
  line-height: 50px;
  Margin-bottom: 26px;
}
.feature .one-col h2 {
  font-size: 32px;
  color: #222222;
  line-height: 40px;
  Margin-bottom: 20px;
}
.feature .one-col h3 {
  color: #222222;
  font-size: 26px;
  line-height: 34px;
  Margin-bottom: 18px;
}
.feature .one-col p,
.feature .one-col ol,
.feature .one-col ul {
  font-size: 21px;
  color: #222222;
  line-height: 32px;
  Margin-bottom: 32px;
}
.feature .one-col ol {
  Margin-left: 31px;
}
.feature .one-col ol li {
  padding-left: 0;
}
.feature .one-col ul {
  Margin-left: 23px;
}
.feature .one-col ul li {
  padding-left: 9px;
}
.wrapper .feature .one-col blockquote {
  border-left: none;
  Margin-left: 0;
  padding-left: 0;
}
.feature .one-col blockquote p,
.feature .one-col blockquote ol,
.feature .one-col blockquote ul {
  font-style: italic;
  color: #8e959c;
}
.feature .one-col .btn {
  Margin-bottom: 36px;
  text-align: center;
}
.feature .one-col .btn a {
  border: 2px solid #202020;
  color: #202020;
  font-weight: 500;
  font-size: 16px;
  line-height: 26px;
  padding: 12px 28px;
}
.feature .one-col .btn a:hover {
  border: 2px solid #202020 !important;
}
.feature .one-col .contents:nth-last-child(2) h1:last-child,
.feature .one-col .contents:nth-last-child(2) h2:last-child,
.feature .one-col .contents:nth-last-child(2) h3:last-child,
.feature .one-col .contents:nth-last-child(2) p:last-child,
.feature .one-col .contents:nth-last-child(2) ul:last-child,
.feature .one-col .contents:nth-last-child(2) ol:last-child,
.feature .one-col .contents:nth-last-child(2) blockquote:last-child *:last-child {
  Margin-bottom: 36px !important;
}
.feature .one-col .column-bottom {
  font-size: 6px !important;
  line-height: 6px !important;
}
.feature .border {
  background-color: #e1e3e6;
  height: 3px;
}
.feature .column-top {
  font-size: 42px;
  line-height: 42px;
}
.feature .column-bottom {
  font-size: 6px;
  line-height: 6px;
}
.orange,
.green,
.blue,
.header,
.preheader,
.footer {
  width: 100%;
}
.orange .one-col a,
.orange .one-col .btn a,
.green .two-col a,
.green .two-col .btn a,
.blue .three-col a,
.blue .three-col .btn a {
  border-bottom-color: #ffffff;
  color: #ffffff;
}
.orange .btn a:hover,
.green .btn a:hover,
.blue .btn a:hover {
  border: 1px solid #ffffff !important;
}
.orange .one-col h1,
.orange .one-col h2,
.orange .one-col h3,
.orange .one-col p,
.orange .one-col ol,
.orange .one-col ul,
.green .two-col h1,
.green .two-col h2,
.green .two-col h3,
.green .two-col p,
.green .two-col ol,
.green .two-col ul,
.blue .three-col h1,
.blue .three-col h2,
.blue .three-col h3,
.blue .three-col p,
.blue .three-col ol,
.blue .three-col ul {
  color: #ffffff;
  border: none;
}
.orange .one-col .btn a,
.green .two-col .btn a,
.blue .three-col .btn a {
  border: 1px solid #ffffff;
}
.orange {
  background-color: #fc9c2a;
}
.orange .one-col {
  background-color: #fc9c2a;
}
.orange .column {
  background-color: #e28c26;
}
.wrapper .orange .one-col blockquote {
  border-left-color: #cd7e20;
}
.green {
  background-color: #7bc142;
}
.green .two-col {
  background-color: #7bc142;
}
.green .column {
  color: #ffffff;
}
.green .first {
  background-color: #78bd40;
}
.green .second {
  background-color: #75b83e;
}
.wrapper .green .two-col blockquote {
  border-left-color: #639c33;
}
.blue {
  background-color: #0e7ac4;
}
.blue .three-col {
  background-color: #0e7ac4;
}
.blue .column {
  color: #ffffff;
}
.blue .first {
  background-color: #0d77bf;
}
.blue .second {
  background-color: #0d74bb;
}
.blue .third {
  background-color: #0c71b6;
}
.wrapper .blue .three-col blockquote {
  border-left-color: #085f9b;
}
.one-col h1 a,
.two-col h1 a,
.three-col h1 a,
.one-col .orange h1 a,
.two-col .green h1 a,
.three-col .blue h1 a,
.feature .one-col h1 a {
  border: none;
}
.logo {
  color: #202020;
  font-size: 36px;
  font-weight: 400;
  line-height: 52px;
  max-width: 520px;
  padding-top: 40px;
  padding-bottom: 40px;
  text-align: center;
}
.logo a {
  color: #202020;
}
.logo a:hover {
  color: #404040;
}
.footer {
  width: 100%;
  background-color: #e8eaec;
}
.footer .padded {
  padding-left: 20px;
  padding-right: 20px;
}
.footer .one-col {
  background-color: #e8eaec;
}
.footer .one-col a {
  border: none;
}
.footer td {
  font-family: Merriweather, Georgia, serif;
  color: #8e8e8e;
  font-size: 10px;
  line-height: 18px;
  font-style: italic;
}
.footer .contents {
  background-color: #e8eaec;
}
.footer .footer-container {
  width: 100%;
}
.footer .footer-container .column-details {
  padding: 40px 0 75px 0;
}
.footer .footer-container .column-details td {
  text-align: left;
}
.footer .footer-container .column-social {
  width: 140px;
  padding: 42px 0 75px 20px;
}
.footer .footer-container .column-social td {
  text-align: left;
}
.footer .social {
  width: 130px;
}
.footer .social a {
  text-decoration: none;
  font-weight: bold;
}
.footer .social .social-icon {
  width: 38px;
  height: 30px;
}
.footer .social .social-icon img {
  display: block;
}
.footer .social .facebook,
.footer .social .twitter,
.footer .social .forward {
  font-family: Merriweather, Georgia, serif;
  width: 100px;
  letter-spacing: 0.05em;
  font-size: 10px;
  line-height: 12px;
  vertical-align: middle;
  font-weight: bold;
  text-transform: uppercase;
}
.footer .social .facebook,
.footer .social .facebook a {
  color: #3b5998;
}
.footer .social .twitter,
.footer .social .twitter a {
  color: #00b6f1;
}
.footer .social .forward,
.footer .social .forward a {
  color: #75b73f;
}
.footer .social-space {
  font-size: 10px;
  line-height: 10px;
  display: block;
  width: 100%;
}
.footer .prefs a {
  color: #8e8e8e;
}
.footer .address,
.footer .permission {
  display: block;
}
.footer .address a,
.footer .permission a {
  color: #8e8e8e;
  text-decoration: underline;
}
.footer .address {
  Margin-bottom: 17px;
}
@media (min-width: 0) {
  body {
    background-color: #e8eaec;
  }
}
@media only screen and (max-width: 620px) {
  [class*=wrapper] blockquote {
    border-left-width: 5px !important;
    padding-left: 15px !important;
  }
  [class*=wrapper] .preheader .title {
    display: none;
  }
  [class*=wrapper] .preheader .webversion {
    text-align: center !important;
  }
  [class*=wrapper] .logo {
    width: 280px!important;
  }
  [class*=wrapper] .logo img {
    max-width: 194px!important;
    height: auto !important;
    margin: 0 auto !important;
  }
  [class*=wrapper] h1 {
    font-size: 36px !important;
    line-height: 44px !important;
    margin-bottom: 18px !important;
  }
  [class*=wrapper] h2 {
    font-size: 24px !important;
    line-height: 32px !important;
    margin-bottom: 12px !important;
  }
  [class*=wrapper] h3 {
    font-size: 14px !important;
    line-height: 22px !important;
    margin-bottom: 10px !important;
  }
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class*=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class*=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class*=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child {
    Margin-bottom: 25px !important;
  }
  [class*=wrapper] .one-col p,
  [class*=wrapper] .two-col p,
  [class*=wrapper] .three-col p,
  [class*=wrapper] .one-col ol,
  [class*=wrapper] .two-col ol,
  [class*=wrapper] .three-col ol,
  [class*=wrapper] .one-col ul,
  [class*=wrapper] .two-col ul,
  [class*=wrapper] .three-col ul {
    font-size: 16px !important;
    line-height: 25px !important;
    margin-bottom: 25px !important;
  }
  [class*=wrapper] ol,
  [class*=wrapper] ul {
    margin-left: 17px;
  }
  [class*=wrapper] li {
    padding-left: 4px;
  }
  [class*=wrapper] .btn {
    margin-bottom: 25px !important;
  }
  [class*=wrapper] .btn a {
    display: block !important;
    font-size: 14px !important;
    line-height: 18px !important;
    width: auto !important;
  }
  [class*=wrapper] .divider .hr {
    padding-bottom: 25px !important;
  }
  [class*=wrapper] .two-col .btn a,
  [class*=wrapper] .three-col .btn a {
    padding: 13px 10px !important;
  }
  [class*=wrapper] .column-bottom {
    font-size: 17px !important;
    line-height: 17px !important;
  }
  [class*=wrapper] .first .column-bottom,
  [class*=wrapper] .three-col .second .column-bottom {
    display: none;
  }
  [class*=wrapper] .second .column-top,
  [class*=wrapper] .third .column-top {
    display: none;
  }
  [class*=wrapper] .green .column-top,
  [class*=wrapper] .blue .column-top,
  [class*=wrapper] .green .column-bottom,
  [class*=wrapper] .blue .column-bottom {
    display: block !important;
  }
  [class*=wrapper] .feature h1 {
    font-size: 36px !important;
    line-height: 44px !important;
    margin-bottom: 22px !important;
  }
  [class*=wrapper] .feature h2 {
    font-size: 26px!important;
    line-height: 32px!important;
    margin-bottom: 18px!important;
  }
  [class*=wrapper] .feature h3 {
    font-size: 24px!important;
    line-height: 32px!important;
    margin-bottom: 16px!important;
  }
  [class*=wrapper] .feature p,
  [class*=wrapper] .feature ol,
  [class*=wrapper] .feature ul {
    font-size: 18px !important;
    line-height: 26px !important;
    margin-bottom: 26px !important;
  }
  [class*=wrapper] .feature ol {
    margin-left: 28px !important;
  }
  [class*=wrapper] .feature ol li {
    padding-left: 0 !important;
  }
  [class*=wrapper] .feature ul {
    margin-left: 20px !important;
  }
  [class*=wrapper] .feature ul li {
    padding-left: 8px !important;
  }
  [class*=wrapper] .feature .btn a {
    margin-left: 0;
    margin-right: 0;
  }
  [class*=wrapper] .feature blockquote {
    border-left: none !important;
    padding-left: 0 !important;
  }
  [class*=wrapper] .footer .footer-container {
    width: 280px !important;
    margin: 0 auto !important;
  }
  [class*=wrapper] .footer .column-social {
    padding-left: 0!important;
    padding-right: 0!important;
    width: 100% !important;
  }
  [class*=wrapper] .footer .column-details {
    width: 100% !important;
  }
  [class*=wrapper] .footer .column-details table {
    width: 100% !important;
  }
  [class*=wrapper] .footer .social {
    width: 280px!important;
  }
  [class*=wrapper] .footer .social .social-text {
    padding: 0!important;
    text-align: left !important;
  }
  [class*=wrapper] .footer .social .facebook,
  [class*=wrapper] .footer .social .twitter,
  [class*=wrapper] .footer .social .forward {
    width: auto !important;
  }
  [class*=wrapper] .footer .social-space {
    display: none !important;
  }
  [class*=wrapper] .footer .button {
    width: auto !important;
    margin: 0 auto 10px !important;
  }
  [class*=wrapper] .footer *[class*=column] {
    display: block !important;
    text-align: center!important;
    padding-top: 15px!important;
    padding-bottom: 10px!important;
  }
  [class*=wrapper] .footer *[class*=column] td {
    text-align: center!important;
  }
  [class*=wrapper] .footer *[class*=column] .padded {
    padding: 0!important;
  }
  [class*=wrapper] .footer *[class*=column] .social {
    width: 100%!important;
    margin-top: 15px!important;
  }
}
</style>
    <!--[if (gte mso 9)|(IE)]>
    <style>
      li {
        padding-left: 5px !important;
        margin-left: 10px !important;
      }
      ul li {
        list-style-image: none !important;
        list-style-type: disc !important;
      }
      ol, ul {
        margin-left: 20px !important;
      }
      .feature ol, .feature ul {
        margin-left: 28px !important;
      }
      .feature li {
        padding-left: 1px !important;
      }
    </style>
    <![endif]-->
    <!--[if mso]>
    <style>
      .spacer, .border, .column-top, .column-bottom {
        mso-line-height-rule: exactly;
      }
      .feature .one-col h2, .feature .one-col h3 {
        font-weight: bold  !important;
      }
    </style>
    <![endif]-->
  </head>
  <body bgcolor=\"#ffffff\" class=\" emb-font-stack-\">
    <center class=\"wrapper\">
      <table class=\"wrapper\">
        <tr>
          <td>
                        
          </td>
        </tr>
      </table>
      
          <table class=\"wrapper\">
            <tr>
              <td>
                <center>
                  <table class=\"one-col\">
                    <tr>
                      <td class=\"column\">
                   <center><img style=\"width:600px;\"src=\"$affiche\"></center>
                        <div><div class=\"column-top\">&nbsp;</div></div>
                          <table class=\"contents\">
                            <tr>
                              <td class=\"padded\">
                              <p>$message</p>
                              <div style=\"float:right;margin-right:10px;\" class=\"btn\"><a href=\"$link\" cs-button>Accèder</a></div>
                              </td>
                            </tr>
                          </table>
                        
                        <div class=\"column-bottom\">&nbsp;</div>
                      </td>
                    </tr>
                  </table>
                </center>
              </td>
            </tr>
          </table>
      <div class=\"spacer\" style=\"line-height:42px;\">&nbsp;</div>
      <table class=\"wrapper\">
        <tr>
          <td>
            <center>
              <table class=\"footer\">
                <tr>
                  <td>
                    <center>
                      <table class=\"one-col\">
                        <tr>
                          <td class=\"column\">
                            <table class=\"contents\">
                              <tr>
                                <td class=\"padded\">
                                
                                                                      </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </center>
                  </td>
                </tr>
              </table>
            </center>
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>";
    $sujet = $subject;
    $headers = "From: \"TimeFlix\"<webmaster@timeflix.net>\n";
    $headers .= "Reply-To:webmaster@timeflix.net\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"";
    if(mail($destinataire,$sujet,$codehtml,$headers))
    {
             return true;
    }
    else
    {
            return false;
    }
}
     function calcfilesize($bytes)
        {
        if ($bytes < 1000 * 1024)
            return number_format($bytes / 1024, 2) . " kB";
        elseif ($bytes < 1000 * 1048576)
            return number_format($bytes / 1048576, 2) . " MB";
        elseif ($bytes < 1000 * 1073741824)
            return number_format($bytes / 1073741824, 2) . " GB";
        else
            return number_format($bytes / 1099511627776, 2) . " TB";
        }
    
    
     function checktorrent($alltorrent)
    {
      $debutTorrent = "";
      for ($i=0;$i<11;$i++)
      {
        $debutTorrent .= $alltorrent[$i];
      }
      if($debutTorrent == "d8:announce")
      {
        //echo $debutTorrent;
        echo " Le fichier est bien un torrent <br />";
      }
      else
      {
        //echo $debutTorrent;
        exit (" Erreur le fichier n'est pas un torrent");
      }
    }   
     function calchash($alltorrent)
    {
      $array = BDecode($alltorrent);
      if (!$array)
      {
        echo "<p class=\"error\">There was an error handling your uploaded torrent. The parser didn't like it.</p>";
        endOutput();
        exit;
      }
      $hash = @sha1(BEncode($array["info"]));
      
      return $hash;
    }
     function parcourirtorrent($filesTorrentSize,$alltorrent)
    {
      $compt=0;
      $tailleFichier = '';
      $urlfound = false;
      $namefound = false;
      $datefound = false;
      for ($i=0;$i<$filesTorrentSize;$i++)
      {
        //************//nom du torrent
        if ($alltorrent[$i] == "n" and $namefound !=true)
        {
          $a = $i;
          $name = $alltorrent[$a].$alltorrent[$a+1].$alltorrent[$a+2].$alltorrent[$a+3];
          if ($name == "name")
          {
            $index = $alltorrent[$a+4].$alltorrent[$a+5];
              $index = $a+7+$index;
              $nameTorrent = "";
              for ($j=$a+7;$j<$index;$j++)
              {
                $nameTorrent .= $alltorrent[$j];
                
              }
              //echo " <b>Nom du torrent :</b> $nameTorrent <br />";
              $namefound = true;
          }
          
        }
        //************//trouver l'url  du tracker
        if ($alltorrent[$i] == "e" and $urlfound != true)
        {
          $b = $i;
          $index = $alltorrent[$b+1] . $alltorrent[$b+2];
          $index = $b+4+$index;
          $urlTracker = "";
          for ($j=$b+4;$j<$index;$j++)
          {
            $urlTracker .= $alltorrent[$j];
            
          }
          //echo " <b>URL du tracker :</b> $urlTracker <br />";
          $urlfound = true;
          
        }
        //************//trouver la date création du torrent 
        if ($alltorrent[$i] == "d" and $datefound != true)
        {
          $d = $i;
          $datei = $alltorrent[$d] . $alltorrent[$d+1] . $alltorrent[$d+2] . $alltorrent[$d+3].  $alltorrent[$d+4];
          if ($datei == "datei")
          {
            $indexdepart = $d+4;
            $timestamp = "";
            for ($j=$indexdepart+1;$j<$indexdepart+11;$j++)
            {
              $timestamp .= $alltorrent[$j];  
            }
            $date = date('d/m/Y à H:i',$timestamp);
            //echo "<b>Date de création du .torrent:</b> $date<br/>";
            $datefound = true;
          }
          
        }
        //************//trouver la taille total du fichier
        if ($alltorrent[$i] == 'l')
        {
          $c = $i;
          $checklength = $alltorrent[$c].$alltorrent[$c+1].$alltorrent[$c+2].$alltorrent[$c+3].$alltorrent[$c+4].$alltorrent[$c+5];
          //echo "<b>doit contenir lenght:</b> $checklength";
          if ($checklength == "length")
          {
            
            for ($d=$c+7;$d<$filesTorrentSize;$d++)
            { 
            
            
              //echo " <b>variable parcoure : </b>$alltorrent[$d]";
              if ($alltorrent[$d] == 'e')
              {
                $compt++;
                $tabTailleFichier[$compt]=$tailleFichier;
                $tailleFichier = '';
                break;
              }
              else
              {
                $tailleFichier .= $alltorrent[$d];
                //echo " <b>!!!!taille fichier!!!!!:</b> $tailleFichier";
                
              }
            }         
          }
        }
      }
      $globalPoid=0;
      for ($b=1;$b<=$compt;$b++)
      {
        //echo " >>Fichiers $b et sa tailles : $tabTailleFichier[$b]";
        $globalPoid =  $globalPoid+$tabTailleFichier[$b];
      }
      $calcfilesize = calcfilesize($globalPoid);
      //echo " <b>Poids total du dossier :</b> $calcfilesize <br />";
      //echo " <b>Nombre de fichiers :</b> $compt <br />";
      $data = explode(':',$alltorrent);
      $data['name'] = $nameTorrent;
      return $data;
    }
?>