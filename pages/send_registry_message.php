<?php
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$userID = $_SESSION['user_ID'];
include('functions.php');
include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "")
{
# LOGIN OK
$logged_in_var = "yes";
}
else
{
$logged_on = "no";
$target_url_in = 'pages/send_registry_message.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In Send Message" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

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
<?

$Link = mysql_connect ($Host, $User, $Password);
$query = "(SELECT r.username,r.row_id,r.action,r.manufacturer,r.year,r.model,r.serial_number,r.owner,r.location,r.comments,r.entered FROM registry  AS r where r.row_id=$edit_row )";	
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array ($result);
 

?>

<BR>

<TABLE ALIGN=CENTER bgcolor=eeeeee>
<FORM NAME=message ACTION=newmessage.php METHOD=POST enctype="multipart/form-data" onSubmit="return check_form();">
<TR><TH colspan=2 bgcolor=79888E>Send Private Message</TH></TR>
<TR>
<TD>To: </TD>
<TD><INPUT TYPE=TEXT NAME=recipient VALUE="<?echo $rec;?>" size=15><?echo $Row[0];?></TD>
</TR>

<TR>
<TD>Subject:</TD>
<TD><INPUT TYPE=TEXT NAME=subject VALUE="<?echo $sub;?>" size=40>"<?echo $Row[3];?> <?echo $Row[4];?> <?echo $Row[5];?>"</TD>
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

mysql_close ($Link);

// End check log in
#}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
}
?>