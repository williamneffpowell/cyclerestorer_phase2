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
$target_url_in = 'pages/delete_messages.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

}
########################################################################################################
#             End of Login
########################################################################################################


if ($userID > 0) {

if ($message[0] == "" && $messageID <> "") {$message[0] = $messageID;}

$i=0; 
while($i<count($message)){ 
$mid = $message[$i];
$Query = "DELETE FROM messages WHERE messageID=$mid AND receiverID=$userID;";
$Result = mysql_db_query ($DBName, $Query, $Link);

$i = $i + 1;
}


header("Location: messages.php");




} // END IF LOGGED IN

else {print ("Error");}






mysql_close ($Link);





?>