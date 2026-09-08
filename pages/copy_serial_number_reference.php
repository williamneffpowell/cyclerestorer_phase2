<?PHP
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "")
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Serial Number Entry" onClick="goToadd_link()">
</form>';

}
else
{

$target_url_in = 'pages/serial_number_reference.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar = '<table align = "center"> <form align="center">
<input type=button value="Log In to add Serial Numbers" onClick="goToLogin()">
</form></table>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_serial_numbers.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title>Serial Number Reference Page </title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h1>Cyclerestorer</h1> </p>
        <p align="center" class="white_24pt_bold"><h4 align="center">Serial Number Reference</h4></p>
      <p align="center"><img src="../Images/serial_numbers.jpg" width="138" height="89" align="middle"></p></td>
      <td width="44%">&nbsp;</td>
    </tr>

  
  </table>
</div>

  <?php
// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
$sort_field_url = $_GET['sort_field'];  #URL Variable for which field will be sorted
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by manufacturer" ;}
elseif ($sort_field_url == 7)
{$sort_field_in = "order by model";}
elseif ( $sort_field_url == 4)
{$sort_field_in = "order by bike_year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by manufacturer";}


mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "SELECT * FROM serial_numbers $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML

echo "<table class='registry' width=100% align='center'>\n";
echo "<TH width='2%'><dif align='left'>&nbsp</TH>";
#echo "<TH width='3%'><div align='left'><a href=serial_number_reference.php?sort_field=4>Year</a></TH>";
echo "<TH width='4%'><div align='left'><a href=serial_number_reference.php?sort_field=5>Manufacturer</a></TH>";
#echo "<TH width='2%'><div align='left'><a href=serial_number_reference.php?sort_field=7>Model</a></TH>";
#echo "<TH width='2%'><div align='left'>CCs</a></TH>";
#echo "<TH width='2%'><div align='left'># of Cylinders</a></TH>";
#echo "<TH width='2%'><div align='left'>Tank_Color</a></TH>";
#echo "<TH width='15%'><div align='left'>Engine Number</TH>";
#echo "<TH width='15%'><div align='left'>Frame Number</TH>";

while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$engine_number = $Row[0];
$frame_number = $Row[1];
$bike_year = $Row[4];
$bike_model = $Row[5];
$ccs = $Row[9];
$num_cyl = $Row[8];
$fuel_tank_color = $Row[10];
$bike_manufacturer = $Row[6];
$user_tab = $Row[3];
$row_id_tab = $Row[7];

echo "<TR bgcolor=$bgcolor>";
if ($user_tab == $session_username)
{

$name = ("<a href=edit_serial_number.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}

if ($bike_manufacturer <> $manufacturer_temp)
{
echo "\t\t<td><font color=$fcolor><a href=show_man_serial_num.php?manufacturer=$bike_manufacturer>$bike_manufacturer</a></td>\n";
}

$manufacturer_temp = $bike_manufacturer;         
echo "\t</tr>\n";
}


echo "</table>\n";

echo "<br>";
mysql_free_result($result);

print "<table align='center'><tr><td>$loginvar</td></tr></table>";

// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
  

</body>
</html>



