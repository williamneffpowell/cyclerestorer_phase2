<?PHP
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();

#$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';
if (!$is_logged_in) 
{
$target_url_in = '/pages/edit_rest_parts_entry.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$edit_row = $_REQUEST['edit_row'];
$before_after_rowID=$_REQUEST['before_after_rowID'];
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT * FROM tb_restoration_parts where (row_ID ='$edit_row')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
#$user_tab = $Row[3];
#$model_tab = $Row[6];
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
          <td class="wh_tnr_12"><div align="left">Part Category:</div></td>
          <td><div align="left">
            <input type="text" name="part_category_fd" value="<?PHP echo $Row[7]; ?>">
			 <input type="hidden" name="editrowID" value= "<?php echo $edit_row;?> ">
			 <input type="hidden" name="bfore_aftr_row_id" value="<?php echo $before_after_rowID;?>">
			 
          </div></td>
          <td>&nbsp;</td>
        </tr>
				<tr>
          <td class="wh_tnr_12"><div align="left">Part Name:</div></td>
          <td><div align="left">
            <input type="text" name="part_name_fd" value="<?PHP echo $Row[2]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td width="210" class="wh_tnr_12"><div align="center">Part Description:</div></td>
		  <td align="center" width="50" height="5"><textarea  name="part_description_fd" rows="10" cols="40"><?PHP echo $Row[6]; ?></textarea >
           </td>
		   <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210" class="wh_tnr_12"><div align="left">Wanted/Purchased:</div></td>
           <td >
          <select name="wanted_purchased_fd" size="1">
		  <option value="Wanted"<?php echo($Row[8] == "Wanted"?' selected="selected"':null) ?>>Wanted</option>
		  <option value="Purchased"<?php echo($Row[8] == "Purchased"?' selected="selected"':null) ?>>Purchased</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
         <tr>
          <td width="210" class="wh_tnr_12"><div align="left">Desired/Actual Cost:</div></td>
           <td >
          <input type="text" name="desired_cost_fd" value ="<?PHP echo $Row[1]; ?>">
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



<?PHP


 if ($_REQUEST['submit']) {
        $part_name=$_REQUEST['part_name_fd'];
		$part_description=$_REQUEST['part_description_fd'];
		$part_category=$_REQUEST['part_category_fd'];
		$desired_cost=$_REQUEST['desired_cost_fd'];
		$enter_date=date("Y-m-d h:i:s");
		$wanted_purchased=$_REQUEST['wanted_purchased_fd'];

$editrowID = $_REQUEST['editrowID'];


	 $Query = "UPDATE tb_restoration_parts  SET  part_name = '$part_name', part_description = '$part_description',part_category = '$part_category', desired_cost = '$desired_cost',enter_date = '$enter_date', wanted_purchased = '$wanted_purchased'  WHERE row_ID = '$editrowID' ";

		#print " Query $query \n";
		$result=mysql_query($Query) or die ('Insert Query Failed' . mysql_error());

		if    ($result)
		{
			#mysql_close ($Link);
		$bfore_aftr_row_id=$_REQUEST['bfore_aftr_row_id'];
			  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$bfore_aftr_row_id.'"</script>';
		  }
		  else
		  {
		  echo "<b>ERROR: unable to post.</b>";
		 print "<h2>ERROR IN UPDATE QUERY \n</h2>";
		  mysql_close ($Link);
		  }
	}


 if ($_REQUEST['delete']) {
        $part_name=$_REQUEST['part_name_fd'];
		$part_description=$_REQUEST['part_description_fd'];
		$part_category=$_REQUEST['part_category_fd'];
		$desired_cost=$_REQUEST['desired_cost_fd'];
		$enter_date=date("Y-m-d h:i:s");
		$wanted_purchased=$_REQUEST['wanted_purchased_fd'];
	     $Query2 = "Delete from tb_restoration_parts WHERE row_ID = '$editrowID'";


		$result=mysql_query($Query2) or die ('Update Query Failed $Query2');


		if  ($result)
			{
		    	mysql_close ($Link);
				$edit_row=$_REQUEST['bfore_aftr_row_id'];
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$bfore_aftr_row_id.'"</script>';
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
   <title>Edit Restoration Parts Entry</title>
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

