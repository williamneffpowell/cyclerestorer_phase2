<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;


include '../includes/dbconnect.inc.php';

$link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");
$sort_field="";
$logged_in ="";
$login_var = "";
if ($is_logged_in)
{
$logged_in = "yes";
$login_var = "";

}
if (!$is_logged_in)
{
$target_url_in = '/pages/library.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url']?? '0';

$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php"><div align="center">
<div align="center"><span class="style1"><b></b></span>
       <table width="261" border="0" class="index">
        <caption>&nbsp;
        </caption> 
       </table>
       <br>
       <input type="submit" name="submit" value="Login to Edit your bike or send a Message">
       <br>
     </div></Form>';


}

##############################################################################################################################################

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Member Collection</title>
   <script type="text/javascript">
function goToURL(){ window.location = "http://www.cyclerestorer.com/pages/add_classified_ad_pics.php?edit_row=<?php print "$id_temp_var"?>"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=600,left = 204,top = 140');");
}</script>
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
      <th scope="col">Member Collection</th>
    </tr>
    <tr>
      <td><div align="center"><FORM><INPUT TYPE="BUTTON" VALUE="Add your Cycle" ONCLICK="window.location.href='Registry_Add.php'"></FORM></div>
	  <?php echo "$login_var"; ?></td>
      <td><a href="library.php" target="_self"></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center"></div></td>  
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

    <?php
$sort_field_url = $_REQUEST['sort_field'] ?? '0'; 



// Printing results in HTML
echo "<table class='registry' width=100% >\n";

#<div align="center">

$sort_field_url = $_REQUEST['sort_field'] ?? '0';  #URL Variable for which field will be sorted 
$sort_field_order_url = $_REQUEST['sort_field_order'] ?? '0';
if ($sort_field_order_url == "" or $sort_field_order_url == "ascending") 
{ 
    $sort_field_order_url = 'descending';
	 $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 1 or $sort_field_url == "")
	//{$sort_field =  "order by manufacturer ASC" ;}
	{$sort_field =  "order by entered DESC" ;}
	elseif ($sort_field_url == 3)
	{$sort_field = "order by year ASC";}
	elseif ( $sort_field_url == 5)
	{$sort_field = "order by username ASC";}
	elseif ( $sort_field_url == 4)
	{$sort_field = "order by model ASC";}
	elseif ( $sort_field_url == 11)
	{$sort_field = "order by entered ASC";}


}
	else
  		{ $sort_field_order_url = "ascending";
		   $_SESSION['sort_field_order'] = "$sort_field_order_url" ;
	if ($sort_field_url == 1 )
	{$sort_field =  "order by manufacturer DESC" ;}
	elseif ($sort_field_url == 3)
	{$sort_field = "order by year DESC";}
	elseif ( $sort_field_url == 5)
	{$sort_field = "order by username DESC";}
	elseif ( $sort_field_url == 4)
	{$sort_field = "order by model DESC";}
		elseif ( $sort_field_url == 11)
	{$sort_field = "order by entered DESC";}


}


if ($logged_in == "yes" ) 
{
echo "<TR><TH width='5%'><div align='left'>Edit<br>Message</TH>";
}

echo "<TH width='8%'><div align='left'><a href=library.php?sort_field=1&sort_field_order=$sort_field_order_url>Manufacturer</a>";
echo " <a href=library.php?sort_field=2 target='_self'></a></TH>";
echo "<TH width='5%'><div align='left'><a href=library.php?sort_field=4&sort_field_order=$sort_field_order_url>Model</a>";
echo " <a href=library.php?sort_field=9 target='_self'></a></TH>";
echo "<TH width='4%'><div align='left'><a href=library.php?sort_field=3&sort_field_order=$sort_field_order_url>Year</a>";
echo " <a href=library.php?sort_field=8 target='_self'></a></TH>";
echo "<TH width='10%'><div align='left'><a href=library.php?sort_field=5&sort_field_order=$sort_field_order_url>Username</a>";
echo " <a href=library.php?sort_field=7 target='_self'></a>";
echo " </TH><TH width='10%'><div align='left'>Location</TH>";
echo " </TH><TH width='10%'><div align='left'><a href=library.php?sort_field=11&sort_field_order=$sort_field_order_url>entered</a>";

echo "<TH width='15%'><div align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comment&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TH>";
if ($logged_in == "yes" ) {
echo "<TH width='3%'><div align='left'>Send<br>Message</TH>\n";
}
echo "<TH width='3%'><div align='center'>Restoration<br>Projects</TH>\n";

echo "<TH width='3%'><div align='left'>Picture</TH></TR>\n";
#where r.type_of_entry = 'Registry'  This used to be in the querry but I'm showing all bikes now. 
$query = "";

$query = "(SELECT r.username,r.row_id,r.action,r.manufacturer,r.model,r.year,r.serial_number,r.owner,r.location,r.comments,r.entered,b.row_id,p.picID,p.filename,p.caption,r.picID,r.userID,entered FROM registry as r LEFT JOIN before_after as b ON r.row_id = b.registration_row_id LEFT JOIN  tb_pictures as p ON r.picID = p.picID  $sort_field)";	

//$result = mysql_query($query) or die('Query failed: ' . mysql_error());
/* activate reporting */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
    $result = mysqli_query($link, $query);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
}
	
$bgcolor = "";
$fcolor="";
#if ($logged_in == "yes" ) {
while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";$fcolor="FFFFFF";}
else {$bgcolor = "BBBBBB";$fcolor="000000";}

$user_tab = $Row[0] ?? '0';
$row_id_tab = $Row[1]?? '0';
$action_tab = $Row[2]?? '0';
$manufacturer_tab = $Row[3]?? '0';
$model_tab = $Row[4]?? '0';
$year_tab = $Row[5]?? '0';
$serial_number_tab = $Row[6]?? '0';
$owner_tab = $Row[7]?? '0';
$location_tab = $Row[8]?? '0';
$comments_tab = $Row[9]?? '0';
#entered $Row [10]
$before_after_tab = $Row[11]?? '0';
$bike_picture_id_tab = $Row[12]?? '0';
$file_name = $Row[13]?? '0';
$row_pick_it_tab = $Row[16]?? '0';
$recpid = $Row[16]?? '0';
$entered_tab = $Row[17]?? '0';
#echo "<h3>reg Userid= $reg_userid</h3>";
echo "<TR bgcolor=$bgcolor>";

#echo "reg_row_ID = $row_id_tab";

if ($logged_in == "yes" ) {
    if ($user_tab == $session_username and ($Row[0] <> ""))
       {
        $name = ("<a href=edit_registry.php?edit_row=$row_id_tab&picID=$bike_picture_id_tab>Edit</a>");
		echo "\t\t<td><font color=$fcolor>$name</td>\n";
		}
	else 
		{
		echo "\t\t<td><font color=$fcolor>&nbsp;</td>\n";
		}
}

echo "\t\t<td><font color=$fcolor>$manufacturer_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$model_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$year_tab</td>\n";
echo "\t\t<td><a href=user_library.php?user_library_var=$user_tab&type_entry_var=Registry>$user_tab</a>\n";
echo "\t\t<td><font color=$fcolor>$location_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$entered_tab</td>\n";
echo "\t\t<td><font color=$fcolor>$comments_tab</td>\n";


#recipient user id = recpid = $row_id_tab
#recipient username = recpnm = $owner_tab




if ($logged_in == "yes" ) {
if ($user_tab <> $session_username ) 
{
			
     #echo "<h1>$message</h1>";
	 

echo "\t\t<td><a href=http://www.cyclerestorer.com/pages/send_email.php?recpnm=$user_tab&recpid=$recpid><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>";

 
// OLD FILE echo "\t\t<td><a href=http://www.cyclerestorer.com/pages/send_email_r.php?recpnm=$user_tab&recpid=$row_pick_it_tab&regid=$row_id_tab><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>";

#echo "\t\t<td><a href=send_message.php?sub=Your&nbsp;$manufacturer_tab&nbsp;$year_tab&nbsp;$model_tab&nbsp;on&nbsp;cyclerestorer&rec=$user_tab><IMG SRC=../Images/icons/email_icon.gif border=0></a></td>"; 
}
else
{
echo "<td><a>&nbsp;</a></td>\n";
}
}


if ($before_after_tab <> "")
{
echo "<td><a align=center href=restoration_pics.php?edit_row=$before_after_tab>View Restoration</a></td>\n";
}
else
{
echo "<td><a>&nbsp;</a></td>\n";
}


############################ Show the Registration Image ################################################
if ($bike_picture_id_tab <> "")
{
#echo "<td><a href=registry_pics.php?edit_row=$row_id_tab&pic_id=$bike_picture_id_tab><A HREF=\"javascript:popUp('../image_upload/$file_name')\"><img src='../image_upload/thumbs/$file_name' align='left'></a></td>\n";
echo "<td><a href=view_collection_info.php?picID=$bike_picture_id_tab&edit_row=$row_id_tab><img src='../image_upload/thumbs/$file_name'></a></td>\n";
#echo "<td><a href=add_registry_pics.php?picID=$bike_picture_id_tab&edit_row=$row_id_tab><A HREF=\"javascript:popUp('../image_upload/$file_name')\"><img src='../image_upload/thumbs/$file_name' align='left'></a></td>\n";


}
else
{
echo "<td>&nbsp;</td>";
}

if (logged_in == "yes") 
{
	if ($bike_picture_id_tab == "" and $logged_in == "yes" and  $user_tab == $session_username   )
	{
	echo "<td><a href=add_registry_pics.php?picID=$bike_picture_id_tab&edit_row=$row_id_tab>Add/Edit<br>Pic</a></td>\n";
	}
	else
	{
	echo "<td><a>&nbsp;</a></td>\n";
	}
}
###########################################################################################################

echo "\t</tr>\n";
}  #END OF WHILE STATEMENT
echo "</table>\n";


mysqli_free_result($result);

// Closing connection
#mysql_close($link);
?>
</p><?php 
include 'bottom_index_table.php';
//include '../includes/analytics.inc.php';
?>
</div>
</body>
</html>