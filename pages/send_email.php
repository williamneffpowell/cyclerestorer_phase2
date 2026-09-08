<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../classified_ads.php';
   //including phpBB3 stuff   
  // define('IN_PHPBB', true);
 //  include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');
  // $phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../phpBB3/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include ($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);

session_start();

$session_username = $user->data['username'];
$session_userid= $user->data['user_id'];	


include '../includes/dbconnect.inc.php';
$Link = mysql_connect ($Host, $User, $Password); 


if ($user->data['is_registered'])
{
# LOGIN OK
$logged_in_var = "yes";
}
if (!$user->data['is_registered'])
{
$logged_on = "no";
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

//function validate_form(email_form)
//{
//with (email_form)
//{
//if (validate_required(your_name_fd,"The 'Your Name' field must be filled out!")==false)
 // {your_name_fd.focus();return false}
//if (validate_required(email_fd,"Email must be filled out!")==false)
 // {email_fd.focus();return false}
//if (validate_required(city_state_fd,"The City State field must be filled out!")==false)
//  {city_state_fd.focus();return false}
//if (validate_required(phone_fd,"The 'Country' field must be filled out!")==false)
//  {phone_fd.focus();return false}
//if (validate_required(comment_fd,"The 'Comment' field must be filled out!")==false)
 // {comment_fd.focus();return false}  
 //}
//}
</script>
<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	themes : 'simple,advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});

<script language="javascript" type="text/javascript">
	tinyMCE.init ({
		mode : "textareas",
		theme : "advanced",
		plugins : "emotions,preview,zoom,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_disable : "image,cleanup,removeformat,formatselect,styleselect,sub,sup,separator,outdent,indent,help,anchor,code,hr,visualaid,charmap",
		theme_advanced_buttons1_add : "fontselect",
		theme_advanced_buttons2_add : "preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "emotions,cut,copy,paste,separator,search,separator",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "example_word.css",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false,	
		theme_advanced_statusbar_location : "none"
	
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
</script>

<title>Send Classified Email</title>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css" />
</head>

<body>



<?


$recpid = $_REQUSET['recpid'];
$ad_id = $_REQUEST['ad_id'];
$recpnm = $_REQUEST['recpnm'];

mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());

// Performing SQL query
$query = "(SELECT    title FROM for_sale_wanted where item_row_id = '$ad_id')";	
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 

while ($Row = mysql_fetch_array($result))
{
$subject = $Row[0];
}
$enable_signature = false;                                                     
$id_temp_add_var = 'yes';
if ($id_temp_add_var == 'yes')
{

print '<br>';
print '&nbsp;';
print '<br>';
print '&nbsp;';
print '<br>';
print '&nbsp;';
print '<br>';
print '<h1 align="center">Send Message Page</h1>';
print '<br>';
print '&nbsp';
print ' <div align="center"><h2><b>Clasified Ads</b></h2> </div>';
 print '<br>';
print '&nbsp';



?>
<tr><TD><h2 align="center"><strong>Send to Member:&nbsp; </strong> <?echo $recpnm;?></h2></TD></tr>   

<?
//<tr><TD><h2 align="center"><strong>Subject:&nbsp; </strong> <?echo $subject;?      </h2></TD></tr>




print '&nbsp;';
print '<br>';



print '
<form name="email_form" method="POST" >
    
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>   
<!--	<tr>
          <td width="40"><div align="center"><strong>Content of Message</strong></div></td>
        
		  <td align="center" width="50" height="5"><textarea name="message_fd" cols="40" rows="10"></textarea> </td>
         
          <td>&nbsp;</td>
        </tr>	 -->
     </table>
	 
	 <tr><td align="center"><h2>CAPTCHA:<br>
    <tr><td aling="center"><h2> (Enter antispam code, 3 black symbols)</h2></td><br>
    <table><tr><td><img src="captcha.php" alt="captcha image"></td>
    <td><input type="text" name="captcha" size="3" maxlength="3"></td></tr></table>
</td></tr>
       <br>
       <input type="submit" name="submit" value="Submit">
	    <input type="reset" name="Clear" value="Clear Form and Start Over">
       <br>
       <br>
       <table width="200">
         <tr>
           </tr>
       </table>
       <br>
       </textarea>
       <br>
     </div>
</form> 
	</body>
</html>
';
}
 if ($_REQUEST['submit']) 
 { 
 

 if($_SESSION["captcha"]==$_POST["captcha"])  //CAPTHCA is valid; proceed the message: save to database, send by e-mail ...
{
  
//$recipient_id = $_REQUEST['userid'];
//$uid = make_bbcode_uid();
$recpnm = $_REQUEST['recpnm'];
$enable_signature = false;
$recpid= $_REQUEST['recpid'];	
$today = date("Y-m-d h:i:s");
#echo "<h5> Recipient_id = </h5>";
#echo  $recipient_id; 
 
    //    $message=$_REQUEST['message_fd'];
	//	echo $message;
		//$recipient_username = $_REQUEST['uname'];
	//	$sender_username = $user->data['username'];
//echo "http://www.cyclerestorer.com/phpBB3/memberlist.php?mode=email&u=2		
		
// THIS WAS A GOOD ATTEMPT, THE VARIABLES WERE NOT GETTING PASSED RIGHT
//...    send_private_message($recpid, 'localhost', $sender_username, $recipient_id, $subject, $message, $enable_signature = FALSE, $enable_bbcode = TRUE, $enable_smilies = TRUE, $enable_urls = TRUE);
?>

<script language="JavaScript" type="text/javascript">
window.location.href="http://www.cyclerestorer.com/phpBB3/memberlist.php?mode=email&u=<? echo "$recpid" ?> "</script>';
				
<?			

} 	
else
{
	echo 'CAPTHCA is not valid; ignore submission';
}     
}   
 

#############################################################################################################
# FUNCTIONS
#############################################################################################################
function send_private_message($recpid, $sender_ip = '127.0.0.1', $sender_username, $recipient_id, $subject, $message, $enable_signature = FALSE, $enable_bbcode = TRUE, $enable_smilies = TRUE, $enable_urls = TRUE)
{
  #DO CONFIG VARIABLE CHECKS
  
  echo "<h1>IM IN THE FUNCTION</h1>";
  $uid = $bitfield = $options = '';
    #this function is from functions_content which is already loaded by common.php
  generate_text_for_storage($message, $uid, $bitfield, $options, $enable_bbcode, $enable_urls, $enable_smilies);
$data = array(
     'from_user_id'      => $recpid,
     'from_user_ip'      => $sender_ip,
     'from_username'      => $sender_username,
     'enable_sig'      => $enable_signature,
     'enable_bbcode'      => $enable_bbcode,
     'enable_smilies'   => $enable_smilies,
     'enable_urls'      => $enable_urls,
     'icon_id'         => 0,
     'bbcode_bitfield'   => $bitfield,
     'bbcode_uid'      => $uid,
     'message'         => $message,
     'address_list'      => array('u' => array($recipient_id => 'to'))
  );
  

  
   submit_pm('post', $subject, $data, FALSE);
  print_r($subject);
    print_r($data);
  header("Location: http://www.cyclerestorer.com/pages/classified_ads.php"); 

}       
  
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>
