<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
if ($session_temp_var <> "") {
$Link = mysqli_connect($Host, $User, $Password, $DBName);
$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
$Result = mysqli_query($Link, $Query);
$Row = mysqli_fetch_array($Result);
//$username = $Row[0];
}
//Session doesn't exist
if ($is_logged_in) 
{
#print_edit_add();
#print "logged in ";

}
if (!$is_logged_in) 
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = 'pages/edit_links.php';
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
$query = "SELECT * FROM resource_links   where (resource_links_row_id  ='$id_temp_var')";
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
<br>
     <h2><div align="center"><b>Link Registry </b> </div></h2>
	 <br>
	 <h5><div align="center">* Please keep the links Motorcycle or Restoration related.</div></h5>
	 <h6><div align="center">(Unrelated Links will be removed)</div></h6>
	 <br> 
	 
     <div align="center"><h1><b>Edit Resource Link</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
	
		         
		   <tr>
          <td class="wh_tnr_12"><div align="left">Link Name:</div></td>
          <td><div align="left">
            <input type="text" name="link_name_fd" value="<?php echo $Row[3]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Link Comment:</div></td>
          <td><div align="left">
            <input type="text" name="link_comment_fd" value="<?php echo $Row[5]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Focused Cycle Manufacturer:</div></td>
          <td><div align="left">
            <input type="text" name="manufacturer_fd" value="<?php echo $Row[7]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Focused Cycle Model:</div></td>
          <td><div align="left">
            <input type="text" name="model_fd" value="<?php echo $Row[8]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Focused Link Type:</div></td>
          <td><div align="left">
            <input type="text" name="type_fd" value="<?php echo $Row[11]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">HTML LINK   http://</div></td>
          <td><div align="left">
            <input type="text" name="html_link_fd" value="<?php echo $Row[4]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		
		
        <tr>
          <td class="wh_tnr_12"><div align="left">Link Rating:</div></td>
          <td><div align="left">
            <input type="text" name="link_rating_fd" value="<?php echo $Row[6]; ?>">
          </div></td>
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
        $link_name=$_REQUEST['link_name_fd'];
		$link_comment=$_REQUEST['link_comment_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$type=$_REQUEST['type_fd'];
		$html_link=$_REQUEST['html_link_fd'];
		
$username = $session_username;		
		
	     $Query2 = "UPDATE resource_links  SET resource_name = '$link_name',link_comment = '$link_comment', manufacturer = '$manufacturer', model = '$model',type = '$type' ,html_link = '$html_link' WHERE resource_links_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysqli_query($Link, $Query2) or die ( 'Update Query Failed $Query2'. mysqli_error($Link));	
		
		if  ($result) 
			{
		    	mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/links.php" </script>';
			
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
	    } 
}


 if ($_REQUEST['delete']) { 

	     $Query2 = "Delete from resource_links  where resource_links_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysqli_query($Link, $Query2) or die ('Update Query Failed $Query2');
		
		
		if  ($result) 
			{
		    	mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/links.php" </script>';
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
   <title>Edit Resource Links Page </title>
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

