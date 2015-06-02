<?php
/**
 * @author Cr@zy
 * @version 1.0
 * @copyright 2009 @ crazyws.fr
 */
// Durée de vie du cookie (secondes)
$cookietime = 3600;
// Récupération de la résolution de l'utilisateur
$width = ( isset($_GET['width']) && is_numeric($_GET['width']) ) ? intval($_GET['width']) : '';
$height = ( isset($_GET['height']) && is_numeric($_GET['height']) ) ? intval($_GET['height']) : '';
if( !empty($width) && !empty($height) ){
	$_COOKIE['res_width'] = $width;
	$_COOKIE['res_height'] = $height;
	setcookie("res_width", $_COOKIE['res_width'], time() + $cookietime, '/');
	setcookie("res_height", $_COOKIE['res_height'], time() + $cookietime, '/');
}
 
?>