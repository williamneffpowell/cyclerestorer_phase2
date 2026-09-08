<?php
include '../includes/dbconnect.inc.php';

$Link = mysql_connect("$Host","$User","$Password");	

mysql_select_db("$DBName") or die ("unable to select DB");
	
if ($_REQUEST['submit']) {
		$usernme=$_REQUEST['usernme'];
		$passwrd=$_REQUEST['passwrd'];
		$first_name=$_REQUEST['first_name'];
		$last_name=$_REQUEST['last_name'];
		$address_1=$_REQUEST['address_1'];
		$address_2=$_REQUEST['address_2'];
		$city=$_REQUEST['city'];
		$state=$_REQUEST['state'];
		$zipcode=$_REQUEST['zipcode'];
		$email=$_REQUEST['email'];	
		
	
$Query = "SELECT username FROM auth_user WHERE (username = '$usernme');";
$Result = mysql_db_query($DBName,$Query,$Link);
$Row = mysql_fetch_row($Result);
if ($Row <> "")
{
$chosen_name = "The username chosen has already been used, please select another username";
		
}		
else
{		
		
		
$query ="INSERT INTO auth_user (username,password,first_name,last_name,address_1,address_2,city,state,zipcode,email)";
$query.= "VALUES  ('$usernme','$passwrd','$first_name','$last_name','$address_1','$address_2','$city','$state','$zipcode','$email')"; 
		  
		
		$result=mysql_query($query) or die(mysql_error());
		
		
		if ($result) 
		{
		 #echo "Successfully Entered" ;
		 }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
	  	}

}	
}
			
?>



<div align="center"><br />
  
   <a href="../index.php">Home</a><br>	
</div>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>User Registration</title>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <table width="33%" height="335">
    <tr>
      <th width="14%" scope="col">&nbsp;</th>
      <th width="79%" scope="col"><?PHP
	  
	  if ($chosen_name <> "")
	  {
	  echo "<b>$chosen_name</b>";

	  
	  }
	  else
	  {
	  print "Succsessfully Entered";
	  
	  }
	  ?></th>
      <th width="7%" scope="col">&nbsp;</th>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center"><?PHP
	  
	  if ($chosen_name <> "")
	  {
	  
	  echo '<a href="user_registration.html">User Registration</a>';
	  
	  }
	  else
	  {
#The line must be edit below if this file is ported to production.
#Production Link: http://www.cyclerestorer.com/pages/login.php	  
#Development Link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/login.php
	  echo '<form method="POST" action="http://localhost:8080/redbug/_no_task/cyclerestorer/pages/login.php"><div align="center">
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


	  }
	  
	  ?></div>
      <div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="285">&nbsp;</td>
      <td></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<p>
<?php
include '../includes/analytics.inc.php';
?>
</body>
</html>