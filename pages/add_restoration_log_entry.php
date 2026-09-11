<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';
mysqli_connect("$Host","$User","$Password","$DBName");
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$session_username = $_SESSION['user_name'];

$edit_row = $_REQUEST['edit_row'];

$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
if ($is_logged_in) {
$Link = mysqli_connect($Host, $User, $Password, $DBName);
$Query = "SELECT username, userID FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
$Result = mysqli_query($Link, $Query);
$Row = mysqli_fetch_array($Result);
$username = $Row[0];
$userID = $Row[2];
#print "usernerm $username\n";
//Session doesn't exist

}

If ($is_logged_in)
{

echo "<br>";
echo "<br>";
echo "<table align='center'>";
echo "<tr>&nbsp;</tr>";
echo "<tr>&nbsp;</tr>";
echo "</table align='center'>";
echo "<br>";
//$todo_or_log = $_REQUEST['todo_or_log'];


print_html_add($_REQUEST['bfore_aftr_row_id'],$_REQUEST['todo_or_log']);
# Do Nothing print_html_add();
mysqli_close($Link);

}
If (!$is_logged_in)
{
$logged_on = "no";

$target_url_in = 'pages/add_restoration_log_entry.php';
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
//$id_temp_add_var = $_REQUEST['bfore_aftr_row_id'];
//$todo_or_log = $_REQUEST['todo_or_log'];

#print "<h5>LOG VALUE = $target_url_goto </h5>";
#******************************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Add Restoration Log Entry </title>

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
function print_html_add($bfore_aftr_row_id,$todo_or_log) {
print ("

<form name=adform method=\"POST\" onsubmit=\"return validate_form(this)\" action=\"add_restoration_log_entry.php\">
<input type=\"hidden\" name=\"bfore_aftr_row_id\" value=\"$bfore_aftr_row_id\">
<input type=\"hidden\" name=\"todo_or_log\" value=\"$todo_or_log\">
     <div align=\"center\"><h1><b>Add Restoration Log Entry</h1></b> </div>
  <div align=\"center\">
     <table  align=\"center\" width=\"600\" border=\"0\">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width=\"550\"><div align=\"center\"><strong>* Log Title:</strong></div></td>
          <td width=\"148\"><div align=\"center\"><input type=\"text\" name=\"log_title_fd\">
            <br>
          </div></td>
          <td width=\"12\">&nbsp;</td>
        </tr>
	     <tr>
          <td><div align=\"center\"><strong>Description</strong></div></td>
 		  <td align=\"center\" width=\"50\" height=\"5\"><textarea name=\"description_fd\" cols=\"40\" rows=\"10\"></textarea> </td>
           <td>&nbsp;</td>
        </tr>

		<tr>
		<td>
		<strong><span>Work Start Date</span></strong>
		</td>
		<td>
		<input id=\"demo1\" type=\"text\" size=\"25\" name=\"start_date_fd\"><a href=\"javascript:NewCal(\'demo1\',\'YYYYMMDD\')\"><img src=\"../Images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Pick a Start date\"></a>
	  	</td>
		</tr>
          	<tr>
			<td>
			<strong><span>Work End Date</span></strong>
			</td>
			<td>
		<input id=\"demo2\" type=\"text\" size=\"25\" name=\"end_date_fd\"><a href=\"javascript:NewCal(\'demo2\',\'YYYYMMDD\')\"><img src=\"../Images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Pick a End date\"></a>
	  	</td>
        </tr>
		<tr>
          <td width=\"550\"><div align=\"center\"><strong>Hours Spent:</strong></div></td>
          <td width=\"148\"><div align=\"center\"><input type=\"text\" name=\"hours_spent_fd\">
            <br>
          </div></td>
          <td width=\"12\">&nbsp;</td>
        </tr>

		<tr>
          <td width=\"550\"><div align=\"center\"><strong>Cost:</strong></div></td>
          <td width=\"148\"><div align=\"center\"><input type=\"text\" name=\"cost_fd\">
            <br>
          </div></td>
          <td width=\"12\">&nbsp;</td>
        </tr>
 	 </table>
       <br>
       <input type=\"submit\" name=\"submit\" value=\"Submit\">
	    <input type=\"reset\" name=\"Clear\" value=\"Clear Form and Start Over\">
       <br>
       <br>
       <table width=\"200\">
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
");
}

 if ($_REQUEST['log_title_fd'] <> "") {
        $log_title=$_REQUEST['log_title_fd'];
		$description=$_REQUEST['description_fd'];
		$work_start_date=$_REQUEST['start_date_fd'];
		$work_end_date=$_REQUEST['end_date_fd'];
		$hours_spent=$_REQUEST['hours_spent_fd'];
		$cost=$_REQUEST['cost_fd'];
		$enter_date=date("Y-m-d h:i:s");
		$user_var=$_REQUEST["user_form_var"];
		

		//$log_or_goto_var=$_REQUEST["user_log_or_goto_var"];

		//$log_or_goto_var = $_REQUEST['todo_or_log'];

$todo_or_log = $_REQUEST['todo_or_log'];
$bfore_aftr_row_id = $_REQUEST['bfore_aftr_row_id'];
$username = $session_username;
//print "<h2>from the form user_var = $username\n</h2>";
//print "<h2>from the request var todo_or_log = $todo_or_log \n</h2>";
//print "<h2>From the header  edit_row = $bfore_aftr_row_id \n</h2>";




mysqli_connect("$Host","$User","$Password","$DBName");
$Link = mysqli_connect($Host, $User, $Password, $DBName);

$query ="INSERT INTO tb_restoration_work(log_title,work_description,work_start_date,work_end_date,enter_date,hours_spent,username,before_after_row_id,cost,category)
 VALUES ('$log_title','$description','$work_start_date','$work_end_date','$enter_date','$hours_spent','$username','$bfore_aftr_row_id','$cost','$todo_or_log')";
			#print "user_var = $user_var\n";
		//print " Query $query \n";
		$result=mysqli_query($Link, $query) or die ('Insert Query Failed' . mysqli_error($Link));

		if    ($result)
		{
					  $edit_row = $_REQUEST['bfore_aftr_row_id'];
			//	echo '<script language="JavaScript" type="text/javascript">
			//	window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row='.$edit_row.'"</script>';
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