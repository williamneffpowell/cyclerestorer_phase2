
<?php
require '../includes/auth_check.inc.php';
$random = trim($random);

$session_username = $session_username;
$session_userid= $_SESSION['user_id'];	


include '../includes/dbconnect.inc.php';
$Link = mysqli_connect($Host, $User, $Password, $DBName); 


if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";
}
if (!$is_logged_in)
{
$logged_on = "no";
$target_url_in = '/pages/formhandler.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit an ad, or to contact a seller" onClick="goToLogin()">
</form>'; 
}
########################################################################################################
#             End of Login
########################################################################################################

/*This starts the session that we created on the last page*/
 $random=$_REQUEST['random'];

/*This trims the random variable of any white space that the user may have unknowingly put in.*/
$random = trim($random);

#echo "<h2>Random = $random</h2>";
#echo "<h2>new_string = $new_string</h2>";

/*Below is a conditional statement: In English it reads, if the string that the user put into the text box is equal to what is in the image then print to the screen, "You are verified."  If they are not equal it tells the user to go back and try again.*/

/*We can use the variable $new_string because we registered it into our session on the last page, it retains its value that it had on the first page.*/
if ($new_string == $random){

$temp_var_holder = 'yes';

#http://www.cyclerestorer.com/pages/add_classified_ad_pics.php?edit_row=<?php print "$id_temp_var">?
$session_username = $session_username;
$session_userid= $_SESSION['user_id'];

$_SESSION['email_id_authenticated'] = $temp_var_holder;

$recpid = $_REQUEST['recpid'];
$ad_id = $_REQUEST['ad_id'];
$recpnm = $_REQUEST['recpnm'];



echo "You verified the code, hit the back button on your browser";
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/send_email.php?recpnm=<?php print "$recpnm"?>&recpid=<?php print "$recpid"?>&ad_id=<?php print "$ad_id"?>"</script>'; 
			
}
else{
echo "Please go back, refresh the screen, and get verified.";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
