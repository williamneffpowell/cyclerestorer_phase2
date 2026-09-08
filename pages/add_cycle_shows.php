<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_serial_numbers.php';
   //including phpBB3 stuff   
  
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');
$username = $user->data['username'];
// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();
include '../includes/dbconnect.inc.php';
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$session_username = $_SESSION['user_name'];
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);

}

#print "usernerm $username\n";
//Session doesn't exist

if ($user->data['is_registered'])
{

echo "<br>";
echo "<br>";
echo "<table align='center'>";
echo "<tr>&nbsp;</tr>";
#echo "<tr><td><H1>Add Cycle Shows</H1></td></tr>";
echo "<tr>&nbsp;</tr>";
echo "</table align='center'>";
echo "<br>";

print_html_add();
# Do Nothing print_html_add();
mysql_close ($Link);

}
if (!$user->data['is_registered'])
{
$logged_on = "no";

$target_url_in = 'pages/add_cycle_shows.php';
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
#print "usernameagain $username\n";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Add Cycle Shows </title>

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

<?PHP
function print_html_add() {
print '
<form name=adform method="POST" onsubmit="return validate_form(this)">
     <div align="center"><h1><b>Add Cycle Shows</h1></b> </div>
  <div align="center">
     <table  align="center" width="600" border="0">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width="550"><div align="center"><strong>* Show Name:</strong></div></td>
          <td width="148"><div align="center"><input type="text" name="show_name_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>* Show City: </strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="show_city_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        <tr>
          <td width="210"><div align="center"><strong>* Show State</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="show_state_fd">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Show Zipcode</strong></div></td>
          <td><input type="text" name="show_zipcode_fd"></td>
          <td>&nbsp;</td>
        </tr> 
		      <tr>
          <td><div align="center"><strong>Comment</strong></div></td>
 		  <td align="center" width="50" height="5"><textarea name="comment_fd" cols="40" rows="10"></textarea> </td>
           <td>&nbsp;</td>
        </tr>
		
		<tr>
		<td>
		<strong><span>Select a Start Date</span></strong>
		</td>
		<td>
		<input id="demo1" type="text" size="25" name="start_date_fd"><a href="javascript:NewCal(\'demo1\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick a Start date"></a>
	  	</td>
		</tr>
          	<tr>
			<td>
			<strong><span>Select an End Date</span></strong>
			</td>
			<td>
		<input id="demo2" type="text" size="25" name="end_date_fd"><a href="javascript:NewCal(\'demo2\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick a End date"></a>
	  	</td>
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
        $show_name=$_REQUEST['show_name_fd'];
		$show_address=$_REQUEST['show_address_fd'];
		$show_city=$_REQUEST['show_city_fd'];
		$show_state=$_REQUEST['show_state_fd'];
		$show_zipcode=$_REQUEST['show_zipcode_fd'];
		$comment=$_REQUEST['comment_fd'];
		$start_date=$_REQUEST['start_date_fd'];
		$end_date=$_REQUEST['end_date_fd'];
		$enter_date=date("Y-m-d h:i:s");
		
$session_username = $_SESSION['user_name'];				
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);		 
 
$query ="INSERT INTO cycle_shows(show_name,show_address,show_city,show_state,show_zipcode,comment,start_date,end_date,enter_date,username)
 VALUES ('$show_name','$show_address','$show_city','$show_state','$show_zipcode','$comment','$start_date','$end_date','$enter_date','$session_username')"; 
			#print "user_var = $user_var\n";  
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed' . mysql_error());
			
		if    ($result) 
		{ 
				  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/cycle_shows.php"</script>';

	
		  }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link);
		  }
		  
		  
	 } 
		

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>

</html>