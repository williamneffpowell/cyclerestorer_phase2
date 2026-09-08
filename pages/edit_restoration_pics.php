<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password);


if ($is_logged_in)
{
$logged_in = "yes";
$login_var = "";

}
if (!$is_logged_in)
{
$target_url_in = '/pages/edit_restoration_pics.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

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
//END CHECK LOGIN
#########################################################################################################################################################
#**************************************************************************
# The row to select from the Before_after Page selection
$id_temp_var = $_REQUEST['edit_row'];
$todo_or_log = $_REQUEST['log_or_todo'];
#******************************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script type="text/javascript">
function goToAddPicURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_pics.php?bfore_aftr_row_id=<?php print"$id_temp_var"?>"; }

function sendpicforwardURL(pic_display_order){ window.location = "http://www.cyclerestorer.com/pages/adjust_restoration_pics.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&pic_display_order="+pic_display_order+"&pic_action=Forward"; }
function sendpicbackURL(pic_display_order){ window.location = "http://www.cyclerestorer.com/pages/adjust_restoration_pics.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&pic_display_order="+pic_display_order+"&pic_action=Back"; }

function deletepicURL(pic_display_order){ window.location = "http://www.cyclerestorer.com/pages/adjust_restoration_pics.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&pic_display_order="+pic_display_order+"&pic_action=Delete"; }


function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>"; }
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


<p>

</p>
<br>
<?

if ($sort_field_url == "")
{
$sort_field_in =  "order by username" ;}

#print "ID TEMP TEMP VAR $id_temp_var \n";
$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
mysql_select_db("$DBName") or die(mysql_error());

$query = ("SELECT b.restoration_title, b.username from before_after as b  where b.row_id = '$id_temp_var' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$restoration_title = $Row[0];
$username = $Row[1];

?>
<body>
<h2>&nbsp;</h2>
<h1 align='center' class="style4 wh_tnr_12">Edit Picture Layout</h1>
<h2>&nbsp;</h2>
<br>
<table align="center" border="1">
<td>
<h3 align='center' class="style4"> <?php print "$restoration_title"?></h3>
<h3 align='center' class="style4"> Presented by <?php print "$username"?></h3>
</td>
</tr>
</table>
	<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Pictures </h5></TD></tr>
	</table>



<?
$query = ("SELECT  filename,pic_comment,pic_enter_date,pic_display_order from before_after_pics  where before_after_row_id ='$id_temp_var' order by pic_display_order, pic_enter_date");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password);
// Printing results in HTML
echo "<table align='left' width=80% >\n";
echo '<table align=center>';
#######################33 echo '<tr><td>';
#echo "<a align='center' href=_restoration_pics.php?bfore_aftr_row_id=$id_temp_var>Add a Picture</a>";


echo '<br>';
$td_var = 1;
while ($Row = mysql_fetch_array($result))
{
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";}
else {$bgcolor = "BBBBBB";}
if ($td_var == '0' )
{
echo "<TR bgcolor=$bgcolor>";
}
# echo "<h5>td_var value = $td_var</h5>";

#$user_tab = $Row[0];
#$restoration_title = $Row[3];
$file_name = $Row[0];
$photo_comment = $Row[1];
$pic_enter_date = $Row[2];
$pic_display_order = $Row[3];

#echo "<TR bgcolor=$bgcolor>";
if ($logged_in == "yes" and ($Row[0] <> ""))
{

#$name = ("<a href=edit_registry.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}

echo "\t\t<td align='left' width= 50 ><A HREF=\"javascript:popUp('../image_upload/$file_name')\"><img src='../image_upload/thumbs/$file_name' alt='$photo_comment &nbsp; $pic_enter_date' align='left'>";
#print "id_temp_var $id_temp_var";
$sql = "SELECT COUNT(*) FROM before_after_pics where before_after_row_id = '$id_temp_var'";
$results = mysql_query($sql) or die(mysql_error());
#print "$results";
$total_rows = mysql_fetch_row($results); 
$total_rows_var = $total_rows[0];
#print "$total_rows_var";

#if (!$is_logged_in)
#{
if ($pic_display_order <> $total_rows_var )
{
print "<input type=button value=Forward onClick=sendpicforwardURL('$pic_display_order')>";
}
if ($pic_display_order <> 1 )
{
print "<input type=button value=Back onClick=sendpicbackURL('$pic_display_order')>";
}
if ($pic_display_order == $total_rows_var)
{
print "<input type=button value=Delete onClick=deletepicURL('$pic_display_order')>";
}
print "</td>";
#}
#echo "\t\t<td align='center' width = 200>$photo_comment</td>";
#echo "\t\t<td align='center' width = 50>$pic_enter_date</td>";
#echo "\t</tr>\n\n\n";

if ($td_var == 5 )
{
echo "</tr>";
$td_var = 0;
}

$td_var++;

}
echo '<br>';

?>
<table align="center">
<tr align="center">
<td >

<?


if (!$is_logged_in)
{
print '<form align="center"><input type=button value="Add a picture" onClick="goToAddPicURL()"></form>';
echo '</td><td>';
}
else
{
echo '<br>';
echo '<td>';
$target_url_in = '/pages/before_after.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
print '<form align="center">
<input type=button value="Log In to add Pictures, Parts, Log Entries, and Send Messages" onClick="goToLogin()">
</form>';
}
?>
</td>

</tr>

</table>

</table>
<br>
<table align="center">
<tr align="center">
<td >


</tr>
</table>
	<hr size="10" noshade >


<?php

#echo "$loginvar";
echo "<br>";
echo "<br>";

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>
