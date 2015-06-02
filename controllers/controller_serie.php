<?php 
$serie = get_data('series',"");
$favoris = get_data('favoris','WHERE id_users='.$_SESSION['id_users'].'');
$list_id = array();
foreach ($favoris as $k)
{
	$list_id[$k['id_series']] = $k['id_series'];
}
include_once('views/view_serie.php');