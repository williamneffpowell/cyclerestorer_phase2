
	<?php
	session_start();
	include '../includes/dbconnect.inc.php';
	mysql_connect("$Host","$User","$Password");
	mysql_select_db($DBName) or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES

$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);
$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
print $username[0];
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$username = $Row[0];
//Session doesn't exist
if ($username <> "")
{
# Do Nothing print_html_add();
mysql_close ($Link);

}
else 
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}
}
if ($logged_on == "no")
{
$target_url_in = 'pages/cycle_registry_entry.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://localhost:8080/redbug/_no_task/cyclerestorer/pages/login.php"</script>';

}
//END CHECK LOGIN

	
	
	  if ($HTTP_POST_VARS['submit']) { 
		$manufacturer=$HTTP_POST_VARS['manufacturer'];
		$model=$HTTP_POST_VARS['model'];
		$year=$HTTP_POST_VARS['year'];
		$serial_number=$HTTP_POST_VARS['serial_number'];
		$owner=$HTTP_POST_VARS['owner'];
		$location=$HTTP_POST_VARS['location'];
		$comments=$HTTP_POST_VARS['comments'];
		
	
		 $query ="INSERT INTO registry (manufacturer,model,year,serial_number,owner,location,comments)";
		 $query.= " VALUES ('$manufacturer','$model','$year','$serial_number','$owner','$location','$comments')"; 
		  
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed');
		
		
		
		#print "$mysqul_query($query) \n";
		
		
		if    ($result)  echo "Successfully Entered" ;
		  else echo "<b>ERROR: unable to post.</b>"; 
	    } 
	  # if(!mysql_db_query($dbname,$query,$link_id)) die(mysql_error());
		# echo "success in database entry.";
	
			
?>	
<br />
<a href="Registry_Add.php">Another</a><br />			
 <a href="../index.php">Home</a><br>
