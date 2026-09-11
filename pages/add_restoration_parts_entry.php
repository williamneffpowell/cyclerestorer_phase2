<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
include '../includes/dbconnect.inc.php';
mysqli_connect("$Host","$User","$Password","$DBName");
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES

#print "usernerm $username\n";
//Session doesn't exist

if ($is_logged_in)
{

echo "<br>";
echo "<br>";
echo "<table align='center'>";
echo "<tr>&nbsp;</tr>";
echo "<tr>&nbsp;</tr>";
echo "</table align='center'>";
echo "<br>";

print_html_add();
# Do Nothing print_html_add();


}
if (!$is_logged_in)
{
$logged_on = "no";

$target_url_in = '/pages/add_restoration_parts_entry.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];


echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
//No Session Variable
$failed = 1;
}


//END CHECK LOGIN ##################################################################################################

#**************************************************************************
# The row to select from the Before_after Page selection
$id_temp_add_var = $_REQUEST['bfore_aftr_row_id'];
#******************************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Add Restoration Parts</title>

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
<!--
body {
	background-color: #CC0033;
}
-->
</style>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>


<br>
<h3 align='center'>* = Required </h3>

<?php




function print_html_add() {

echo '
<form name=adform method="POST" onsubmit="return validate_form(this)">
     <div align="center"><h1><b>Add Restoration Parts</h1></b> </div>
  <div align="center">
     <table  align="center" width="600" border="0">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width="550"><div align="center"><strong>* Part Category:</strong></div></td>
          <td width="148"><div align="center"><input type="text" name="part_category_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="550"><div align="center"><strong>* Part Name:</strong></div></td>
          <td width="148"><div align="center"><input type="text" name="part_name_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		 <tr>
          <td width="210"><div align="center"><strong>Wanted/Purchased:</strong></div></td>
           <td >
          <select name="wanted_purchased_fd" >
		  <option value="Wanted">Wanted</option>
		 <option value="Purchased">Purchased</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
	     <tr>
          <td><div align="center"><strong>Part Description</strong></div></td>
 		  <td align="center" width="50" height="5"><textarea name="part_description_fd" cols="40" rows="10"></textarea> </td>
           <td>&nbsp;</td>
        </tr>
		<tr>
          <td width="550"><div align="center"><strong>Desired/Actual Cost:</strong></div></td>
          <td width="148"><div align="center"><input type="text" name="desired_cost_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
 	 </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	    <input type="reset" name="Clear" value="Clear Form and Start Over">
       <br>
       <br>
       <table width="200">
         <tr>
           </tr>
       </table>
       <br>
       </textarea>
       <br>
     </div>
</form>
	</body>
</html>
';






}

 if ($_REQUEST['submit']) {
        $part_name=$_REQUEST['part_name_fd'];
		$part_description=$_REQUEST['part_description_fd'];
		$part_category=$_REQUEST['part_category_fd'];
		$desired_cost=$_REQUEST['desired_cost_fd'];
		$enter_date=date("Y-m-d h:i:s");
		$wanted_purchased=$_REQUEST['wanted_purchased_fd'];
$username = $session_username;
mysqli_connect("$Host","$User","$Password","$DBName");
$Link = mysqli_connect($Host, $User, $Password, $DBName);
$query ="INSERT INTO tb_restoration_parts(part_name,part_description,part_category,username,before_after_row_id,desired_cost,enter_date,wanted_purchased)
 VALUES ('$part_name','$part_description','$part_category','$username','$id_temp_add_var','$desired_cost','$enter_date','$wanted_purchased')";
			#print "user_var = $user_var\n";
		#print " Query $query \n";
		$result=mysqli_query($Link, $query) or die ('Insert Query Failed' . mysqli_error($Link));

		if    ($result)
		{
			  $edit_row = $_REQUEST['bfore_aftr_row_id'];
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$edit_row.'"</script>';
		  }
		  else
		  {
		  echo "<b>ERROR: unable to post.</b>";
		  mysqli_close($Link);
		  }


	 }


include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>

</html>