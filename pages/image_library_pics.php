<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;

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
$id_temp_var = $_GET['edit_row'];
#******************************************************************
#print "ID TEMP TEMP VAR $id_temp_var \n";
$Link = mysqli_connect($Host, $User, $Password, $DBName);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
$query = ("SELECT manufacturer, year, model from image_library_registry where row_id = '$id_temp_var'");
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
$Row = mysqli_fetch_array($result);

$manufacturer = $Row[0];
$model = $Row[1];
$year = $Row[2];


$query = ("SELECT image_library.filename, image_library.pic_comment,  bike_pictures.bike_row_id FROM image_library LEFT JOIN bike_pictures ON image_library.img_lib_rowID = bike_pictures.bike_picture_id where '$id_temp_var' = bike_pictures.registry_row_id");



#print "$query\n";
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
 $Link = mysqli_connect($Host, $User, $Password, $DBName); 
// Printing results in HTML
echo "<table align='left' width=100% >\n";
echo '<table align=center>';
echo '<tr><td>';
if ($loginvar == "OK")
{
print '<form align="center">
<input type=button value="Add More Pictures" onClick="goToURL()">
</form>';
echo '</td></tr>';
}
else
{
$target_url_in = '/pages/image_library_pics.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
print '<form align="center">
<input type=button value="Log In to Add More Pictures" onClick="goToLogin()">
</form>';
}

echo '<br>';
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

echo "\t\t<td align='left'><A HREF=\"javascript:popUp('../image_library_upload/$file_name')\"><img src='../image_library_upload/thumbs/$file_name' align='left'> </td>";
echo "\t\t<td align='center' width = 300>$photo_comment</td>";  
echo "\t</tr>\n\n\n";     

}
echo '<br>';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script type="text/javascript">
function goToURL(){ window.location = "http://www.cyclerestorer.com/pages/add_image_library_pics.php?edit_row=<?php print "$id_temp_var"?>"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php?edit_row=<?php print "$id_temp_var"?>"; }
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
<br>
<h3 align='center' class="style4 wh_tnr_12">Image Library Pictures</h3>
<br>
<h3 align='center' class="style4"> <?php print "$manufacturer"?></h3>
<h3 align='center' class="style4"> <?php print "$year"?></h3>
<h3 align='center' class="style4">  <?php print "$model"?></h3>  

<p>

</p>
<br>
<?php 

#echo "$loginvar";
echo "<br>";
echo "<br>";

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>