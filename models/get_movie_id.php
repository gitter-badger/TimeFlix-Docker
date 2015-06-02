<?php

/*
Modèle films - Gère la récupération des films avec ID avec des rêgles de filtrage.  
*/

function get_movie_id($id)
{
    global $bdd;
    $id = (int) $id;
    $req = $bdd->prepare('SELECT * FROM films WHERE allocine='.$id.'');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $limit, PDO::PARAM_INT);
    $req->execute();
    $movie = $req->fetchAll();
    
    
    return $movie;
}
