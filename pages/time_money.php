<?PHP
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "")
{
# LOGIN OK
print '<form align="center">
<input type=button value="Add a time or expense." onClick="goToadd_link()">
</form>';

}
else
{

$target_url_in = 'pages/time_money.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
print '<form align="center">
<input type=button value="Log In to add Information" onClick="goToLogin()">
</form>';
}

function print_html_add() {
print '
<form method="POST" >
     <div align="center"><b>Cycle Registry </b> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="210"><div align="center"><strong>Link Name:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="resource_name">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>HTML Link</strong></div></td>
          <td><div align="center">
            <input type="text" name="html_link">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Link Comment</strong></div></td>
          <td><div align="center">
            <input type="text" name="link_comment">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Link Rating</strong></div></td>
          <td><input type="text" name="link_rating"></td>
          <td>&nbsp;</td>
        </tr>
         
         
         
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	    <input type="reset" name="Clear" value="Clear Form and Start Over">
       <br>
       <br>
       <a href="../index.php">Home</a> 
	   <a href="links.php">Back to Library</a>
       <table width="200">
         <tr>
           </tr>
       </table>
       <br>
       </textarea>
       <br>
     </div>
</form> 
	</body>
</html>
'; 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
<!--function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_resource_links.php"; }-->
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>
   <title> </title>
   <style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-weight: bold;
}
body {
	background-color: #993333;
}
.style5 {color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; }
a:visited {
	color: #CCCCCC;
}
-->
   </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<div align="center">
  <table width="74%" height="361" border="0">
    <tr>
      <td width="37%" height="184" align="center"><span class="style1"><a href="../index.php">Home</a></span></td>
      <td width="19%"><p align="center" class="style1">Time and Money!</p>
        <p>&nbsp;</p></td>
      <td width="44%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td><p align="center" class="style1">&nbsp;</p></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	
  </table><table width="50%" bgcolor='BBBBBB' align='center' border="1" cellpadding="1" cellspacing="0">
         <tr>
           <th width="24%" height="19" scope="col"><a href="../index.php" class="style1"><strong>Home</strong></a></th>
           <th width="51%" scope="col"><span class="style2 style12 style1"><a href="classified_ads.php" class="gray_tnr_12">Parts and Supplies </a></span></th>
           <th width="25%" scope="col"><span class="style1 style13"><strong><a href="library.php">Registration Library</a> </strong></span></th>
         </tr>
         <tr>
           <td height="23" align="center"><span class="style1 style15"><strong><a href="before_after.php" class="Bk_TNR_12pt">Before and After </a></strong></span></td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
</table>
</div>
</body>
</html>