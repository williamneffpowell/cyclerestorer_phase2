<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;

#$session_username = $_SESSION['user_name'];
##$session_userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';


if (!$is_logged_in)
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = '/pages/edit_rest_log_entry.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$edit_row = $_REQUEST['edit_row'];
mysqli_connect("$Host","$User","$Password","$DBName");
// Performing SQL query
$query = "SELECT * FROM tb_restoration_work where (row_ID ='$edit_row')";
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
$Row = mysqli_fetch_array($result);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script language="javascript" type="text/javascript" src="datetimepicker.js">


</script>
<script language="javascript" type="text/javascript" src="javascript/tiny_mce/tiny_mce_gzip.js"></script>

<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	themes : 'simple,advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>




<script language="javascript" type="text/javascript" src="javascript/tiny_mce/tiny_mce_gzip.js"></script>

<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	themes : 'simple,advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>


<script language="javascript" type="text/javascript">
	tinyMCE.init ({
		mode : "textareas",
		theme : "advanced",
		plugins : "emotions,preview,zoom,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_disable : "image,cleanup,removeformat,formatselect,styleselect,sub,sup,separator,outdent,indent,help,anchor,code,hr,visualaid,charmap",
		theme_advanced_buttons1_add : "fontselect",
		theme_advanced_buttons2_add : "preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "emotions,cut,copy,paste,separator,search,separator",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "example_word.css",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false,
		theme_advanced_statusbar_location : "none"

	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
</script>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<form name=editform onSubmit="return validate_form(this)" method="POST" >
<br>
<br>
     <div align="center"><h1><b>Edit Restoration Log Entry</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>


		   <tr>
          <td class="wh_tnr_12"><div align="left">Log Title:</div></td>
          <td><div align="left">
            <input type="text" name="log_title_fd" value="<?php echo $Row[5]; ?>">
			 <input type="hidden" name="editrowID" value= "<?php echo $edit_row;?> ">
			 <input type="hidden" name="before_after_rowID_fd" value= "<?php echo $Row[7]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td width="210" class="wh_tnr_12"><div align="center">Description</div></td>
		  <td align="center" width="50" height="5"><textarea  name="work_description_fd" rows="10" cols="40"><?php echo $Row[2]; ?></textarea >
           </td>
		   <br>
          </div></td>
          <td width="12">&nbsp;</td>
		  <tr>
          <td width="210" class="wh_tnr_12"><div align="left">Wanted/Purchased:</div></td>
           <td >
          <select name="log_or_todo_fd" size="1">
		  <option value="log"<?php echo($Row[10] == "log"?' selected="selected"':null) ?>>Log Entry</option>
		  <option value="todo"<?php echo($Row[10] == "todo"?' selected="selected"':null) ?>>To Do Entry</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        </tr>


          <td class="wh_tnr_12"><div align="center">Work Start Date:<a href="javascript:NewCal(\'demo1\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick a Start date"></a></div></td>
          <td><div align="left">
            <input type="text" name="work_start_date_fd" value="<?php echo $Row[1]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		        <tr>
          <td class="wh_tnr_12"><div align="center">Work End Date:<a href="javascript:NewCal(\'demo1\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick an End date"></a></div></td>
          <td><div align="left">
            <input type="text" name="work_end_date_fd" value="<?php echo $Row[6]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Hours Spent:</div></td>
          <td><div align="left">
            <input type="text" name="hours_spent_fd" value="<?php echo $Row[3]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>


          <tr>
          <td width="210" class="wh_tnr_12"><div align="left">Cost:</div></td>
           <td >
          <input type="text" name="cost_fd" value ="<?php echo $Row[4]; ?>">
        </td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
     </table>
       <br>
       <input type="submit" name="submit" value="Update">
	   <input type="submit" name="delete" value="Delete">
       <br>



       </textarea>

     </div>
</form>
	</body>
</html>



<?php


 if ($_REQUEST['submit']) {
        $log_title=$_REQUEST['log_title_fd'];
		$work_description=$_REQUEST['work_description_fd'];
		$work_start_date=$_REQUEST['work_start_date_fd'];
		$work_end_date=$_REQUEST['work_end_date_fd'];
		$hours_spent=$_REQUEST['hours_spent_fd'];
		$cost=$_REQUEST['cost_fd'];
		$editrowID=$_REQUEST['editrowID'];
		$category=$_REQUEST['log_or_todo_fd'];



	 $Query = "UPDATE tb_restoration_work  SET  log_title = '$log_title', work_description = '$work_description',work_start_date = '$work_start_date',work_end_date = '$work_end_date', hours_spent = '$hours_spent', cost = '$cost' , category = '$category'   WHERE row_ID = '$editrowID' ";

		#print " Query $query \n";
		$result=mysqli_query($Link, $Query) or die ('Insert Query Failed' . mysqli_error($Link));

		if    ($result)
		{
			mysqli_close($Link);
				$edit_row=$_REQUEST['before_after_rowID_fd'];
			  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$edit_row.'"</script>';
		  }
		  else
		  {
		  echo "<b>ERROR: unable to post.</b>";
		  mysqli_close($Link);
		  }
	}


 if ($_REQUEST['delete']) {
		 $log_title=$_REQUEST['log_title_fd'];
		$work_description=$_REQUEST['work_description_fd'];
		$work_start_date=$_REQUEST['work_start_date_fd'];
		$work_end_date=$_REQUEST['work_end_date_fd'];
		$hours_spent=$_REQUEST['hours_spent_fd'];
		$cost=$_REQUEST['cost_fd'];
		$editrowID=$_REQUEST['editrowID'];
	     $Query2 = "Delete from tb_restoration_work WHERE row_ID = '$editrowID'";


		$result=mysqli_query($Link, $Query2) or die ('Update Query Failed $Query2');


		if  ($result)
			{
		    	mysqli_close($Link);
				$edit_row=$_REQUEST['before_after_rowID_fd'];
			  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$edit_row.'"</script>';
			}
		  else
		 {
		  echo "<b>ERROR: unable to delete.</b>";
	    }
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Edit Restoration Log Entry</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><body>
   <p class="wh_tnr_12">&nbsp;</p>
   <div align="center">
<!--  <table width="33%" height="65">
    <tr>
      <th width="35%" scope="col">&nbsp;</th>
      <th width="32%" scope="col">&nbsp;</th>
      <th width="33%" scope="col">&nbsp;</th>
    </tr>


  </table> -->
</div>
<p>
<?php
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

