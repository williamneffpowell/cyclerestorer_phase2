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
print '<form align="center">
<input type=button value="Add a New Resource Link" onClick="goToadd_link()">
</form>';

}
else
{

$target_url_in = 'pages/parts_and_supplies.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
print '<form align="center">
<input type=button value="Log In to add Links" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
<!-- function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_resource_links.php"; } -->
<!--function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }-->
</script>
   <title>Classified Ads</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large">Cyclerestorer </p>
        <p align="center" class="Wh_TNR_Large">Classified Adds</p>
      <p align="center"><img src="../Images/link_thumb.jpg" width="138" height="89" align="middle"></p></td>
      <td width="44%">&nbsp;</td>
    </tr>

  
  </table>
</div>


  <?php
// Connecting, selecting database
#include '../includes/dbconnect.inc.php';
if ($sort_field_url == "")
{ 
$sort_field_in =  "order by manufacturer" ;}
elseif ($sort_field_url == 7)
{$sort_field_in = "order by html_link";}
elseif ( $sort_field_url == 4)
{$sort_field_in = "order by owner";}
elseif ( $sort_field_url == 6)
{$sort_field_in = "order by owner DESC";}


mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "SELECT * FROM parts_supplies $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table width=70% align='center'>\n";
echo "<TR><TH width='5%'><div align='left'>Link Name</TH>";
echo "<TH width='10%'><div align='left'>Link Comment</TH>";
echo "<TH width='5%'><div align='left'><a href=links.php?sort_field=7>Manufacturer</a></TH>";
echo "<TH width='5%'><div align='left'>Model</TH>";
echo "<TH width='10%'><div align='left'>Actual Link</TH>";
echo "<TH width='5%'><div align='left'>Date Entered</TH>";



while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

#$user_tab = $Row[0];
$link_name = $Row[3];
$link_comment = $Row[5];
$manufacturer_tab = $Row[7];
$model_tab = $Row[8];
$html_link = $Row[4];
$date_entered_tab = $Row[2];

echo "<TR bgcolor=$bgcolor>";
if ($user_tab == $session_username and ($Row[0] <> ""))
{

#$name = ("<a href=edit_registry.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}
echo "\t\t<td><font color=$fcolor>$link_name</td>\n";
echo "\t\t<td><font color=$fcolor>$link_comment</td>\n";
echo "\t\t<td><font color=$fcolor>$manufacturer_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$model_tab</td>\n";
echo "\t\t<td><font color=$fcolor><a href=\"http://$html_link\"" .">$html_link</strong></a></td>\n";
echo "\t\t<td><font color=$fcolor>$date_entered_tab</td>\n";
         
echo "\t</tr>\n";
}
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";

echo "</table>\n";


mysql_free_result($result);

// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
?>
  <table>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>


</table>

</body>
</html>
