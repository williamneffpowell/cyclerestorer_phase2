<?php
include '../includes/dbconnect.inc.php';
$Link = mysql_connect("$Host","$User","$Password");	

mysql_select_db("$DBName") or die ("unable to select DB");
#include('init.php');
include('functions.php');
if ($uid <> "" && $verification <> "") {

#print_header($username); 

$Query = "SELECT userID FROM email_confirm WHERE userID=$uid AND verification='$verification'";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

if ($Row[0] == $uid) {
$Query = "UPDATE auth_user SET status=1 WHERE userID=$uid";
$Result = mysql_db_query ($DBName, $Query, $Link);

//PREVENT F5'ing
$Query = "UPDATE email_confirm SET verification='fuku' WHERE userID=$uid";
$Result = mysql_db_query ($DBName, $Query, $Link);


//REFERRALS
#$Query = "SELECT referredby FROM tb_user WHERE userID=$uid";
#$Result = mysql_db_query ($DBName, $Query, $Link);
#$Row = mysql_fetch_array ($Result);
#$rid = $Row[0];

#$Query = "UPDATE tb_user SET credits=credits+25 WHERE userID=$rid";
#$Result = mysql_db_query ($DBName, $Query, $Link);
#$Query = "UPDATE tb_referrals SET credits=credits+25 WHERE userID=$rid AND rid=$uid";
#$Result = mysql_db_query ($DBName, $Query, $Link);
//END REFS

print ("
<BR><H2 align=center>Thank You!</H2><H5 align=center>Your account has been activated. <A HREF=../index.php>Click here to log in</A></H5><BR><BR><BR>
");
}

else {print ("<BR><H2 align=center>Invalid Verification Code </H2><BR><BR><BR>");}




#print_footer($username);

} //end check fields

mysql_close ($Link);





?>