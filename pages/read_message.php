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
$logged_on = "no";
$target_url_in = 'pages/read_message.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

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

   <title>Read </title>

   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1>My Friends </h1>
<br>

</div>

<?
if (checklogin($userID, 'messages.php')) {


// Make sure we have message ID
if (!intval($messageID) > 0) {header("Location: messages.php");}

else { 




// MAKE SURE USER HAS ACCESS

$Query = "SELECT messageID FROM messages WHERE messageID=$messageID AND (senderID=$userID OR receiverID=$userID)";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

if ($Row[0] <> "") {




print_header($username); 





$Query = "SELECT u.username, m.mdate, m.subject, m.body, m.senderID FROM messages AS m, auth_user AS u WHERE m.messageID=$messageID AND m.senderID=u.userID";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

$Query2 = "SELECT u.userID, u.username FROM messages AS m, auth_user AS u WHERE m.messageID=$messageID AND m.receiverID=u.userID";
$Result2 = mysql_db_query ($DBName, $Query2, $Link);
$Row2 = mysql_fetch_array ($Result2);
$toid = $Row2[0];
$to = $Row2[1];

if ($Row[5] <> $userID) {
$options = ("
<A HREF=newfriend.php?uid=$Row[4]&src=3>add $Row[0]</A> to friends list</A><BR><BR>
");
}



print ("

<BR>
<H2 align=center>Read Message</H2>
<CENTER><A HREF=messages.php>Return to Inbox</A></CENTER>
<BR>



<TABLE ALIGN=CENTER width=700>
<TR><TD valign=top width=120 height=100%>

<TABLE bgcolor=eeeeee width=120 height=100%>
<TR><TH bgcolor=79888E height=18>Menu</TH>
</TR>
<TR><TD valign=top>
<A HREF=messages.php>$i Inbox $ie</A><BR>
<A HREF=messages.php?mode=2>$o Sent Messages $oe </A><BR>
<A HREF=myfriends.php>Friends List</A><BR>
<A HREF=blocked.php>Blocked List</A><BR><BR>
</TD></TR></TABLE>

</TD><TD valign=top>


<TABLE ALIGN=CENTER WIDTH=580>
<TR><TD>
<TABLE WIDTH=100% bgcolor=eeeeee>
<TR><TD>
To: <A HREF=profile.php?uid=$toid>$to</A><BR>
From: <A HREF=profile.php?uid=$Row[4]>$Row[0]</A><BR>
Date: $Row[1]<BR>
Subject: <B>$Row[2]</B><BR>
</TD>
<TD align=right>
$options
</TD>
</TR>
</TABLE>
<HR>
$Row[3]
<BR>
$image
<HR>

</TD></TR>
<TR><TD><CENTER><INPUT TYPE=BUTTON VALUE=\"Reply\" onCLick=\"window.location='send_message.php?rec=$Row[0]&sub=RE: $Row[2]';\"> <INPUT TYPE=BUTTON VALUE=\"New Message\" onCLick=\"window.location='send_message.php';\"> <INPUT TYPE=BUTTON VALUE=\"Delete Message\" onCLick=\"window.location='delete_messages.php?messageID=$messageID';\"></CENTER><HR></TD></TR>

</TABLE>

</TD></TR></TABLE>
<BR>
");




//SET STATUS TO READ

$Query = "UPDATE messages SET status=2 WHERE messageID=$messageID";
$Result = mysql_db_query ($DBName, $Query, $Link);


mysql_close ($Link);
#print_footer($username);











// End Check Access
}

else {print ("Error");}





// END Check MessageID
}


// End check log in
}
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';

?>