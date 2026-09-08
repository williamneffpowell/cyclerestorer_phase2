<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../classified_ads.php';
   //including phpBB3 stuff   
  // define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);

session_start();

$session_username = $user->data['username'];
$session_userid= $user->data['user_id'];	


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 


$_SESSION['email_id_authenticated'] ="no";   #initialize the this variable that will be used in send_email.php and formhandler.php

if ($user->data['is_registered'])
{
# LOGIN OK
$logged_in_var = "yes";
$loginvar =  '<form align="center">
<input type=button value="Add or Edit a Classified Ad" onClick="goToadd_link()">
<input type=button value="Add or Edit a Part" onClick="goToadd_part_link()">
</form>';
}
if (!$user->data['is_registered'])
{
$logged_on = "no";
$target_url_in = '/pages/classified_ads.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit an ad, or to contact a seller" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_identify_part.php"; }
function goToadd_part_link(){ window.location = "http://www.cyclerestorer.com/pages/add_classified_parts.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>

   <title>Identify This Part</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>

<div align="center">
  <h1>&nbsp;</h1>
<h1>Classified Ads </h1>
<br>
<h5>Click on Username to contact seller</h5>
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
	{$sort_field_in = "order by price ASC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by date_entered ASC";}
	elseif ( $sort_field_url == 9)
	{$sort_field_in = "order by state ASC";}		
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
	{$sort_field_in = "order by price DESC";}
	elseif ( $sort_field_url == 8)
	{$sort_field_in = "order by date_entered DESC";}
	elseif ( $sort_field_url == 9)
	{$sort_field_in = "order by state DESC";}
}


mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "(SELECT DISTINCT  f.for_sale_wanted,f.user_name,f.username,f.manufacturer,f.model,f.description,
f.price,f.date_entered,f.state,f.country, f.item_condition, f.item_row_id, f.parts_bike,f.year,
 a.bike_picture_id,f.title,f.userID,c.filename  FROM for_sale_wanted as f 
LEFT JOIN ad_pictures as a ON f.item_row_id = a.registry_row_id 
LEFT JOIN classified_image_library as c ON a.bike_picture_id = c.img_lib_rowID  $sort_field_in)";	



#$query = ("SELECT classified_image_library.filename, classified_image_library.pic_comment,  
#ad_pictures.bike_row_id FROM classified_image_library 
#LEFT JOIN ad_pictures ON classified_image_library.img_lib_rowID = ad_pictures.bike_picture_id where '$id_temp_var' = ad_pictures.registry_row_id");



#$query = "SELECT * FROM for_sale_wanted $sort_field_in ";
#print "$query\n";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 
// Printing results in HTML
echo "<table width='100%' align='center'  class='classified' cellspacing='0'>\n";
echo "<TH width='7%'><div align='left'>For Sale<br>Wanted Condition</TH>";
echo "<TH width='3%'><div align='center'><a href=classified_ads.php?sort_field=7&sort_field_order=$sort_field_order_url>Make</a></TH>";
echo "<TH width='5%'><div align='left'><a href=classified_ads.php?sort_field=4&sort_field_order=$sort_field_order_url>Model</a><br><a href=classified_ads.php?sort_field=2&sort_field_order=$sort_field_order_url>Year</a></TH>";
echo "<TH width='70%'><div align='Center'>Title / <br> Description </TH>";
echo "<TH width='3%'><div align='left'><a href=classified_ads.php?sort_field=6&sort_field_order=$sort_field_order_url>Price</a></TH>";
echo "<TH width='5%'><div align='left'>Username<br><a href=classified_ads.php?sort_field=8&sort_field_order=$sort_field_order_url>Date Entered</a></TH>";
echo "<TH width='2%'><div align='left'>State Country</TH>";
if ($logged_in_var == "yes")
    {
	 echo "<TH width ='2%'><div align='Center'>Edit<br>ad</TH>";
	 echo "<TH width ='2%'><div align='Center'>Message</TH>";
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
$for_sale_wanted_tab = $Row[0];
$user_name_tab=$Row[1];
$username_tab=$Row[2];
$manufacturer_tab = $Row[3];
$model_tab = $Row[4];
$description_tab = $Row[5];
$price_tab = $Row[6];
$date_entered_tab = $Row[7];
$state_tab = $Row[8];
$country_tab = $Row[9];
$condition_tab = $Row[10];
$item_id_tab = $Row[11];
$parts_bike = $Row[12];
$year_tab = $Row[13];
$bike_picture_id_tab = $Row[14];
$title_tab = $Row[15];
$user_id = $Row[16];
$file_name = $Row[17];

$phpdate =date("d:M:Y", strtotime($date_entered_tab));

if ($item_id_tab <> $item_id_temp)
{
echo "<TR bgcolor=$bgcolor>";
#echo "<td><font color=$fcolor><a href=\"http://$html_link\"" .">$html_link</strong></a></td>\n";
	if ($parts_bike == "YES")
	{

		if (($username_tab == $session_username) and ($Row[2] <> ""))
		{
	    	$parts = ("<a href=classified_parted_out.php?edit_row=$item_id_tab>Edit Parts</a>");
		}
		else
		{
			/* Make this so that if it is a logged in owner then edit, otherwise just parts....*/
			$parts = ("<a href=classified_parted_out.php?edit_row=$item_id_tab>Parts</a>");
		}
 	}
	else
	{
	$parts="";
	} #end of parts bike if


#{

#$name=$your_name_tab;
#$name = "  ";

$message_name = $username_tab ;
$name = ("<a>$username_tab</a>");
echo "<td><font color=$fcolor>$for_sale_wanted_tab<br><br>$condition_tab</td>\n";
echo "<td><font color=$fcolor>$manufacturer_tab</td>\n";
echo "<td><font color=$fcolor>$model_tab<br><br>$year_tab</td>\n";
echo "<td width='70%'><font color=$fcolor><b>$title_tab</b><br><font color=$fcolor>$description_tab</td>\n";
echo "<td><font color=$fcolor>$price_tab</td>\n";
echo "<td><font color=$fcolor>$name<br><br>$phpdate</td>\n";
echo "<td><font color=$fcolor>$state_tab<br><br>$country_tab</td>\n";
#echo "<td><font color=$fcolor>$parts</td>\n";

if ($logged_in_var == "yes")
{
   if (($username_tab == $session_username) and ($Row[2] <> ""))
	{
		$edit_row = ("<a href=edit_classified_ad.php?edit_row=$item_id_tab>Edit</a>");
		echo "<td><font color=$fcolor>$edit_row</td>\n";
		echo "<td>&nbsp;</td>";
	
		echo "<td><a href=add_classified_ad_pics.php?edit_row=$item_id_tab>Add Pics</a></td>\n";
		
	
	}
	else 
	{
	 echo "<td>&nbsp;</td>\n";
              #This sends the email to PHPBB Mail Server
			  #Recpnm=Recipient Username
			  
			  
			  
			  
			echo "\t\t<td><a href=http://www.cyclerestorer.com/pages/send_email.php?recpnm=$username_tab&recpid=$user_id&ad_id=$item_id_tab><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>";
	#echo "\t\t<td><a href=http://www.cyclerestorer.com/phpBB3/ucp.php?i=pm&mode=compose><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>";
		
			}
	

	
	 if (($username_tab == $session_username) and ($Row[2] <> ""))
	{
		echo "<td>&nbsp;</td>";#echo "&nbsp";#echo "<td><a href=add_classified_ad_pics.php?edit_row=$item_id_tab>Add Pics</a></td>\n";
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
		echo "<td><a font color=$fcolor href=classified_pics.php?edit_row=$item_id_tab><img src='../classified_ad_image_upload/thumbs/$file_name' align='left'></a></td>";
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
