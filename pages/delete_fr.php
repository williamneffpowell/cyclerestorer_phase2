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
$loginvar =  '<form align="center">
<input type=button value="Add a Cycle Show" onClick="goToadd_link()">
</form>';
}
else
{
$target_url_in = 'pages/delete_fr.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to Delete a potential Friend" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################



if ($userID > 0) {

if ($uid <> "" && $friend[0] == "") {$friend[0] = $uid;}

$i=0; 
while($i<count($friend)){ 
$fid = $friend[$i];

$Query = "DELETE FROM tb_friend_pending WHERE requestorID=$fid AND friendID=$userID;";
$Result = mysql_db_query ($DBName, $Query, $Link);

$i = $i + 1;
}

header("Location: friend_requests.php");



} // END IF LOGGED IN

else {print ("Error");}






mysql_close ($Link);

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';



?>