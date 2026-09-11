	<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';



$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
    
    
$session_username = $session_username;


if ($is_logged_in){


    

$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));


$logged_in = "yes";
$login_var = "";

}
if (!$is_logged_in)
{
$target_url_in = '/pages/restoration_pics_view.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url']??'0';

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

$id_temp_var = isset($_GET['edit_row']) ? intval($_GET['edit_row']) : 0;

$todo_or_log = $_REQUEST['log_or_todo']??'0';
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
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=800,left = 340,top = 212');");
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

<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=800');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>




</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>


<p>

</p>
<br>
<?php

#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
#$sort_field_url ="";
if ($sort_field_url == "")
{
$sort_field_in =  "order by username" ;}

#print "ID TEMP TEMP VAR $id_temp_var \n";





$query = ("SELECT b.restoration_title, b.username from before_after as b  where b.row_id = '$id_temp_var' ");






$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));

$Row = mysqli_fetch_array($result);
$restoration_title = $Row[0] ?? '0';


$username = $Row[1] ?? '0';

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



<?php
$query = ("SELECT  filename,pic_comment,pic_enter_date,pic_display_order from before_after_pics  where before_after_row_id ='$id_temp_var' order by pic_display_order");



$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));




// Printing results in HTML
echo "<table align='left' width=80% >\n";
echo '<table align=center>';
###############################################################################################################
# This is the logic that puts out the picture thumbnails. 
#########################################################################################
echo '<br>';
$td_var = 1;
while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))  #BEGINNING
{
$bgcolor ="";

    
    
if ($bgcolor == "BBBBBB") {$bgcolor = "777777";}
else {$bgcolor = "BBBBBB";}
if ($td_var == '0' )
{
echo "<TR bgcolor=$bgcolor>";
}
$file_name = $Row[0] ?? '0';
$photo_comment = $Row[1] ?? '0' ;
$pic_enter_date = $Row[2] ?? '0';
$pic_display_order = $Row[3] ?? '0';
if ($username == $session_username and ($Row[0] <> ""))
{
}
else
{
$name = "  ";
}

echo "\t\t<td align='left' width= 50 ><A HREF=\"javascript:popUp('restoration_pics_view.php?bef_aft_row=$id_temp_var&td_var=$pic_display_order')\"><img src='../image_upload/thumbs/$file_name' alt='$photo_comment &nbsp; $pic_enter_date' align='left'> </td>";

#echo "a href="../../restoration_pics_view.php" onclick="return popitup('restoration_pics_view.php')"
#	><h5>The index Page</h5></a>"
	
	
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

<?php
//echo "<h5> Username = $username Session_username= $session_username </h5>";

if ($username == $session_username)
{ //and ($Row[0] <> ""

print '<form align="center"><input type=button value="Add a Picture" onClick="goToAddPicURL()"></form>';
print '<form align="center"><input type=button value="Edit Picture Layout" onClick="goToEditPicURL()"></form>';
echo '</td><td>';
}
if (!$is_logged_in)
{
echo '<td>';
$target_url_in = '/pages/before_after.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'] ?? '0';
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
<?php
$query = ("SELECT r.log_title, r.work_description, r.hours_spent, r.cost, r.work_end_date, r.row_ID, r.username,r.work_start_date from tb_restoration_work as r where r.before_after_row_id = '$id_temp_var' and r.category = 'log'");





$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));


$counter="";
$cost_temp_var = "";
$hours_spetn_temp_var = "";
while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))  #BEGINNING OF WHILE##################################################################
{
	$log_title = $Row[0] ?? '0';
	$work_description = $Row[1] ?? '0';
	$hours_spent = $Row[2] ?? '0';
	$cost = $Row[3] ?? '0';
	$work_end_date = $Row[4] ?? '0';
	$work_rowID = $Row[5] ?? '0';
	$work_username = $Row[6] ?? '0';
	$work_start_date = $Row ?? '0';

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
	<?php
		}
		

	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;
	?>
	<br>
	<table align="center" class='journal'  >
	<?php
	if ( $work_start_date <> 0000-00-00 and $work_end_date <> 0000-00-00 )
	{
	?>

	<tr><TD><b>Work Start Date: </b><?php print "$work_start_date"?>&nbsp;&nbsp;<b>Work End Date </b><?php print "$work_end_date"?></TD></tr>
	<?php
	}
	?>

	<tr><TD><b>Title:   </b><?php print "$log_title"?></TD><td align="right"><b>Hours:   </b><?php print "$hours_spent"?>  <b>Cost:   </b><?php print "$".number_format($cost, 2, '.', ',')?> </td>
	<?php
    if ($work_username == $session_username and ($Row[0] <> ""))
       {
      echo "<td align='right'><strong><a href=edit_rest_log_entry.php?edit_row=$work_rowID>Edit</a></strong></td>";
		}
?></tr>
	<TR><td><b>Work Descrption:   </b><?php print "$work_description"?>  </TD></tr>
	<hr>
	</table>

<?php
}    ################################################## End of the while #


########################## End of Log Entry above #################################
?>
<table align="center">
<tr align="center">
<td >

<?php
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
<?php
######################### BEGINNING OF TODO SECTION Below ###########################################3
$query = ("SELECT r.log_title, r.work_description, r.hours_spent, r.cost, r.work_end_date, r.row_ID, r.username,r.work_start_date from tb_restoration_work as r where r.before_after_row_id = '$id_temp_var' and r.category = 'todo' ");

$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));

while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))     #BEGINNING OF WHILE##################################################################
{
	$log_title = $Row[0] ?? '0';
	$work_description = $Row[1] ?? '0';
	$hours_spent = $Row[2] ?? '0';
	$cost = $Row[3] ?? '0';
	$work_end_date = $Row[4] ?? '0';
	$work_rowID = $Row[5] ?? '0';
	$work_username = $Row[6] ?? '0';
	$work_start_date = $Row[7] ?? '0';

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
	<?php
		}
	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;
	?>
	<br>
	<table align="center" class='journal'  >
	<?php
	if ( $work_start_date <> 0000-00-00 and $work_end_date <> 0000-00-00 )
	{
	?>

	<tr><TD><b>Work Start Date: </b><?php print "$work_start_date"?>&nbsp;&nbsp;<b>Work End Date </b><?php print "$work_end_date"?></TD></tr>
	<?php
	}
	?>

	<tr><TD><b>Title:   </b><?php print "$log_title"?></TD><td align="right"><b>Hours:   </b><?php print "$hours_spent"?>  <b>Cost:   </b><?php print "$".number_format($cost, 2, '.', ',')?> </td>
	
	
	<?php
    if ($work_username == $session_username) 
       {
      echo "<td align='right'><strong><a href=edit_rest_log_entry.php?edit_row=$work_rowID>Edit</a></strong></td>";
		}
?></tr>
	<TR><td><b>Work Descrption:   </b><?php print "$work_description"?>  </TD></tr>
	<hr>
	</table>
<?php

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


<?php
if ($username == $session_username)
{
print '<form align="center"><input type=button value="Add a To Do  entry" onClick="goToAddToDoURL()">
</form>';
echo '</td>';
}
?>
</tr>
</table>
<?php
#######################################################################################################################################################
##### Parts Section
#######################################################################################################################################################
?>

	<table align="center" class='journal'  >
	<hr size="10" noshade >
	<tr><TD><H5 align="center"> Parts Wanted </h5></TD></tr>
	</table>
<table align="center">
<?php

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





$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));



while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))  #BEGINNING   #BEGINNING OF WHILE##################################################################
{
  	$part_name = $Row[0] ?? '0';
	$part_description = $Row[1]?? '0';
	$part_category = $Row[2]?? '0';
	$desired_cost = $Row[3]?? '0';
	$enter_date = $Row[4]?? '0';
	$work_rowID = $Row[5]?? '0';
	$work_username = $Row[6]?? '0';
	$wanted_purchased = $Row[7]?? '0';

	$cost_temp_var = $cost_temp_var + $cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;

	if ($wanted_purchased == "Wanted")
	{	#Beginning of wanted if work
  ?>
	<br>
	<tr><TD><?php print "$part_name"?></TD><TD><?php print "$part_category"?></TD><TD><?php print "$".number_format($desired_cost, 2, '.', ',')?> </TD><TD><?php print "$enter_date"?></TD><td><?php print "$part_description"?></td>";
	<?php
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

<?php
echo "<table align='center' class='journal'  >";
echo "<TH width='10%'><div align='left'>Name</a></TH>";
echo "<TH width='15%'><div align='left'>Category</a></TH>";
echo "<TH width='15%'><div align='left'>Cost</a></TH>";
echo "<TH width='15%'><div align='left'>Date Entered</a></TH>";
echo "<TH width='40%'><div align='left'>Part Description</a></TH>";


$query = ("SELECT p.part_name, p.part_description, p.part_category, p.desired_cost, p.enter_date, p.row_ID,p.username, p.wanted_purchased from tb_restoration_parts as p where p.before_after_row_id = '$id_temp_var' and p.wanted_purchased = 'Purchased' ");



$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));




$actual_cost = 0;
$cost_temp_var = 0;
while ($Row = mysqli_fetch_array($result, MYSQLI_NUM))    #BEGINNING OF WHILE##################################################################
{
  	$part_name = $Row[0]?? '0';
	$part_description = $Row[1]?? '0';
	$part_category = $Row[2]?? '0';
	$actual_cost = $Row[3]?? '0';
	$enter_date = $Row[4]?? '0';
	$work_rowID = $Row[5]?? '0';
	$work_username = $Row[6]?? '0';
	$wanted_purchased = $Row[7]?? '0';

	$cost_temp_var = $cost_temp_var + $actual_cost;
	$hours_spent_temp_var = $hours_spent_temp_var + $hours_spent;

If ($wanted_purchased == "Purchased")
	{	#Beginning of wanted if work
	?>
	<br>

	<tr><TD><?php print "$part_name"?></TD><TD><?php print "$part_category"?></TD><TD><?php print "$".number_format($actual_cost, 2, '.', ',')?> </TD><TD><?php print "$enter_date"?></TD><td><?php print "$part_description"?></td>

	<?php



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
<?php


?>
</table>
<br>
<table align="center">
<tr align="center">
<td >

<?php

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
