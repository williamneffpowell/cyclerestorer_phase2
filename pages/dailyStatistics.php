<?PHP
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Daily Counter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">

<br>

<?php

include '../includes/dbconnect.inc.php';
$Link = mysql_connect ($Host, $User, $Password);
$Query = "SELECT count FROM simplecount";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

$daily_count = $Row[0];

if ($Row[0] <> "")
{

$daily_count = $Row[0];
#mysql_close ($Link);
}						

$today = date("Y-m-d h:i:s");


$Link = mysql_connect ($Host, $User, $Password);
$Query2 ="INSERT INTO daily_statistics(daily_count,count_date) VALUES ('$daily_count','$today')";


	$result=mysql_query($Query2) or die ('Insert Query Failed' . mysql_error());
			
		if    ($result) 
		{ 
		mysql_close ($Link);
		 }
		  else 
		  { echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link); }
	
		

?>
	  
  
   
        
 

</body>
</html>