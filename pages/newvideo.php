<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;
//$SESSION['showID'] = $showID;

include '../includes/dbconnect.inc.php';
$showID = $_REQUEST['edit_row'];

$Link = mysqli_connect($Host, $User, $Password, $DBName); 


if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";
}
if (!$is_logged_in)
{
$logged_on = "no";
$target_url_in = '/pages/newvideo.php';
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

$title = $_REQUEST['title'];
$embedcode = $_REQUEST['embedcode'];
$description = $_REQUEST['description'];




if ($title <> "" && $embedcode <> "" ) {

// Lets check Embed code

$failed = 0;
// must have width, height | must have either embed, object, or script
if ( (strpos($embedcode, "<embed") === false) && (strpos($embedcode, "<object") === false) && (strpos($embedcode, "<script") === false)) {$failed = 1;}

if (strpos($embedcode, "width") === false) {$failed = 1;}

if (strpos($embedcode, "height") === false) {$failed = 1;}

// END CHECK EMBED
	if ($failed == 0) {
	//YouTube Autoplay
		if (strpos($embedcode, "youtube") > 0) {
		if (strpos($embedcode, "autoplay") === false) {
			$embedcode = str_replace("&rel=1", "&rel=1&autoplay=1", $embedcode);
			}
		}

//Revver Autoplay
	if (strpos($embedcode, "revver") > 0) {
		if (strpos($embedcode, "autoStart") === false) {

		$embedcode = str_replace("player.js?", "player.js?flashvars:autoStart=true;", $embedcode);
		}
	}
// INSERT USER 
$Query = "INSERT into tb_video VALUES ('', '','$title','$description','','$embedcode','',0,0,'',CURDATE(),'',1,'$showID','$session_username')";

if (mysqli_query($Link, $Query)) {

$Query = "SELECT videoID FROM tb_video WHERE username='$username' AND title='$title' ORDER BY videoID DESC;";
$Result4 = mysqli_query($Link, $Query)  or die ('Update Query Failed $Query2');
$Row = mysqli_fetch_array($Result4);
$videoID = $Row[0];

#header("Location: edit_video.php?videoID=$videoID");
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php" </script>';
}
else {print ("Database Error!<BR>$Query");}

} // End Check failed

else {
print ("<BR><H2 align=center>We were unable to verify your embed code</H2><HR>
<TABLE ALIGN=CENTER WIDTH=600>
<TR><TD>
We're sorry, but the embed code you submitted does not appear to be a valid video. 
Please go back and double check it. If you continue to have difficulties please email webmaster@cyclerestorer.com
</TD></TR>
</TABLE>
<BR>
<CENTER>
<FORM ACTION=add_video.php METHOD=POST>
<INPUT TYPE=HIDDEN NAME=title VALUE=\"$title\">
<INPUT TYPE=HIDDEN NAME=description VALUE=\"$description\">
<INPUT TYPE=SUBMIT VALUE=Continue>
</FORM>
</CENTER><BR><BR>
");

}

}
else {print ("incomplete form");}

mysqli_close($Link);

// END CHECK LOGIN
}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>