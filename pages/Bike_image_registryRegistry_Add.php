<?php
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);
$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
print $username[0];
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$username = $Row[0];
//Session doesn't exist
if ($username <> "")
{
print_html_add();


}
else 
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}
}
if ($logged_on == "no")
{
$target_url_in = 'pages/Registry_Add.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
//END CHECK LOGIN

function print_html_add() {
print '
<form method="POST" >
       <br>
	   <br>
     <div align="center"><h1><b>Cycle Registry </b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="210"><div align="center"><strong>Manufacturer:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="manufacturer">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Model:</strong></div></td>
          <td><div align="center">
            <input type="text" name="model">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Year:</strong></div></td>
          <td><div align="center">
            <input type="text" name="year">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Owner:</strong></div></td>
          <td><input type="text" name="owner"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td><div align="center"><strong>Location:</strong></div></td>
          <td><input type="text" name="location"></td>
          <td>&nbsp;</td>
        </tr>
         
         <tr>
           <td><div align="center"><strong>Comments:</strong></div></td>
          <td><input type="text" name="comments"></td>
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


 if ($HTTP_POST_VARS['submit']) { 
		$manufacturer=$HTTP_POST_VARS['manufacturer'];
		$model=$HTTP_POST_VARS['model'];
		$year=$HTTP_POST_VARS['year'];
		$serial_number=$HTTP_POST_VARS['serial_number'];
		$owner=$HTTP_POST_VARS['owner'];
		$location=$HTTP_POST_VARS['location'];
		$comments=$HTTP_POST_VARS['comments'];
		
	
		 $query ="INSERT INTO registry (username,manufacturer,model,year,owner,location,comments)";
		 $query.= " VALUES                		('$session_username','$manufacturer','$model','$year','$owner','$location','$comments')"; 
		  
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed');
		
		if    ($result)  echo "<h3 align = 'center'> Successfully Entered </h3>" ;
		  else echo "<b>ERROR: unable to post.</b>"; 
	    } 

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Cycle Registration</title>
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
include 'bottom_index_table.php';
?>
</body>
</html>

