<?php

/*
Modèle users - Gère la récupération des films avec ID avec des rêgles de filtrage.  
*/

function get_profil_id($id)
{
    global $bdd;
    $id = (int) $id;
    $req = $bdd->prepare('SELECT * FROM usersflix WHERE id='.$id.' LIMIT 1');
    $req->bindParam(':offset', $offset, PDO::PARAM_INT);
    $req->bindParam(':limit', $limit, PDO::PARAM_INT);
    $req->execute();
    $profil = $req->fetchAll();
    
    
    return $profil;
}
