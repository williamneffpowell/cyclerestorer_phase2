<!--serial_number_referance_page.php -->

<?php

// temporarily enable superglobals

define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../serial_number_reference.php';
   //including phpBB3 stuff   
 //  define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
  
$sessionID = "";
$session_username = "";
session_start();
$sessionId = $_SESSION['SESSION_ID']??'0'; 


$session_username = request_var('username', '', 'string');

include '../includes/dbconnect.inc.php';



$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");

$Query = "SELECT * from auth_user WHERE sesnID = '$sessionID'";   
/* activate reporting */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
    $result = mysqli_query($link, $Query);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
}
	


$Row = mysqli_fetch_array($result, MYSQLI_NUM);





if ($user->data['is_registered']) 
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Serial Number Entry" onClick="goToadd_link()">
</form></table>';

}
else
{


$target_url_in = '/pages/serial_number_reference.php';
//$_SESSION['target_url'] = "$target_url_in";
//$target_url_goto= $_SESSION['target_url']  ?? null;
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
   <title>Serial Number Reference Page</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>

<body>
<h2>&nbsp;</h2>
<h1 align='center' class="style4 wh_tnr_12">Cycle Restorer</h1>
<h2>&nbsp;</h2>
<br>

<p align="center" class="white_24pt_bold"><h4 align="center">Serial Number Reference</h4></p>

<p align="center"><img src="../Images/serial_numbers.jpg" width="138" height="89" align="middle"></p></td>



  <?php

$sort_field_in =  "order by manufacturer" ;





$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
// If the connection is successfull then 
// the program does not terminates
// and the following message is displayed.
//echo "<h2>Connection Successfull</h2>";
  
/* activate reporting */

$Query = "SELECT * FROM serial_numbers $sort_field_in ";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
    $result = mysqli_query($link, $Query);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
}



// Performing SQL query



// Printing results in HTML
echo "<div align='center'>";
echo "<table class='serialnumberreference'>\n";

$manufacturer_temp = "";
$bike_manufacturer = "";
$bgcolor = "777777";$fcolor="FFFFFF";

echo "<TH width='15%' bgcolor=$bgcolor ><div align='center'>Manufacturer</a>";
$bgcolor = "BBBBBB";$fcolor="FFFFFF";
echo "<TR bgcolor=$bgcolor>";

//***************** Test of passing variable. 
$item = "Computer";
$model = "Latitude 5420";
$price = "900.00";

//***********************************************

echo "<a href='temp2.php?i=$item'>Go to Next Page temp2.html </a>";

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))


{
    

    
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
$production_run_tab =$Row[13] ?? null;
$nickname_tab = $Row[12] ?? null;
$model_code_tab = $Row[11] ?? null;

$bike_manufacturer = rtrim($bike_manufacturer);



$bike_urlencode = urLencode($bike_manufacturer);

//printf "<h2>$bike_urlencode</h2>";
//print "<h2>$result\n</h2>";


if ($bike_manufacturer <> $manufacturer_temp)
{
echo "<TR bgcolor=$bgcolor>";
echo "<td align=center><font color=$fcolor><a href='show_man_serial_num.php?manufacturer=$bike_urlencode'>$bike_manufacturer</a></td>";
echo "</tr>";
}









$manufacturer_temp = $bike_manufacturer;         

} #end of while


echo "</table>";
echo "</div>";

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



