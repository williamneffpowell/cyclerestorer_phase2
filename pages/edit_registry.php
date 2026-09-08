<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();

//$userID = $_SESSION['user_ID'];
//$session_temp_var=$_SESSION['sessionID'];

include '../includes/dbconnect.inc.php';

//if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);
$session_username = $session_username;
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
if ($is_logged_in)
{
$username = $session_username;
$logged_on = "yes";
//Session doesn't exist
}
if (!$is_logged_in)
{
$logged_on = "no";
}

if ($logged_on == "no")
{
$target_url_in = '/pages/edit_registry.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$id_temp_var = $_REQUEST['edit_row'];


$_SESSION['PASSED_ROW_ID'] = $id_temp_var;
#echo "<br> id_temp_var = $id_temp_var ";

mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT * FROM registry  where (row_id ='$id_temp_var')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$user_tab = $Row[0];
$reg_rowID = $Row[1];
$model_tab = $Row[4];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
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

function validate_form(editform)
{
with (editform)
{
if (validate_required(manufacturer,"The 'Manufacturer' field must be filled out!")==false)
  {manufacturer.focus();return false}
if (validate_required(model,"Email must be filled out!")==false)
  {model.focus();return false}
if (validate_required(year,"The 'Year' field must be filled out!")==false)
  {year.focus();return false}
if (validate_required(message,"The 'Started By' field must be filled out!")==false)
  {message.focus();return false}
}
}
</script>
<script type="text/javascript" src="javascript/checkbox.js"></script>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">

<table align="center">
<tr>
<TD>
<form name=editform onSubmit="return validate_form(this)" method="POST" >
<br>
<br>
     <div align="center"><h1><b>Edit Collection Record</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="210"><div align="center"><strong>Manufacturer:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="manufacturer" value ="<?PHP echo $Row[3]; ?>"  >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Model:</strong></div></td>
          <td><div align="center">
            <input type="text" name="model" value="<?PHP echo $Row[4]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Year:</strong></div></td>
          <td><div align="center">
            <input type="text" name="year" value="<?PHP echo $Row[5]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Serial Number:</strong></div></td>
          <td><input type="text" name="serial_number" value="<?PHP echo $Row[6]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td><div align="center"><strong>Engine Number:</strong></div></td>
          <td><input type="text" name="engine_number" value="<?PHP echo $Row[12]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Owner:</strong></div></td>
          <td><input type="text" name="owner" value="<?PHP echo $Row[7]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td><div align="center"><strong>Location:</strong></div></td>
          <td><input type="text" name="location" value="<?PHP echo $Row[8]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td><div align="center"><strong>Comments (no commas please) :</strong></div></td>
          <td><input type="text" name="comments" value="<?PHP echo $Row[9]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
		 <td class="wh_tnr_12"><div align="left">Switch to "Off" if the bike is sold:</div></td>

          <td>
		  <input type="checkbox" name="registry_fd[]"  <?PHP if ($Row[11] == "Registry" )
		  { echo ' value="Registry';

			 echo '" CHECKED'; }
		 else
		 { echo 'value="Sold"'; }
		  ?>></td>
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	   <input type="submit" name="delete" value="delete">
       <br>
       </textarea>
     </div>
</form>
</td>
<td>
<table>
<?
//echo "<h5> Username = $username </h5>";
echo "<a href='add_video.php?edit_row=$reg_rowID'>Add Video</a>";
$Query = "SELECT v.videoID, v.title FROM tb_video AS v  WHERE v.username='$username' AND v.reg_rowID = $reg_rowID";
$Result1 = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
while ($Row = mysql_fetch_array ($Result1)) {
	$videotable = $videotable . ("
	<tr>
	<TD><A HREF=edit_video.php?videoID=$Row[0]>Edit $Row[14]</A></TD>
	<TD align=center>$Row[2]</TD>
	<TD align=center>$Row[3]</TD></tr>
	");
	$results = $results + 1;
	}
	echo "$videotable";
If (logged_in_var == "yes"  ) #Used to have 'and $userID==$reg_userID
{
	if ($results == 0)
	{ $videotable = $videotable . ("<TD colspan=6 align=center><BR><BR>No videos Listed. <A HREF=add_video.php>Click here to add a video</A><BR><BR>		</TD>");
	#$tdis = "disabled";
	}
}
?>
</table>
</td>
	</body>
</html>
<?PHP
 if ($_REQUEST['submit']) {
		$manufacturer=$_REQUEST['manufacturer'];
		$model=$_REQUEST['model'];
		$year=$_REQUEST['year'];
		$serial_number=$_REQUEST['serial_number'];
		$egine_number=$_REQUEST['engine_number'];
		$owner=$_REQUEST['owner'];
		$location=$_REQUEST['location'];
		$comments=$_REQUEST['comments'];
		print "In the if ";

		if(isset($_POST['registry_fd']))
		 {
		  $registry_entry = "Registry";
		  }
		  else
		  {
		  $registry_entry= "Sold";
		  }
	     $Query2 = "UPDATE registry SET manufacturer = '$manufacturer', type_of_entry = '$registry_entry', model = '$model',year = '$year',serial_number = '$serial_number',owner = '$owner', location = '$location',comments = '$comments',engine_number = '$engine_number' WHERE row_id = '$id_temp_var'";
		$result=mysql_query($Query2) or die ('Update Query Failed $Query2');

		#The HREF location must be changed then the application is ported to production.
		#This is the production Link: http://www.cyclerestorer.com/pages/library.php
		#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/library.php

		if  ($result)
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php" </script>';
			}
		  else
		 {
		  echo "<b>ERROR: unable to update.</b>";
	    }
}
 if ($_REQUEST['delete']) {
		$manufacturer=$_REQUEST['manufacturer'];
		$model=$_REQUEST['model'];
		$year=$_REQUEST['year'];
		$serial_number=$_REQUEST['serial_number'];
		$engine_number=$_REQUEST['engine_number'];
		$owner=$_REQUEST['owner'];
		$location=$_REQUEST['location'];
		$comments=$_REQUEST['comments'];
		#print "In the if ";
	     $Query2 = "Delete from registry where row_id = '$id_temp_var'";
		$result=mysql_query($Query2) or die ('Update Query Failed $Query2');

		#The HREF location must be changed then the application is ported to production.
		#This is the production Link: http://www.cyclerestorer.com/pages/library.php
		#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/library.php

		if  ($result)
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php" </script>';
			}
		  else
		 {
		  echo "<b>ERROR: unable to delete.</b>";
	    }
}

$Row[0]="";
$Row[1]="";


$picID_var = $_REQUEST['picID'];
$id_temp_var = $_REQUEST['edit_row'];
if ($picID_var <> "") {
$Query = "SELECT  filename, caption FROM  tb_pictures where picID=$picID_var";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$SESSION['PASSED_ROW_ID'] = $id_temp_var;
}
if ($Row[0] <> "") {$mainpic = "image_upload/$Row[0]";
$caption = $Row[1];
}
else {$mainpic = "image_upload/default.jpg";
}
?>
<TABLE width=600 ALIGN=CENTER>
<FORM ACTION=update_registry_pic.php METHOD=POST enctype="multipart/form-data">
<TR><TD valign=top>
Profile Image
</TD>
<TD valign=top>
<IMG SRC="../<?echo $mainpic;?>" alt="<?echo $caption;?>">
</TD>
</TR>
<TR>
<TD valign=top>Upload New Image</TD>
<TD><input TYPE=FILE NAME=imagefile ID=file ></TD>
</TR>
<TR>
<TD valign=top>
Image Caption
</TD>
<TD valign=top><INPUT TYPE=TEXT NAME=caption SIZE=40 VALUE="<?echo $caption;?>"></TD></TR>
<TR><TD colspan=2><CENTER><INPUT TYPE=SUBMIT VALUE="Update Image"></TD></TR>
</FORM>
</TABLE>
<?



include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

