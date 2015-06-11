<?php

/*
Core - Get_movie_db - Api MovieDB
*/

function search_movie_db($search)
{ 
    global $moviedb_api;
    $titre= str_replace(" ", "%20",$search);
    $json = file_get_contents('http://api.themoviedb.org/3/search/multi?api_key='.$moviedb_api.'&query='.$titre); 
    $data = json_decode($json);
    return $data;
}
function search_movie_detail_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_serie_detail_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_serie_saison($id,$saison)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'/season/'.$saison.'?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_desc_actors($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_images_actors($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'/tagged_images?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_images_series($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'/images?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
function get_movies_actors($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'/movie_credits?api_key='.$moviedb_api.'&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_movie_actors_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/credits?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
function search_serie_actors_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'/credits?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
function search_movie_video_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/videos?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
function get_saison($serieid,$saisonid)
{
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$serieid.'/season/'.$saisonid.'?api_key='.$moviedb_api.'&language=en'); 
    $data = json_decode($json);
    return $data;
}
function get_episode($serieid,$saisonid,$episode)
{
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$serieid.'/season/'.$saisonid.'/episode/'.$episode.'?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
function search_movie_torrent($title,$language=NULL)
{
    $search = $title.' '.$language;
    $title = str_replace(": ", "%20",$search);
    $title= str_replace(" ", "%20",$title);
    $title= str_replace("-", "",$title);
    $json = file_get_contents('https://getstrike.net/api/v2/torrents/search/?phrase='.$title.''); 
    $data = json_decode($json);
    return $data;
}
function search_serie_torrent($title)
{
    $search = $title;
    $title = str_replace(": ", "%20",$search);
    $title= str_replace(" ", "%20",$title);
    $title= str_replace("-", "",$title);
    $json = file_get_contents('https://getstrike.net/api/v2/torrents/search/?phrase='.$title.''); 
    $data = json_decode($json);
    return $data;
}
function search_movie_images_db($id)
{ 
    global $moviedb_api;
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/images?api_key='.$moviedb_api.''); 
    $data = json_decode($json);
    return $data;
}
?>