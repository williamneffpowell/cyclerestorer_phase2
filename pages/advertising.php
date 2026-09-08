<?PHP
#session_start();
#$sessionID = $_SESSION['sessionID'];
#$session_username = $_SESSION['user_name'];

#include '../includes/dbconnect.inc.php';

#$Link = mysql_connect ($Host, $User, $Password); 
#$Query = "SELECT * from auth_user WHERE (sesnID='$sessionID')";   #Add Yes logic
#$Result = mysql_db_query ($DBName, $Query, $Link);
#$Row = mysql_fetch_array ($Result);
#if ($Row[0] <> "")
#{
# LOGIN OK
#$loginvar =  '<form align="center">
#<input type=button value="Add or Edit a Classified Ad" onClick="goToadd_link()">
#</form>';
#}
#else
#{
#$target_url_in = 'pages/classified_ads.php';
#$_SESSION['target_url'] = "$target_url_in";
#$target_url_goto= $_SESSION['target_url'];
#$loginvar='<form align="center">
#<input type=button value="Log In to add or Edit an ad" onClick="goToLogin()">
#</form>';
#}
########################################################################################################
#             End of Login
########################################################################################################

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_classified_ads.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>

   <title>Classified Ads</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1 align="center">Site Sponsors</h1>

<br>
<br>
<br>
</div>
</table>
<table align="center">
 <tr align="center">

   

</tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table align="center">
 <tr align="center">
    
 

</tr>


<!--
/* google_ad_client = "pub-2941881919980479";
/* cyclerestorer_advertising */
/*google_ad_slot = "1941795724";
google_ad_width = 728;
google_ad_height = 90;
//-->

</table>

<p>&nbsp;</p>

<br>
<br>
<br>
<?php
 include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>



</table>

</body>
</html>
