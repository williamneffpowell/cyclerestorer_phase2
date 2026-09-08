<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../newmessage.php';
   //including phpBB3 stuff   

   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();

$session_username = $user->data['username'];


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

if ($user->data['is_registered'])
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Add a New Resource Link" onClick="goTo_send_message()">
</form>';
}
if (!$user->data['is_registered'])
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
if ($loginvar == "Yes")  {

//$Query = "SELECT username, user_email FROM phpbb_users WHERE username='$receivername' ";
//$Result = mysql_db_query ($DBName, $Query, $Link);
//$Row = mysql_fetch_array ($Result);


<HTML>
<head><script type="text/javascript">
function goTo_send_message(){ window.location = "http://www.cyclerestorer.com/pages/add_resource_links.php"; }

</script>
<BODY>


}


print "<table align='center'><tr align='center'><td>$loginvar</td></tr></table>"; 




mysql_close ($Link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

//End check login
}

?>