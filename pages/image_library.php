<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../edit_registry.php';
   //including phpBB3 stuff
//   define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');
$request->enable_super_globals();
// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
$login_var = "";
$sort_field_in = "";
$manufacturer_tab_temp = "";
$manufacturer_temp = "";
$manufacturer_tab = "";


//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
	session_start();
	include '../includes/dbconnect.inc.php';


//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$fail4ed = 0;

$session_username = $user->data['username'] ?? '0';

	$Link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");

//Session doesn't exist
if ($user->data['is_registered'])
{
# Do Nothing print_html_add(); login OK.

$logged_in_var = "yes";
}
if (!$user->data['is_registered'])
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = '/pages/image_library.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
//END CHECK LOGIN
####################################################################################################
####################################################################################################
####################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Image Library</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
a:link {
	color: #333333;
}
a:visited {
	color: #333333;
}
-->
</style></head>
<body>
<div align="center">
  <table width="100" border="0" cellpadding="0"    >
    <tr>
      <th scope="col"><img src="../Images/library/manuals.jpg" alt="Library Page" width="137" height="103"></th>
      <th scope="col">Cyclerestorer Image Library </th>
    </tr>
    <tr>
      <td><div align="center"><span class="style1"><a href="Bike_image_Registry_Add.php">Add New Bike Category</a></span>&nbsp;</div></td>
      <td><a href="image_library.php" target="_self"></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center"></div></td>
      <td><?php
	  echo "$login_var";

	  ?>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

    <?php
$sort_field_url = $_GET['sort_field'] ?? '0';  #URL Variable for which field will be sorted
// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
if ($sort_field_url == "")
{ $sort_field_in =  "order by image_library_registry.manufacturer, image_library_registry.year, image_library_registry.model" ;}
elseif ($sort_field_url == 1){$sort_field_in = "order by image_library_registry.manufacturer, image_library_registry.year, image_library_registry.model";}
elseif ($sort_field_url == 2){$sort_field_in = "order by image_library_registry.manufacturer DESC,image_library_registry.year DESC, image_library_registry.model DESC";}
elseif ($sort_field_url == 3){$sort_field_in = "order by image_library_registry.year, image_library_registry.manufacturer, image_library_registry.model";}
elseif ($sort_field_url ==  8){$sort_field_in = "order by image_library_registry.year DESC, image_library_registry.manufacturer DESC, image_library_registry.model DESC";}
elseif ($sort_field_url ==  4){$sort_field_in = "order by image_library_registry.model, image_library_registry.year, image_library_registry.manufacturer";}
elseif ($sort_field_url ==  9){$sort_field_in = "order by image_library_registry.model DESC, image_library_registry.year DESC, image_library_registry.manufacturer DESC";}




//$query = "(SELECT * FROM image_library_registry) UNION (Select before_after.row_id FROM before_after  $sort_field_in )";  #WHERE before_after.registration_row_id = image_library_registry.row_i           //

////$query = "(SELECT DISTINCT image_library_registry.username,image_library_registry.manufacturer,image_library_registry.model,image_library_registry.year,image_library_registry.row_id  FROM image_library_registry LEFT JOIN bike_pictures ON image_library_registry.row_id = bike_pictures.registry_row_id  $sort_field_in)";

$query = "SELECT DISTINCT username, manufacturer, model, year, row_id  
          FROM image_library_registry 
          LEFT JOIN bike_pictures 
          ON image_library_registry.row_id = bike_pictures.registry_row_id  
          $sort_field_in";
          
$stmt = mysqli_prepare($Link, $query);
mysqli_execute($stmt);
$result = mysqli_stmt_get_result($stmt);









//$result = mysqli_query($query) or die('Query failed: ' . mysqli_error());

// Printing results in HTML
echo "<table width=50% class='registryhome'>\n";

$bgcolor = "";
$fcolor = "";
$bgcolor = "BBBBBB";$fcolor="FFFFFF";

echo "<TH width='15%' bgcolor=$bgcolor ><div align='left'><a href=image_library.php?sort_field=1>Manufacturer</a>";

$bgcolor = "BBBBBB";$fcolor="FFFFFF";
while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
#if ($bgcolor == "BBBBBB") {}
#else {$bgcolor = "BBBBBB";$fcolor="000000";}

$user_tab = $Row[0] ?? '0';
$row_id_tab = $Row[4]?? '0';
$bike_manufacturer = $Row[1]?? '0';
$model_tab = $Row[2]?? '0';
$year_tab = $Row[3]?? '0';
$before_after_tab = $Row[5]?? '0';


#if ($model_tab_temp = $model_tab and $year_tab_temp = $year_tab and $manufacturer_tab_temp = $manufacturer_tab)
#{
echo "<TR bgcolor=$bgcolor>";
#echo "\t\t<td><font color=$fcolor>$manufacturer_tab</td>\n";

$urlbike_manufacturer = urlencode($bike_manufacturer);

if ($bike_manufacturer <> $manufacturer_temp)
{
echo "\t\t<td><font color=$fcolor><a href=image_library_manufacturer.php?manufacturer=$urlbike_manufacturer >$bike_manufacturer</a></td>\n";
}

$manufacturer_temp = $bike_manufacturer;
echo "\t</tr>\n";

$model_tab_temp = $model_tab;
$year_tab_temp = $year_tab;
$manufacturer_tab_temp = $manufacturer_tab;

echo "\t</tr>\n";
# end of while
}
echo "</table>\n";

//mysql_free_result($result);

// Closing connection
#mysql_close($Link);
echo "<br>";
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
mysqli_close ($Link);
?>
</div>
</body>
</html>