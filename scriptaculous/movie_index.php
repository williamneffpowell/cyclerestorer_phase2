<?php
   include '../includes/dbconnect.inc.php';
   
 

mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
   
   
   
   


     require_once('movies.php');
    $movies = getMovies();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>phpRiot Sortable Lists</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
 
        <script type="text/javascript" src="scriptaculous-js-1.5.3/lib/prototype.js"></script>
        <script type="text/javascript" src="scriptaculous-js-1.5.3/src/scriptaculous.js"></script>
    </head>
    <body>
        <h1>phpRiot Sortable Lists</h1>
 
        <ul id="movies_list" class="sortable-list">
            <?php foreach ($movies as $movie_id => $title) { ?>
                <li id="movie_<?= $movie_id ?>"><?= $title ?></li>
            <?php } ?>
        </ul>
 
        <script type="text/javascript">
            function updateOrder()
            {
                var options = {
                                method : 'post',
                                parameters : Sortable.serialize('movies_list')
                              };
 
                new Ajax.Request('processor.php', options);
            }
 
            Sortable.create('movies_list', { onUpdate : updateOrder });
        </script>
    </body>
</html>