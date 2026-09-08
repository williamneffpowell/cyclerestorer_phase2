<?php

session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
#include('init.php');
include('functions.php');

$username = $_POST['username'];

$Link = mysql_connect("$Host","$User","$Password");	

mysql_select_db("$DBName") or die ("unable to select DB");

print_header($username); 


print ("





<TABLE WIDTH=756 BORDER=0 CELLPADDING=0 CELLSPACING=0 align=center bgcolor=ffffff>
<TR><TD>

<BR>
<CENTER>

");



print ("
</CENTER>

<BR>
<H2 align=center>Cycle Restorer Forum</H2>

<HR>

");


if ($topicID > 0) {


$Query = "SELECT topic FROM tb_forum_topics WHERE topicID=$topicID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$topic = $Row[0];



print ("

<TABLE ALIGN=CENTER WIDTH=700>
<TR>
<TD><P><A HREF=\"forum.php\">Return to Forum Index</A></P></TD>
<TD><P ALIGN=RIGHT><A HREF=\"reply.php?topicID=$topicID\">Post a reply</A></P></TD>

</TR>
</TABLE>

<TABLE ALIGN=CENTER WIDTH=700>
<TR><TH BGCOLOR=79888E colspan=2>$topic</TH></TR>
");

$Query = "SELECT u.userID, u.username, p.postdate, p.post, i.filename, i.caption, DATE_FORMAT(u.lastlogin, '%m/%e/%y'), (u.lastlogin>ADDDATE(NOW(), INTERVAL -3 MINUTE)) FROM tb_forum_posts AS p, auth_user AS u LEFT JOIN tb_pictures AS i ON i.picID=u.picID WHERE p.topicID=$topicID AND u.userID=p.UserID ORDER BY p.postdate";
echo "$query";
$Result = mysql_db_query ($DBName, $Query, $Link);
while ($Row = mysql_fetch_array ($Result)) {
$lastlogon = $Row[6];
$online = $Row[7];

if ($Row[4] <> "") {$image = "<A HREF=profile.php?uid=$Row[0]><IMG SRC=../userthumbs/$Row[4] alt=\"$Row[5]\" border=0></A>";}
else {$image = "";}
print ("
<TR bgcolor=eeeeee>
<TD width=100 height=50>
$image
");
#if ($online > 0) {
#print ("<TABLE><TR><TD valign=middle>
#<IMG SRC=images/tv.gif border=0 alt=\"Online Now\">
#</TD>
#<TD valign=middle>
#<FONT COLOR=009900<B><A HREF=profile.php?uid=$Row[0]>$Row[1]</A></B>
#</FONT>
#</TD></TR></TABLE>");
#}
#else {
#print ("
#<B><A HREF=profile.php?uid=$Row[0]>$Row[1]</A></B>
#");}

print ("
</TD>
<TD valign=top>
Posted: $Row[2] Author: $Row[1]<HR>
$Row[3]

</TD></TR>
");
}

print ("
<TR><TD colspan=2 bgcolor=79888E><BR></TD></TR>
</TABLE>

");


}


else {

print ("



<TABLE ALIGN=CENTER WIDTH=700>
<TR>
<TD><P><A HREF=\"newtopic.php\">Post New Topic</A></P></TD>
</TR>
</TABLE>

<TABLE ALIGN=CENTER WIDTH=700>
<TR><TH BGCOLOR=79888E colspan=2>Latest Topics</TH><TH BGCOLOR=79888E>Started By</TH><TH BGCOLOR=79888E>Posts</TH><TH BGCOLOR=79888E>Last Post</TH></TR>
");

if ($s == "") {$s=0;}
$results = 0;
$Query = "SELECT t.topicID, t.topic, u.userID, u.username, t.posts, t.lastpost FROM tb_forum_topics AS t, auth_user AS u WHERE u.userID=t.startedby ORDER BY t.lastpost DESC LIMIT $s, 50";
$Result = mysql_db_query ($DBName, $Query, $Link);

while ($Row = mysql_fetch_array ($Result)) {

print ("

<TR bgcolor=eeeeee>
<TD width=25 align=center><IMG SRC=../Images/folder.gif></TD>
<TD width=300 height=25>
<A HREF=forum.php?topicID=$Row[0]>$Row[1]</A><BR>
</TD>
<TD width=125 height=25 align=center><A HREF=profile.php?uid=$Row[2]>$Row[3]</A></TD>
<TD width=125 height=25 align=center>$Row[4]</TD>
<TD width=125 height=25 align=center>$Row[5]</TD>
</TD></TR>

");
$results = $results + 1;
}

print ("

<TR><TD colspan=5 bgcolor=79888E><BR></TD></TR>
</TABLE>
<CENTER><BR>
");

if ($s > 0) {
$l = $s-50;
print ("<A HREF=forum.php?s=$l><-Previous Page</A> ");
}


if ($results == 50) {
$n=$s+50;
print (" <A HREF=forum.php?s=$n>Next Page-></A>");}


print ("
</CENTER>
");

}
?>


<?php


print ("<HR><TABLE ALIGN=CENTER><TR><TD>Online Now: </TD>");
$Query = "SELECT userID, username FROM auth_user WHERE lastlogin>ADDDATE(NOW(), INTERVAL -3 MINUTE)";
$Result = mysql_db_query ($DBName, $Query, $Link);
while ($Row = mysql_fetch_array ($Result)) {
print ("<TD><A HREF=profile.php?uid=$Row[0]>$Row[1]</A>,</TD>");
}
print ("</TR></TABLE>");





?>


</TD></TR>
</TABLE>




<?php
print_footer($username);
mysql_close ($Link);

?>