<?PHP
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
#**************************************************************************
# The row to select from the Before_after Page selection 
$reg_picID = $_REQUEST['picID'];
$reg_rowID = $_REQUEST['edit_row'];
$_SESSION['reg_rowID'] = "$reg_rowID";
#******************************************************************
if ($Row[0] <> "")
{
# LOGIN OK

#$Query = "UPDATE auth_user SET sesnID='$sid' WHERE username='$username'";
if ($reg_picID <> "" )
{
#$reg_picID = "0";
}
$Query = "SELECT p.filename, p.caption FROM tb_pictures AS p, auth_user AS u WHERE u.userID=$userID AND '$reg_picID'=p.picID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "") {$mainpic = "$Row[0]";}
else {$mainpic = "default.jpg";}
$caption = $Row[1];
?>



<H2 align=center>Add Registry Picture</H2>


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
<FORM ACTION=update_registry_pic.php METHOD=POST enctype="multipart/form-data">
<TR><TD valign=top>
Registry Image
</TD>
<TD valign=top>
<IMG SRC="../image_upload/<?echo $mainpic;?>" alt="<?echo $caption;?>">
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



<?PHP
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

}
?>

<p>&nbsp;</p>
</body>
</html>