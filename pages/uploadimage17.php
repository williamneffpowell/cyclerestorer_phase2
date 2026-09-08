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

	
echo('Upload images: 

<FORM ENCTYPE="multipart/form-data" ACTION="' . $PHP_SELF . '" METHOD="POST"> 

The file: <INPUT TYPE="file" NAME="userfile"> 

<INPUT TYPE="submit" VALUE="Upload"> 

</FORM>'); 

$path = "../image_upload/"; 

$max_size = 150000; 

if (!isset($HTTP_POST_FILES['userfile'])) exit; 

if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'])) 
 { 
	if ($HTTP_POST_FILES['userfile']['size']>$max_size) 
	{ 
	  echo "The file is too big<br>n"; exit; 
	} 

if (($HTTP_POST_FILES['userfile']['type']=="image/gif") || ($HTTP_POST_FILES['userfile']['type']=="image/pjpeg") || ($HTTP_POST_FILES['userfile']['type']=="image/jpeg") || ($HTTP_POST_FILES['userfile']['type']=="image/png")) { 

if (file_exists($path . $HTTP_POST_FILES['userfile']['name'])) 
    { 
	echo "The file already exists<br>n"; exit; 
	} 
    print "RES = $res \n";
	$res = copy($HTTP_POST_FILES['userfile']['tmp_name'], $path . 

	$HTTP_POST_FILES['userfile']['name']); 

if (!$res) 
{ 
echo "upload failed!<br>n"; exit; 
} 
else 
{ 
echo "upload sucessful<br>n"; 

$query ="INSERT INTO before_after (file_name)";
		 $query.= " VALUES('$res')"; 
		  
		print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed');
		
		








} 

echo "File Name: ".$HTTP_POST_FILES['userfile']['name']."<br>n"; 
echo "File Size: ".$HTTP_POST_FILES['userfile']['size']." bytes<br>n"; 
echo "File Type: ".$HTTP_POST_FILES['userfile']['type']."<br>n"; 

} else { echo "Wrong file type<br>n"; exit; } 

} 

$my_file = $HTTP_POST_FILES['userfile']['name']; 

?> 



</body>
</html>
