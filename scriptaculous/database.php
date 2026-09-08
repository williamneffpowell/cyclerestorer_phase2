
<?php
    function dbConnect()
    {
	
        include '../includes/dbconnect.inc.php';

$link = mysql_connect ($Host, $User, $Password);
        if (!$link)
		  print "It did not link!";		  
            return false;
 
        return mysql_select_db('phpriot');
    }
?>
