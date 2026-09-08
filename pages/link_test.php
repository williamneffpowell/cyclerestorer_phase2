<?php
require '../includes/auth_check.inc.php';
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';
$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($is_logged_in)
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Resource Link" onClick="goToadd_link()">
</form>';
}
if (!$is_logged_in)
{
$target_url_in = '/pages/links.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto = $_SESSION['target_url'];
$loginvar = '<form align="center">
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
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_resource_links.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title>Cyclerestorer Links </title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
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
$sort_field_url = $_GET['sort_field'];  #URL Variable for which field will be sorted  
$sort_field_order_url = $_GET['sort_field_order'];
if ($sort_field_order_url == "" or $sort_field_order_url == "ascending") 
{ 
    $sort_field_order_url = 'descending';
	
    $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
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
  		{ $sort_field_order_url = "ascending";
		   $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
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

mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "SELECT * FROM resource_links $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table class='links' align='center' >\n";

echo "<TH width='5%'><div align='left'>Edit</TH>";
echo "<TH width='5%' ><a href=links.php?sort_field=8&sort_field_order=$sort_field_order_url><div align='center'>Link Name</TH>";
echo "<TH width=300 height=25 ><div align='center'>Link Comment</TH>";
echo "<TH width='5%'><div align='left' ><a href=links.php?sort_field=5&sort_field_order=$sort_field_order_url>Manufacturer</a></TH>";
echo "<TH width='5%'><div align='center' ><a href=links.php?sort_field=6&sort_field_order=$sort_field_order_url>Model</a></TH>";
echo "<TH width='5%'><div align='center' ><a href=links.php?sort_field=11&sort_field_order=$sort_field_order_url>Type</a></TH>";
echo "<TH width='10%'><div align='center' ><a href=links.php?sort_field=7&sort_field_order=$sort_field_order_url>Actual Link</a></TH>";
echo "<TH width='10%'><div align='left' ><a href=links.php?sort_field=4&sort_field_order=$sort_field_order_url>Date Entered</a></TH>";
#echo "</span>";
$header_color = "FFFFFF";
while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$header_color="FFFFFF";}
else {$bgcolor = "BBBBBB";$header_color="000000";}


$link_name = $Row[3];
$link_comment = $Row[5];
$manufacturer_tab = $Row[7];
$model_tab = $Row[8];
$html_link = $Row[4];
$date_entered_tab = $Row[2];
$user_tab = $Row[9];
$resource_links_row_id = $Row[1];
$link_tab = $Row[11];
echo "<TR bgcolor=$bgcolor>";
$redbug2 = "redbug2";
#if ($user_tab == $session_username and ($Row[0] <> ""))
if ($user_tab == $session_username or ($session_username) == $redbug2)
{
$name = ("<a href=edit_links.php?edit_row=$resource_links_row_id>Edit</a>");
}
else
{
$name = "  ";
}
echo "\t\t<td><font color=$header_color>$name</td>\n";
echo "\t\t<td width=125 height=25><font color=$header_color>$link_name</td>\n";
echo "\t\t<td width=125 height=25><font color=$header_color>$link_comment</td>\n";
echo "\t\t<td><font color=$header_color>$manufacturer_tab</td>\n";
echo "\t\t<td><font color=$$header_color>$model_tab</td>\n";
echo "\t\t<td><font color=$$header_color>$link_tab</td>\n";
echo "\t\t<td><font color=$header_color><a href=\"http://$html_link\"" .">$html_link</strong></a></td>\n";
echo "\t\t<td><font color=$header_color>$date_entered_tab</td>\n";        
echo "\t</tr>\n";

}
/* 
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td>&nbsp;</td>";
echo "</tr>";
*/
echo "</table>\n";

echo "<br>";
echo "<br>";
print "<table align='center'><tr align='center'><td>$loginvar</td></tr></table>"; 

echo "<br>";
echo "<br>";

 
mysql_free_result($result);

// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>



