<?php

$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_resource_link.php';
   //including phpBB3 stuff
   require '../includes/auth_check.inc.php';
$session_username = $session_username;
include '../includes/dbconnect.inc.php';
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$session_username = $_SESSION['user_name'];
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];

if ($is_logged_in) {
$Link = mysql_connect ($Host, $User, $Password);
//$Query = "SELECT username, userID FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
//$Result = mysql_db_query ($DBName, $Query, $Link);
//$Row = mysql_fetch_array ($Result);
//$username = $Row[0];
//$userID = $Row[1];
}
if (!$is_logged_in)
{

echo "<br>";
echo "<br>";
echo "<table align='center'>";
echo "<tr>&nbsp;</tr>";
echo "<tr>&nbsp;</tr>";
echo "</table align='center'>";
echo "<br>";


# Do Nothing print_html_add();
mysql_close ($Link);


$logged_on = "no";

$target_url_in = 'pages/add_rest_techniques.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
//No Session Variable
$failed = 1;

}
	  # if(!mysql_db_query($dbname,$query,$link_id)) die(mysql_error());
		# echo "success in database entry.";
//END CHECK LOGIN ##################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Add Restoration Technique </title>
   <script type="text/javascript">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</head>
<body>


<script>
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


<?

print_html_add();
function print_html_add() {
print '
<form name=adform method="POST" onsubmit="return validate_form(this)">
     <div align="center"><h1><b>Restoration Technique</h1></b> </div>
	 <br>
	 <br>
	 <h3 align="center">* = Required </h3>
  <div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width="210"><div align="center"><strong>Title:</strong></div></td>
           <td >
         <input type="text" name="item_title_fd" size="50" >
             </div></td>
          <td width="50">&nbsp;</td>
        </tr>

        <tr>
          <td width="210"><div align="center"><strong>Manufacturer</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="manufacturer_fd">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Model</strong></div></td>
          <td><input type="text" name="model_fd"></td>
          <td>&nbsp;</td>
        </tr>
		  <tr>
          <td><div align="center"><strong>Year</strong></div></td>
          <td><input type="text" name="year_fd"></td>
          <td>&nbsp;</td>
        </tr>
		      <tr>
          <td><div align="center"><strong>* Description</strong></div></td>

		  <td align="center" width="50" height="5"><textarea name="description_fd" cols="40" rows="10"></textarea> </td>

          <td>&nbsp;</td>
        </tr>
		        <tr>
          <td width="210"><div align="center"><strong>cost</div></td>
          <td width="148"><div align="center">
            <input type="text" name="cost_fd">
          </div></td>
          <td>&nbsp;</td>
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
$today = date("Y-m-d h:i:s");
 if ($_REQUEST['submit']) {
        $rest_technique=$_REQUEST['rest_technique_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$year=$_REQUEST['year_fd'];
		$description=$_REQUEST['description_fd'];
		$cost=$_REQUEST['cost_fd'];
		$state=$_REQUEST['state_fd'];
		$country=$_REQUEST['country_fd'];
		$item_title=$_REQUEST['title_fd'];
	


mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());
$Link = mysql_connect ($Host, $User, $Password);
//$session_userID = $_SESSION['user_ID'];
$session_username = $session_username;
$query ="INSERT INTO tb_rest_tech(username,contact_email,phone,rest_technique,date_entered,manufacturer,model,year,description,cost,state,country,item_title,parts_bike,userID)
 VALUES ('$session_username','$email','$phone','$rest_technique','$today','$manufacturer','$model','$year','$description','$cost','$state','$country','$item_title','$parts_bike','$session_userID')";
			#print "user_var = $user_var\n";
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed' . mysql_error());

		if    ($result)
		{
		echo "Successfully Entered" ;

		  }
		  else
		  {
		  echo "<b>ERROR: unable to post.</b>";
		  mysql_close ($Link);
		  }

		  if ($parts_bike)
		  {
		  #shouldn't you pass the number of the bike that has the parts?
	  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/restoration_techniques.php"</script>';
		  }

	 }


?>






<?php
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>

</html>