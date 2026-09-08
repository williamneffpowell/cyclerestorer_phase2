<?php

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
$loginvar =  '<form align="center">
<input type=button value="Add or Edit a Classified Ad" onClick="goToadd_link()">
</form>';
}
else
{
$target_url_in = 'pages/edit_profile.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit an ad" onClick="goToLogin()">
</form>';
}

####################################################################################
#### End of LOGON
####################################################################################
if (checklogin($userID, 'edit_profile.php')) {

print_header($username); 

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

<SCRIPT TYPE="text/javascript">
function check_form() {
var errs=0;
if (document.forms.profile.fname.value == '') {alert('Please enter your first name'); errs=1;}
else if (document.forms.profile.lname.value == 0) {alert('Please enter your last name'); errs=1;}
else if (checkMail()) {alert('Please enter a valid email address'); errs=1;}
else if (document.forms.profile.password.value == '') {alert('Please enter a password'); errs=1;}
else if (document.forms.profile.password.value != document.forms.profile.password2.value) {alert('Please make sure password is typed the same as in confirm password'); errs=1;}
return (errs==0);
}

function checkMail()
{
	var x = document.forms.profile.email.value;
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (filter.test(x)) return false;
	else return true;
}

</SCRIPT>



<?php


$Query = "SELECT first_name, last_name, email, bio, url FROM auth_user WHERE userID=$userID;";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);



$fname = $Row[0];
$lname = $Row[1];
$email = $Row[2];
$bio = $Row[3];
$url = $Row[4];
?>


<BR>



<H2 align=center>My Profile</H2>
<CENTER><A HREF=profile.php?uid=<?echo $userID;?>>see profile</A> | <A HREF=myvideos.php>manage videos</A></CENTER>




<TABLE width=600 ALIGN=CENTER CELLPADDING=2 CELLSPACING=2>
<TR><TD colspan=4 align=center><BR><HR><FONT COLOR=FF0000>*</FONT> indicates required field</TD></TR>
<FORM ACTION=updateuser.php NAME=profile METHOD=POST onSubmit="return check_form();">
<TR>
<TD width=20%>First Name <FONT COLOR=FF0000>*</FONT></TD><TD width=30%><INPUT TYPE=TEXT NAME=fname VALUE="<?echo $fname;?>" SIZE=15></TD>
<TD width=20%>Last Name <FONT COLOR=FF0000>*</FONT></TD><TD width=30%><INPUT TYPE=TEXT NAME=lname VALUE="<?echo $lname;?>" SIZE=15></TD>
</TR>
<TR>
<TD>Email Address <FONT COLOR=FF0000>*</FONT></TD><TD><INPUT TYPE=TEXT NAME=email VALUE="<?echo $email;?>" SIZE=25></TD>
<TD>Website <FONT COLOR=FF0000>*</FONT></TD><TD><INPUT TYPE=TEXT NAME=url VALUE="<?echo $url;?>" SIZE=25></TD>
</TR>


<TR><TD width=20% valign=top>Director's Bio</TD>
<TD colspan=3>
<textarea id="elm1" name="bio" rows="15" cols="50" style=\"width: 100%;\"><?echo $bio;?></TEXTAREA>
</TD></TR>
<TR>
<TD>Password <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT NAME=password TYPE=PASSWORD VALUE=blankpass></TD>
<TD>Confirm Password <FONT COLOR=FF0000>*</FONT></TD>
<TD><INPUT NAME=password2 TYPE=PASSWORD VALUE=blankpass></TD>

</TR>



<TR><TD colspan=4><HR><CENTER><INPUT TYPE=SUBMIT VALUE="Update Profile"> <INPUT TYPE=BUTTON VALUE="See Profile" onClick="window.location='profile.php?uid=<?echo $userID;?>';"></TD></TR>
</FORM>
</TABLE>
<HR>

</FORM>



<BR>

<?
$Query = "SELECT p.filename, p.caption FROM auth_user AS u, tb_pictures AS p WHERE u.userID=$userID AND u.picID=p.picID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "") {$mainpic = "userpics/$Row[0]";}
else {$mainpic = "userpics/default.jpg";}
$caption = $Row[1];

?>

<H2 align=center>Profile Picture</H2>


<TABLE align=center width=600 bgcolor=eeeeee>
<TR><TH bgcolor=79888E>Image Upload Policy</TH>
<TR><TD>
<CENTER><B>(<FONT COLOR=ff0000>Violating any of the below will result in removal from the site</FONT>)</B></CENTER>

<UL>
<LI>Please do not upload copyrighted images 
<LI>Do not upload pornographic pictures
<LI>Do not use this website to post SPAM or Ads for other products or services
</UL>
<CENTER>* Images must be GIF or JPEG and no greater than 1 MB in size.</CENTER>
</TD></TR>
</TABLE>
<BR>


<TABLE width=600 ALIGN=CENTER>
<FORM ACTION=update_profile_pic.php METHOD=POST enctype="multipart/form-data">
<TR><TD valign=top>
Profile Image
</TD>
<TD valign=top>
<IMG SRC="<?echo $mainpic;?>" alt="<?echo $caption;?>">
</TD>
</TR>
<TR>
<TD valign=top>Upload New Image</TD>
<TD><input type="file" name="imagefile"></TD>
</TR>
<TR>
<TD valign=top>
Image Caption
</TD>
<TD valign=top><INPUT TYPE=TEXT NAME=caption SIZE=40 VALUE="<?echo $caption;?>"></TD></TR>
<TR><TD colspan=2><CENTER><INPUT TYPE=SUBMIT VALUE="Update Image"></TD></TR>
</FORM>
</TABLE>
<BR>
<HR>
<BR>



<?php

mysql_close ($Link);
print_footer($username);

// End check log in
}


?>