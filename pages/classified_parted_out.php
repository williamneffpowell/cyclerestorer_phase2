<?PHP
session_start();
$sessionID = $_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "")
{
# LOGIN OK

}
else
{
$target_url_in = 'pages/classified_parted_out.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php"><div align="center">
<div align="center"><span class="style1"><b>User Login</b></span>
       <table width="261" border="0">
        <caption>&nbsp;
        </caption>
          <tr>
          <td width="84"><div align="center"><strong><span class="style1">*Username:</span></strong> </div></td>
          <td width="162"><div align="center">
            <input name="username" type="text">
            <br>
          </div></td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center" class="style1"><strong><span class="style2">*</span>Password:</strong></div></td>
          <td><div align="center">
            <input type="password" name="password">
          </div></td>
          <td>&nbsp;</td>
        </tr>
       </table>
       <br>
       <input type="submit" name="submit" value="Login">
       <br>
     </div></Form>';
#$logged_status = "Must log In before registering a cycle";

}

##############################################################################################################################################

#**************************************************************************
# The row to select from the Before_after Page selection 

$id_temp_var = $_GET['edit_row'];
echo "<br>";
#******************************************************************
($sort_field_url == "");
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
/************************************************************************************************************/
echo "<h1 align=\"center\"> Display Parts </h1>\n";
echo "<br>";
print "\n";
/************************************************************************************************************/
/* Beginning of outer parts loop to get part names                                                          */
/************************************************************************************************************/
?>
<form  align="center" name=adform method='POST' action="<?php echo $_SERVER['PHP_SELF'];?>">
<?PHP

$query1 = "(SELECT username,manufacturer,model FROM  for_sale_wanted WHERE '$id_temp_var' = item_row_id)";	
    $Row='';
   $doQuery1='';
	$doQuery1=mysql_query($query1);
	while ($Row = mysql_fetch_array($doQuery1))
	{

	$username_tab = $Row[0];
	$manufacturer_tab = $Row[1];
	$model_tab = $Row[2];
	#$year_tab = $Row[5];
	
	
	}
	echo "<table  align='center'><tr><td>$manufacturer_tab  $model_tab </td></tr></table>";
	
$query = "(Select part_name FROM bike_and_inventory WHERE '$id_temp_var' = classified_row_id)";		
	   
$query_parts="(SELECT * from cycle_parts_inventory)";
$do2Query=mysql_query($query_parts);

echo "<table align='center'>";
while($Row=mysql_fetch_array($do2Query)) # search through part type inventory table for cycle parts
{
	$part_cat = $Row[2];
	echo "<tr align='center'>";
	echo "<td align='center'>$part_cat\n";
	echo "<input type='checkbox'  value=\"$part_cat\" name=\"parts[]\" ";
	#$query= "(SELECT * FROM bike_and_inventory WHERE classified_row_id = '$id_temp_var')";
#	$query_for_sale = "(SELECT username manufacturer model for_sale_wanted  FROM for_sale_wanted WHERE classified_row_id = '$id_temp_var')
	
	
	#$query= "(SELECT part_name, username from bike_and_inventory right join  manufacturer, model from 
	#for_sale_wanted on classified_row_id.bike_and_inventory = '$id_temp_var' and item_row_id.for_sale_wanted = '$id_temp_var')";
	$doQuery=mysql_query($query);
	$numrows=mysql_num_rows($doQuery);	
		if($numrows <> 0)
		 {
		# $rowcounter = 1;
			 while($part_name=mysql_fetch_array($doQuery))
 			{ # beginning of while
			    ########$username_tab=$part_name['username'];
				#if ($rowcounter == 1)
				#  { 
				#$temp_var = $part_name['manufacturer'];
				#$temp_var2 = $part_name['model'];
				#echo "This is Manufacturer and Model $temp_var  $temp_var2";
				#	} 
				#$rowcounter++;	
				
				
  				$part_name_arr=unserialize($part_name[0]);
				 # echo "$part_name_arr \n";
   					 if (is_array($part_name_arr ))
						{
   							foreach ($part_name_arr as $part)
  								{ 
     								if ($part == $part_cat)
	  								{
	  								echo " CHECKED ";
	 								 }  
     							} # end of foreach */
     					} #end of is array if
			}  # end of while
      } # end of numrows if
	  		echo " </td>";
		echo "<br>";
  		echo " </tr>";
}


echo "</table>";
echo "</table align='center'>";
#echo "print username_tab = $username_tab  session_username = $session_username \n";
#$username_tab=$HTTP_POST_VARS["user_form_var"];
if ($username_tab == $session_username)#login if statement to allow submission
   {
    echo "<table align='center'>";
	echo "<tr align='center'>";
	echo "<td align='center'>";
	#echo "username before hidden = $username_tab ";
	echo "<input type='hidden' name='user_form_var' value=\"$username_tab\">";
	echo "<input type='hidden' name='it_temp_frm' value=\"$id_temp_var\">";
	echo "<input type='submit' name='submit' value='Submit' align='center'>";
	#echo "<input type='reset' name='Clear' value='Clear Form and Start Over'>";
	echo " </td>";
	echo " </tr>";
	echo "</table>";
  } # End of login if statement
 
 /* {
  echo "<table align='center'>";
	echo "<tr align='center'>";
	echo "<td align='center'>";
 echo " <a href=classified_ads.php align='center'>Back to Classified Ads</a>";
 echo " </td>";
	echo " </tr>";
	echo "</table>";
  } */
  
  
echo "</form>";
/******************************************************************************************************************/
/* The logic below accepts entries for the motorcycle parts if the submit button is pushed and puts them in the database  */
/******************************************************************************************************************/
 if ($HTTP_POST_VARS['submit'])
 {
$username_tab=$HTTP_POST_VARS["user_form_var"];

if(isset($_POST['parts']))
{
   $language = $_POST['parts'];
   $n        = count($language);
   $i        = 0;

/* echo  "<ol>";
 while ($i < $n)
   {
  #  echo "printing number \n";
      echo "<li>{$parts[$i]}</li> \r\n";
      $i++;
   }
   echo "</ol>"; */
}
$session_username = $_SESSION['user_name'];
if ($session_username == $username_tab) #login if statement
    { 
		$id_temp_passed=$HTTP_POST_VARS['it_temp_frm'];
		$today = date("Y-m-d h:i:s");
		$parts=serialize($_POST['parts']); //takes the data from a post operation...	
		 $res = mysql_query("SELECT count(classified_row_id)  FROM bike_and_inventory WHERE classified_row_id = '$id_temp_passed'");
        $record_count = mysql_result($res,0,0);
		 echo "<BR>";
		 if ($record_count > 0) 
		 {
		 $Query2 = "UPDATE bike_and_inventory SET part_name = '$parts', date_time_entered = '$today' WHERE  classified_row_id = '$id_temp_passed'";
		 $result=mysql_query($Query2) or die ('Update Query Failed' . mysql_error());
		 }
		 else
		 {
		$Query2 = "insert into bike_and_inventory(part_name,classified_row_id,date_time_entered,username) VALUES 		     ('$parts','$id_temp_passed','$today','$session_username')";
		
		  $result=mysql_query($Query2) or die ('Insert Query Failed' . mysql_error());
		 }
		 		 		 
		 	 	
		if  ($result) 
			{
			  
		 	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/classified_ads.php" </script>';
			}
			else
			{
			  echo "$mysql_error\n";
			  }
	} #end of login if statement		
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
   <title>Parts Available</title>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>
