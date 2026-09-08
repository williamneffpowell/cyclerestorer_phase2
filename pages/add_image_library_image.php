<?php
	session_start();
	include '../includes/dbconnect.inc.php';
	mysql_connect("$Host","$User","$Password");
	mysql_select_db("$DBName") or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
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
#mysql_close ($Link);

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
$target_url_in = 'pages/add_image_library_image.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
//END CHECK LOGIN
#########################################################################################################################################################
#########################################################################################################################################################
#########################################################################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
{
if (value==null||value=="")
  {alert(alerttxt);return false}
else {return true}
}
}


</script>
   <title>Add Images to Image Library</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<br>
<H1 align='center' >Add Cycle Images</H1>
<br>

<form name=add_before_after onSubmit="return validate_form(this)" method="POST" ><div align="Left">
<?PHP
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by manufacturer" ;}
elseif ($sort_field_url == 3)
{$sort_field_in = "order by year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by owner";}
elseif ( $sort_field_url == 6)
{$sort_field_in = "order by owner DESC";}


$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
#$query = "SELECT * FROM registry where row_id NOT IN (SELECT registration_row_id FROM before_after)";

$query = "SELECT * from registry"; 

$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Link = mysql_connect ($Host, $User, $Password);

echo "<table align='center' width='60%' border='0'>\n";
echo "<TR><TH width='5%'><div align='center'>Select Bike</TH>";
echo "<TH width='5%'><div align='center'>Make</TH>";
echo "<TH width='5%'><div align='center'>Model</TH>";
echo "<TH width='5%'><div align='center'>Year</TH>";

while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "7777777";}
else {$bgcolor = "BBBBBB";}

$user_tab = $Row[0];
$row_id_tab = $Row[1];
$action_tab = $Row[2];
$manufacturer_tab = $Row[3];
$model_tab = $Row[4];
$year_tab = $Row[5];
$serial_number_tab = $Row[6];
$owner_tab = $Row[7];
$location_tab = $Row[8];
$comments_tab = $Row[9];

echo "<TR bgcolor=$bgcolor>";
if ($user_tab == $session_username and ($Row[0] <> ""))
{
$name = ("<INPUT TYPE='radio' NAME='id_radio_button' VALUE='$row_id_tab'>");
echo "<td align='center'>$name</td>\n";
echo "<td align='Left'>$manufacturer_tab</td>\n";
echo "<td align='Left'>$model_tab</td>\n";
echo "<td align='Left'>$year_tab</td>\n";          
echo "</tr>\n";
}
else
{
#$name = "  ";
}
}
echo "</table>\n";
echo "        <caption>&nbsp;";
echo "        </caption>";


?>           

	 <div align="center">
	 <br><div align="center"><strong>Restoration Title</strong></div>
	 <br>
              <input  name="restoration_title" type="text" size="50">
  </div></td>
        </tr>
		<br>
		<br>
		<tr>
           <td><div align="center" class="style1"></div></td>
          <td><div align="center">
    <input type="submit" name="submit" value="submit">
	<input type="button" value="Register a Bike" onClick="javascript: location.href = 'http://www.cyclerestorer.com/pages/registry_add.php';">
          </div></td>
        </tr>
     </table>
</form> 

<?PHP		 
	  if ($_REQUEST['submit']) 
	{ 
		$restoration_title_value=$_REQUEST['restoration_title'];
		$radio_button=$_REQUEST['id_radio_button'];
		$query ="INSERT INTO before_after (username,restoration_title,registration_row_id) VALUES('$session_username','$restoration_title_value','$radio_button')";
		$result=mysql_query($query) or die ('Update Query Failed $Query');
		#The HREF location must be changed then the application is ported to production.
		#This is the production Link: http://www.cyclerestorer.com/pages/library.php
		#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/library.php
		print "$result";
		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/before_after.php"</script>';
			}
		  else 
		 {
		  echo "<b>ERROR: unable to insert.</b>"; 
	    } 
	}
     elseif ($_REQUEST['Register'])
	    {
		  print "Register If\n";
		 mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php"</script>';
         }
?>
<?php 
include 'bottom_index_table.php';
?>
</body>
</html>