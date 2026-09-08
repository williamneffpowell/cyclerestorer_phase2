<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../cycle_show_image_Registry_Add.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;

$session_username =$user->data['username'];
include '../includes/dbconnect.inc.php';
if ($user->data['is_registered']) {

print $username;
print_html_add();
}
//Session doesn't exist

if (!$user->data['is_registered'])
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = '/pages/cycle_show_image_Registry_Add.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
//END CHECK LOGIN==================================================================================================================
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Cycle Show Image Registration</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<body>
<div align="center">
  <table width="33%" height="65">
    <tr>
      <th width="35%" scope="col">&nbsp;</th>
      <th width="32%" scope="col">&nbsp;</th>
      <th width="33%" scope="col">&nbsp;</th>
    </tr>


  </table>
</div>
<p>
<?php 
function print_html_add() {
print '
<form method="POST" >
       <br>
	   <br>
     <div align="center"><h1><b>Cycle Show Image Registry</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>

        <tr>
          <td><div align="center"><strong>Comments:</strong></div></td>
          <td><div align="center">
            <input type="text" name="comments">
          </div></td>
          <td>&nbsp;</td>
        </tr>
    

         
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
 

       <table width="200">

       </table>
   
       </textarea>

     </div>
</form> 
	</body>
</html>
'; 


}
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);	


 if ($_REQUEST['submit']) { 
		
		$type_of_entry="show";
		$location=$_REQUEST['location'];
		$comments=$_REQUEST['comments'];
		$entered=date("Y-m-d h:i:s");
		$session_username =$user->data['username'];
		 
		 $type_of_entry = 'cycle_show';
		 $query ="INSERT INTO image_library_registry (username,type_of_entry,comments,entered,location)";
		 $query.= " VALUES ('$session_username','$type_of_entry','$comments','$entered','$location')"; 
		  
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Query failed: ' . mysql_error());
		
		if    ($result)  echo "<h3 align = 'center'> Successfully Entered </h3>" ;
		  else echo "<b>ERROR: unable to post.</b>"; 
	    } 


include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

