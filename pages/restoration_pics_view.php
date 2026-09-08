 <?php
 //restoration_pics_view.php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';
	$link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");
$session_username = $session_username ?? '0';


//if ($is_logged_in){






//$logged_in = "yes";
//$login_var = "";

//}
/*  if (!$is_logged_in)
{
$target_url_in = '/pages/restoration_pics_view.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'] ?? '0';

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
} */
//END CHECK LOGIN
#########################################################################################################################################################
#**************************************************************************
# The row to select from the Before_after Page selection
$bef_aft_row = isset($_GET['bef_aft_row']) ? (int) $_GET['bef_aft_row'] : 0;
$td_var = isset($_GET['td_var']) ? (int) $_GET['td_var'] : 0;
#******************************************************************


?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function goToAddPicURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_pics.php?bfore_aftr_row_id=<?php print"$id_temp_var"?>"; }
function goToEditPicURL(){ window.location = "http://www.cyclerestorer.com/pages/edit_restoration_pics.php?edit_row=<?php print"$id_temp_var"?>"; }
function goToAddLogURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_log_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&todo_or_log=log"; }
function goToAddToDoURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_log_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&todo_or_log=todo"; }
function goToAddPartsURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_parts_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>"; }
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=1600,height=800,left = 20,top = 50');");
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
</head>
<body>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<p>
</p>
<br>
<?php
#$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
#mysql_select_db("$DBName") or die(mysql_error());



if ($sort_field_url == "")
{
$sort_field_in =  "order by username" ;}

#print "ID TEMP TEMP VAR $id_temp_var \n";

$query = "";
$query = ("SELECT b.restoration_title, b.username from before_after as b  where b.row_id = '$id_temp_var' ");


$stmt = $link->prepare("SELECT b.restoration_title, b.username FROM before_after AS b WHERE b.row_id = ?");
$stmt->bind_param("i", $id_temp_var);
$stmt->execute();
$result = $stmt->get_result();
$Row = $result->fetch_array(MYSQLI_NUM);



$restoration_title = $Row[0] ?? '0';
$username = $Row[1] ?? '0';

?>
<body>
<h2>&nbsp;</h2>


<?php



$Query2 = "SELECT COUNT(*) FROM  before_after_pics WHERE before_after_row_id  = '$bef_aft_row'";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
    $Result2 = mysqli_query($link, $Query2);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
}




$Row = mysqli_fetch_array($Result2, MYSQLI_NUM);




$total_pictures = $Row[0];



$query = "SELECT filename, pic_comment, pic_enter_date FROM before_after_pics WHERE before_after_row_id = ? AND pic_display_order = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("ii", $bef_aft_row, $td_var);
$stmt->execute();
$result = $stmt->get_result();









mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
   //* this WILL NOT report any errors even if index is not available */
    $result = mysqli_query($link, $query);
} catch (mysqli_sql_exception $e) {
    error_log($e->__toString());
}



// Printing results in HTML
echo "<table align='left' width=80% >\n";
echo '<table align=center>';

echo '<br>';

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))
{
$file_name = $Row[0] ?? '0';
$photo_comment = $Row[1] ?? '0';
$pic_enter_date = $Row[2] ?? '0';
$td_backward=$td_var;
$td_tempbackward=$td_var;
$td_backward--;

    if ($td_backward < 1)
        {
        $td_backward=1;
        }
    
    $td_forward=$td_var;
    $td_temp_forward = $td_var;
    $td_forward++;
    
    if ($td_forward > $total_pictures)
        {
        $td_forward=$total_pictures;
        }

    if ($username <> $session_username and ($Row[0] <> ""))
        {
        }
        else
        {
        $name = "  ";
        }
?>
<tr> <td align="center">
<?php
    
    if ($td_tempbackward == 1)
        {
        echo "<img src='../Images/taillight_on.jpg' >";
        }
        else
        {
        echo "<img src='../Images/taillight_off.jpg' >";
        }
?>


<!-- <div s<div style="text-align:left; width:100px; margin-left:auto; margin-right:auto;"> -->
<img id="Image-Maps_4201112270945232" src="https://www.cyclerestorer.com/Images/cropped_turn.jpg" usemap="#Image-Maps_4201112270945232" border="0" width="100" height="91" alt="" />
<map id="_Image-Maps_4201112270945232" name="Image-Maps_4201112270945232">
    
<area shape="rect" coords="49,3,95,86" href="https://www.cyclerestorer.com/pages/restoration_pics_view.php?bef_aft_row=<?php echo htmlspecialchars($bef_aft_row); ?>&td_var=<?php echo htmlspecialchars($td_forward); ?>" alt="right" title="right" onMouseOver="if(document.images) document.getElementById('Image-Maps_4201112270945232').src= 'https://www.cyclerestorer.com/Images/cropped_turn_right.jpg';" onMouseOut="if(document.images) document.getElementById('Image-Maps_4201112270945232').src= 'https://www.cyclerestorer.com/Images/cropped_turn.jpg';" />    
 <area shape="rect" coords="2,3,52,86" href="http://www.cyclerestorer.com/pages/restoration_pics_view.php? bef_aft_row=<?php echo htmlspecialchars($bef_aft_row); ?>&td_var=<?echo htmlspecialchars($td_backward);?>" alt="left" title="left" onMouseOver="if(document.images) document.getElementById('Image-Maps_4201112270945232').src= 'http://www.cyclerestorer.com/Images/cropped_turn_left.jpg';" onMouseOut="if(document.images) document.getElementById('Image-Maps_4201112270945232').src= 'http://www.cyclerestorer.com/Images/cropped_turn.jpg';"  />
<!--<area shape="rect" coords="96,87,98,89" href="http://www.image-maps.com/index.php?aff=mapped_users_4201112270945232" alt="Image Map" title="Image Map" />-->
</map>
<!-- </div> -->


<?php

#$is_last = $total_pictures - td_forward;


    if ($td_temp_forward == $total_pictures) 
    {
    echo "<img src='../Images/taillight_on.jpg' >";
    }
    else
    {
    echo "<img src='../Images/taillight_off.jpg' >";
    }
?>
</td>
<td align="center">

</td>
</tr>
<tr>
<td>
<p><img src='../image_upload/<?php echo "$file_name"?>' alt='<?php echo "$photo_comment"?> &nbsp; <?php echo "$pic_enter_date"?>' border='0'><br>
 </td>
</tr>
</table>
    <?php

    } //The end of the while loop.
    
    echo '<br>';
    
    
    ?>
<table align="center">
<tr align="center">
<td >

 <?php
//echo "<h5> Username = $username Session_username= $session_username </h5>";

    if ($username == $session_username)
    { //and ($Row[0] <> ""
    print '<form align="center"><input type=button value="Add a Picture" onClick="goToAddPicURL()"></form>';
    print '<form align="center"><input type=button value="Edit Picture Layout" onClick="goToEditPicURL()"></form>';
    echo '</td><td>';
    }


?>
</td></tr></table>
<table align="center" class='journal'  >
	</table>
</table>
<?php

#echo "$loginvar";
echo "<br>";
echo "<br>";

include 'bottom_index_table.php';
//include '../includes/analytics.inc.php';
?>

</body>
</html>
