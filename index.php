<!--

████████╗██╗███╗   ███╗███████╗███████╗██╗     ██╗██╗  ██╗
╚══██╔══╝██║████╗ ████║██╔════╝██╔════╝██║     ██║╚██╗██╔╝
   ██║   ██║██╔████╔██║█████╗  █████╗  ██║     ██║ ╚███╔╝ 
   ██║   ██║██║╚██╔╝██║██╔══╝  ██╔══╝  ██║     ██║ ██╔██╗ 
   ██║   ██║██║ ╚═╝ ██║███████╗██║     ███████╗██║██╔╝ ██╗
   ╚═╝   ╚═╝╚═╝     ╚═╝╚══════╝╚═╝     ╚══════╝╚═╝╚═╝  ╚═╝
                                                          v1-beta
                                                          
-->
<?php

//error_reporting(0);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include_once('config/config.php');
define('CRYPT_KEY', '*mr6dRQ9T/@5Gn9c!5S-');
include_once('core/core.crypt.php');
include_once('core/core_get_data.php');
include_once('core/core_get_moviedb.php');
include_once ("core/core.torrent.decode.php");
include_once ("core/core.torrent.encode.php");
//GEOIP LIB 
include("library/geoip/geoipcity.inc");
include("library/geoip/geoipregionvars.php");

//Récupéation de la config
$right = get_data('config',"WHERE id_config=1");
$right = array_shift($right);
$moviedb_api = $right['moviedb_api'];

$gi = geoip_open(realpath("library/geoip/GeoLiteCity.dat"),GEOIP_STANDARD);


if (php_sapi_name() == 'cli')
{	
    include_once('controllers/controller_cron.php');
    exit;
}
if (isset($_GET['view']) AND $_GET['view'] == 'invitation')
{
	include_once('controllers/controller_invitation.php');
  exit;
}
if (isset($_GET['view']) AND $_GET['view'] == 'mobile')
{
  include_once('views/view_mobile.php');
  exit;
}
session_start();
if(!empty($_SESSION['id_users']))
{
  if (!isset($_GET['view']) OR $_GET['view'] == 'index')
  {
  	 include_once('views/view_header.php');
      include_once('controllers/controller_home.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'movie_detail')
  {
  	 include_once('views/view_header.php');
      include_once('controllers/controller_movie_detail.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'serie')
  {
     include_once('views/view_header.php');
      include_once('controllers/controller_serie.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'actors_detail')
  {
     include_once('views/view_header.php');
      include_once('controllers/controller_actors_detail.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'serie_detail')
  {
     include_once('views/view_header.php');
      include_once('controllers/controller_serie_detail.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'episode')
  {
     include_once('views/view_header.php');
      include_once('controllers/controller_episode.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'help')
  {
     include_once('views/view_help.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'search')
  {
	  if(!empty($_GET['cli']))
	  {
		include_once('controllers/controller_search.php');  
	  }
	  else
	  {
	  include_once('views/view_header.php');
      include_once('controllers/controller_search.php');
      include_once('views/view_footer.php');
      }
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'add_movie')
  {
      include_once('controllers/add_movie.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'add_serie')
  {
      include_once('controllers/add_serie.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'basic')
  {
      include_once('controllers/controller_movies_basic.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'views_movies')
  {
      include_once('controllers/controller_views_movies.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'episode_detail')
  {
      include_once('controllers/controller_episode_detail.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'goflix')
  {
      include_once('views/view_header.php');
      include_once('controllers/controller_goflix.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'admin' AND $_SESSION['is_admin'] == 1)
  {
      include_once('views/view_header.php');
      include_once('controllers/controller_admin.php');
      include_once('views/view_footer.php');
  }
  elseif (isset($_GET['view']) AND $_GET['view'] == 'download' AND isset($_GET['file']))
  {
    download($_GET['file']);
  }
  // elseif (isset($_GET['view']) AND $_GET['view'] == 'mail')
  // {
  //   $link = 'test';
  //   $corps = '<h1>TimeFlix</h1>
  //      <div style=\"float:right;margin-right:10px;\" class=\"btn\"><a href=\"" cs-button>Télécharger</a></div>';
  //   $affiche="http://w3af.org/wp-content/uploads/beta-testin.png";
  //     echo push_email('jack.gianesini@gmail.com','hah',$corps,$affiche,$link);
  // }
  else
  {
      include_once('views/view_header.php');
    echo '<center><p style="padding-top:10%;font-size:30px;text-transform: uppercase;font-weight: 300;text-shadow: 0 2px 0 #000;color:white;margin-top:1%;">Page introuvable ... </p><br>
<img style="border-radius: 10px;box-shadow: 1px 1px 8px #000;" src="theme/gif/ohshit.gif"><center>';  
      include_once('views/view_footer.php');
  }
}
else
{
  include_once('controllers/controller_login.php');
}
?>
