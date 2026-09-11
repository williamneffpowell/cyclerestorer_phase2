<?php
require '../includes/auth_check.inc.php';
	include '../includes/dbconnect.inc.php';
	mysqli_connect("$Host","$User","$Password","$DBName");
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username  = $session_username;
//$session_userID = $_SESSION['user_ID'];



$Link = mysqli_connect($Host, $User, $Password, $DBName);


//Session doesn't exist
if ($is_logged_in)
{
# Do Nothing print_html_add();
#mysqli_close($Link);

}
if (!$is_logged_in)
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = 'pages/popup_add_before_after.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#The HREF location must be changed then the application is ported to production.

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
//END CHECK LOGIN
#########################################################################################################################################################
#########################################################################################################################################################
#########################################################################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
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

function validate_form(add_before_after)
{
with (add_before_after)
{
if (validate_required(restoration_title,"The 'Restoration Title' field must be filled out!")==false)
  {restoration_title.focus();return false}
if (validate_required(id_radio_button,"A bike must be selected!")==false)
  {id_radio_button.focus();return false}
}
}
</script>
   <title>Select Registered Bike </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<br>
<H3 align='center' >Select Registered Bike for Restorations Projects Posting</H3>
<div align="center"><br>
  <H4 align='center' >
  Cycles Must be registered before they can be added to the Restoration Projects page.
  <H4>
</div>
<form name=add_before_after onSubmit="return validate_form(this)" method="POST" ><div align="Left">
<?php
if ($sort_field_url == "")
{
$sort_field_in =  "order by r.manufacturer" ;}
elseif ($sort_field_url == 3)
{$sort_field_in = "order by r.year";}
elseif ( $sort_field_url == 5)
{$sort_field_in = "order by r.owner";}
elseif ( $sort_field_url == 6)
{$sort_field_in = "order by r.owner DESC";}


$Link = mysqli_connect($Host, $User, $Password, $DBName);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
// Performing SQL query
#$query = "SELECT * FROM registry where row_id NOT IN (SELECT registration_row_id FROM before_after)";
$type_of_entry = "Registry";
//$query = "SELECT * from registry where type_of_entry = '$type_of_entry' ";
//$query = "SELECT r.username,r.row_id,r.action,r.manufacturer,r.model,r.year,r.serial_number,r.owner,r.location,r.comments from registry as r where r.type_of_entry - '$type_of_entry' $sort_field_in  ";
 //where r.type_of_entry = '$type_of_entry'
//$sort_field_in  = '$type_of_entry' ";
//r.type_of_entry = '$type_of_entry' and

//select * from location where id not in (select id from bannedlocation)


$query = "SELECT r.username,r.row_id,r.action,r.manufacturer,r.model,r.year,r.serial_number,r.owner,r.location,r.comments FROM registry as r where r.row_id not in (select registration_row_id from before_after) and r.type_of_entry = '$type_of_entry' ";

$result = mysqli_query($Link, $query) or die('Query failed: ' . mysqli_error($Link));
$Link = mysqli_connect($Host, $User, $Password, $DBName);

echo "<table align='center' width='60%' border='0'>\n";
echo "<TR><TH width='5%'><div align='center'>Select Bike</TH>";
echo "<TH width='5%'><div align='center'>Make</TH>";
echo "<TH width='5%'><div align='center'>Model</TH>";
echo "<TH width='5%'><div align='center'>Year</TH>";

while ($Row = mysqli_fetch_array($result))
{
//if ($bgcolor == "BBBBBB") {$bgcolor = "7777777";}
//else {$bgcolor = "BBBBBB";}

$user_tab = $Row[0];
$row_id_tab = $Row[1];
$action_tab = $Row[2];
$manufacturer_tab = $Row[3];
$model_tab = $Row[4];
$year_tab = $Row[5];
$serial_number_tab = $Row[6];
$owner_tab = $Row[7];
$location_tab = $Row[8];
$comments_tab = $Row[9];

echo "<TR bgcolor=$bgcolor>";
if ($user_tab == $session_username and ($Row[0] <> ""))
{
$name = ("<INPUT TYPE='radio' NAME='id_radio_button' VALUE='$row_id_tab'>");
echo "<td align='center'>$name</td>\n";
echo "<td align='Left'>$manufacturer_tab</td>\n";
echo "<td align='Left'>$model_tab</td>\n";
echo "<td align='Left'>$year_tab</td>\n";
echo "</tr>\n";
}
else
{
#$name = "  ";
}
}
echo "</table>\n";
echo "        <caption>&nbsp;";
echo "        </caption>";


?>

	 <div align="center">
	 <br><div align="center"><strong>Restoration Title</strong></div>
	 <br>
              <input  name="restoration_title" type="text" size="50">
  </div></td>
        </tr>
		<br>
		<br>
		<tr>
           <td><div align="center" class="style1"></div></td>
          <td><div align="center">
    <input type="submit" name="submit" value="submit">
	<input type="button" value="Register a Bike" onClick="javascript: location.href = 'http://www.cyclerestorer.com/pages/Registry_Add.php';">
          </div></td>
        </tr>
     </table>
</form>

<?php
	  if ($_REQUEST['submit'])
	{
		$restoration_title_value=$_REQUEST['restoration_title'];
		$radio_button=$_REQUEST['id_radio_button'];
	//	$session_userID = $_SESSION['user_ID'];
		 # OLD $query ="INSERT INTO before_after (username,restoration_title,userID) VALUES('$session_username','$restoration_title_value','$radio_button','$session_userID')";
		$query ="INSERT INTO before_after (username,restoration_title,registration_row_id) VALUES('$session_username','$restoration_title_value','$row_id_tab')";
		$result=mysqli_query($Link, $query) or die ('Update Query Failed $Query');
		#The HREF location must be changed then the application is ported to production.
		#This is the production Link: http://www.cyclerestorer.com/pages/library.php
		#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/library.php
		print "$result";
		if  ($result)
			{
		    	mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/before_after.php"</script>';
			}
		  else
		 {
		  echo "<b>ERROR: unable to insert.</b>";
	    }
	}
     elseif ($_REQUEST['Register'])
	    {
		  print "Register If\n";
		 mysqli_close($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/library.php"</script>';
         }
?>
<?php
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>