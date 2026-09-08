<?php

session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$session_userID = $_SESSION['user_ID'];

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
$target_url_in = 'pages/friends.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to Add or Edit a Show" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################


include('functions.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

#print_header($username); 

   <title>Contacts</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
#<h1>My Contacts </h1>
<br>

</div>
<?php
if (!intval($uid) > 0) {header("Location: search.php");}
else {

$Query = "SELECT username FROM auth_user WHERE userID=$uid";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$alias = $Row[0];



#print_header($username); 


print ("

<SCRIPT LANGUAGE=JAVASCRIPT>
function changeColor() {


var tbl = document.getElementById('tblCurrent');
var lastRow = tbl.rows.length;

for (t = 1; t < lastRow - 1; t++)
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
<H2 align=center>$alias's Contacts</H2>
<h5><CENTER><A HREF=profile.php?uid=$uid>return to $alias's profile</A></CENTER></h5><HR>
<TABLE ALIGN=CENTER>
<TR><TD valign=top>

<TABLE ALIGN=CENTER width=350 cellpadding=2 cellspacing=2 bgcolor=eeeeff>
");

$Query = "SELECT u.userID, u.username, p.filename, p.caption FROM auth_user AS u LEFT JOIN tb_pictures AS p ON u.picID=p.picID, friends AS f  WHERE f.userID=$uid AND u.userID=f.friendID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;
$r = 0;
$t = 0;

while ($Row = mysql_fetch_array ($Result)) {

if ($Row[2] <> "") {$image = "<IMG SRC=../userthumbs/$Row[2] alt=\"$Row[3]\" border=0>";}
else {$image = "<IMG SRC=../userthumbs/default.jpg alt=\"No images available\" border=0>";}

if ($r == 0) {print ("<TR>");}


print ("
<TD align=center>
<A HREF=profile.php?uid=$Row[0]>$image</A><BR><A HREF=profile.php?uid=$Row[0]>$Row[1]</A>
</TD>
");
$results = $results + 1;
$r = $r + 1;
if ($r == 3) {print "</TR>"; $r = 0;}
$t = $t + 1;

}

if ($results == 0) {print ("<TR><TD colspan=3>$alias currently doesn't have any contacts</TD></TR>");}


print ("

</table>

</TD>
<TD valign=top>
");
#echo show_ad(3);


print ("
</TD></TR>
</TABLE>
<BR>
");




mysql_close ($Link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
#print_footer($username);

} // End check for uid

?>