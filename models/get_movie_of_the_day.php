<?php

/*
Modèle films - Gère la récupération des films avec ID avec des rêgles de filtrage.  
*/

function get_movie_of_the_day()
{
    global $bdd;
    $req = $bdd->prepare('SELECT * FROM propose_film');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $limit, PDO::PARAM_INT);
    $req->execute();
    $movie = $req->fetchAll();
    
    
    return $movie;
}
