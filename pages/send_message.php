<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;
include('functions.php');
include '../includes/dbconnect.inc.php';

$Link = mysqli_connect($Host, $User, $Password, $DBName); 

if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";
}
if (!$is_logged_in)
{
$logged_on = "no";
$target_url_in = '/pages/send_message.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';


}
########################################################################################################
#             End of Login
########################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>



   <title>Send Message</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1>Send a Message</h1>
<br>

</div>
<?php
if ($logged_in_var == "yes") {                      


?>



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
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
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

<SCRIPT TYPE="text/javascript">
function check_form() {
var errs=0;
if (document.forms.message.recipient.value == '') {alert('Please enter recipient'); errs=1;}
else if (document.forms.message.subject.value == '') {alert('Please enter a subject'); errs=1;}
return (errs==0);
}

</SCRIPT>


<BR>

<TABLE ALIGN=CENTER bgcolor=eeeeee>
<FORM NAME=message ACTION=newmessage.php METHOD=POST enctype="multipart/form-data" onSubmit="return check_form();">
<TR><TH colspan=2 bgcolor=79888E>Send Private Message</TH></TR>
<TR>
<TD>To: </TD>
<TD><INPUT TYPE=TEXT NAME=recipient VALUE="<?php echo $rec;?>" size=15> (Enter Cyclerestorer Username)</TD>
</TR>

<TR>
<TD>Subject:</TD>
<TD><INPUT TYPE=TEXT NAME=subject VALUE="<?php echo $sub;?>" size=40></TD>
</TR>

<TR>
<TD colspan=2>
<textarea id="elm1" name="body" rows="15" cols="60" style="width: 100%"></textarea>
</TD>
</TR>

<TR><TD colspan=2><CENTER><INPUT TYPE=SUBMIT VALUE="Send Message"></center></td></tr>
</FORM>
</TABLE>

<BR>
<?php

mysqli_close($Link);

// End check log in
#}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
}
?>