<?PHP
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../edit_rest_techniques.php';
   //including phpBB3 stuff   
  // define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];

include '../includes/dbconnect.inc.php';

if (!$user->data['is_registered'])
{
$logged_on = "no";

$target_url_in = '/pages/edit_rest_techniques.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

//No Session Variable
$failed = 1;
}

##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$session_username = $user->data['username'];	
$id_temp_var = $_REQUEST['edit_row'];
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT * FROM tb_rest_tech  where (item_row_id ='$id_temp_var')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
#$model_tab = $Row[6];



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
     <div align="center"><h1><b>Edit Your Restoration Technique</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>	         
		<tr>
          <td width="210" class="wh_tnr_12"><div align="left">Title:</div></td>
    
		   <td><div align="left">
		    <input type="text" name="item_title_fd" value="<?PHP echo $Row[12]; ?>">
        </td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		 <tr>
          <td class="wh_tnr_12"><div align="left">Manufacturer:</div></td>
          <td><div align="left">
            <input type="text" name="manufacturer_fd" value="<?PHP echo $Row[5]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="wh_tnr_12"><div align="left">Model:</div></td>
          <td><div align="left">
            <input type="text" name="model_fd" value="<?PHP echo $Row[6]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		       <tr>
          <td class="wh_tnr_12"><div align="left">Year:</div></td>
          <td><div align="left">
            <input type="text" name="year_fd" value="<?PHP echo $Row[18]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
          <td class="wh_tnr_12"><div align="left">Description:</div></td>
		  <TD><textarea  name="description_fd" rows="10" cols="40"><? echo $Row[7];?></TEXTAREA></TD>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="wh_tnr_12"><div align="left">Cost:</div></td>
          <td><input type="text" name="cost_fd" value="<?PHP echo $Row[8]; ?>"></td>
          <td>&nbsp;</td>
        </tr>


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
 


<?PHP
$session_username = $user->data['username'];	

 if ($_REQUEST['submit']) { 
                                                                                                                                                     
		$item_title=$_REQUEST['item_title_fd'];
		$rest_technique=$_REQUEST['rest_technique_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$year=$_REQUEST['year_fd'];
		$description=$_REQUEST['description_fd'];
		$cost=$_REQUEST['cost_fd'];
		$date_entered = date("Y-m-d h:i:s");
	
		
	
	
	
		
	     $Query2 = "UPDATE tb_rest_tech SET item_title = '$item_title', rest_technique = '$rest_technique', manufacturer = '$manufacturer', model = '$model', year = '$year',username = '$session_username',date_entered = '$date_entered',description = '$description',cost = '$cost' WHERE item_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());	
		
		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_techniques.php" </script>';
			
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
	    } 
}


 if ($_REQUEST['delete']) { 
		$rest_technique=$_REQUEST['rest_technique_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$description=$_REQUEST['description_fd'];
		$cost=$_REQUEST['cost_fd'];
 
		
	     $Query2 = "Delete from tb_rest_tech where item_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysql_query($Query2) or die ('Update Query Failed $Query2');
		
		
		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_techniques.php" </script>';
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
   <title>Edit Restoration Technique</title>
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

