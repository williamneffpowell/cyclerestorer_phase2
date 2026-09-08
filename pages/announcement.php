<?php
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$userID = $_SESSION['user_ID'];
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
$target_url_in = 'pages/announcement.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
########################################################################################################
#             End of Login
########################################################################################################


include('functions.php');

if (checklogin($userID, "myaccount.php")) {

#print_header($username); 


print ("<BR><CENTER>");
#echo show_ad(1);
print ("</CENTER><BR>");


?>

<BR>

<TABLE ALIGN=CENTER bgcolor=eeeeee>
<FORM ACTION=newannouncement.php METHOD=POST>
<TR><TH colspan=2 bgcolor=79888E>Send announcement to all your friends</TH></TR>
<TR>
<TD colspan=2>
<textarea name="announcement" rows="5" cols="60"></textarea>
</TD>
</TR>

<TR><TD colspan=2><BR><CENTER><INPUT TYPE=SUBMIT VALUE="Send Announcement"></center></td></tr>
</FORM>
</TABLE>

<BR>
<?php

mysql_close ($Link);
#print_footer($username);

// End check log in
}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>