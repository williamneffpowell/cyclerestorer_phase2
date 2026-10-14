	<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';



$link = mysqli_connect($Host,$User,$Password,$DBName) or
    die("Connection Unsuccessfull");
    
    
$session_username = $session_username;


if ($is_logged_in){


    

// Removed premature query: $query is defined later in this page.


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
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<style>

/* Readable, mobile-friendly restoration work journal. */
.cr-log-section { width:min(900px,calc(100% - 24px)); margin:28px auto; color:#342b22; }
.cr-log-section h2 { text-align:center;font-size:27px;margin:0 0 4px; }
.cr-log-intro {text-align:center;margin:0 0 18px;color:#594b3e;}
.cr-log-card {background:#fffaf1;border:1px solid #cbb99f;border-radius:10px;margin:14px 0;padding:20px;box-shadow:0 2px 5px #35281b12;}
.cr-log-card-head {display:flex;justify-content:space-between;align-items:flex-start;gap:15px;flex-wrap:wrap;}
.cr-log-card h3 {font-size:22px!important;margin:0 0 5px!important;}
.cr-log-date {font-size:15px;color:#5c4e40;}
.cr-log-edit {display:inline-block;background:#654d38;color:white!important;border-radius:6px;padding:9px 15px;text-decoration:none;font-weight:bold;white-space:nowrap;}
.cr-log-metrics {display:flex;flex-wrap:wrap;gap:12px;margin:15px 0;}
.cr-log-metrics>div {flex:1 1 135px;background:#f3ebdd;border-radius:6px;padding:10px 14px;}
.cr-log-metrics span {display:block;font-size:14px;color:#514539;}
.cr-log-metrics strong {display:block;font-size:19px;}
.cr-log-notes {font-size:16px;line-height:1.55;overflow-wrap:anywhere;}
.cr-log-notes p {margin:6px 0 0;white-space:normal;}
.cr-log-summary {display:flex;justify-content:center;flex-wrap:wrap;gap:12px;font-weight:bold;padding:15px;border-top:2px solid #bba589;}
.cr-log-empty {text-align:center;padding:18px;}
@media(max-width:520px){.cr-log-card{padding:14px}.cr-log-card-head{display:block}.cr-log-edit{margin-top:12px}.cr-log-section{width:calc(100% - 16px)}}
/* Restoration project visual refresh: styles only, no data or workflow changes. */
html { -webkit-text-size-adjust:100%; }
body { background:#f3ecdc !important; color:#302b25 !important; font-family:Arial,Helvetica,sans-serif; font-size:17px; line-height:1.5; margin:0; padding:12px; }
body h1, body h2, body h3, body h5 { color:#4c2f24 !important; line-height:1.3; }
body h1 { font-size:clamp(27px,4vw,38px) !important; margin:12px auto !important; }
body h3 { font-size:clamp(19px,3vw,25px) !important; }
body h5 { font-size:21px !important; margin:10px 0 !important; }
body table { max-width:100%; color:#302b25; }
body table.journal { background:#fffaf0; border-color:#b8a68b; }
body td, body th { font-size:16px; line-height:1.45; overflow-wrap:anywhere; }
body a { color:#743522; }
body a:focus-visible, body input:focus-visible { outline:3px solid #926326; outline-offset:2px; }
body input[type=button], body input[type=submit], body button { background:#654d38; color:#fff; border:1px solid #493524; border-radius:7px; padding:10px 15px; min-height:44px; font-size:16px; font-weight:600; cursor:pointer; max-width:100%; white-space:normal; }
body input[type=button]:hover, body input[type=submit]:hover, body button:hover { background:#493524; }
body img { max-width:100%; height:auto; }
/* Restore generously sized gallery thumbnails, without shrinking them to their intrinsic size. */
body img[src*="image_upload/thumbs/"] { width:145px !important; height:108px !important; max-width:none !important; object-fit:cover; }
/* Keep the legacy gallery's five-column layout usable on smaller screens. */
@media(max-width:760px) { body img[src*="image_upload/thumbs/"] { width:90px !important; height:78px !important; } }
@media(max-width:500px) { body img[src*="image_upload/thumbs/"] { width:65px !important; height:65px !important; } }
body .cr-page-nav { display:flex;justify-content:center;flex-wrap:wrap;gap:12px;margin:8px auto 20px; }
body .cr-page-nav a, body .cr-video-action { display:inline-block;padding:11px 18px;background:#654d38;color:#fff!important;border-radius:7px;border:1px solid #493524;text-decoration:none;font-size:17px;font-weight:bold; }
body .cr-page-nav a:hover, body .cr-video-action:hover {background:#493524;}
body hr { border:0; height:2px; background:#aa9273; max-width:100%; }
@media(max-width:650px) {
 body { padding:8px; font-size:16px; }
 body table { width:auto; max-width:100%; }
 body td, body th { font-size:15px; padding:5px; }
 body input[type=button], body input[type=submit] { display:inline-block; margin:4px 0; }
}
</style>
</head>


<p>

</p>
<br>
<?php

#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
#$sort_field_url ="";
if (($sort_field_url ?? "") == "")
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
<nav class="cr-page-nav" aria-label="Restoration navigation">
<a href="/index.php">Home</a>
<a href="before_after.php">Back to Restorations</a>
</nav>
<h1 align='center' class="style4 wh_tnr_12">Restoration Project</h1>

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
// Journal display: preserve existing database fields and edit permissions.
$query = "SELECT r.log_title, r.work_description, r.hours_spent, r.cost, r.work_end_date, r.row_ID, r.username, r.work_start_date
          FROM tb_restoration_work AS r
          WHERE r.before_after_row_id = '" . (int)$id_temp_var . "' AND r.category = 'log'
          ORDER BY COALESCE(NULLIF(r.work_start_date, '0000-00-00'), r.work_end_date), r.row_ID";
$result = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));
$cost_temp_var = 0.0;
$hours_spent_temp_var = 0.0;
$journal_count = 0;
?>
<section class="cr-log-section" aria-label="Restoration work journal">
  <h2>Restoration Journal</h2>
  <p class="cr-log-intro">Work completed, time invested, expenses, and lessons learned.</p>
<?php while ($Row = mysqli_fetch_assoc($result)):
    $journal_count++;
    $log_title = trim((string)($Row['log_title'] ?? ''));
    $work_description = trim((string)($Row['work_description'] ?? ''));
    $hours_spent = is_numeric($Row['hours_spent'] ?? null) ? (float)$Row['hours_spent'] : 0.0;
    $cost = is_numeric($Row['cost'] ?? null) ? (float)$Row['cost'] : 0.0;
    $cost_temp_var += $cost;
    $hours_spent_temp_var += $hours_spent;
    $work_rowID = (int)($Row['row_ID'] ?? 0);
    $work_username = (string)($Row['username'] ?? '');
    $work_start_date = (string)($Row['work_start_date'] ?? '');
    $work_end_date = (string)($Row['work_end_date'] ?? '');
    $valid_start = $work_start_date !== '' && $work_start_date !== '0000-00-00';
    $valid_end = $work_end_date !== '' && $work_end_date !== '0000-00-00';
    $safe = static function ($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'ISO-8859-1'); };
?>
  <article class="cr-log-card">
    <div class="cr-log-card-head">
      <div>
        <h3><?php echo $safe($log_title !== '' ? $log_title : 'Restoration work'); ?></h3>
        <div class="cr-log-date">
          <?php if ($valid_start): ?>Started <?php echo $safe($work_start_date); ?><?php endif; ?>
          <?php if ($valid_end): ?><?php echo $valid_start ? ' · ' : ''; ?>Finished <?php echo $safe($work_end_date); ?><?php endif; ?>
          <?php if (!$valid_start && !$valid_end): ?>Date not recorded<?php endif; ?>
        </div>
      </div>
      <?php if ($is_logged_in && $work_username === $session_username): ?>
        <a class="cr-log-edit" href="edit_rest_log_entry.php?edit_row=<?php echo $work_rowID; ?>">Edit entry</a>
      <?php endif; ?>
    </div>
    <div class="cr-log-metrics">
      <div><span>Hours spent</span><strong><?php echo number_format($hours_spent, 1); ?></strong></div>
      <div><span>Recorded cost</span><strong>$<?php echo number_format($cost, 2); ?></strong></div>
    </div>
    <div class="cr-log-notes"><strong>Work performed / notes</strong>
      <p><?php echo $work_description !== '' ? nl2br($safe($work_description)) : '<em>No description recorded.</em>'; ?></p>
    </div>
  </article>
<?php endwhile; ?>
<?php if ($journal_count === 0): ?><p class="cr-log-empty">No work entries have been recorded yet.</p><?php endif; ?>
<div class="cr-log-summary"><span><?php echo $journal_count; ?> work <?php echo $journal_count === 1 ? 'entry' : 'entries'; ?></span><span><?php echo number_format($hours_spent_temp_var, 1); ?> total hours</span><span>$<?php echo number_format($cost_temp_var, 2); ?> recorded costs</span></div>
</section>
<?php if ($is_logged_in && $username === $session_username): ?>
<div style="text-align:center;margin:12px auto;"><button type="button" onclick="goToAddLogURL()">Add a Log Entry</button></div>
<?php endif; ?>
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

    if ( $work_start_date == '0000-00-00' )
	   { $work_start_date = $work_end_date; }
	if ( $work_end_date == '0000-00-00')
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
	$cost_temp_var += (float)$cost;
	$hours_spent_temp_var += (float)$hours_spent;
	?>
	<br>
	<table align="center" class='journal'  >
	<?php
	if ( $work_start_date <> '0000-00-00' and $work_end_date <> '0000-00-00' )
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
if (($logged_in ?? "") == "yes")
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

	$cost_temp_var += (float)$cost;
	$hours_spent_temp_var += (float)$hours_spent;

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
		if (($logged_in ?? "") == "yes")
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

	$cost_temp_var += (float)$actual_cost;
	$hours_spent_temp_var += (float)$hours_spent;

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
		if (($logged_in ?? "") == "yes")
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
?>
<?php if ($id_temp_var > 0): ?>
<div class="cr-journal-export" style="max-width:900px;margin:20px auto;padding:16px;text-align:center;background:#fffaf0;border:1px solid #b8aa96;border-radius:8px;font:17px Arial,sans-serif;">
<strong>Restoration Journal</strong><div style="margin-top:12px;display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
<a style="background:#634934;color:white;padding:12px 16px;border-radius:7px;text-decoration:none;" href="restoration_journal_export.php?id=<?php echo (int)$id_temp_var; ?>&amp;format=print">Print / Save PDF</a>
<a style="background:#634934;color:white;padding:12px 16px;border-radius:7px;text-decoration:none;" href="restoration_journal_export.php?id=<?php echo (int)$id_temp_var; ?>&amp;format=csv">Download CSV</a>
</div></div>
<?php endif; ?>
<?php if ($id_temp_var > 0): ?>
<div style="max-width:900px";margin:24px auto;padding:14px;text-align:center;background:#f5f1e8;border:1px solid #b8aa96;border-radius:8px;font:17px Arial,sans-serif;">
  <a class="cr-video-action" href="video_links.php?type=restoration&amp;id=<?php echo (int)$id_temp_var; ?>">View or Add Restoration Videos</a>
  <p style="margin:8px 0 0;color:#333;">Video links open external hosting services; no videos are uploaded here.</p>
</div>
<?php endif; ?>
<?php
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>


</body>
</html>
