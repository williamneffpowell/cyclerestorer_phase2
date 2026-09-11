<?php
//image_library_manufacturer.php
require '../includes/auth_check.inc.php';
	include '../includes/dbconnect.inc.php';
 
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$failed = 0;
//$session_temp_var=$_SESSION['sessionID'];
$session_username = $session_username ?? '0';
$Link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");

if ($is_logged_in) {
$logged_in_var = "yes";
}

if (!$is_logged_in)
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = '/pages/image_library_manufacturer.php';
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
  <table width="200" border="0" cellpadding="0"    >
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
$manufacturer = $_REQUEST['manufacturer'] ?? '';
	
$sort_field_url = $_GET['sort_field'] ?? '0';  #URL Variable for which field will be sorted 
$sort_field_order_url = $_GET['sort_field_order']?? '0';	
	

// Connecting, selecting database
#include '../includes/dbconnect.inc.php';

if ($sort_field_order_url == "" or $sort_field_order_url == "ascending") 
{ 
    $sort_field_order_url = 'descending';
	
    $_SESSION['sort_field'] = "$sort_field_order_url" ;
	if ($sort_field_url == "")
		{$sort_field_in =  "order by r.manufacturer, r.year, r.model ASC" ;}
			elseif ($sort_field_url == 1)
				{$sort_field_in = "order by r.year ASC";}
			elseif ( $sort_field_url == 2)
				{$sort_field_in = "order by r.model ASC";}
			
		}
	else
  		{ $sort_field_order_url = "ascending";
		   $_SESSION['sort_field'] = "$sort_field_order_url" ;
			if ($sort_field_url == 1 )
				{ $sort_field_in = "order by r.year DESC";}
				elseif ( $sort_field_url == 2)
					{$sort_field_in = "order by r.model DESC";}
				
}



//$query = "(SELECT * FROM image_library_registry) UNION (Select before_after.row_id FROM before_after  $sort_field_in )";  #WHERE before_after.registration_row_id = image_library_registry.row_i           //
	
//$query = "(SELECT DISTINCT r.username,r.manufacturer,r.model,r.year,r.row_id  FROM image_library_registry as r LEFT JOIN bike_pictures as b ON r.row_id = b.registry_row_id  where r.manufacturer = '$manufacturer' $sort_field_in )";	


//$result = mysqli_query($query) or die('Query failed: ' . mysqli_error($Link));



// Sanitize sort field to prevent SQL injection
$allowed_sort_fields = ['username', 'manufacturer', 'model', 'year'];
$sort_field = in_array($sort_field_in, $allowed_sort_fields) ? $sort_field_in : 'username'; // Default to 'username'

$query = "SELECT DISTINCT r.username, r.manufacturer, r.model, r.year, r.row_id  
          FROM image_library_registry AS r  
          LEFT JOIN bike_pictures AS b ON r.row_id = b.registry_row_id  
          WHERE r.manufacturer = ? 
          ORDER BY r.$sort_field"; // Using the sanitized sort field

$stmt = $Link->prepare($query);
$stmt->bind_param("s", $manufacturer);
$stmt->execute();
$result = $stmt->get_result();








// Printing results in HTML
echo "<table width='100%' class='registry'>\n";


echo "<TH width='15%'><div align='left'>Manufacturer</a>";


echo "<TH width='15%'><div align='left'><a href=image_library_manufacturer.php?sort_field=1&sort_field_order=$sort_field_order_url&manufacturer=$manufacturer>Year</a>";
echo " <a href=image_library_manufacturer.php?sort_field=1&manufacturer=$manufacturer target='_self'></a></TH>";

echo "<TH width='15%'><div align='left'><a href=image_library_manufacturer.php?sort_field=2&sort_field_order=$sort_field_order_url&manufacturer=$manufacturer>Model</a>";
echo " <a href=image_library_manufacturer.php?sort_field=2&manufacturer=$manufacturer target='_self'></a></TH>";
echo "<TH width='15%'><div align='left'>View</a>";
$bgcolor = "";
$fcolor = "";

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$user_tab = $Row[0]?? '0';
$row_id_tab = $Row[4]?? '0';
$manufacturer_tab = $Row[1]?? '0';
$model_tab = $Row[2]?? '0';
$year_tab = $Row[3]?? '0';
$before_after_tab = $Row[5]?? '0';


#if ($model_tab_temp = $model_tab and $year_tab_temp = $year_tab and $manufacturer_tab_temp = $manufacturer_tab) 
#{
echo "<TR bgcolor=$bgcolor>";
echo "\t\t<td><font color=$fcolor>$manufacturer_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$year_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$model_tab</td>\n";


if ( $logged_in_var == "yes")
{
echo "<td><a href=add_image_library_pics.php?edit_row=" . htmlspecialchars($row_id_tab) . ">Add Pictures</a></td>\n";
}

#if ($before_after_tab <> "")
#{
echo "<td><a href=image_library_pics.php?edit_row=" . htmlspecialchars($row_id_tab) . ">View</a></td>\n";
     
#}
#else
#{
#echo "<td><a>&nbsp;</a></td>\n";
#}



$model_tab_temp = $model_tab;
$year_tab_temp = $year_tab;
$manufacturer_tab_temp = $manufacturer_tab;


echo "\t</tr>\n";
# end of while


}
echo "</table>\n";


mysqli_free_result($result);

// Closing connection
mysqli_close($Link);
echo "<br>";
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</div>
</body>
</html>