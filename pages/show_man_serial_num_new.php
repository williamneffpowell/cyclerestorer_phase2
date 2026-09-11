
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


mysqli_connect("$Host","$User","$Password","$DBName");
//performing SQL query s=serial_numbers r=registry p=tb_pictures i=image_library_registry b=bike_pictures
$query = "SELECT s.engine_number,s.frame_number,s.bike_year,s.model,s.ccs,s.num_cyl,s.fuel_tank_color,s.manufacturer,
s.user_name,s.serial_row_id,s.nickname,s.production_run, 
 r.year,r.model,r.picID,r.row_id,
 p.filename,
 i.bike_pictures_pic_row_id, i.bike_pic_filename , i.year, i.model,i.row_id

 FROM serial_numbers as s 
LEFT JOIN registry as r ON r.model = s.model and r.year = s.bike_year 
LEFT JOIN image_library_registry as i ON r.model = i.model and r.year = i.year  
LEFT JOIN tb_pictures  as p on r.picID = p.picID where s.manufacturer = '$manufacturer'  $sort_field_in ";


//$query = "SELECT s.engine_number,s.frame_number,s.bike_year,s.model,s.ccs,s.num_cyl,s.fuel_tank_color,s.manufacturer,s.user_name,s.serial_row_id,s.nickname,s.production_run,
 //r.year,r.model,r.picID,r.row_id,
 //p.filename,
 //i.manufacturer,i.model,i.year,i.bike_pictures_pic_row_id,i.bike_pic_filename,
 //b.filename 
 //FROM serial_numbers as s 
//LEFT JOIN registry as r ON r.model = s.model and r.year = s.bike_year  
//LEFT JOIN image_library_registry as i ON i.model = s.model  and i.year = s.bike_year
//LEFT JOIN tb_pictures  as p on r.picID = p.picID  where s.manufacturer = '$manufacturer'  $sort_field_in;"

//$query = "SELECT * FROM serial_numbers where manufacturer = '$manufacturer'  $sort_field_in ";
#print "$query\n";
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
 $Link = mysqli_connect($Host, $User, $Password, $DBName); 
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
echo "<TH width='15%'><div align='left'>Image Library</TH>";

while ($Row = mysqli_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$engine_number = $Row[0];
$frame_number = $Row[1];
$bike_year = $Row[2];
$bike_model = $Row[3];
$ccs = $Row[4];   //s.ccs
$num_cyl = $Row[5]; //s.num_cyl
$fuel_tank_color = $Row[6]; //s.fuel_tank_color
$bike_manufacturer = $Row[7]; //s.manufacturer
$user_tab = $Row[8]; // s.user_name
$row_id_tab = $Row[9]; //s.serial_row_id
$nickname = $Row[10]; // s.nickname
$production_run = $Row[11]; //s.production_run
$registration_year = $Row[12]; //r.year
//$registation_model = $Row[12];
$picID = $Row[14]; //r.picID
$row_id = $Row[15]; //r.row_id
$file_name =$Row[16]; //p.filename
$image_pic_id = $Row[17]; //i.bike_pictures_pic_row_id
$image_filename = $Row[18]; //i.bike_pic_filename
$image_year = $Row[19]; //i.year
$image_model = $Row[20]; //I.model
$image_row_id = $Row[21]; // i.row_id

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
~
$name = ("<a href=edit_serial_number.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}
$registration_model2 = trim($Row[13]);
$bike_model2 = trim($bike_model);

$member_bike = " ";
$image_library_bike = " ";
if ($registration_year == $bike_year and $registration_model2 == $bike_model2)
{	
#echo "\t\t<td align='left' width= 50 ><A HREF=\"javascript:popUp('restoration_pics_view.php?bef_aft_row=$id_temp_var&td_var=$pic_display_order')\"><img src='../image_upload/thumbs/$file_name' alt='$photo_comment &nbsp; $pic_enter_date' align='left'> </td>";
	
			//$member_bike = ("<a href=view_collection_info.php?picID=$picID&edit_row=$row_id>View Registry</a>");
	       $member_bike = ("<a href=view_registration_info.php?bike_year=$bike_year&manufacturer=$bike_manufacturer&model=$bike_model><img src='../image_upload/thumbs/$file_name' align='left'></a>");
		
}



echo "<td>  reg year = $registration_year image year = $image_year reg model =  $registration_model2 image model = $image_model </td>\n";
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
//echo "<td><h5>registration year: $registration_year image_year:  $image_year registration model: $registration_model2  image model:  $image_model</h5><td>\n";

if ($registration_year == trim($image_year) and trim($registration_model2) == trim($image_model) and trim($image_year <> ""))
{	

	       $image_library_bike = ("<a href=image_library_pics.php?edit_row=$image_row_id><img src='../Images/library/manuals.jpg' align='left'></a>");
echo "\t\t<td><font color=$fcolor>$image_library_bike</td>\n";
}
else
{
$image_library_bike = " ";
echo "\t\t<td><font color=$fcolor>$image_library_bike</td>\n";

}


         
echo "\t</tr>\n";

$registration_year = 1;
$registration_model2 = 2;
$bike_year = 3;
$bike_model2 = 4;
$image_model = 5;
$image_year = 6;


}
}
echo "</table>\n";

echo "<br>";
mysqli_free_result($result);

print "<table align='center'><tr><td>$loginvar</td></tr></table>";

// Closing connection
#mysqli_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
  

</body>
</html>



