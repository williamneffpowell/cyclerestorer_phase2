<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//require '../includes/auth_check.inc.php';
//Commented Out
//session_start();  // Removed redundant session start - Important:  Do NOT remove this, it is needed.
// Removed session_start();
$sort_field_in = "";
$bgcolor = "";
$offset = "";
//session_start();  // Removed redundant session start
$sessionID = session_id();

//global $user; // Commented Out  //No longer using phpBB $user
include '../includes/dbconnect.inc.php';
$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
     

session_start(); //ADDED SESSION START

if (isset($_SESSION['username'])) //changed to reflect the website's session
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Resource Link" onClick="goToadd_link()">
</form>';
$session_username = $_SESSION['username']; //added session username
$is_registered = true; // Set a variable to track login status
}
if (!isset($_SESSION['username']))  //changed to reflect website's session
{
$target_url_in = '/pages/links.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto = $_SESSION['target_url'];
$loginvar = '<form align="center">
<input type=button value="Log In to add Links" onClick="goToLogin()">
</form>';
$is_registered = false; //set variable to track login status
}
########################################################################################################
#       End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_resource_links.php"; }
function goToLogin(){ window.location = "../login.php"; } //changed to site login
</script>
    <title>Cyclerestorer Links </title>
    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<style type="text/css">


th {
  background-color: gold;
  color: navy
}
</style>

<body>
<div align="center"> 
  <table width="74%" height="236" border="0">
    <tr>
      <td width="37%" height="232" align="center"><p align="center" class="Wh_TNR_Large"><img src="../Images/link_thumb.jpg" width="138" height="89" align="middle"></p>
      <span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h3>Cyclerestorer</h3> </p>
        <p align="center" class="Wh_TNR_Large"><h2>Links</h2></p>
        <p align="center">&nbsp;</p></td>
      <td width="44%">&nbsp;</td>
    </tr>
  </table>
</div>

  <?php
  

    $sort_field_roder_url = "";
$sort_field_url = "";
    $sort_field_order_url = 'descending';
  

if ($sort_field_order_url == "" or $sort_field_order_url == "ascending")  
{ 
    $sort_field_order_url = 'descending';
  if ($sort_field_url == 5 or $sort_field_url == "")
    {$sort_field_in =  "order by manufacturer ASC" ;}

      elseif ($sort_field_url == 7)
        {$sort_field_in = "order by html_link ASC";}
      elseif ( $sort_field_url == 4)
        {$sort_field_in = "order by date_entered ASC";}
      elseif ( $sort_field_url == 6)
        {$sort_field_in = "order by model ASC";}
      elseif ( $sort_field_url == 11)
        {$sort_field_in = "order by type ASC";}
      elseif ( $sort_field_url == 8)
        {$sort_field_in = "order by resource_name ASC";}
    }
  else
    {   
      
      $sort_field_order_url = "";
      $sort_field_order_url = "ascending";
      if ($sort_field_url == 5 )
        { 
          $sort_field_in =  "order by manufacturer DESC" ;}
        elseif ($sort_field_url == 7)
          {$sort_field_in = "order by html_link DESC";}
        elseif ( $sort_field_url == 4)
          {$sort_field_in = "order by date_entered DESC";}
        elseif ( $sort_field_url == 6)
          {$sort_field_in = "order by model DESC";}
        elseif ( $sort_field_url == 11)
          {$sort_field_in = "order by type DESC";}
        elseif ( $sort_field_url == 8)
        {$sort_field_in = "order by resource_name DESC";}
}
$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
// Performing SQL query

$sort_field_in = "order by type DESC";
$query = "SELECT * FROM resource_links $sort_field_in ";



mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
   $result = mysqli_query($link, $query);
} catch (mysqli_sql_exception $e) {
  error_log($e->__toString());
}



// Printing results in HTML
echo "<table class='links' align='center' >\n";
if ($is_registered) //changed to reflect website's session
{
echo "<TH width='5%' bgcolor=green><div align='left'>Edit</TH>";
}
echo "<TH width='5%' ><a href=links.php?sort_field=8&sort_field_order=$sort_field_order_url><div align='center'>Link Name</TH>";
echo "<TH width=300 height=25 ><div align='center'>Link Comment</TH>";
echo "<TH width='5%'><div align='left' ><a href=links.php?sort_field=5&sort_field_order=$sort_field_order_url>Manufacturer</a></TH>";
echo "<TH width='5%'><div align='center' ><a href=links.php?sort_field=6&sort_field_order=$sort_field_order_url>Model</a></TH>";
echo "<TH width='5%'><div align='center' ><a href=links.php?sort_field=11&sort_field_order=$sort_field_order_url>Type</a></TH>";
echo "<TH width='10%'><div align='center' ><a href=links.php?sort_field=7&sort_field_order=$sort_field_order_url>Actual Link</a></TH>";
echo "<TH width='10%'><div align='left' ><a href=links.php?sort_field=4&sort_field_order=$sort_field_order_url>Date Entered</a></TH>";
#echo "</span>";
$header_color = "FFFFFF";

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM)) 
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$header_color="FFFFFF";}
else {$bgcolor = "BBBBBB";$header_color="000000";}

$link_name         = $Row[3] ?? null;
$link_comment       = $Row[5] ?? null;
$manufacturer_tab     = $Row[7] ?? null;
$model_tab         = $Row[8] ?? null;
$html_link         = $Row[4] ?? null;
$date_entered_tab     = $Row[2] ?? null;
$user_tab         = $Row[9] ?? null;
$resource_links_row_id = $Row[1] ?? null;
$link_tab         = $Row[11] ?? null;
echo "<TR bgcolor=$bgcolor>";
$redbug2 = "redbug2";


 if ($is_registered) //changed to reflect website's session
{
if ($user_tab == $session_username or  $redbug2) //simplified condition
{
$name = ("<a href=edit_links.php?edit_row=$resource_links_row_id>Edit</a>");
}
else
{
$name = "  ";
}

echo "\t\t<td><font color=$header_color>$name</td>\n";
}
echo "\t\t<td width=125 height=25><font color=$header_color>$link_name</td>\n";
echo "\t\t<td width=125 height=25><font color=$header_color>$link_comment</td>\n";
echo "\t\t<td><font color=$header_color>$manufacturer_tab</td>\n";
echo "\t\t<td><font color=$$header_color>$model_tab</td>\n";
echo "\t\t<td><font color=$$header_color>$link_tab</td>\n";
echo "\t\t<td><font color=$header_color><a href=\"http://$html_link\"" .">$html_link</strong></a></td>\n";
echo "\t\t<td><font color=$header_color>$date_entered_tab</td>\n";         
echo "\t</tr>\n";

} 

echo "</table>\n";

echo "<br>";
echo "<br>";
print "<table align='center'><tr align='center'><td>$loginvar</td></tr></table>";  

echo "<br>";
echo "<br>";

 
mysqli_free_result($result);


include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>
