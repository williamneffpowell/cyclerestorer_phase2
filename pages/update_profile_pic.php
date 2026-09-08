<?PHP
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../update_profile_pic.php';
   //including phpBB3 stuff   
 //  define('IN_PHPBB', true);
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

# Old Code $sessionID = $_SESSION['sessionID'];
# Old Code $session_username = $_SESSION['user_name'];
session_start();

$session_username = $user->data['username'];
$session_userid= $user->data['user_id'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
#********
// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();

$session_username = $user->data['username'];


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
if ($user->data['is_registered'])
{
$logged_in = "yes";
$login_var = "";

}
if (!$user->data['is_registered'])
{
$target_url_in = '/pages/update_profile_pic.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php"><div align="center">
<div align="center"><span class="style1"><b></b></span>
       <table width="261" border="0" class="index">
        <caption>&nbsp;
        </caption> 
       </table>
       <br>
       <input type="submit" name="submit" value="Login to Edit your bike or send a Message">
       <br>
     </div></Form>';


}

########################################################################################################
#             End of Login
########################################################################################################

include('functions.php');
 #echo '<h3> On the update_profile_pic page and after the include </h3>';
#echo '<h3> Im In the Update Programe </h3>';


if ($_FILES["imagefile"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else #adding picture else
{

$imageFilename = upload_image($_FILES['imagefile'], 350, 150, "../userpics", "../userthumbs");



if ($imageFilename == "Error") 
{
print ("Error uploading image. Please make sure that the images are either GIF or JPEG");
}
else 
{

print ("ImageFilename Worked");

$caption = ($_POST["caption"]) ;
// INSERT PICTURE
$Query = "INSERT INTO tb_pictures VALUES ('', '$imageFilename', '$caption')";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Query = "SELECT picID FROM tb_pictures WHERE (filename='$imageFilename')";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);

if  ($Result) 
			{
		    
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
	    } 




$picID = $Row[0];

// UPDATE USER

$session_username = $user->data['username'];


$Query3 = "UPDATE auth_user SET picID='$picID' WHERE (username='$session_username')";
$Result3 = mysql_db_query ($DBName, $Query3, $Link);




mysql_close ($Link);
if  ($Result3) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/index.php" </script>';
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update user data.</b>"; 
	    } 

?>

<h3> This is a head line and it should work </h3>
<?PHP echo $Row2[0]; ?>" alt="<?echo $Row2[1];?>		
<?		
header("Location: edit_user_info.php?r=$userID");

} // END WAS PICTURE UPLOAD OK


} # End of adding picture else
?>