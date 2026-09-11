<?php
require '../includes/auth_check.inc.php';
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';

$Link = mysqli_connect($Host, $User, $Password, $DBName); 

if ($is_logged_in)
{
$loginvar =  "OK" ;
}
if (!$is_logged_in)
{
$loginvar =   "NO" ;
}
//END CHECK LOGIN
#########################################################################################################################################################

#if ($sort_field_url == "")
#{ 
#$sort_field_in =  "order by username" ;}


#**************************************************************************
# The row to select from the Before_after Page selection 
$id_temp_var = $_REQUEST['edit_row'];
#******************************************************************
#print "ID TEMP TEMP VAR $id_temp_var \n";
$Link = mysqli_connect($Host, $User, $Password, $DBName);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
$query = ("SELECT manufacturer, year, model, description from for_sale_wanted where item_row_id = '$id_temp_var'");
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
$Row = mysqli_fetch_array($result);

$manufacturer = $Row[0];
$model = $Row[1];
$year = $Row[2];
$description = $Row[3];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script type="text/javascript">
function goToURL(){ window.location = "http://www.cyclerestorer.com/pages/add_classified_ad_pics.php?edit_row=<?php print "$id_temp_var"?>"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=600,left = 340,top = 212');");
}</script>
<script type="text/javascript">

function validate_required(field,alerttxt)
{
with (field)
{
if (value==null||value=="")
  {alert(alerttxt);return false}
else {return true}
}
}

function validate_form(picture_upload)
{
with (picture_upload)
{
if (validate_required(photo_comment,"The 'Photo Comment' field must be filled out!")==false)
  {photo_comment.focus();return false}
if (validate_required(file_name,"You Must Select A File to Upload")==false)
  {file_name.focus();return false}
}
}
</script>


</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>

<body>
<br>
<br><!-- class="style4 wh_tnr_12" -->
<h3 align='center' >Classified Ad Pictures</h3>
<br>

<table align='center' width="60%" border="1" cellpadding="5">

 
	<tr align='center'>
		
		<td align='right'>
			<h3 align='center' class="style4"> <?php print "$manufacturer"?></h3>
			<h3 align='center' class="style4"> <?php print "$year"?></h3>
			<h3 align='center' class="style4">  <?php print "$model"?></h3>
		</td>
		<td align='left'>		
			<h5> <?php print "$description"?> </h5>			
		</td>	
    </tr>

</table>

<?php

$query = ("SELECT classified_image_library.filename, classified_image_library.pic_comment,  ad_pictures.bike_row_id FROM classified_image_library LEFT JOIN ad_pictures ON classified_image_library.img_lib_rowID = ad_pictures.bike_picture_id where '$id_temp_var' = ad_pictures.registry_row_id");

$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
 $Link = mysqli_connect($Host, $User, $Password, $DBName); 
// Printing results in HTML
echo "<table align='left' width=100% >\n";
echo '<table align=center>';
echo '<tr><td>';
$target_url_in = '/pages/classified_pics.php?edit_row='.$id_temp_var.'';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
if ($loginvar == "OK")
{
print '<form align="center">
<input type=button value="Add More Pictures" onClick="goToURL()">
</form>';
echo '</td></tr>';
}
else
{

print '<form align="center">
<input type=button value="Log In to Add More Pictures" onClick="goToLogin()">
</form>';
}

while ($Row = mysqli_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";}
else {$bgcolor = "BBBBBB";}
$file_name = $Row[0];
$photo_comment = $Row[1];


echo "<TR bgcolor=$bgcolor>";
if ($user_tab == $session_username and ($Row[0] <> ""))
{

#$name = ("<a href=edit_registry.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}

echo "\t\t<td align='left'><A HREF=\"javascript:popUp('../classified_ad_image_upload/$file_name')\"><img src='../classified_ad_image_upload/thumbs/$file_name' align='left'> </td>";
echo "\t\t<td align='center' width = 300>$photo_comment</td>";  
echo "\t</tr>\n\n\n";     

}
echo '<br>';
echo '<p>&nbsp;</p>';

?>
<p>&nbsp;</p>
<?php 

#echo "$loginvar";
echo "<br>";
echo "<br>";

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>