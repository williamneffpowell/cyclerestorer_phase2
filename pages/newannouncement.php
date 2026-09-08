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
$target_url_in = 'pages/newannouncement.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
########################################################################################################
#             End of Login
########################################################################################################


include('functions.php');

if (checklogin($userID, 'myaccount.php')) {


if ($announcement <> "") {


$Query = "SELECT u.userID FROM auth_user AS u, friends AS f WHERE f.userID=$userID AND u.userID=f.friendID";
$Result = mysql_db_query ($DBName, $Query, $Link);

while ($Row = mysql_fetch_array ($Result)) {

$Query2 = "INSERT into tb_announcement VALUES ('', $Row[0], $userID, '$announcement', now())";
$Result2 = mysql_db_query ($DBName, $Query2, $Link);
}

#print_header($username);

print ("<BR><H2 align=center>Your Announcement Has  Been Sent</H2><HR>
<H4 align=center><A HREF=myaccount.php?uid=$uid>click here to continue</A></H4><BR>");

#print_footer($username);



}
else {
#print_header($username);
print ("<BR><H2 align=center>Announcement text was blank</H2><BR><BR><H3 align=center><A HREF=\"javascript:history.back(1)\">click here to continue</A></H3><BR>");
#print_footer($username);
}









mysql_close ($Link);

// END CHECK LOGIN
}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>