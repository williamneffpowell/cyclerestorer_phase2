<?php
require '../includes/auth_check.inc.php';
include '../includes/dbconnect.inc.php';
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES

if ($is_logged_in)
{
print_html_add();
# Do Nothing print_html_add();


}
if (!$is_logged_in)
{
$logged_on = "no";

$target_url_in = '/pages/add_resource_links.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';



//No Session Variable
$failed = 1;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title> </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CC0033;
}
-->
</style>

</head>
<body>
<?
//END CHECK LOGIN
#print "usernameagain $username\n";
function print_html_add() {
print '
<form method="POST" >
	<br>
	<br>
     <h2><div align="center"><b>Link Registry </b> </div></h2>
	 <br>
	 <h5><div align="center">* Please keep the links Motorcycle or Restoration related.</div></h5>
	 <h6><div align="center">(Unrelated Links will be removed)</div></h6>
	 	 <h6><div align="center">(No Commas or Apostrophes)</div></h6>

	 <br> 
	
   </form>
   <form method="POST" ><div align="center">
     <table class="links" width="384" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="210"><div align="center"><strong>Link Name:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="link_name">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>

        <tr>
          <td><div align="center"><strong>Link Comment</strong></div></td>
          <td><div align="center">
            <input type="text" name="link_comment">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Focused Cycle Manufacturer</strong></div></td>
          <td><input type="text" name="manufacturer"></td>
          <td>&nbsp;</td>
        </tr> 
		      <tr>
          <td><div align="center"><strong>Focused Cycle Model</strong></div></td>
          <td><div align="center">
            <input type="text" name="model">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
          <td><div align="center"><strong>Focused Link Type</strong></div></td>
          <td><div align="center">
            <input type="text" name="type">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		        <tr>
          <td><div align="center"><strong>HTML LINK   http://</strong></div></td>
          <td><div align="center">
            <input type="text" name="html_link">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
		<input type="hidden" name="user_form_var" value="'.$username.'">
         </tr>               
         <tr>
          <td><div align="center"><strong>Link Rating</strong></div></td>
          <td><input type="text" name="link_rating"></td>
          <td>&nbsp;</td>
        </tr>      
     </table>
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
$today = date("Y-m-d h:i:s");
 if ($_REQUEST['submit']) { 
		$manufacturer=$_REQUEST['manufacturer'];
		$model=$_REQUEST['model'];
		$type=$_REQUEST['type'];
		$link_name=$_REQUEST['link_name'];
		$serial_number=$_REQUEST['serial_number'];
		$html_link=$_REQUEST['html_link'];
		$link_rating=$_REQUEST['link_rating'];
		$link_comment=$_REQUEST['link_comment'];
		$user_var=$_REQUEST['user_form_var'];
		
$session_username = $session_username;		


mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);		 
		 
		 $Query2 ="INSERT INTO resource_links(date_entered,manufacturer,resource_name,link_comment,html_link,link_rating,username,model,type)  VALUES ('$today','$manufacturer','$link_name','$link_comment','$html_link','$link_rating','$session_username','$model','$type')"; 
			#print "user_var = $user_var\n";  
		#print " Query $query \n";

	$result=mysql_query($Query2) or die(mysql_error());
		

		
		#print "$mysqul_query($query) \n";
		
		
		if    ($result) 
		{ 
		echo "Successfully Entered" ;
		  }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link);
		  }
	    } 
		

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>

</html>