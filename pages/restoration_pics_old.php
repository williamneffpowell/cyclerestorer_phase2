<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../restoration_pics.php';
   //including phpBB3 stuff   
  // define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();
include '../includes/dbconnect.inc.php';
	mysql_connect("$Host","$User","$Password");
$session_username = $user->data['username'];


if ($user->data['is_registered']){

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password);
$Result = mysql_db_query ($DBName, $Query, $Link);


$logged_in = "yes";
$login_var = "";

}
if (!$user->data['is_registered'])
{
$target_url_in = '/pages/restoration_pics.php';
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
function goToEditPicURL(){ window.location = "http://www.cyclerestorer.com/pages/edit_restoration_pics.php?edit_row=<?php print"$id_temp_var"?>"; }
function goToAddLogURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_log_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&todo_or_log=log"; }
function goToAddToDoURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_log_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>&todo_or_log=todo"; }
function goToAddPartsURL(){ window.location = "http://www.cyclerestorer.com/pages/add_restoration_parts_entry.php?bfore_aftr_row_id=<?php print "$id_temp_var"?>"; }
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
#$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
#mysql_select_db("$DBName") or die(mysql_error());
if ($sort_field_url == "")
{
$sort_field_in =  "order by username" ;}

#print "ID TEMP TEMP VAR $id_temp_var \n";
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

$query = ("SELECT b.restoration_title, b.username from before_after as b  where b.row_id = '$id_temp_var' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$restoration_title = $Row[0];
$username = $Row[1];

?>
<body>
<h2>&nbsp;</h2>
<h1 align='center' class="style4 wh_tnr_12">Restoration Project</h1>
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
$query = ("SELECT  filename,pic_comment,pic_enter_date from before_after_pics  where before_after_row_id ='$id_temp_var' order by pic_display_order");
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

#echo "<TR bgcolor=$bgcolor>";
if ($username == $session_username and ($Row[0] <> ""))
{

#$name = ("<a href=edit_registry.php?edit_row=$row_id_tab>Edit</a>");
}
else
{
$name = "  ";
}

echo "\t\t<td align='left' width= 50 ><A HREF=\"javascript:popUp('../image_upload/$file_name')\"><img src='../image_upload/thumbs/$file_name' alt='$photo_comment &nbsp; $pic_enter_date' align='left'> </td>";
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
//echo "<h5> Username = $username Session_username= $session_username </h5>";

if ($username == $session_username)
{ //and ($Row[0] <> ""

print '<form align="center"><input type=button value="Add a Picture" onClick="goToAddPicURL()"></form>';
print '<form align="center"><input type=button value="Edit Picture Layout" onClick="goToEditPicURL()"></form>';
echo '</td><td>';
}
if (!$user->data['is_registered'])
{
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
<table align="center" class='journal'  >

	</table>
<?
$query = ("SELECT r.log_title, r.work_description, r.hours_spent, r.cost, r.work_end_date, r.row_ID, r.username,r.work_start_date from tb_restoration_work as r where r.before_after_row_id = '$id_temp_var' and r.category = 'log'");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

while ($Row = mysql_fetch_array($result))     #BEGINNING OF WHILE##################################################################
{
	$log_title = $Row[0];
	$work_description = $Row[1];
	$hours_spent = $Row[2];
	$cost = $Row[3];
	$work_end_date = $Row[4];
	$work_rowID = $Row[5];
	$work_username = $Row[6];
	$work_start_date = $Row[7];

    if ( $work_start_date == 0000-00-00 )
	   { $work_start_date = $work_end_date; }
	if ( $work_end_date == 0000-00-00)
	   { $work_end_date =$work_start_date; }
	$counter++;
		If( $counter == 1 )
		{
		?>
		<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Log Entries </h5></TD></tr>
	</table>
	<?
		}
	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;
	?>
	<br>
	<table align="center" class='journal'  >
	<?
	if ( $work_start_date <> 0000-00-00 and $work_end_date <> 0000-00-00 )
	{
	?>

	<tr><TD><b>Work Start Date: </b><?php print "$work_start_date"?>&nbsp;&nbsp;<b>Work End Date </b><?php print "$work_end_date"?></TD></tr>
	<?
	}
	?>

	<tr><TD><b>Title:   </b><?php print "$log_title"?></TD><td align="right"><b>Hours:   </b><?php print "$hours_spent"?>  <b>Cost:   </b><?php print "$".number_format($cost, 2, '.', ',')?> </td>
	<?
    if ($work_username == $session_username and ($Row[0] <> ""))
       {
      echo "<td align='right'><strong><a href=edit_rest_log_entry.php?edit_row=$work_rowID>Edit</a></strong></td>";
		}
?></tr>
	<TR><td><b>Work Descrption:   </b><?php print "$work_description"?>  </TD></tr>
	<hr>
	</table>

<?
}    ################################################## End of the while #


########################## End of Log Entry above #################################
?>
<table align="center">
<tr align="center">
<td >

<?
if ($username == $session_username)
{
print '<form align="center"><input type=button value="Add a Log entry" onClick="goToAddLogURL()">
</form>';
echo '</td>';
}
?>
</tr>
</table>

<table align="center" class='journal'  >

<table align="center">
<tr align="center">
<td >
	<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> To Do Entries </h5></TD></tr>
	</table>
<?
######################### BEGINNING OF TODO SECTION Below ###########################################3
$query = ("SELECT r.log_title, r.work_description, r.hours_spent, r.cost, r.work_end_date, r.row_ID, r.username,r.work_start_date from tb_restoration_work as r where r.before_after_row_id = '$id_temp_var' and r.category = 'todo' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

while ($Row = mysql_fetch_array($result))     #BEGINNING OF WHILE##################################################################
{
	$log_title = $Row[0];
	$work_description = $Row[1];
	$hours_spent = $Row[2];
	$cost = $Row[3];
	$work_end_date = $Row[4];
	$work_rowID = $Row[5];
	$work_username = $Row[6];
	$work_start_date = $Row[7];

    if ( $work_start_date == 0000-00-00 )
	   { $work_start_date = $work_end_date; }
	if ( $work_end_date == 0000-00-00)
	   { $work_end_date =$work_start_date; }
	$counter++;
		If( $counter == 1 )
		{
		?>
		<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Log Entries </h5></TD></tr>
	</table>
	<?
		}
	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;
	?>
	<br>
	<table align="center" class='journal'  >
	<?
	if ( $work_start_date <> 0000-00-00 and $work_end_date <> 0000-00-00 )
	{
	?>

	<tr><TD><b>Work Start Date: </b><?php print "$work_start_date"?>&nbsp;&nbsp;<b>Work End Date </b><?php print "$work_end_date"?></TD></tr>
	<?
	}
	?>

	<tr><TD><b>Title:   </b><?php print "$log_title"?></TD><td align="right"><b>Hours:   </b><?php print "$hours_spent"?>  <b>Cost:   </b><?php print "$".number_format($cost, 2, '.', ',')?> </td>
	
	
	<?
    if ($work_username == $session_username) 
       {
      echo "<td align='right'><strong><a href=edit_rest_log_entry.php?edit_row=$work_rowID>Edit</a></strong></td>";
		}
?></tr>
	<TR><td><b>Work Descrption:   </b><?php print "$work_description"?>  </TD></tr>
	<hr>
	</table>
<?

}    ################################################## End of the while #





######################## END OF TODO SECTION
?>
	<table align="center" class='journal'  >
	<hr size="3" noshade>
	<tr ><TD align="right"><b>Total Cost:   </b><?php print "$".number_format($cost_temp_var, 2, '.', ',')?><b>&nbsp;&nbsp;&nbsp;&nbsp;Total Hours:   </b><?php print "$hours_spent_temp_var"?></TD></tr>
	</table>
<br>
<table align="center">
<tr align="center">
<td >


<?
if ($username == $session_username)
{
print '<form align="center"><input type=button value="Add a To Do  entry" onClick="goToAddToDoURL()">
</form>';
echo '</td>';
}
?>
</tr>
</table>
<?
#######################################################################################################################################################
##### Parts Section
#######################################################################################################################################################
?>

	<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Parts Wanted </h5></TD></tr>
	</table>
<table align="center">
<?

echo "<table align='center' class='journal'  >";
echo "<TH width='10%'><div align='left'>Name</a></TH>";
echo "<TH width='15%'><div align='left'>Category</a></TH>";
echo "<TH width='15%'><div align='left'>Desired Cost</a></TH>";
echo "<TH width='15%'><div align='left'>Date Entered</a></TH>";
echo "<TH width='40%'><div align='left'>Part Description</a></TH>";
if ($logged_in == "yes")
{
echo "<TH width='5%'><div align='left'>Message</a></TH>";
}

$query = ("SELECT p.part_name, p.part_description, p.part_category, p.desired_cost, p.enter_date, p.row_ID, p.username, p.wanted_purchased from tb_restoration_parts as p where p.before_after_row_id = '$id_temp_var' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());


while ($Row = mysql_fetch_array($result))     #BEGINNING OF WHILE##################################################################
{
  	$part_name = $Row[0];
	$part_description = $Row[1];
	$part_category = $Row[2];
	$desired_cost = $Row[3];
	$enter_date = $Row[4];
	$work_rowID = $Row[5];
	$work_username = $Row[6];
	$wanted_purchased = $Row[7];

	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;

	If ($wanted_purchased == "Wanted")
	{	#Beginning of wanted if work
	?>
	<br>
	<tr><TD><?php print "$part_name"?></TD><TD><?php print "$part_category"?></TD><TD><?php print "$".number_format($desired_cost, 2, '.', ',')?> </TD><TD><?php print "$enter_date"?></TD><td><?php print "$part_description"?></td>

	<?
   if ($work_username == $session_username and ($Row[0] <> ""))
       {

      echo "<td><strong><a href=edit_rest_parts_entry.php?edit_row=$work_rowID&before_after_rowID=$id_temp_var>Edit</a></strong></td>";
		}
	else
		{
		if ($logged_in == "yes")
		{
				echo "\t\t<td><a href=send_message.php?&rec=$username&sub=$part_name&nbsp;for&nbsp;Your&nbsp;$restoration_title&nbsp;part><IMG SRC=../Images/icons/email_icon.gif border=0 ></a></td>";
		}
		}

} # End of Wanted If


}    ################################################## End of the while #


# BEGINNING OF PURCHASED
?>
</table>
	<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Parts Purchased </h5></TD></tr>
	</table>
	<table align="center">

<?
echo "<table align='center' class='journal'  >";
echo "<TH width='10%'><div align='left'>Name</a></TH>";
echo "<TH width='15%'><div align='left'>Category</a></TH>";
echo "<TH width='15%'><div align='left'>Cost</a></TH>";
echo "<TH width='15%'><div align='left'>Date Entered</a></TH>";
echo "<TH width='40%'><div align='left'>Part Description</a></TH>";


$query = ("SELECT p.part_name, p.part_description, p.part_category, p.desired_cost, p.enter_date, p.row_ID,p.username, p.wanted_purchased from tb_restoration_parts as p where p.before_after_row_id = '$id_temp_var' and p.wanted_purchased = 'Purchased' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$actual_cost = 0;
$cost_temp_var = 0;
while ($Row = mysql_fetch_array($result))     #BEGINNING OF WHILE##################################################################
{
  	$part_name = $Row[0];
	$part_description = $Row[1];
	$part_category = $Row[2];
	$actual_cost = $Row[3];
	$enter_date = $Row[4];
	$work_rowID = $Row[5];
	$work_username = $Row[6];
	$wanted_purchased = $Row[7];

	$cost_temp_var = $cost_temp_var + $actual_cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;

If ($wanted_purchased == "Purchased")
	{	#Beginning of wanted if work
	?>
	<br>

	<tr><TD><?php print "$part_name"?></TD><TD><?php print "$part_category"?></TD><TD><?php print "$".number_format($actual_cost, 2, '.', ',')?> </TD><TD><?php print "$enter_date"?></TD><td><?php print "$part_description"?></td>

	<?



    if ($work_username == $session_username  and ($Row[0] <> ""))
       {

      echo "<td><strong><a href=edit_rest_parts_entry.php?edit_row=$work_rowID&before_after_rowID=$id_temp_var>Edit</a></strong></td>";
		}
	else
		{
		if ($logged_in == "yes")
		{
				echo "\t\t<td><a href=send_message.php?&rec=$username&sub=$part_name&nbsp;for&nbsp;Your&nbsp;$restoration_title&nbsp;part><IMG SRC=../Images/icons/email_icon.gif border=0 ></a></td>";
		}
		}

} # End of Wanted If

} #end of While

?>
<table align="center" class='journal'  >
	<hr size="3" noshade>
	<tr ><TD align="right"><b>Total Cost:   </b><?php print "$".number_format($cost_temp_var, 2, '.', ',')?><b></TD></tr>
	</table>

</tr>
<?


?>
</table>
<br>
<table align="center">
<tr align="center">
<td >

<?

if ($username == $session_username)
{
print '<form align="center"><input type=button value="Add a Part" onClick="goToAddPartsURL()"></form>';
echo '</td>';
}
?>
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
