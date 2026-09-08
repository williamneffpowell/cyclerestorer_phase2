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
$loginvar =  "Yes";
}
else
{
$target_url_in = 'pages/messages.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
########################################################################################################
#             End of Login
########################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>



   <title>Messages</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1>Messages</h1>
<br>

</div>


<?




include('functions.php');

if ($loginvar == "Yes") {

if ($mode == "") {$mode = 1;}

if ($mode == 1) {$box = "Inbox"; $i = "<b>"; $ie = "</b>";}
else {$box = "Outbox"; $o = "<b>"; $oe = "</b>";}

#print_header($username); 
print ("

<SCRIPT LANGUAGE=JAVASCRIPT>

function checkAll() {


var tbl = document.getElementById('tblCurrent');
var lastRow = tbl.rows.length;

for (t = 1; t < lastRow -2; t++)
{
i = t - 1;
if (document.forms.messages.all.checked) {
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

for (t = 1; t < lastRow - 2; t++)
{
i = t - 1;

if (document.getElementById('chc' + i).checked) {
tbl.rows[t].style.backgroundColor = \"#ffffcc\";  
}
else {tbl.rows[t].style.backgroundColor = \"#ffffff\";   }}}
</SCRIPT>

");


print ("
<BR>
<H2 align=center>My Messages: $box</H2>
<!-- <CENTER><A HREF=myaccount.php>Go to My Account</A></CENTER> --><BR>
<TABLE ALIGN=CENTER width=700>
<TR><TD valign=top width=120 height=100%>

<TABLE bgcolor=eeeeee width=120 height=100%>
<TR><TH bgcolor=79888E height=18>Menu</TH>
</TR>
<TR><TD valign=top>
<A HREF=messages.php>$i Inbox $ie</A><BR>
<A HREF=messages.php?mode=2>$o Sent Messages $oe </A><BR>
<A HREF=myfriends.php>Contacts List</A><BR>
</TD></TR></TABLE>

</TD><TD valign=top>


<TABLE ALIGN=CENTER width=580 bgcolor=eeeeee id=\"tblCurrent\" >
<FORM NAME=messages ACTION=delete_messages.php onSubmit=\"return confirm('Are you sure you want to delete these messages?');\">
<TR><TH bgcolor=79888E></TH><TH bgcolor=79888E>User</TH><TH bgcolor=79888E>Subject</TH><TH bgcolor=79888E>Date</TH></TR>
");

if ($mode == 1) {
$Query = "SELECT m.messageID, DATE_FORMAT(m.mdate, '%M %e, %Y - %h:%i %p'), u.username, m.subject, m.status, p.filename, p.caption from messages AS m, auth_user AS u LEFT JOIN tb_pictures AS p ON p.picID=u.picID WHERE m.receiverID=$userID AND m.senderID=u.userID ORDER BY mdate DESC";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
}

elseif ($mode == 2) {
$Query = "SELECT m.messageID, DATE_FORMAT(m.mdate, '%M %e, %Y - %h:%i %p'), u.username, m.subject, m.status, p.filename, p.caption from messages AS m, auth_user AS u LEFT JOIN tb_pictures AS p ON p.picID=u.picID WHERE m.senderID=$userID AND m.receiverID=u.userID ORDER BY mdate DESC";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
}
while ($Row = mysql_fetch_array ($Result)) {
if ($Row[5] <> "") {$image = "<IMG SRC=../userthumbs/$Row[5] ALT=\"$Row[6]\" border=0><BR>";}
else {$image = "<IMG SRC=../userthumbs/default.jpg ALT=\"No image available\" border=0><BR>";}
if ($Row[4] == 1) {$B = "<B>"; $eB = "</B>";}
else {$B = ""; $eB = "";}
print ("
<TR bgcolor=ffffff><TD width=25 align=center><INPUT TYPE=checkbox NAME=message[] VALUE=$Row[0] id=chc$results onClick=\"changeColor()\"></TD>
<TD width=150 align=center>$B<A HREF=read_message.php?messageID=$Row[0]>$image$Row[2]</A>$eB</TD>
<TD>$B<A HREF=read_message.php?messageID=$Row[0]>$Row[3]</A>$eB</TD>
<TD align=center width=80>$Row[1]</TD>

</TR>
");
$results = $results + 1;

}



print ("
<TR><TD colspan=4><input type=checkbox name=all onClick=\"checkAll()\"> Select All</TD></TR>

<TR bgcolor=ffffff><TD colspan=4>

<CENTER>
<INPUT TYPE=BUTTON VALUE=\"New Message\" onCLick=\"window.location='send_message.php';\"> 
");
if ($mode == 1) {
print ("<INPUT TYPE=SUBMIT VALUE=\"Delete Messages\">");
}
print ("
</CENTER>
</TD></TR>
</FORM>
</table>

</TD></TR>
</TABLE>

<BR>
");




mysql_close ($Link);
#print_footer($username);

// End check log in
}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>