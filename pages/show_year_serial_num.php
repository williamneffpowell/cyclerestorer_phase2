<?php
//show_year_serial_number_page.php
require '../includes/auth_check.inc.php';
$sessionID = $_SESSION['sessionID']??'0';
$session_username = $_SESSION['user_name']??'0';

include '../includes/dbconnect.inc.php';
$request->enable_super_globals();
$link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");
mysqli_set_charset($link, 'utf8mb4');

if ($is_logged_in) 
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Serial Number Entry" onClick="goToadd_link()">
</form>';

}
if (!$is_logged_in) 
{

$target_url_in = '/pages/show_man_serial_num.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar = '<table align = "center"> <form align="center">
<input type=button value="Log In to add Serial Numbers" onClick="goToLogin()">
</form></table>';
}
########################################################################################################
#             End of Login
########################################################################################################

// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
$manufacturer = $_GET['manufacturer']?? null;
$bike_year = $_GET['bike_year']?? null;
?>
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_serial_numbers.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title>Serial Number Reference Page by Manufacturer and Year </title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h1>Cyclerestorer</h1> </p>
        <p align="center" class="white_24pt_bold"><h4 align="center">Serial Number Reference by Manufacturer and Year</h4></p>
      <p align="center"><img src="../Images/serial_numbers.jpg" width="138" height="89" align="middle"></p>
	   <p align="center" class="white_24pt_bold"><h4 align="center"><? echo "$manufacturer  $bike_year" ?></h4></p>
	  </td>
      <td width="44%">&nbsp;</td>
    </tr>
  </table>
</div>



<?php

 
 
$sort_field_url = $_REQUEST['sort_field']?? '';  #URL Variable for which field will be sorted
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by bike_year, model" ;}
elseif ($sort_field_url == 7)
{$sort_field_in = "order by model";}
elseif ( $sort_field_url == 4)
{$sort_field_in = "order by bike_year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by manufacturer";}


//mysql_connect("$Host","$User","$Password");
//mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query


$stmt = $link->prepare("SELECT * FROM serial_numbers WHERE manufacturer = ? AND bike_year = ? $sort_field_in");
$stmt->bind_param("ss", $manufacturer, $bike_year);
$stmt->execute();
$result = $stmt->get_result();








#print "$query\n";
//$result = mysqli_query($link, $query) or die('Query failed: ' . mysql_error());
// $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML

echo "<table class='registry'  align='center'>\n";
echo "<TH width='2%'><dif align='left'>&nbsp</TH>";
echo "<TH width='3%'><div align='left'>Year</a></TH>";
echo "<TH width='2%'><div align='left'>Model</a></TH>";
echo "<TH width='2%'><div align='left'>Nickname</a></TH>";
echo "<TH width='2%'><div align='left'>CCs</a></TH>";
echo "<TH width='2%'><div align='left'># of Cylinders</a></TH>";
echo "<TH width=20%><div align='Center'>Tank_Color</a></TH>";
echo "<TH width=35%><div align='Center'>Engine Number</TH>";
echo "<TH width=35%><div align='Center'>Frame Number</TH>";

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
$bgcolor ="";
$fgcolor="";
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$engine_number = $Row[0] ?? null;
$frame_number = $Row[1] ?? null;
$bike_year = $Row[4] ?? null;
$bike_model = $Row[5] ?? null;
$ccs = $Row[9] ?? null;
$num_cyl = $Row[8] ?? null;
$fuel_tank_color = $Row[10] ?? null;
$bike_manufacturer = $Row[6] ?? null;
$user_tab = $Row[3] ?? null;
$row_id_tab = $Row[7] ?? null;
$nickname = $Row[12] ?? null;

echo "<TR bgcolor=$bgcolor>";

$session_username = $session_username; 
if ($user_tab == $session_username)
{

$name = ("<a href=edit_serial_number.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}
echo "\t\t<td><font color=$fcolor>$name</td>\n";
echo "\t\t<td><font color=$fcolor>$bike_year</td>\n";
echo "\t\t<td><font color=$fcolor>$bike_model</td>\n";
echo "\t\t<td><font color=$fcolor>$nickname</td>\n";
echo "\t\t<td><font color=$fcolor>$ccs</td>\n";
echo "\t\t<td><font color=$fcolor>$num_cyl</td>\n";
echo "\t\t<td><font color=$fcolor>$fuel_tank_color</td>\n";
echo "\t\t<td><font color=$fcolor>$engine_number</td>\n";
echo "\t\t<td><font color=$fcolor>$frame_number</td>\n";
         
echo "\t</tr>\n";
}


echo "</table>\n";

echo "<br>";
mysqli_free_result($result);

print "<table align='center'><tr><td>$loginvar</td></tr></table>";

// Closing connection
mysqli_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
  

</body>
</html>



