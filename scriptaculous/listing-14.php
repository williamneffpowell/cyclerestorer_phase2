<?php
    require_once('database.php');
    require_once('movies.php');
 
    if (!dbConnect())
        exit;
 
    processMoviesOrder('movies_list');
?>