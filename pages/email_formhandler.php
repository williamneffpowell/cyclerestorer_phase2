<?PHP

/*This starts the session that we created on the last page*/
session_start(); 

/*This trims the random variable of any white space that the user may have unknowingly put in.*/
$random = trim($random);

/*Below is a conditional statement: In English it reads, if the string that the user put into the text box is equal to what is in the image then print to the screen, "You are verified."  If they are not equal it tells the user to go back and try again.*/

/*We can use the variable $new_string because we registered it into our session on the last page, it retains its value that it had on the first page.*/
if ($new_string == $random){
echo "You are verified";
}
else{
echo "Please go back and get verified.";
}


$today = date("Y-m-d h:i:s");
 if ($HTTP_POST_VARS['submit']) { 
        $sender_name_pv=$HTTP_POST_VARS['your_name_fd'];
		$sender_email_pv=$HTTP_POST_VARS['email_fd'];
		$city_state_pv=$HTTP_POST_VARS['city_state_fd'];
		$phone_pv=$HTTP_POST_VARS['phone_fd'];
		$comment_pv=$HTTP_POST_VARS['comment_fd'];
		$classified_row=$HTTP_POST_VARS['classified_row_id'];
		
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);		 
		 
		 $query ="INSERT INTO sent_ad_emails(sender_name,sender_email,city_state,sender_phone,sender_message,username,send_date)";
		 $query.= " VALUES  ('$sender_name_pv','$sender_email_pv','$city_state_pv','$phone_pv','$comment_pv','$username','$today')";
		$result=mysql_query($query) or die ('Insert Query Failed');

$query = "SELECT * FROM for_sale_wanted where item_row_id = '$classified_row'";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 $Link = mysql_connect ($Host, $User, $Password); 

while ($Row = mysql_fetch_array($result))
{
$placer_email = $Row[2];
$subject_content=$Row[7];
}


		if    ($result) 
		{ 
		$to = $placer_email;
		$subject = $subject_content;
		$body = $comment_pv;
         		
		if (mail($to, $subject, $body)) 
		{
 		 echo("<p>Message successfully sent!</p>");
 		} else 
		{
  		echo("<p>Message delivery failed...</p>");
 		}

	   }
	  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link);
		  }
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
