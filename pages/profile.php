<?PHP
require '../includes/auth_check.inc.php';
$session_username = $session_username;


#$userID = $_SESSION['user_ID'];
#include '../includes/dbconnect.inc.php';

#$Link = mysql_connect ($Host, $User, $Password); 
#$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
#$Result = mysql_db_query ($DBName, $Query, $Link);
#$Row = mysql_fetch_array ($Result);
if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";

}
else
{
$logged_on = "no";
$target_url_in = 'pages/profile.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
########################################################################################################
#             End of Login
########################################################################################################
include('functions.php');

//if (checklogin($userID, "profile.php?uid=$uid")) {


#if ($uid == "" && $userID > 0) {$uid = $userID;}
#if (!intval($uid) > 0) {header("Location: search.php");}

#else {

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

#print_header($username);
$uid= $_SESSION['user_id'];
$Query = "SELECT u.username, u.bio, p.filename, p.caption, u.url, DATE_FORMAT(u.lastlogin, '%m/%e/%y'), (u.lastlogin>ADDDATE(NOW(), INTERVAL -3 MINUTE)) FROM auth_user AS u LEFT JOIN tb_pictures AS p ON u.picID=p.picID WHERE u.userID=$uid;";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

$alias = $Row[0];
$bio = $Row[1];
if ($Row[2] <> "") {$image = "$Row[2]";}
else {$image = "default.jpg";}
$caption = $Row[3];
if ($Row[4] <> "http://") 
{$url = "<HR>Website: <a>$Row[4]</a>";}
$lastlogon = $Row[5];
$online = $Row[6];
;
?>


<BR>
<H2 align=center><?echo $alias;?></H2>

<?
if ($uid == $userID) {print ("<H3 ALIGN=CENTER><A HREF=edit_user_info.php><FONT COLOR=79888E>edit my profile</FONT></A></H3>");}

?>
<HR>
<TABLE width=700 ALIGN=CENTER cellpadding=2 cellspacing=2>
<TR>


<!--LEFT COLUMN-->

<TD width=275 valign=top>

<TABLE width=275 cellpadding=0 cellspacing=0 bgcolor=ffffff>
<TR><TH colspan=2 bgcolor=79888E>
<?echo $alias;?>'s Stats
</TH></TR>

<TR><TD>
<div class="box">
<TABLE>

<TR><TD width=150>

<A HREF=../userpics/<?echo $image;?> target=_new>
<IMG SRC="../userthumbs/<?echo $image;?>" alt="<?echo $caption;?>" border=0>
</A>
<?
if ($online == 0) {
print ("<BR>Last logon: $lastlogon");
}
else {
print ("
<BR><TABLE><TR><TD valign=middle>
<IMG SRC=../Images/tv.gif border=0 alt=\"Online Now\">
</TD>
<TD valign=middle>
<FONT COLOR=009900><B>Online Now</B></FONT>
</TD></TR></TABLE>");
}
?>

</TD>
<TD>

</TD>
</TR>
<TR><TD colspan=2><BR>
<A HREF=send_message.php?rec=<?echo $alias;?>><IMG SRC=../Images/icons/email_icon.gif border=0></A> <A HREF=send_message.php?rec=<?echo $alias;?>>send message</A> |  
<A HREF=newfriend.php?uid=<?echo $uid;?>&src=2><IMG SRC=../Images/icons/friendrequest_icon.gif border=0></A> <A HREF=newfriend.php?uid=<?echo $uid;?>&src=2>Add Contact</A>
<?echo $sr;?>
</A>
</TR>



</TABLE>
</DIV>
</TD></TR>
</TABLE>


<BR>



<TABLE cellpadding=0 cellspacing=0 width=275><TR><TH bgcolor=79888E><?echo $alias;?>'s Bio</TH></TR>
<TR><TD>
<div class="box">
<TABLE>

<TR><TD>

<DIV style="width: 260; height: 200; overflow:auto; padding: 4; ">
<?echo $bio;?>
<?echo $url;?>
</DIV>


</TD></TR>
</TABLE>
</DIV>
</TD></TR>
</TABLE>

</TD>
<!-- RIGHT COLUMN -->
<TD width=425 valign=top align=right>

<?

$friends = ("
<TABLE width=400 cellpadding=0 cellspacing=0 bgcolor=ffffff>
<TR><TH colspan=2 bgcolor=79888E>
$alias's Contacts
</TH></TR>

<TR><TD>
<div class=box>
<TABLE align=center cellpadding=6 cellspacing=6>
");


$r = 0;
$t = 0;

$Query = "SELECT f.friendID, u.username, p.filename, p.caption FROM auth_user AS u LEFT JOIN tb_pictures AS p ON p.picID=u.picID, friends AS f WHERE f.userID=$uid AND f.friendID=u.userID ORDER BY RAND() LIMIT 0,12";
$Result = mysql_db_query ($DBName, $Query, $Link);

while ($Row = mysql_fetch_array ($Result)) {
if ($Row[2] <> "") {$image = "<IMG SRC=../userthumbs/$Row[2] border=0 alt=\"$Row[3]\" width=100 height=100>";}
else {$image = "<IMG SRC=../userthumbs/default.jpg border=0 alt=\"No Image available\" width=100 height=100>";}
if ($r == 0) {$friends = $friends . ("<TR>");}
$friends = $friends . ("<TD align=center><A HREF=profile.php?uid=$Row[0]>$image<BR>$Row[1]</A></TD>");
$r = $r + 1;
if ($r == 3) {$friends = $friends . "</TR>"; $r = 0;}

$t = $t + 1;
}

$friends = $friends . ("
<TR><TD colspan=3><BR><A HREF=newfriend.php?uid=$uid&src=2><IMG SRC=../Images/icons/friendrequest_icon.gif border=0></A> <A HREF=newfriend.php?uid=$uid&src=2>Add to Contacts</A> | <A HREF=friends.php?uid=$uid>See all $nfriends Contacts</A>
</TD></TR>");


$friends = $friends . ("


</TABLE>
</DIV>
</TD></TR>
</TABLE>
");

if ($t > 0) {print ("$friends");}
else {
print ("<CENTER>");

print ("</CENTER>");
}
?>



<!--END RIGHT COLUMN-->




</TD></TR>
</TABLE>



<?php

mysql_close ($Link);
#print_footer($username);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

// End If UserID ELSE


//} // End check login

?>