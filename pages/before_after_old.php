<?php
require '../includes/auth_check.inc.php';
	include '../includes/dbconnect.inc.php';
	mysqli_connect("$Host","$User","$Password","$DBName");
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
if ($is_logged_in){
$Link = mysqli_connect($Host, $User, $Password, $DBName);
//$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
//$Result = mysqli_query($Link, $Query);
//$Row = mysqli_fetch_array($Result);
//$username = $Row[0];
//Session doesn't exist
$session_username = $_SESSION['user_name'];
if ($session_username <> "")
{
# Do Nothing print_html_add();
//mysqli_close($Link);

}
else 
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Restoration Projects</title>

<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css" />
<HEAD>

<SCRIPT LANGUAGE="JavaScript">

function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=600,left = 340,top = 212');");
}
// End -->
</script>


<!-- STEP TWO: Use the following button code for the new window -->






<!-- Script Size:  0.73 KB  -->

</HEAD>

<body>



<?php

if (!$is_logged_in)
{
$target_url_in = 'pages/before_after.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
//END CHECK LOGIN
####################################################################################################
####################################################################################################
####################################################################################################
echo "<br>";
echo "<br>";
echo "<table align='center'>";
echo "<tr>&nbsp;</tr>";
echo "<tr><td><H1> Restoration Projects </H1></td></tr>";
echo "<tr>&nbsp;</tr>";
echo "</table align='center'>";
echo "<br>";
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by username" ;}
#elseif ($sort_field_url == 3)
#{$sort_field_in = "order by year";}
#elseif ( $sort_field_url == 5)
#{$sort_field_in = "order by owner";}
#elseif ( $sort_field_url == 6)
#{$sort_field_in = "order by owner DESC";}

$Link = mysqli_connect($Host, $User, $Password, $DBName);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
$query = ("SELECT before_after.username, before_after.restoration_title, before_after.registration_row_id,before_after.row_id, registry.manufacturer, registry.model,registry.year  from before_after LEFT JOIN registry on registry.row_id=before_after.registration_row_id");

#$query = "SELECT * FROM before_after  $sort_field_in ";
#print "$query\n";
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
 $Link = mysqli_connect($Host, $User, $Password, $DBName); 
// Printing results in HTML
echo "<table class='registry' width='60%' align='center'>\n";
#echo "<TR><TH width='5%'><div align='left'>Edit if Owner</TH>";
echo "<TH width='5%'><div align='Center'>Link</TH>";
echo "<TH width='7%'><div aling='Center'>Username</TH>";
echo "<TH width='50%'><div align='Center'>Restoration Title</TH>";
echo "<TH width='10%'><div align='Center'>Manufacturer</TH>";
echo "<TH width='10%'><div align='Center'>Model</TH>";
echo "<TH width='5%'><div align='Center'>Year</TH>";


while ($Row = mysqli_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

	
	$user_tab = $Row[0];
	#$file_name = $Row[1];
	$restoration_title = $Row[1];
	#$photo_tile = $Row[3];
	$registration_row_id = $Row[2];
	$before_after_row_id=$Row[3];
	$manufacturer = $Row[4];
	$model = $Row[5];
	$year = $Row[6];
	 # $temp_row_id = $before_after_row_id;
	#print "Temp ROW IT = $temp_row_id\n";
	echo "<TR bgcolor=$bgcolor>";
	
if ( $registration_row_id <> $temp_row_id)
  { 	
	
	$name = ("<a href=restoration_pics.php?edit_row=$before_after_row_id>Details</a>");
	
	echo "<td><font color=$fcolor>$name</td>\n";
	echo "<td><font color=$fcolor>$user_tab</td>\n";
	#echo "<td>$file_name</td>\n";
	echo "<td><font color=$fcolor>$restoration_title</td>\n";
	#echo "<td>$photo_title</td>\n";
	echo "<td><font color=$fcolor>$manufacturer</td>\n";
	echo "<td><font color=$fcolor>$model</td>\n";          
	echo "<td><font color=$fcolor>$year</td>\n";
	echo "\t</tr>\n";
 }	
}
	echo "</table>\n";
	
	
if ($session_username <> "")
{
	?>
	<br />
<br/>
<br/>

<table align='center'>
<tr>
<td>

<input type="button"  value="Add a Bike" onClick="javascript: location.href = 'http://www.cyclerestorer.com/pages/popup_add_before_after.php';">
</td>
</tr>
</table>
<br />
<br/>
<br/>
	<?php
}
else
{
	?>
	<br />
<br/>
<br/>

<table align='center'>
<tr>
<td>

<input type="button"  value="Log In to Add a Bike" onClick="javascript: location.href = 'http://www.cyclerestorer.com/pages/login.php';">
</td>
</tr>
</table>
<br />
<br/>
<br/>
	<?php

}

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>
</body>
