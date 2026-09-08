<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_video.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();
$edit_row = $_REQUEST['edit_row'];


$session_username = $user->data['username'];
$userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

if ($user->data['is_registered'])
{
# LOGIN OK
$logged_in_var = "yes";

}
if (!$user->data['is_registered'])
{
$logged_on = "no";
$target_url_in = '/pages/add_video.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
########################################################################################################
#             End of Login
########################################################################################################
include('functions.php');

if ($logged_in_var == "yes") {



//$session_username
//print_header($session_username); 




//if ($status == 0) {

//print ("<BR><H3 align=center><FONT COLOR=0000ff>Please check your email for your verification email</FONT></H3>
//<H5 align=center>You will not be able to add videos until you verify your email address</H5>
//<HR><BR><BR><BR>
//");

//}

//else {

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
		mode : "exact",
		elements : "elm1",
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

<SCRIPT>
function check_form() {
var errs=0;
if (document.forms.video.title.value == '') {alert('Please enter a title'); errs=1;}
else if (document.forms.video.catID.value == -1) {alert('Please select a category'); errs=1;}
else if (document.forms.video.embed.value == '') {alert('Please enter your embed code'); errs=1;}


return (errs==0);
}
</SCRIPT>







<BR>



<FORM NAME=video ACTION=newvideo.php?edit_row=<?echo $edit_row;?> METHOD=POST onSubmit="return check_form();">
<TABLE align=center bgcolor=eeeeee width=700>
<TR><TH colspan=2 bgcolor=79888E>Add New Video</TH>
</TR>
<TR>
<TD>Video Title</TD>
<TD><INPUT TYPE=TEXT NAME=title SIZE=60 value="<?echo $title;?>"></TD>
</TR>
<TR>
<TD>Category</TD>
<TD>
</TD>
</TR>

<TR>
<TD valign=top>Description</TD>
<TD><textarea id="elm1" name="description" rows="15" cols="40"><?echo $description;?></TEXTAREA></TD>
</TR>

<input type="hidden" name="showID" value= "<?echo $edit_row;?> ">
<TR>
<TD valign=top>Embed Code</TD>
<TD><textarea name="embedcode" rows="3" cols="60"></TEXTAREA></TD>
</TR>
<TR><TD colspan=2>
<BR>
<TABLE ALIGN=CENTER width=350 bgcolor=eeeeee cellpadding=2 cellspacing=2 border=1>


</TABLE>

<BR>
<CENTER><INPUT TYPE=SUBMIT VALUE="Add Video"></CENTER>
<BR>

</TD></TR>
</FORM>
</TABLE>
<BR>




<?php

} //end check status

mysql_close ($Link);


// End check log in

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>