<?php
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$userID = $_SESSION['user_ID'];


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password);
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   # Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

if ($Row[0] <> "")
{
$logged_in = "yes";
$login_var = "";

}
else
{
$target_url_in = 'pages/adjust_restoration_pics.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php"><div align="center">
<div align="center"><span class="style1"><b></b></span>
       <table width="261" border="0" class="index">
        <caption>&nbsp;
        </caption>
       </table>
       <br>
       <input type="submit" name="submit" value="Login to Edit picture_order">
       <br>
     </div></Form>';


}

#**************************************************************************
# The row to select from the Before_after Page selection 
$bef_pic_row_id = $_REQUEST['bfore_aftr_row_id'];
$pic_display_order = $_REQUEST['pic_display_order'];
$pic_action = $_REQUEST['pic_action'];
#******************************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">


<?

$Link = mysql_connect ($Host, $User, $Password);

mysql_select_db("$DBName") or die(mysql_error());
$query = ("SELECT b.restoration_title, b.username from before_after as b  where b.row_id = '$id_temp_var' ");
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$restoration_title = $Row[0];
$username = $Row[1];

?>

</head>
<body>

<?php
$Link = mysql_connect ($Host, $User, $Password); 
mysql_select_db("$DBName") or die(mysql_error());


$sql = "SELECT COUNT(*) FROM before_after_pics where before_after_row_id = '$bef_pic_row_id'";
$results = mysql_query($sql) or die(mysql_error());
$total_rows = mysql_fetch_row($results); 
$total_rows_var = $total_rows[0];

//print "<h5>Total Rows = $total_rows_var </h5>";

//print "<h5>Pic Action = $pic_action</h5>";


if ($pic_action == "Forward")
{
$pic_plus_one = $pic_display_order + 1 ;
$pic_minus_one = $pic_display_order - 1 ;


//set target to move to zero
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '0' WHERE pic_display_order = '$pic_display_order' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());

//set pic in front one back
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '$pic_display_order' WHERE pic_display_order = '$pic_plus_one' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());

//set target forward pick to its old position plus one.
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '$pic_plus_one' WHERE pic_display_order = '0' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());
}

If ($pic_action == "Back")
{
$pic_plus_one = $pic_display_order + 1 ;
$pic_minus_one = $pic_display_order - 1 ;


//set target to move to zero
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '0' WHERE pic_display_order = '$pic_display_order' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());

//set pic in front one back
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '$pic_display_order' WHERE pic_display_order = '$pic_minus_one' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());

//set target forward pick to its old position plus one.
$Query2 = "UPDATE before_after_pics  SET pic_display_order = '$pic_minus_one' WHERE pic_display_order = '0' and before_after_row_id = '$bef_pic_row_id'";
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());
}

if ($pic_action == "Delete")
{
 $Query2 = "Delete from before_after_pics  where pic_display_order = '$pic_display_order' and before_after_row_id = '$bef_pic_row_id'"; 
$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());
}

#print "ID TEMP TEMP VAR $id_temp_var \n";
//$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
//mysql_select_db("$DBName") or die(mysql_error());


#//$query ="INSERT INTO before_after_pics (pic_comment,filename,pic_enter_date,before_after_row_id,pic_display_order) #VALUES('$photo_comment','$temp_th_url','$today','$bef_pic_row_id','$total_plus_one')"; 	

#print $query;
	//	$result=mysql_query($query) or die (print '<h5>Insert Query Failed</h5>' . mysql_error());
	mysql_close ($Link);
echo '<script language="JavaScript" type="text/javascript">
		window.location.href="http://www.cyclerestorer.com/pages/edit_restoration_pics.php?edit_row=',"$bef_pic_row_id",'"</script>';	 
//echo "\n";
//$my_file = $_FILES['file_name']['name']; 

?>


<?PHP
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

<p>&nbsp;</p>
</body>
</html>