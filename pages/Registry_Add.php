<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../Registry_Add.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();


//$session_username = $_SESSION['user_name'];
//$session_userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';

mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
//Session doesn't exist
if ($user->data['is_registered'])
{
$session_username = $user->data['username'];
print_html_add();
}
if (!$user->data['is_registered'])
{
$logged_on = "no";
//No Session Variable

$target_url_in = '/pages/Registry_Add.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
//END CHECK LOGIN======================================================================================================================
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Cycle Registration</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<body>
<div align="center">
  <table width="33%" height="65">
    <tr>
      <th width="35%" scope="col">&nbsp;</th>
      <th width="32%" scope="col">&nbsp;</th>
      <th width="33%" scope="col">&nbsp;</th>
    </tr>


  </table>
</div>
<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com 

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

</style>



<br>
<?
function print_html_add() {
print '
<form method="POST" >
       <br>
	   <br>
     <div align="center"><h1><b>Cycle Registry </b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="210"><div align="left"><strong>Manufacturer:</strong></div></td>
          <td width="148"><div align="left">
            <input type="text" name="manufacturer">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left"><strong>Model:</strong></div></td>
          <td><div align="left">
            <input type="text" name="model">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left"><strong>Year:</strong></div></td>
          <td><div align="left">
            <input type="text" name="year">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
          <td><div align="left"><strong>Frame Serial Number (Optional):</strong></div></td>
          <td><div align="left">
            <input type="text" name="serial_number">
          </div></td>
          <td>&nbsp;</td>
        </tr>
			 <tr>
          <td><div align="left"><strong>Engine Number (Optional):</strong></div></td>
          <td><div align="left">
            <input type="text" name="engine_number">
          </div></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td><div align="center"><strong>Location:</strong></div></td>
          <td><input type="text" name="location"></td>
          <td>&nbsp;</td>
        </tr>
         
         <tr>
           <td><div align="center"><strong>Comments:</strong></div></td>
		    <td align="center" width="50" height="5"><textarea name="comments" cols="40" rows="10"></textarea> </td>
        
          <td>&nbsp;</td>
        </tr>
		<tr><td>
		<h5>After you add your entry you will be redirected to the "Member Collection", once there find your bike and edit it to add a photo to your listing. </h4>
		</td></tr>
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
 

       <table width="200">

       </table>
   
       </textarea>

     </div>
</form> 
	</body>
</html>'; 


}

$today = date("Y-m-d h:i:s");
 if ($_REQUEST['submit']) { 
		$manufacturer=$_REQUEST['manufacturer'];
		$model=$_REQUEST['model'];
		$year=$_REQUEST['year'];
		$serial_number=$_REQUEST['serial_number'];
		$engine_number=$_REQUEST['engine_number'];
		$owner=$_REQUEST['owner'];
		$location=$_REQUEST['location'];
		$comments=$_REQUEST['comments'];
		$user_id_temp = $user->data['user_id'];
	    $type_of_entry = 'Registry';
		 $query ="INSERT INTO registry (username,manufacturer,model,year,location,comments,type_of_entry,entered,serial_number,engine_number,userID)";
		 $query.= " VALUES 	('$session_username','$manufacturer','$model','$year','$location','$comments','$type_of_entry','$today','$serial_number','$engine_number','$user_id_temp')"; 		  
		
		$result=mysql_query($query) or die('Error: ' . mysql_error());

		
		if    ($result) {
		echo "<h3 align = 'center'> Successfully Entered </h3>" ;
		echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php"</script>';
		}
		  else
		{
		  echo "msql Error "; 
	    }
}
 ?>
 
 

<p>
<?php 
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

