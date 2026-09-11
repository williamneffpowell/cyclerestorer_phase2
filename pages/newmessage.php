<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;


include '../includes/dbconnect.inc.php';

$Link = mysqli_connect($Host, $User, $Password, $DBName); 

if ($is_logged_in)
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Resource Link" onClick="goTo_send_message()">
</form>';
}
if (!$is_logged_in)
{
$target_url_in = '/pages/newmessage.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Send Private Message-                       -++" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################
$subject = $_POST['subject'];
$body = $_POST['body'];
$recievername = $_POST['receivername'];
include('functions.php');
print "<h5> Receivername = $recievername </h5>";
print "<h5> Subject = $subject </h5>";
print "<h5> body = $body </h5>";
//$Query = "SELECT username, user_email FROM phpbb_users WHERE username='$receivername' ";
//$Result = mysqli_query($Link, $Query);
//$Row = mysqli_fetch_array($Result);

print "<table align='center'><tr align='center'><td>$loginvar</td></tr></table>"; 




mysqli_close($Link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

//End check login

?>