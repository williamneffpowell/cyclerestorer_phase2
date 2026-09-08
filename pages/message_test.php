<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../message_test.php';
   //including phpBB3 stuff   
 //  define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';
$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($user->data['is_registered'])
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Send a message" onClick="goTo_message_link()">
</form>';
}
if (!$user->data['is_registered'])
{
$target_url_in = '/pages/message_test.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto = $_SESSION['target_url'];
$loginvar = '<form align="center">
<input type=button value="Log In to add Links" onClick="goTo_message_link()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goTo_message_link(){ window.location = "http://www.cyclerestorer.com/pages/test_send_private_message.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title>Cyclerestorer Links </title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center"> 
  <table width="74%" height="236" border="0">
    <tr>
      <td width="37%" height="232" align="center"><p align="center" class="Wh_TNR_Large"><img src="../Images/link_thumb.jpg" width="138" height="89" align="middle"></p>
      <span class="style1"></span></td>
      <td width="19%"><p align="center" class="Wh_TNR_Large"><h3>Cyclerestorer</h3> </p>
        <p align="center" class="Wh_TNR_Large"><h2>Message Test Program</h2></p>
        <p align="center">&nbsp;</p></td>
      <td width="44%">&nbsp;</td>
    </tr>
  </table>
</div>

  <?php




echo "</table>\n";

echo "<br>";
echo "<br>";
print "<table align='center'><tr align='center'><td>$loginvar</td></tr></table>"; 

echo "<br>";
echo "<br>";

 


// Closing connection
#mysql_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>



