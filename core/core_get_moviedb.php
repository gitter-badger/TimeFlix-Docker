<?php

/*
Core - Get_movie_db - Api MovieDB
*/

function search_movie_db($search)
{ 
    $titre= str_replace(" ", "%20",$search);
    $json = file_get_contents('http://api.themoviedb.org/3/search/multi?api_key=c61458343dec48dd506164bb1a15dda9&query='.$titre); 
    $data = json_decode($json);
    return $data;
}
function search_movie_detail_db($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_serie_detail_db($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_serie_saison($id,$saison)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'/season/'.$saison.'?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_desc_actors($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_images_actors($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'/tagged_images?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function get_movies_actors($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/person/'.$id.'/movie_credits?api_key=c61458343dec48dd506164bb1a15dda9&language=fr'); 
    $data = json_decode($json);
    return $data;
}
function search_movie_actors_db($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/credits?api_key=c61458343dec48dd506164bb1a15dda9'); 
    $data = json_decode($json);
    return $data;
}
function search_serie_actors_db($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$id.'/credits?api_key=c61458343dec48dd506164bb1a15dda9'); 
    $data = json_decode($json);
    return $data;
}
function search_movie_video_db($id)
{ 
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/videos?api_key=c61458343dec48dd506164bb1a15dda9'); 
    $data = json_decode($json);
    return $data;
}
function get_saison($serieid,$saisonid)
{
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$serieid.'/season/'.$saisonid.'?api_key=c61458343dec48dd506164bb1a15dda9&language=en'); 
    $data = json_decode($json);
    return $data;
}
function get_episode($serieid,$saisonid,$episode)
{
    $json = file_get_contents('http://api.themoviedb.org/3/tv/'.$serieid.'/season/'.$saisonid.'/episode/'.$episode.'?api_key=c61458343dec48dd506164bb1a15dda9'); 
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
    $json = file_get_contents('http://api.themoviedb.org/3/movie/'.$id.'/images?api_key=c61458343dec48dd506164bb1a15dda9'); 
    $data = json_decode($json);
    return $data;
}
function generateCallTrace()
{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();
    
    for ($i = 0; $i < $length; $i++)
    {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
    }
    
    return "\t" . implode("\n\t", $result);
}
?>