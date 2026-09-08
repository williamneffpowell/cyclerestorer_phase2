
<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';

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
 <?php
// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
$manufacturer = $_GET['manufacturer'];
$sort_field_url = $_GET['sort_field'];  #URL Variable for which field will be sorted
?>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h1>Cyclerestorer</h1> </p>
        <p align="center" class="white_24pt_bold"><h4 align="center"><?php echo "$manufacturer"?>&nbsp;Serial Number Reference</h4></p>
      <p align="center"><img src="../Images/serial_numbers.jpg" width="138" height="89" align="middle"></p></td>
      <td width="44%">&nbsp;</td>
    </tr>

  
  </table>
</div>

 <?php
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by s.manufacturer" ;}
elseif ($sort_field_url == 7)
{$sort_field_in = "order by s.model";}
elseif ( $sort_field_url == 4)
{$sort_field_in = "order by s.bike_year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by s.manufacturer";}


mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query

$query = "SELECT s.engine_number,s.frame_number,s.bike_year,s.model,s.ccs,s.num_cyl,s.fuel_tank_color,s.manufacturer,s.user_name,s.serial_row_id,s.nickname,s.production_run, r.year,r.model,r.picID,r.row_id,p.filename FROM serial_numbers as s 
LEFT JOIN registry as r ON r.model = s.model and r.year = s.bike_year  
LEFT JOIN tb_pictures  as p on r.picID = p.picID where s.manufacturer = '$manufacturer'  $sort_field_in ";


//$query = "SELECT * FROM serial_numbers where manufacturer = '$manufacturer'  $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML

echo "<table class='registry' width=100% align='center'>\n";
echo "<TH width='2%'><dif align='left'>&nbsp</TH>";
echo "<TH width='3%'><div align='left'><a href=show_man_serial_num.php?sort_field=4&manufacturer=$manufacturer>Year</a></TH>";
#echo "<TH width='4%'><div align='left'><a href=show_man_serial_num.php?sort_field=5>Manufacturer</a></TH>";
echo "<TH width='2%'><div align='left'><a href=show_man_serial_num.php?sort_field=7&manufacturer=$manufacturer>Model</a></TH>";
echo "<TH width='2%'><div align='left'>Nickname</a></TH>";
echo "<TH width='2%'><div align='left'>CCs</a></TH>";
echo "<TH width='2%'><div align='left'># of Cylinders</a></TH>";
echo "<TH width='2%'><div align='left'>Tank_Color</a></TH>";
echo "<TH width='15%'><div align='left'>Engine Number</TH>";
echo "<TH width='15%'><div align='left'>Frame Number</TH>";
echo "<TH width='15%'><div align='left'>Production Run</TH>";
echo "<TH width='15%'><div align='left'>Registration Groups</TH>";

while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$engine_number = $Row[0];
$frame_number = $Row[1];
$bike_year = $Row[2];
$bike_model = $Row[3];
$ccs = $Row[4];
$num_cyl = $Row[5];
$fuel_tank_color = $Row[6];
$bike_manufacturer = $Row[7];
$user_tab = $Row[8];
$row_id_tab = $Row[9];
$nickname = $Row[10];
$production_run = $Row[11];
$registration_year = $Row[12];
//$registation_model = $Row[12];
$picID = $Row[14];
$row_id = $Row[15];
$file_name =$Row[16];

if (($bike_year == $last_bike_year) && ($bike_model == $last_bike_model))
{

$last_bike_year = $bike_year;
$last_bike_model = $bike_model;

}
else

{
$last_bike_year = $bike_year;
$last_bike_model = $bike_model;
echo "<TR bgcolor=$bgcolor>";

$user_temp = $session_username;

if ($user_tab == ($session_username))
{

$name = ("<a href=edit_serial_number.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}
$registration_model2 = trim($Row[13]);
$bike_model2 = trim($bike_model);
//echo "<h5>registration year: $registration_year     bike_year:  $bike_year registration model: $registration_model2  bike model:  $bike_model2</h5>";
$member_bike = " ";
if ($registration_year == $bike_year and $registration_model2 == $bike_model2)
{	
#echo "\t\t<td align='left' width= 50 ><A HREF=\"javascript:popUp('restoration_pics_view.php?bef_aft_row=$id_temp_var&td_var=$pic_display_order')\"><img src='../image_upload/thumbs/$file_name' alt='$photo_comment &nbsp; $pic_enter_date' align='left'> </td>";
	
			//$member_bike = ("<a href=view_collection_info.php?picID=$picID&edit_row=$row_id>View Registry</a>");
	       $member_bike = ("<a href=view_registration_info.php?bike_year=$bike_year&manufacturer=$bike_manufacturer&model=$bike_model><img src='../image_upload/thumbs/$file_name' align='left'></a>");
}

echo "\t\t<td><font color=$fcolor>$name</td>\n";
echo "\t\t<td><font color=$fcolor><a href=show_year_serial_num.php?bike_year=$bike_year&manufacturer=$bike_manufacturer>$bike_year</a></td>\n";
#echo "\t\t<td><font color=$fcolor>$bike_manufacturer</td>\n";
echo "\t\t<td><font color=$fcolor><a href=show_model_serial_num.php?bike_model=$bike_model&manufacturer=$bike_manufacturer>$bike_model</a></td>\n";
echo "\t\t<td><font color=$fcolor>$nickname</td>\n";
echo "\t\t<td><font color=$fcolor>$ccs</td>\n";
echo "\t\t<td><font color=$fcolor>$num_cyl</td>\n";
echo "\t\t<td><font color=$fcolor>$fuel_tank_color</td>\n";
echo "\t\t<td><font color=$fcolor>$engine_number</td>\n";
echo "\t\t<td><font color=$fcolor>$frame_number</td>\n";
echo "\t\t<td><font color=$fcolor>$production_run</td>\n";
echo "\t\t<td><font color=$fcolor>$member_bike</td>\n";
         
echo "\t</tr>\n";


$registration_year = 1;
$registration_model2 = 2;
$bike_year = 3;
$bike_model2 = 4;
//}
//}
}
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



