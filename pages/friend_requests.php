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

}
else
{
{
$logged_on = "no";
$target_url_in = '/pages/friend_requests.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}

}
########################################################################################################
#             End of Login
########################################################################################################


include('functions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

   <title>Contact Requests</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
  <br />
  <br />
  <br />
   
  
<h1>Contact Requests</h1>
<br>

</div>
<?

#print_header($username);




print ("
<SCRIPT LANGUAGE=JAVASCRIPT>


function delete_friend (uid,friend) {
if (confirm ('Are you sure you want to delete ' + friend)) {
window.location='delete_fr.php?uid='+uid;}
}


function checkAll() {


var tbl = document.getElementById('tblCurrent');
var lastRow = tbl.rows.length;

for (t = 0; t < lastRow-1; t++)
{
i = t;
if (document.forms.friends.all.checked) {
document.getElementById('chc' + i).checked = true;
}
else {
document.getElementById('chc' + i).checked = false;
}
}
changeColor();

}


function changeColor() {


var tbl = document.getElementById('tblCurrent');
var lastRow = tbl.rows.length;

for (t = 0; t < lastRow-1; t++)
{
i = t;

if (document.getElementById('chc' + i).checked) {
tbl.rows[t].style.backgroundColor = \"#ffffcc\";  
}
else {tbl.rows[t].style.backgroundColor = \"#ffffff\";   }}}
</SCRIPT>
");


print ("<BR><H2 align=center>Pending Contact Requests</H2>
<CENTER><H5><A HREF=myaccount.php>Return to My Account</A></H5></CENTER>
<FORM NAME=friends ACTION=approve_friends.php METHOD=POST>
<TABLE ALIGN=CENTER width=600 border=1 id=\"tblCurrent\">
");
#$Query = "SELECT u.userID, u.username, p.filename, p.caption FROM auth_user AS u LEFT JOIN tb_pictures AS p ON u.picID=p.picID, friends AS f  WHERE f.userID=$uid AND u.userID=f.friendID";
$Query = "SELECT u.userID, u.username, p.filename, p.caption FROM auth_user AS u  LEFT JOIN tb_pictures AS p ON u.picID=p.picID, tb_friend_pending AS f WHERE f.friendID=$userID AND u.userID=f.requestorID LIMIT 0,10";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
while ($Row = mysql_fetch_array ($Result)) {

if ($Row[2] <> "") {$image = "<IMG SRC=../userthumbs/$Row[2] alt=\"$Row[3]\" border=0>";}
else {$image = "<IMG SRC=../userthumbs/default.jpg alt=\"No image available\" border=0>";}

print ("
<TD align=center><INPUT TYPE=CHECKBOX NAME=friend[] id=chc$results onClick=\"changeColor()\" VALUE=$Row[0]></TD>
<TD align=center>
 <A HREF=profile.php?uid=$Row[0]>$image<BR>
$Row[1]</A>
</TD>
<TD align=center>
<INPUT TYPE=BUTTON VALUE=\"Add Contact\" onClick=\"window.location='newfriend.php?uid=$Row[0]';\"> <INPUT TYPE=BUTTON VALUE=\"Delete\" onClick=\"delete_friend('$Row[0]', '$Row[1]');\"> <INPUT TYPE=BUTTON VALUE=\"Contact\" onClick=\"window.location='send_message.php?rec=$Row[1]';\"></TD>	
</TR>
");
$results = $results + 1;

}

if ($results == 0) {print ("<TR><TD colspan=3 align=center>You currently do not have any Contact requests</TD></TR>");}

else {
print ("<TR><TD colspan=3><input type=checkbox name=all onClick=\"checkAll()\"> Select All</TD></TR>");
}

print ("
</table>
<BR><CENTER><INPUT TYPE=SUBMIT VALUE=\"Approve Selected\"></CENTER>
</FORM>
<BR>
");
#print_footer($username);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>
