<?php
require '../includes/auth_check.inc.php';
$username = $session_username;


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

if ($is_logged_in)
{
# LOGIN OK
$loginvar =  '<form align="center">
<input type=button value="Add a Cycle Show" onClick="goToadd_link()">
</form>';
}
if (!$is_logged_in)
{
$target_url_in = '/pages/cycle_shows.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to Add or Edit a Show" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_cycle_shows.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>

   <title>Past Cycle Shows</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 24px}
-->
</style>
</head>
<body>
<h1>&nbsp;</h1>
<h1 align="center">Past Cycle Shows</h1>
<div align="center">
  <h1>&nbsp;</h1>
<div align="center"><h5><a href="http://www.cyclerestorer.com/pages/cycle_shows.php">Upcoming Cycle Shows</a></h5></div>
</div>


  <div align="center">
    <?php
$sort_field_url = $_GET['sort_field'];  #URL Variable for which field will be sorted 
$sort_field_order_url = $_GET['sort_field_order'];


if ($sort_field_order_url == "" or $sort_field_order_url == "ascending") 
{ 
    $sort_field_order_url = 'descending';
	if ($sort_field_url == "")
	  {$sort_field_url = "6";}
	 
	 $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 5 or $sort_field_url == "")
	{$sort_field_in =  "order by show_name ASC" ;}
	elseif ($sort_field_url == 7)
	{$sort_field_in = "order by show_state ASC";}
	elseif ( $sort_field_url == 4)
	{$sort_field_in = "order by show_city ASC";}
	elseif ( $sort_field_url == 6)
	{$sort_field_in = "order by start_date ASC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by end_date ASC";}

}
	else
  		{ $sort_field_order_url = "ascending";
		   $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 5 )
	{$sort_field_in =  "order by show_name DESC" ;}
	elseif ($sort_field_url == 7)
	{$sort_field_in = "order by show_state DESC";}
	elseif ( $sort_field_url == 4)
	{$sort_field_in = "order by show_city DESC";}
	elseif ( $sort_field_url == 6)
	{$sort_field_in = "order by start_date DESC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by end_date DESC";}

}



mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
$today = date("Y-m-d");

// Performing SQL query
$query = "SELECT * FROM cycle_shows ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table width=80% align='center'  class='classified' cellspacing='0'>\n";
echo "<TH width='10%'><div align='left'>Show Name<a href=cycle_shows.php?sort_field=5&sort_field_order=$sort_field_order_url></TH>";
echo "<TH width='10%'><div align='left'>Show Address</TH>";
echo "<TH width='15%'><div align='left'><a href=cycle_shows.php?sort_field=4&sort_field_order=$sort_field_order_url>City &nbsp;<a href=cycle_shows.php?sort_field=7&sort_field_order=$sort_field_order_url>State</a></TH>";
#echo "<TH width='3%'><div align='left'><a href=cycle_shows.php?sort_field=7&sort_field_order=$sort_field_order_url>Show State</a></TH>";
echo "<TH width='3%'><div align='left'>Show Zipcode</TH>";
echo "<TH width='40%'><div align='left'>Comment &nbsp;&nbsp;&nbsp;&nbsp;</a></TH>";
echo "<TH width='3%'><div align='left'><a href=cycle_shows.php?sort_field=6&sort_field_order=$sort_field_order_url>Start Date</a></TH>";
echo "<TH width='3%'><div align='left'><a href=cycle_shows.php?sort_field=8&sort_field_order=$sort_field_order_url>End Date</TH>";
echo "<TH width='3%'><div align='left'>Date Entered</a></TH>";
if (($userID_tab == session_userID) and ($Row[1] <> ""))
	{
		echo "<TH width='3%'><div align='left'>Edit</a></TH>";
	}
	






while ($Row = mysql_fetch_array($result))
{
	if ($bgcolor == "BBBBBB") 
	{
		$bgcolor = "777777";$fcolor="FFFFFF";
	}
	else 
	{
	$bgcolor = "BBBBBB";$fcolor="000000";
	}
	
$show_name_tab = $Row[0];
$username_table_tab = $Row[1];
$show_address_tab = $Row[2];
$show_city_tab = $Row[3];
$show_state_tab = $Row[4];
$show_zipcode_tab = $Row[5];
$comment_tab = $Row[6];
$start_date_tab = $Row[7];
$end_date_tab = $Row[8];
$enter_date_tab = $Row[9];
$userID_tab = $Row[10];
$show_id = $Row[11];

if ($start_date_tab < $today )
{
echo "<TR bgcolor=$bgcolor>";


#{

#$name=$your_name_tab;
#$name = "  ";
#}

#$name = ("<a href=send_email.php?edit_row=$item_id_tab>$username_table_tab</a>");
#echo "<td><font color=$fcolor>$name</td>\n";
#echo "<td><font color=$fcolor>$show_name_tab</td>\n";
echo "<td><font color=$fcolor>$show_name_tab</td>\n";
echo "<td><font color=$fcolor>$show_address_tab</td>\n";
echo "<td><font color=$fcolor>$show_city_tab<br><br>$show_state_tab</td>\n";
#echo "<td><font color=$fcolor>$show_state_tab</td>\n";
echo "<td><font color=$fcolor>$show_zipcode_tab</td>\n"; 
echo "<td><font color=$fcolor>$comment_tab</td>\n";
echo "<td><font  color=$fcolor>$start_date_tab</td>\n";
echo "<td><font color=$fcolor>$end_date_tab</td>\n";
echo "<td><font color=$fcolor>$enter_date_tab</td>\n";


	if ($username_table_tab == $session_username )
	{
		$edit_row = ("<a href=edit_cycle_shows.php?edit_row=$show_id>Edit</a>");
		echo "<td><font color=$fcolor>$edit_row</td>\n";
	}
	else
	{
		#$name=$your_name_tab;
		$name = "  ";
	}
$username__table_tab = " ";
$userID_tab = " ";  #Flush it out for next row to be ready.	
$phpdate =date("d:M:Y", strtotime($date_entered_tab));
echo "\t</tr>\n";


	} #end of if
}

echo "<br>";



echo "</table>\n";
echo "<br>";
print "<table align='center'><tr><td>$loginvar</td></tr></table>";

mysql_free_result($result);
// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
    </span>
    </table>
    <span class="style1">
    </span></div>
  <span class="style1"><align = center>
    <div align="center">
      <p>&nbsp;</p>
	  
      <p><a href="mid_ohio.php"> <img src="../Images/mid_ohio/thumbs/random.php" alt="Image Library" width="120" height="83" border="0" ><title="Mid Ohio Swap Meet 2008" target="_blank">    2008 Mid Ohio Pictures</a></p>
      <p>&nbsp;</p>
	        <p><a href="mid_ohio_2009.php"> <img src="../Images/mid_ohio/thumbs/random.php" alt="Image Library" width="120" height="83" border="0" ><title="Mid Ohio Swap Meet 2008" target="_blank">    2009 Mid Ohio Pictures</a></p>
    </div>
  </align = center>
  </span>
</body>
</html>
