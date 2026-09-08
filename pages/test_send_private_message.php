<?php

//$phpEx = "php";

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../phpBB3/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include ($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

   <title>Test Private Message</title>

   

</div>

  <?php
$subject = "3-9-2012 Test 5:05 AM Testing another Message";
$message = "message  Test body";
$sender_id = 56;
$uid = make_bbcode_uid();
$sender_username = "cyclelist";
$enable_signature = false;

$recipient_id = 2;

send_private_message($sender_id, 'localhost', $sender_username, $recipient_id, $subject, $message, $enable_signature = FALSE, $enable_bbcode = TRUE, $enable_smilies = TRUE, $enable_urls = TRUE);

   /*
   * DEV: Config variables need to be checked before submitting. You need to check how submit_pm works! Also what format can the message be in...?
   * Send user a private message.
   *
   * @param int $sender_id The sender's user ID.
   * @param string $sender_ip The sender's IP address.
   * @param string $sender_username The sender's username.
   * @param int $recipient_id Recipient ID.
   * @param string $subject Message subject.
   * @param string $message Message body.
   * @param boolean $enable_signature Attach user signature?
   * @param boolean $enable_bbcode Enable BB code?
   * @param boolean $enable_smilies Enable smiles?
   * @param boolean $enable_urls Enable URLs (automatically wrap URLs in <a> tag)?
   */
function send_private_message($sender_id, $sender_ip = '127.0.0.1', $sender_username, $recipient_id, $subject, $message, $enable_signature = FALSE, $enable_bbcode = TRUE, $enable_smilies = TRUE, $enable_urls = TRUE)
{
   
  #DO CONFIG VARIABLE CHECKS
  $uid = $bitfield = $options = '';
  #this function is from functions_content which is already loaded by common.php
  generate_text_for_storage($message, $uid, $bitfield, $options, $enable_bbcode, $enable_urls, $enable_smilies);

  $data = array(
     'from_user_id'      => $sender_id,
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
       echo "<BR><BR>";
       print_r($data);
      
}
 
function make_bbcode_uid()
{
   // Unique ID for this message..

   $uid = md5(mt_rand());
   $uid = substr($uid, 0, 8);

   return $uid;
}

?>
  </span>
</table>

</body>
</html>