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
$logged_in = "yes";
}
else
{

$target_url_in = 'pages/member_list.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar = '<table align = "center"> <form align="center">
<input type=button value="Log In to view Cycle Restorer Members" onClick="goToLogin()">
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
   <title>Member List</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>&nbsp;</h2>
<br>
<table align="center" border="1">
<td>
<h3 align='center' class="style4">Cyclerestorer</h3>
<h3 align='center' class="style4">Member List</h3>

</td>
</tr>
</table>

<h5>&nbsp;</h5>
  <?php

$sort_field_in =  "order by username" ;
#echo "<h5> Logged in = $logged_in </h5>";
if ($logged_in == "yes")
{
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "SELECT * FROM auth_user $sort_field_in ";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<div align='center'>";
echo "<table class='serialnumberreference'>\n";



$bgcolor = "777777";$fcolor="FFFFFF";

echo "<TH width='15%' bgcolor=$bgcolor ><div align='center'>Member</a>";
$bgcolor = "BBBBBB";$fcolor="FFFFFF";
echo "<TR bgcolor=$bgcolor>";
while ($Row = mysql_fetch_array($result))


{
$username = $Row[0];
$status = $Row[14];
$userID = $Row[15];

if ($status == 1 )
{

#if ($bike_manufacturer <> $manufacturer_temp)
#{
echo "<TR bgcolor=$bgcolor>";
echo "<td align=center><font color=$fcolor><a href=profile.php?uid=$userID>$username</a></td>";
echo "</tr>";
}
#}

#$manufacturer_temp = $bike_manufacturer;         

} #end of while


echo "</table>";
echo "</div>";

echo "<br>";
 #end of logged in If
mysql_free_result($result);
}
print "<table align='center'><tr><td>$loginvar</td></tr></table>";

// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
  

</body>
</html>



