<?php
require '../includes/auth_check.inc.php';
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';
$Link = mysqli_connect($Host, $User, $Password, $DBName); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysqli_query($Link, $Query);
$Row = mysqli_fetch_array($Result);
if ($is_logged_in)
{
# LOGIN OK
$loginvar = '<form align="center">
<input type=button value="Send a message" onClick="goTo_message_link()">
</form>';
}
if (!$is_logged_in)
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
#mysqli_close($link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>



