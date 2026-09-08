<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../restoration_techniques.php';
   //including phpBB3 stuff   
  // define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();

$session_username = $user->data['username'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

if ($user->data['is_registered'])
{
# LOGIN OK
$logged_in_var = "yes";
$loginvar =  '<form align="center">
<input type=button value="Add a Restoration Technique" onClick="goToadd_link()">
</form>';
}
if (!$user->data['is_registered'])
{
$logged_on = "no";
$target_url_in = '/pages/restoration_techniques.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit a Technique" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_rest_techniques.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>

   <title>Restoration Techniques</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1>Restoration Techniques </h1>
<br>
<h5>Click on Username to contact Author</h5>
</div>


  <?php

$item_id_temp = " ";
$sort_field_url = $_GET['sort_field'];  #URL Variable for which field will be sorted  
$sort_field_order_url = $_GET['sort_field_order'];
if ($sort_field_order_url == "" or $sort_field_order_url == "ascending") 
{ 
    $sort_field_order_url = 'descending';
	
    $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 5 or $sort_field_url == "")
	{$sort_field_in =  "order by date_entered ASC" ;}
	elseif ($sort_field_url == 2)
	{$sort_field_in = "order by year ASC";}
	elseif ($sort_field_url == 7)
	{$sort_field_in = "order by manufacturer ASC";}
	elseif ( $sort_field_url == 4)
	{$sort_field_in = "order by model ASC";}
	elseif ( $sort_field_url == 6)
	{$sort_field_in = "order by cost ASC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by date_entered ASC";}
		
	}
	else
  		{ $sort_field_order_url = "ascending";
		   $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 5 )
	{ $sort_field_in =  "order by manufacturer DESC" ;}
	elseif ( $sort_field_url == 2)
	{ $sort_field_in =  "order by year DESC" ;}
	elseif ( $sort_field_url == 4)
	{$sort_field_in = "order by model DESC";}
	elseif ( $sort_field_url == 6)
	{$sort_field_in = "order by cost DESC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by date_entered DESC";}

}


mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "(SELECT DISTINCT  tb_rest_tech.rest_technique,tb_rest_tech.your_name,tb_rest_tech.username,tb_rest_tech.manufacturer,tb_rest_tech.model,tb_rest_tech.description,tb_rest_tech.cost,tb_rest_tech.date_entered,tb_rest_tech.state,tb_rest_tech.country, tb_rest_tech.item_title, tb_rest_tech.item_row_id, tb_rest_tech.parts_bike,tb_rest_tech.year, ad_pictures.bike_picture_id FROM tb_rest_tech LEFT JOIN ad_pictures ON tb_rest_tech.item_row_id = ad_pictures.registry_row_id  $sort_field_in)";	

#$query = "SELECT * FROM tb_rest_tech $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table width='100%' align='center'  class='classified' cellspacing='0'>\n";
echo "<TH width='7%'><div align='left'>Technique<br>Title</TH>";
echo "<TH width='3%'><div align='center'><a href=restoration_techniques.php?sort_field=7&sort_field_order=$sort_field_order_url>Make</a></TH>";
echo "<TH width='5%'><div align='left'><a href=restoration_techniques.php?sort_field=4&sort_field_order=$sort_field_order_url>Model</a><br><a href=restoration_techniques.php?sort_field=2&sort_field_order=$sort_field_order_url>Year</a></TH>";
echo "<TH width='70%'><div align='Center'>Description</TH>";
echo "<TH width='3%'><div align='left'><a href=restoration_techniques.php?sort_field=6&sort_field_order=$sort_field_order_url>Cost</a></TH>";
echo "<TH width='5%'><div align='left'>Username<br><a href=restoration_techniques.php?sort_field=8&sort_field_order=$sort_field_order_url>Date Entered</a></TH>";
# echo "<TH width='2%'><div align='left'>State Country</TH>";
if ($logged_in_var == "yes")
    {
	 echo "<TH width ='2%'><div align='Center'>Edit</TH>";
	 echo "<TH width ='2%'><div align='Center'>Add<br>Image</TH>";
	 }
echo "<TH width='5%'><div align='Center'>Image</TH>";

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
$tb_rest_tech_tab = $Row[0];
$your_name_tab=$Row[1];
$username_tab=$Row[2];
$manufacturer_tab = $Row[3];
$model_tab = $Row[4];
$description_tab = $Row[5];
$cost_tab = $Row[6];
$date_entered_tab = $Row[7];
$state_tab = $Row[8];
$country_tab = $Row[9];
$condition_tab = $Row[10];
$item_id_tab = $Row[11];
$parts_bike = $Row[12];
$year_tab = $Row[13];
$bike_picture_id_tab = $Row[14];

$phpdate =date("d:M:Y", strtotime($date_entered_tab));

if ($item_id_tab <> $item_id_temp)
{
echo "<TR bgcolor=$bgcolor>";
#echo "<td><font color=$fcolor><a href=\"http://$html_link\"" .">$html_link</strong></a></td>\n";
	

#{

#$name=$your_name_tab;
#$name = "  ";
#}
#$name = ("\t\t<td><a href=send_message.php?sub=$tb_rest_tech_tab&nbsp;&rec=$username><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>"); 
#$name = ("<a href=send_email.php?edit_row=$item_id_tab>$username_tab</a>");
echo "<td><font color=$fcolor>$tb_rest_tech_tab<br><br>$condition_tab</td>\n";
echo "<td><font color=$fcolor>$manufacturer_tab</td>\n";
echo "<td><font color=$fcolor>$model_tab<br><br>$year_tab</td>\n";
echo "<td width='70%'><font color=$fcolor>$description_tab</td>\n";
echo "<td><font color=$fcolor>$cost_tab</td>\n";
#echo "<td><font color=$fcolor><a href=send_message.php?rec=$username_tab&nbsp;&sub=$condition_tab><IMG SRC=../Images/icons/email_icon.gif border=0></a><br><br>$phpdate</td>\n";
echo "<td>&nbsp;</td>";
#echo "<td><font color=$fcolor>$state_tab<br><br>$country_tab</td>\n";
#echo "<td><font color=$fcolor>$parts</td>\n";

if ($logged_in_var == "yes")
{
   if (($username_tab == $session_username) and ($Row[2] <> ""))
	{
		$edit_row = ("<a href=edit_rest_techiques.php?edit_row=$item_id_tab>Edit</a>");
		echo "<td><font color=$fcolor>$edit_row</td>\n";
		echo "<td><a href=add_rest_techniques_pics.php?edit_row=$item_id_tab>Add Pics</a></td>\n";
	}
	else
	{
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
	$name = "  ";
	}
}	
if  ( $bike_picture_id_tab <> "")
		{
		echo "<td><a font color=$fcolor href=rest_techniques_pics.php?edit_row=$item_id_tab>View</a></td>";
        }
		else
		{
		echo "<td>&nbsp;</td>";
		}
$username_tab = " ";	

echo "\t</tr>\n";
$item_id_temp = $item_id_tab;
echo "<br>";

}



}
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

</body>
</html>
