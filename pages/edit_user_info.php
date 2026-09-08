<?PHP
require '../includes/auth_check.inc.php';
$session_username = $session_username;
$session_userid= $_SESSION['user_id'];	



//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES

include '../includes/dbconnect.inc.php';
#if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);
#$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
#$Result = mysql_db_query ($DBName, $Query, $Link);
#$Row = mysql_fetch_array ($Result);
#$username = $Row[0];
//Session doesn't exist
if ($is_logged_in)
{
#print_edit_add();
#print "logged in ";

}
if (!$is_logged_in)
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = 'pages/edit_user_info.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.
#This is the production Link: http://www.cyclerestorer.com/pages/login.php
#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/login.php
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
#$id_temp_var = $_REQUEST['edit_row'];
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT bio, url, picID FROM auth_user  where (username ='$session_username')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
//$bio_tab = $Row[0];
//$url_tab = $Row[1];
$pic_id_var = $Row[2];



$Query2 = "SELECT filename,caption FROM tb_pictures WHERE (picID='$pic_id_var')";
$result2 = mysql_query($Query2) or die('Query2 failed: ' . mysql_error());
$Row2 = mysql_fetch_array($result2);

#Print $Query2;

#echo $Row2[0];



?>
<html>
<head>
<script language="javascript" type="text/javascript" src="javascript/tiny_mce/tiny_mce_gzip.js"></script>
<script type="text/javascript" src="javascript/checkbox.js"></script> 
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">


<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
{
if (value==null||value=="")
  {alert(alerttxt);return false}
else {return true}
}
}

function validate_form(editform)
{
with (editform)
{
if (validate_required(usernme,"The 'User Name' field must be filled out!")==false)
  {manufacturer.focus();return false}
if (validate_required(email,"Email must be filled out!")==false)
  {model.focus();return false}
if (validate_required(password,"The 'password' field must be filled out!")==false)
  {year.focus();return false} 
}
}
</script>

</HEAD>
   <title>Edit User Registration </title>	

	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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




<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<form name=editform onSubmit="return validate_form(this)" method="POST" >
<br>
<br>
     <div align="Center"><h1><b>Edit User Information</b></h1> </div>
   </form>
   <form method="POST" ><div align="left">
     <table align="center" width="384" border="0">
        <caption>&nbsp;
        </caption>   
         
		<tr>
          <td class="wh_tnr_12"><div align="left"><strong>Bio:</strong></div></td>
		  <TD><textarea  name="bio" rows="10" cols="40"><? echo $Row[0];?></TEXTAREA></TD>
          <td>&nbsp;</td>
        </tr>
       
		 <tr>
           <td><div align="left"><strong>Your Website URL http://</strong></div></td>
          <td><input type="text" name="url" value="<?PHP echo $Row[1]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
			  
	
		</table>
		
       <br>
	   <table align="center">
	   <tr align="left">
	   <td align="left"><input  type="submit" name="submit" value="Submit">
	   <input  type="submit" name="delete" value="delete"></td>
	   </tr>
	   </table>
       <br>

 
  
       </textarea>
    
     </div>
</form> 

	</body>
</html>
 


<?PHP

		#print "In the if ";
if ($_REQUEST['submit']) {
	
		$bio=$_REQUEST['bio'];	
	
		$url=$_REQUEST['url'];
		
$Query = "UPDATE auth_user SET  bio = '$bio',url = '$url' WHERE username = '$session_username'";
	$result=mysql_query($Query) or die ( 'Update Query Failed $Query'. mysql_error());

		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/index.php" </script>';
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
	    } 
}

		

		#$result=mysql_query($Query) or die ('Update Query Failed $Query');
		




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
<CENTER>* Images must be GIF or JPEG.</CENTER>
</TD></TR>
</TABLE>
<BR>


<TABLE width=600 ALIGN=CENTER>
<FORM ACTION=update_profile_pic.php METHOD=POST enctype="multipart/form-data">
<TR><TD valign=top>
Profile Image
</TD>
<TD valign=top>
<IMG SRC="..//userpics/<?PHP echo $Row2[0]; ?>" alt="<?echo $Row2[1];?>">
</TD>
</TR>
<TR>
<TD valign=top>Upload New Image</TD>
<TD><input type=file name=imagefile></TD>
</TR>
<TR>
<TD valign=top>
New Image Caption
</TD>
<TD valign=top><INPUT TYPE=TEXT NAME=caption SIZE=40 VALUE=""></TD></TR>
<TR><TD colspan=2><CENTER><INPUT TYPE=SUBMIT VALUE="Update Image"></TD></TR>
</FORM>
</TABLE>
<BR>
<HR>
<BR>



<p>
<?php 
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

