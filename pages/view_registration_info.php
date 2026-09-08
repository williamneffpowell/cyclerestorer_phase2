<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';
$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
if ($is_logged_in ?? false) 
{
# LOGIN OK
//$loginvar = '<form align="center">
//<input type=button value="Add a New Serial Number Entry" onClick="goToadd_link()">
# $logged_in_var = "yes";
}
if (!$is_logged_in ?? false) 
{

$target_url_in = '/pages/view_registration_info.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
//$loginvar = '<table align = "center"> <form align="center">
//<input type=button value="Log In to add Serial Numbers" onClick="goToLogin()">
//</form></table>';
}
########################################################################################################
#             End of Login
########################################################################################################
$request->enable_super_globals();

$manufacturer = $_REQUEST['manufacturer'] ?? false;
$bike_model = $_REQUEST['model'] ?? false;
$bike_year = $_REQUEST['bike_year'] ?? false;





?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_serial_numbers.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title> Cycle Registry Page </title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h1>Cyclerestorer</h1> </p>
        <p align="center" class="white_24pt_bold"><h4 align="center">Registration Information</h4></p>
		    <p align="center" class="white_24pt_bold"><h4 align="center"><?php echo "$manufacturer $bike_year $bike_model" ?>&nbsp;Registration Page</h4></p>
      <p align="center"><img src="../Images/serial_numbers.jpg" width="138" height="89" align="middle"></p></td>
      <td width="44%">&nbsp;</td>
    </tr>

  
  </table>
</div>

  <?php
// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
$sort_field_url = "";
$sort_field_url = $_REQUEST['sort_field'] ?? false;  #URL Variable for which field will be sorted
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by s.manufacturer" ;}
elseif ($sort_field_url == 7)
{$sort_field_in = "order by s.model";}
elseif ( $sort_field_url == 4)
{$sort_field_in = "order by s.bike_year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by s.manufacturer";}


$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");

// Performing SQL query

$query = "SELECT r.engine_number,r.serial_number,s.bike_year,s.model,s.ccs,s.num_cyl,s.fuel_tank_color,s.manufacturer,r.username,s.serial_row_id,s.nickname,r.year,r.model,r.manufacturer,r.picID,r.row_id,p.filename FROM serial_numbers as s 
LEFT JOIN registry as r ON r.model = s.model and r.year = s.bike_year  
LEFT JOIN tb_pictures  as p on r.picID = p.picID
where s.bike_year = '$bike_year' and s.manufacturer = '$manufacturer' and s.model = '$bike_model' $sort_field_in ";

//print "<h2>$query\n</h2>";


//print "<h2>$result\n</h2>";

//$link = mysqli_connect($Host,$User,$Password,$DBName) or
//    die("Connection Unsuccessfull");
    
    
$result = "";  

try {
   //* this WILL NOT report any errors even if index is not available */
    $result = mysqli_query($link, $query);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
    
    print "<h2>ERROR Line 120 \n</h2>";
}






//$result = mysqli_query($query) or die('Query failed: ' . mysql_error());
// Printing results in HTML



//printf ("<h2>mysqli_num_rows result returned %d rows.\n</h2>", mysqli_num_rows($result));





echo "<table class='registry' width=100% align='center'>\n";

echo "<TH width='3%'><div align='left'>Year</TH>";
#echo "<TH width='4%'><div align='left'><a href=show_man_serial_num.php?sort_field=5>Manufacturer</a></TH>";
echo "<TH width='2%'><div align='left'>Model</TH>";
echo "<TH width='2%'><dif align='left'>Owner</TH>";
echo "<TH width='2%'><div align='left'>Bike Nickname</TH>";
echo "<TH width='2%'><div align='left'>CCs</TH>";
echo "<TH width='2%'><div align='left'># of Cylinders</TH>";
echo "<TH width='2%'><div align='left'>Tank_Color</TH>";
echo "<TH width='15%'><div align='left'>Engine Number</TH>";
echo "<TH width='15%'><div align='left'>Frame Number</TH>";
echo "<TH width='15%'><div align='left'>More Information</TH>";

$bgcolor = "";

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$engine_number = $Row[0] ?? null;
$frame_number = $Row[1] ?? null;
$bike_year = $Row[2] ?? null;
$bike_model = $Row[3] ?? null;
$ccs = $Row[4] ?? null;
$num_cyl = $Row[5] ?? null;
$fuel_tank_color = $Row[6] ?? null;
$bike_manufacturer = $Row[7] ?? null;
$user_tab = $Row[8] ?? null;
$row_id_tab = $Row[9] ?? null;
$nickname = $Row[10] ?? null;
$registration_year = $Row[11] ?? null;
//$registation_model = $Row[12];
$picID = $Row[14] ?? null;
$row_id = $Row[15] ?? null;
$file_name = $Row[16] ?? null;

echo "<TR bgcolor=$bgcolor>";

//if ($user_tab == ($session_username))
//{

//$name = ("<a href=edit_serial_number.php?edit_row=$row_id_tab>Edit</a>");
//}
//else
//{
//$name = "  ";
//}
$member_bike = " ";

$registration_model2 = trim($Row[12] ?? null);
$bike_model2 = trim($bike_model);
#print "ID TEMP TEMP VAR $id_temp_var \n";
#print "<h5>Registration_Year = $registration_year and bike_year = $bike_year  bike model = $bike_model2 registration_model = $registation_model2</H5>";
if ($registration_year == $bike_year and $registration_model2 == $bike_model2)
{		
if($file_name <> "")
			{
			$member_bike = ("<a href=view_collection_info.php?picID=$picID&edit_row=$row_id><img src='../image_upload/thumbs/$file_name' align='left'></a>");	
			}
}


echo "\t\t<td><font color=$fcolor>$bike_year</td>\n";
echo "\t\t<td><font color=$fcolor>$bike_model</td>\n";
echo "\t\t<td><font color=$fcolor>$user_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$nickname</td>\n";
echo "\t\t<td><font color=$fcolor>$ccs</td>\n";
echo "\t\t<td><font color=$fcolor>$num_cyl</td>\n";
echo "\t\t<td><font color=$fcolor>$fuel_tank_color</td>\n";
echo "\t\t<td><font color=$fcolor>$engine_number</td>\n";
echo "\t\t<td><font color=$fcolor>$frame_number</td>\n";
echo "\t\t<td><font color=$fcolor>$member_bike</td>\n";
         
echo "\t</tr>\n";
}
echo "</table>\n";
echo "<br>";
mysqli_free_result($result);
//print "<table align='center'><tr><td>$loginvar</td></tr></table>";
// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
  

</body>
</html>



