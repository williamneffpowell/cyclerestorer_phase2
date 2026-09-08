<?php
    function getMovies()
    {
        $query = 'select movie_id, title from movies order by ranking, lower(title)';
        $result = mysql_query($query);

 
        $movies = array();
        while ($row = mysql_fetch_object($result)) {
            $movies[$row->movie_id] = $row->title;
        }
 
        return $movies;
    }
?>