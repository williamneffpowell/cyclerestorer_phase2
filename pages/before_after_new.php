<?php
require '../includes/auth_check.inc.php';
	include '../includes/dbconnect.inc.php';
	mysql_connect("$Host","$User","$Password");
	mysql_select_db("$DBName") or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
if ($is_logged_in){
$Link = mysql_connect ($Host, $User, $Password);

$session_username = $_SESSION['user_name'];
if ($session_username <> "")
{
# Do Nothing print_html_add();
//mysql_close ($Link);

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
</HEAD>
<body>
<?
if (!$is_logged_in)
{
$target_url_in = 'pages/before_after.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
}
//END CHECK LOGIN
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
$Link = mysql_connect ($Host, $User, $Password);
mysql_select_db("$DBName") or die(mysql_error());



$query = ("SELECT b.username, b.restoration_title, b.registration_row_id,b.row_id, r.manufacturer, r.model,r.year, p.pic_row_id,p.filename,p.pic_comment, p.pic_display_order from before_after as b  LEFT JOIN registry as r on  r.row_id=b.registration_row_id LEFT JOIN before_after_pics as p on b.row_id=p.before_after_row_id  order by r.row_id, p.pic_display_order");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table class='registry' width='60%' align='center'>\n";
echo "<TH width='5%'><div align='Center'>Before</TH>";
#echo "<TH width='5%'><div align='Center'>Link</TH>";
echo "<TH width='7%'><div aling='Center'>Username</TH>";
echo "<TH width='50%'><div align='Center'>Restoration Title</TH>";
echo "<TH width='10%'><div align='Center'>Manufacturer</TH>";
echo "<TH width='10%'><div align='Center'>Model</TH>";
echo "<TH width='5%'><div align='Center'>Year</TH>";

$before_after_row_temp = "";

while ($Row = mysql_fetch_array($result))
{

if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}
	
	$user_tab = $Row[0];
	$restoration_title = $Row[1];
	$registration_row_id = $Row[2];
	$before_after_row_id=$Row[3];
	$manufacturer = $Row[4];
	$model = $Row[5];
	$year = $Row[6];
    $picid = $Row[7];
	$pic_file_name = $Row[8];
	$pic_display_order =$Row[9];
	echo "<TR bgcolor=$bgcolor>";
		
if (($before_after_row_temp <> $before_after_row_id))
{
#################################################################################################################
#  Store the first image if there is one and the content 
#################################################################################################################
		

		If ($pic_file_name <> "" and $pic_display_order = 1)
			{
    		$first_part = "<td><a href=restoration_pics.php?edit_row=$before_after_row_id><img src='../image_upload/thumbs/$pic_file_name'> </td>";
			}
			else
			{
			$name = ("<a href=restoration_pics.php?edit_row=$before_after_row_id>Details</a>");
			$first_part .= "<td><font color=$fcolor>$name</td>\n";
			}
			$first_part .="<td><font color=$fcolor>$user_tab</td>\n
						<td><font color=$fcolor>$restoration_title</td>\n
						<td><font color=$fcolor>$manufacturer</td>\n
						<td><font color=$fcolor>$model</td>\n          
						<td><font color=$fcolor>$year</td>\n
						</tr>\n";
	
###########################################################################################################################################
#    
	echo  "$first_part";					
}	

 $before_after_row_temp = $before_after_row_id;
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
	<?
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
	<?

}

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>
</body>
