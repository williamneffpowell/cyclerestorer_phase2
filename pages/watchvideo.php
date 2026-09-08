<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../watchvideo.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   

session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
$userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 



########################################################################################################
#             End of Login
########################################################################################################

include('functions.php');


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>


   <title>Watch Videos</title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<H2 align=center>Watch Videos</H2>



<?php

if ($videoID <> "") {

/*$Query = "SELECT viewID FROM tb_views WHERE videoID=$videoID AND userID=$userID AND endtime>CURDATE()";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result); */


$Query = "SELECT v.title, v.description, v.embed, u.userID, u.username, u.bio, p.filename, p.caption, v.videoID, DATE_FORMAT(v.dateadded, '%m/%e/%Y'),  (u.lastlogin>ADDDATE(NOW(), INTERVAL -3 MINUTE)) FROM tb_video AS v, auth_user AS u LEFT JOIN tb_pictures AS p ON u.picID=p.picID WHERE v.userID=u.userID AND v.videoID=$videoID";

$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

$title = $Row[0];
$description = $Row[1];
$embedcode = $Row[2];
$uid = $Row[3];
$alias = $Row[4];
$bio = $Row[5];
if ($Row[6] <> "") {$image = "<IMG SRC=../userthumbs/$Row[6] border=0 alt=\"$Row[7]\">";}
else {$image = "<IMG SRC=../userthumbs/default.jpg border=0 alt=\"\">";}
$videoID = $Row[8];
$dateadded = $Row[9];
$online = $Row[10];

if ($videoID <> "") {

if ( (strpos($embedcode, "metacafe") > 0) && !(strpos($embedcode, "autoPlay=yes") > 0) ) {
$metadiv1 = "<DIV onMouseDown=\"Start();\">"; 
$metadiv2 = "</DIV>";
}
else {$startscript = "<SCRIPT>Start();</SCRIPT>";}
}


if ($title <> "") {
print ("$metadiv1 $embedcode $metadiv2");
echo "<br>";

echo "$description";


?>


<BR>
<TABLE WIDTH=720 ALIGN=CENTER>
<TR>
<TD valign=top width=460>





<TABLE BGCOLOR=dddddd ALIGN=CENTER cellspacing=0 cellpadding=0>
<TR><TH bgcolor=79888E><?echo $title;?></TH></TR>

<TR><TD>
<TABLE WIDTH=100%>
<TR>
<TD align=right>
<a href=# onClick="window.open('abuse.php?vid=<?echo $videoID;?>','newwindow','width=400,height=200');" >Report Abuse</a>
</TD></TR></TABLE>
</TD></TR>


<TR><TD>

</TD></TR>
<TR><TD>
<?echo $description;?></TD></TR>
</TABLE>
<BR>
<TABLE ALIGN=CENTER>
<TR>


<script type="text/javascript">
digg_url = '<?echo "http://cyclerestorer.com/watchvideo.php?videoID=$videoID";?>';
digg_skin = 'compact';
digg_bgcolor = "transparent";
digg_title = '<?echo addslashes($title);?>';
digg_bodytext = '<?echo addslashes($description);?>';
digg_topic = '';
</script>

<script src="http://digg.com/api/diggthis.js"></script>

</TD>

</TR>
</TABLE>



</TD></TR>
</TABLE>

<?
} 


?>




</TD>

<TD valign=top width=260>

<TABLE width=250 cellpadding=0 cellspacing=0>
<TR><TH bgcolor=79888E colspan=2>Collector Profile</TH></TR>
<TR><TD>
<DIV class="box">
<TABLE WIDTH=250>
<TR><TD>
<A HREF=profile.php?uid=<?echo $uid;?>><?echo $image;?></A>
<?

if ($online > 0) {
print ("<TABLE><TR><TD valign=middle>
<IMG SRC=images/tv.gif border=0 alt=\"Online Now\">
</TD>
<TD valign=middle>
<FONT COLOR=009900<B><A HREF=profile.php?uid=$uid>$alias</A></B>
</FONT>
</TD></TR></TABLE>");
}
else {
print ("
<BR><B><A HREF=profile.php?uid=$uid>$alias</A></B>
");}


?>

</TD>
<TD><?echo $bio;?></TD>
</TR></TABLE>
</DIV>
</TD></TR>
</TABLE>

<BR>

<TABLE width=250 cellpadding=0 cellspacing=0>
<TR><TH bgcolor=79888E colspan=2>Comments</TH></TR>
<TR><TD>
<div class=box>
<TABLE width=250 align=center>

<?php

$Query = "SELECT  u.username, p.filename, p.caption FROM auth_user AS u LEFT JOIN tb_pictures AS p ON p.picID=u.picID ";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;




?>

</TABLE>
</DIV>
</TD></TR>
</TABLE>
<BR>
</TD>
</TR>
</TABLE>

<BR>
<?php
}


// Check if there is a video
else {

print ("</CENTER>");
}

mysql_close ($Link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';



?>