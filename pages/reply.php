<?php
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
#include('init.php');
include('functions.php');

$username = $_POST['username'];

$Link = mysql_connect("$Host","$User","$Password");	

mysql_select_db("$DBName") or die ("unable to select DB");
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$userID = $Row[15];
if ($Row[0] <> "")
{
# LOGIN OK
}
else
{
$target_url_in = 'pages/reply.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit an ad" onClick="goToLogin()">
</form>';
}

####################################################################################
#### End of LOGON
####################################################################################
print_header($username); 
if (checklogin($userID, "reply.php?topicID=$topicID")) {


if ($topicID <> "" && $post <> "") {

$post = substr($post,0,5024);
$post = nl2br($post);


$Query = "UPDATE tb_forum_topics SET lastpost=CURDATE(), posts=posts+1 WHERE topicID=$topicID;";
$Result = mysql_db_query ($DBName, $Query, $Link);


$Query = "INSERT into tb_forum_posts  values ('0', '$topicID', '$post', '$userID', CURDATE());";
$Result = mysql_db_query ($DBName, $Query, $Link);

header("Location: forum.php");


}


else {


#print_header($username);





if ($topicID > 0) {

$Query = "SELECT topic FROM tb_forum_topics WHERE topicID=$topicID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$topic = $Row[0];



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

<?




print ("





<TABLE WIDTH=756 BORDER=0 CELLPADDING=0 CELLSPACING=0 align=center bgcolor=ffffff>
<TR><TD>

<BR>
<H2 align=center>Cycle Restorer Forum</H2>
<HR>


<TABLE ALIGN=CENTER WIDTH=700>
<TR>
<TD><P><A HREF=\"forum.php\" class=medium>Return to Forum Index</A></P></TD>
</TR>
</TABLE>

<TABLE ALIGN=CENTER WIDTH=700 bgcolor=eeeeee>
<FORM ACTION=reply.php METHOD=POST>
<INPUT TYPE=HIDDEN NAME=topicID VALUE=$topicID>
<TR><TH BGCOLOR=79888E colspan=2>Post Reply</TH></TR>

<TR>
<TD width=100 class=gray>Subject</TD>
<TD>
<span class=subheading>$topic</span>
</TD></TR>
<TR>
<TD width=100 class=gray>Post</TD>
<TD>
<TEXTAREA NAME=post id=\"elm1\" rows=\"15\" cols=\"60\" style=\"width: 100%\"></TEXTAREA>
</TD></TR>

<TR><TD></TD><TD><CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Post\"></CENTER></TD></TR>

<TR><TD colspan=2 bgcolor=79888E><BR></TD></TR>
</FORM>
</TABLE>

");



?>

<BR>
</TD></TR>
</TABLE>




<?php
print_footer($username);
mysql_close ($Link);
#print_footer($username);


// END IF TOPIC ID > 0
}

//END IF TOPIC AND POST ARE BLANK
}

//END CHECK LOGIN
}
?>
