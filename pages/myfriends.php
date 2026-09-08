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
if ($Row[0] <> "")
{
# LOGIN OK
$logged_in_var = "yes";
$loginvar =  '<form align="center">
<input type=button value="Add or Edit a Classified Ad" onClick="goToadd_link()">
</form>';
}
else
{
$logged_on = "no";
$target_url_in = 'pages/myfriends.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
########################################################################################################
#             End of Login
########################################################################################################

include('functions.php');

#if (checklogin($userID, 'friends.php')) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>


   <title>My Contacts</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1>My Contacts </h1>
<br>

</div>

<?


print ("
<BR>
<!-- <H2 align=center>My Contacts</H2> -->

<TABLE ALIGN=CENTER width=700>
<TR><TD>
<div class=\"box\">

<TABLE ALIGN=CENTER width=600>
<FORM NAME=friends ACTION=delete_friends.php onSubmit=\"return confirm('Are you sure you want to delete these contacts?');\">
");

$Query = "SELECT u.userID, u.username, p.filename, p.caption FROM auth_user AS u LEFT JOIN tb_pictures AS p ON u.picID=p.picID, friends AS f WHERE f.userID=$userID AND u.userID=f.friendID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
$r = 0;

while ($Row = mysql_fetch_array ($Result)) {

if ($Row[2] <> "") {$image = "<IMG SRC=../userthumbs/$Row[2] alt=\"$Row[3]\" border=0>";}
else {$image = "<IMG SRC=../userthumbs/default.jpg alt=\"No Image Available\" border=0>";}

if ($r == 0) {print ("<TR>");}

print ("
<TD align=center width=30><INPUT TYPE=checkbox NAME=friend[] VALUE=$Row[0] id=chc$results onClick=\"changeColor()\"></TD>
<TD align=center><A HREF=profile.php?uid=$Row[0]>$image</A><BR><A HREF=send_message.php?rec=$Row[1]><IMG SRC=../Images/icons/email_icon.gif border=0></A> <A HREF=profile.php?uid=$Row[0]>$Row[1]</A></TD>
");
$r = $r + 1;
if ($r == 3) {print ("</TR><TR><TD colspan=6><HR></TD></TR>"); $r=0;}


$results = $results + 1;

}

if ($results == 0) {print ("<TR><TD colspan=6>You currently don't have any contacts</TD></TR>");}


print ("

<TR bgcolor=ffffff><TD colspan=6>

<CENTER>
<INPUT TYPE=SUBMIT VALUE=\"Remove Selected\">
</CENTER>
</TD></TR>
</FORM>
</table>
</DIV>
</TD></TR>
</TABLE>
");




mysql_close ($Link);
#print_footer($username);

// End check log in
#}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>