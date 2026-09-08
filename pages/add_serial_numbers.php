<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_serial_numbers.php';
   //including phpBB3 stuff   

   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();
include '../includes/dbconnect.inc.php';
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES



#print "usernerm $username\n";
//Session doesn't exist


if ($user->data['is_registered']) 
{
print_html_add();
# Do Nothing print_html_add();
#mysql_close ($Link);

}
else 
{
$logged_on = "no";

$target_url_in = '/pages/add_serial_numbers.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
//No Session Variable
$failed = 1;
}

	  # if(!mysql_db_query($dbname,$query,$link_id)) die(mysql_error());
		# echo "success in database entry.";	
//END CHECK LOGIN ##################################################################################################
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
   <title>Add Serial Numbers</title>
   <h5>This is not an owner registry. Use the Member Collection area to add your bike. If you know a serial number range for a bike that's not in this list please add it. </h5>
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

function validate_form(adform)
{
with (adform)
{
if (validate_required(manufacturer_fd,"The 'Manufacturer' field must be filled out!")==false)
  {manufacturer_fd.focus();return false}
if (validate_required(model_fd,"Model must be filled out!")==false)
  {model_fd.focus();return false}
if (validate_required(year_fd,"The Year field must be filled out!")==false)
  {year_fd.focus();return false}
if (validate_required(begin_number_fd,"The First Number field must be filled out!")==false)
  {begin_number_fd.focus();return false}  
if (validate_required(end_number_fd,"The Last Number field must be filled out!")==false)
  {end_number_fd.focus();return false}    
}
}
</script>
</head>
<body>


<?PHP



#print "usernameagain $username\n";

function print_html_add() {
print '
<form name=adform method="POST" onsubmit="return validate_form(this)">
<br>
<br>
     <div align="center"><h1><b>Add Serial Numbers</b></h1></div>
	 <br>
  <div align="center">
     <table width="500" border="0">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width="240"><div align="center"><strong>Manufacturer:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="manufacturer_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Model:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="model_fd" size="50" >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Nickname:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="nickname_fd" size="50" >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>CCs:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="ccs_fd" size="4" >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Number of Cylinders:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="num_cyl_fd" size="4" >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Fuel Tank Color:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="fuel_tank_color_fd" size="30" >
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Year:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="bike_year_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Engine Number:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="engine_number_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
         <tr>
          <td width="210"><div align="center"><strong>Frame Number:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="frame_number_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		         <tr>
          <td width="210"><div align="center"><strong>Production Run:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="production_run_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		  <tr>
		<input type="hidden" name="user_form_var" value="'.$username.'">
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

 
include 'bottom_index_table.php';

$today = date("Y-m-d h:i:s");
 if ($_REQUEST['submit']) { 
        $manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$nickname=$_REQUEST['nickname_fd'];
		$ccs=$_REQUEST['ccs_fd'];
		$num_cyl=$_REQUEST['num_cyl_fd'];
		$fuel_tank_color=$_REQUEST['fuel_tank_color_fd'];
		$bike_year=$_REQUEST['bike_year_fd'];
		$engine_number=$_REQUEST['engine_number_fd'];
		$frame_number=$_REQUEST['frame_number_fd'];
		$production_run=$_REQUEST['production_run_fd'];
		$user_var=$_REQUEST["user_form_var"];
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);	




#Search the existing table to see if the record is already there. 

$query = "SELECT model, bike_year, manufacturer FROM serial_numbers   where (model ='$model') and (bike_year='$bike_year') and (manufacturer='$manufacturer')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);

if ($Row[0] == "") {


$user_temp = $user->data['username'];
	 

$query ="INSERT INTO serial_numbers(engine_number,frame_number,production_run,enter_date,user_name,bike_year,model,nickname,ccs,num_cyl,fuel_tank_color,manufacturer)
 VALUES ('$engine_number','$frame_number','$production_run','$today','$user_temp','$bike_year','$model','$nickname','$ccs','$num_cyl','$fuel_tank_color','$manufacturer')"; 
		$result=mysql_query($query) or die ('Insert Query Failed' . mysql_error());
			
		if    ($result) 
		{ echo "Successfully Entered" ;}
		  else 
		  { echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link); }
	    } 
		include '../includes/analytics.inc.php';
		
}	
else
{
print "<h5> A Serial number for the Bike you just entered already exists. </h5>"; 

}	
		
?>


</body>

</html>
 

