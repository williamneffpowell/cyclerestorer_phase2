<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;
//$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
//if ($session_temp_var <> "") {
//$Link = mysqli_connect($Host, $User, $Password, $DBName);
//$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
//$Result = mysqli_query($Link, $Query);
//$Row = mysqli_fetch_array($Result);

//Session doesn't exist
if ($is_logged_in)
{
#print_edit_add();
#print "logged in ";

}
if (!$is_logged_in)
{
$logged_on = "no";
$failed = 1;
$target_url_in = '/pages/edit_serial_number.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$id_temp_var = $_REQUEST['edit_row'];
mysqli_connect("$Host","$User","$Password","$DBName");
// Performing SQL query
$query = "SELECT * FROM serial_numbers   where (serial_row_id ='$id_temp_var')";
$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
$Row = mysqli_fetch_array($result);
$user_tab = $Row[3];
#$model_tab = $Row[6];



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

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
     <div align="center"><h1><b>Edit Serial Number Information</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
	
		         
		   <tr>
          <td class="wh_tnr_12"><div align="left">Manufacturer:</div></td>
          <td><div align="left">
            <input type="text" name="manufacturer_fd" value="<?php echo $Row[6]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Model:</div></td>
          <td><div align="left">
            <input type="text" name="model_fd" value="<?php echo $Row[5]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Nickname:</div></td>
          <td><div align="left">
            <input type="text" name="nickname_fd" value="<?php echo $Row[12]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">CCs:</div></td>
          <td><div align="left">
            <input type="text" name="ccs_fd" value="<?php echo $Row[9]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Number of Cylinders:</div></td>
          <td><div align="left">
            <input type="text" name="num_cyl_fd" value="<?php echo $Row[8]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		
		
        <tr>
          <td class="wh_tnr_12"><div align="left">Fuel Tank Color:</div></td>
          <td><div align="left">
            <input type="text" name="fuel_tank_color_fd" value="<?php echo $Row[10]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="wh_tnr_12"><div align="left">Year:</div></td>
          <td><div align="left">
            <input type="text" name="bike_year_fd" value="<?php echo $Row[4]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
          <td class="wh_tnr_12"><div align="left">Engine Number:</div></td>
          <td><input type="text" name="engine_number_fd" value="<?php echo $Row[0]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td class="wh_tnr_12"><div align="left">Frame Number:</div></td>
          <td><input type="text" name="frame_number_fd" value="<?php echo $Row[1]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
           <td class="wh_tnr_12"><div align="left">Production Run:</div></td>
          <td><input type="text" name="production_run_fd" value="<?php echo $Row[13]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
             
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	   <input type="submit" name="delete" value="delete">
       <br>

 
  
       </textarea>
    
     </div>
</form> 
	</body>
</html>
 


<?php

$today = date("Y-m-d h:i:s");
  if ($_REQUEST['submit']) { 
        $manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$nickname=$_REQUEST['nickname_fd'];
		$ccs=$_REQUEST['ccs_fd'];
		$num_cyl=$_REQUEST['num_cyl_fd'];
		$fuel_tank_color=$_REQUEST['fuel_tank_color_fd'];
		$bike_year=$_REQUEST['bike_year_fd'];
		$engine_number=$_REQUEST['engine_number_fd'];
		$frame_number=$_REQUEST['frame_number_fd'];
		$production_run=$_REQUEST['production_run_fd'];
		$user_var=$_REQUEST["user_form_var"];
$username = $_SESSION['user_name'];			
		
	     $Query2 = "UPDATE serial_numbers  SET ccs = '$ccs',num_cyl = '$num_cyl', fuel_tank_color = '$fuel_tank_color', engine_number = '$engine_number', production_run = '$production_run', frame_number = '$frame_number', manufacturer = '$manufacturer', model = '$model',nickname = '$nickname', bike_year = '$bike_year', enter_date = '$today' WHERE serial_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysqli_query($Link, $Query2) or die ( 'Update Query Failed $Query2'. mysqli_error($Link));	
		
		if  ($result) 
			{
		    	mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/serial_number_reference.php" </script>';
			
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
	    } 
}


 if ($_REQUEST['delete']) { 

	     $Query2 = "Delete from serial_numbers  where serial_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysqli_query($Link, $Query2) or die ('Update Query Failed $Query2');
		
		
		if  ($result) 
			{
		    	mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/serial_number_reference.php" </script>';
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
   <title>Edit Classified Ad Page </title>
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

