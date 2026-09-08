<?php

session_start();  



include '../includes/dbconnect.inc.php';
#include('init.php');
include('functions.php');

$username = $_POST['username'];

$Link = mysql_connect("$Host","$User","$Password");	

mysql_select_db("$DBName") or die ("unable to select DB");

//CHECK FUNKY CHARS
$username = trim($username);
$userArray = preg_split('//', $username);

$badCharactersArray = array('#', '$', '%', '(', ')', '&', '!', '*', ' ');
for ($i = 0; $i < sizeof($badCharactersArray); $i++)
    {
        if (in_array ($badCharactersArray[$i], $userArray))
        {
            $badCharacter = true;
        }
    }




$Query = "SELECT username, email FROM auth_user WHERE username='$username' OR email='$email';";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if (strtolower($Row[0]) == strtolower($username)) {
#print_header($username);
print ("<BR><H2 align=center>Username Taken</H2><HR><CENTER>Sorry, another user has already registered the username $username. Please go back and try a different username.</CENTER><BR>");
#print_footer($username);
}

elseif ($Row[1] == $email) {
#print_header($username);
print ("<BR><H2 align=center>Email address already registered</H2><HR><CENTER>Sorry, an account has already registered using this email address. <A HREF=forgotpassword.php>Click here if you forgot your password</A></CENTER><BR>");
#print_footer($username);
}
elseif ($badCharacter) {
#print_header($username);
print ("<BR><H2 align=center>Invailid Username</H2><HR><CENTER>Please do not include special characters in your user</CENTER><BR>");
#print_footer($username);
}

elseif (md5($verifyimage) <> $_SESSION['image_random_value']) {
$testvar = $_SESSION['image_random_value'];
#print_header($username);
print ("<BR><H2 align=center>Incorrect Image Verification</H2><HR><CENTER>You must type the correct image verification number to proceed. This is to prevent automated spam. Sorry for the inconvienience. </CENTER><BR>");
#print_footer($username);
}

else
{

$query ="INSERT INTO auth_user (username,password,email,first_name,last_name) VALUES  ('$username','$password','$email','$first_name','$last_name')"; 
$result=mysql_query($query) or die(mysql_error());
		
		
		if ($result) 
		{
		# echo "Successfully Entered" ;
		 }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
	  	}


#### IF ONE   ######
if (mysql_db_query ($DBName, $Query, $Link)) {

$Query = "SELECT userID FROM auth_user WHERE username='$username';";
$Result = mysql_db_query ($DBName, $Query, $Link);	
$Row = mysql_fetch_array ($Result);
$userID = $Row[0];
//EMAIL CONFIRM
$code = createRandomPassword();
$ip=$_SERVER['REMOTE_ADDR']; 
$Query = "INSERT into email_confirm (userID,verification,ip) VALUES ('$userID', '$code', '$ip');";
$Result = mysql_db_query ($DBName, $Query, $Link);
//END EMAIL CONFIRM
if ($Result) 
		{
		#echo "Successfully Entered into Email_confirm" ;
		 }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
	  	}

session_start();
$_SESSION['userID'] = $userID;
$_SESSION['username'] = $username;


$message = ("

<HTML>
<BODY>


$first_name,
<BR><BR>
Thanks for signing up at Cyclerestorer.com!
<BR><BR>
Please click on the link below to confirm your email address:
<BR><BR>
<A HREF=http://cyclerestorer.com/pages/email_confirm.php?uid=$userID&verification=$code>http://cyclerestorer.com/pages/email_confirm.php?uid=$userID&verification=$code</A>
<BR><BR>
Just as a reminder, your username is $user and password is $password.
<BR>
If you have any questions please email webmaster@cyclerestorer.com.
<BR><BR>
Very Best, Webmaster
<BR><HR><BR>
</BODY></HTML>

");

$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html;"; 


	mail( "$email", "Welcome to cyclerestorer.com", $message, "Return-path: webmaster@cyclerestorer.com\nFrom: webmaster@cyclerestorer.com\n$headers" );
	mail( "webmaster@cyclerestorer.com", "New User Has Signed up", $message, "Return-path: webmaster@cyclerestorer.com\nFrom: webmaster@cyclerestorer.com\n$headers" );
print ("<H3 align=center><FONT COLOR=0000ff>Please check your email for your verification email</FONT></H3>");

#	$message = ("
#	<HTML>
#	<BODY>
#	If you have any questions please email webmaster@cyclerestorer.com.
#	<BR><BR>
#	Very Best, Webmaster
#	<BR><HR><BR>
#	</BODY></HTML>

	

#$headers = "MIME-Version: 1.0\r\n"; 
#$headers .= "Content-type: text/html;"; 


	#mail( "$remail", "New cyclerestorer.com Referral",
	#$message, "Return-path: webmaster@cyclerestorer.com\nFrom: webmaster@cyclerestorer.com\n$headers" );



#header("Location: signup2.php");



	}
else 

{
print ("Database Error!<BR>$Query");

}

} #corresponds to the bracket under the image verification.
mysql_close ($Link);


?>