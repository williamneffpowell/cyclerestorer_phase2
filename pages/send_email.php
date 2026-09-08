<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';
require '../vendor/autoload.php';
require_once '../includes/secrets.inc.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());

if (!$is_logged_in)
{
$target_url_in = '/pages/classified_ads.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
$loginvar='<form align="center">
<input type=button value="Log In to add or Edit an ad, or to contact a seller" onClick="goToLogin()">
</form>';
}
########################################################################################################
#             End of Login
########################################################################################################

$id_temp_add_var = $_SESSION['email_id_authenticated'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
{
if (value==null||value=="")
  {alert(alerttxt);return false}
else {return true}
}
}
</script>

<title>Send Classified Email</title>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php

if (!$is_logged_in) {
    echo $loginvar;
} else {

$recpid = $_REQUEST['recpid'];
$ad_id = $_REQUEST['ad_id'];
$recpnm = $_REQUEST['recpnm'];

mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "(SELECT    title FROM for_sale_wanted where item_row_id = '$ad_id')";	
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

while ($Row = mysql_fetch_array($result))
{
$subject = $Row[0];
}

if (!$_REQUEST['submit']) {
?>

<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
<h1 align="center">Send Message Page</h1>
<br>&nbsp;
<div align="center"><h2><b>Classified Ads</b></h2></div>
<br>&nbsp;

<tr><TD><h2 align="center"><strong>Send to Member:&nbsp; </strong> <?php echo htmlspecialchars($recpnm); ?></h2></TD></tr>
<tr><TD><h2 align="center"><strong>About:&nbsp; </strong> <?php echo htmlspecialchars($subject); ?></h2></TD></tr>

<form name="email_form" method="POST" action="send_email.php">
<input type="hidden" name="recpid" value="<?php echo htmlspecialchars($recpid); ?>">
<input type="hidden" name="ad_id" value="<?php echo htmlspecialchars($ad_id); ?>">
<input type="hidden" name="recpnm" value="<?php echo htmlspecialchars($recpnm); ?>">
<div align="center">
<table width="384" border="0">
<tr>
  <td width="40"><div align="center"><strong>Your Message</strong></div></td>
  <td align="center" width="50" height="5"><textarea name="message_fd" cols="40" rows="10" required></textarea></td>
  <td>&nbsp;</td>
</tr>
</table>

<tr><td align="center"><h2>CAPTCHA:<br>
<h2> (Enter antispam code, 3 black symbols)</h2></td><br>
<table><tr><td><img src="captcha.php" alt="captcha image"></td>
<td><input type="text" name="captcha" size="3" maxlength="3"></td></tr></table>
</td></tr>
<br>
<input type="submit" name="submit" value="Submit">
<input type="reset" name="Clear" value="Clear Form and Start Over">
<br>
</div>
</form>

<?php
} // end if not submitted

if ($_REQUEST['submit']) {

 if($_SESSION["captcha"]==$_POST["captcha"])  //CAPTCHA is valid; proceed with sending the email
{
    $message = $_REQUEST['message_fd'];

    // Look up the recipient's email address from auth_user
    $recpid_safe = mysql_real_escape_string($recpid);
    $email_query = "SELECT email FROM auth_user WHERE userID = '$recpid_safe'";
    $email_result = mysql_query($email_query) or die('Query failed: ' . mysql_error());
    $email_row = mysql_fetch_assoc($email_result);
    $recipient_email = $email_row['email'];

    if ($recipient_email) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'mail.cyclerestorer.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'webmaster@cyclerestorer.com';
            $mail->Password   = $EmailPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('webmaster@cyclerestorer.com', 'CycleRestorer.com');
            $mail->addAddress($recipient_email, $recpnm);

            $mail->isHTML(false);
            $mail->Subject = "CycleRestorer.com: Message about your ad - " . $subject;
            $mail->Body    = "You have a message from " . $session_username . " on CycleRestorer.com about your classified ad \"" . $subject . "\":\n\n"
                            . $message
                            . "\n\nLog in to CycleRestorer.com to view the ad or reply: http://www.cyclerestorer.com/pages/classified_ads.php";

            $mail->send();
            echo "<h3 align='center'>Your message was sent successfully.</h3>";
        } catch (Exception $e) {
            echo "<h3 align='center'>Sorry, your message could not be sent. Please try again later.</h3>";
        }
    } else {
        echo "<h3 align='center'>Sorry, we couldn't find a valid email address for this member.</h3>";
    }

} 	
else
{
	echo '<h3 align="center">CAPTCHA is not valid. Please go back and try again.</h3>';
}     
}   

} // end else logged in

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>
