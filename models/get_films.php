<?php

/*
Modèle films - Gère la récupération des films avec des rêgles de filtrage.  
*/


print_r(get_data('usersflix',",files_movies WHERE movies.id_movies = files_movies.id_movies"));