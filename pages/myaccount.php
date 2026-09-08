<?php
require '../includes/auth_check.inc.php';
$session_username = $session_username;
##### $userID = $_SESSION['user_ID'];
include('functions.php');
include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 
if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";
#$loginvar =  '<form align="center">
#<input type=button value="Add or Edit a Classified Ad" onClick="goToadd_link()">
#</form>';
}
if (!$is_logged_in)
{
echo "NOT LOGGED IN";
$logged_on = "no";
$target_url_in = '/pages/myaccount.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
########################################################################################################
#             End of Login
########################################################################################################<?php
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><script type="text/javascript">
function goToadd_link(){ window.location = "http://www.cyclerestorer.com/pages/add_cycle_shows.php"; }
function goToLogin(){ window.location = "http://www.cyclerestorer.com/pages/login.php"; }
</script>

   <title>My Account</title>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 24px}
-->
</style>
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<h1></h1>
</div>


  <div align="center">
<?php
#$username = $_POST['username'];

$Link = mysql_connect ($Host, $User, $Password); 
//if (checklogin($userID, "profile.php?uid=$uid")) {


#if ($uid == "" && $userID > 0) {$uid = $userID;}
#if (!intval($uid) > 0) {header("Location: search.php");}

#else {

#print_header($username);

$Query = "SELECT p.filename, p.caption FROM tb_pictures AS p, auth_user AS u WHERE u.username='$session_username' AND u.picID=p.picID;";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
if ($Row[0] <> "") {$image = "../userthumbs/$Row[0]";}
else {$image = "../userthumbs/default.jpg";}
if ($Row[1] <> "") {$caption="\"$Row[1]\"";}
else {$caption = "No picture";}





$Query = "SELECT COUNT(*) FROM  registry WHERE username='$session_username'";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$bikes = $Row[0];

$Query = "SELECT COUNT(*) FROM  registry WHERE username='$session_username' and type_of_entry='Registry'";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$active_bikes = $Row[0];


#echo "<h5> Username = $username session_username = $session_username</h5>";

$Query = "SELECT COUNT(*) FROM  registry WHERE username='$session_username' and type_of_entry='Sold'";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$sold_bikes = $Row[0];

$Query = "SELECT  bio,url  FROM auth_user  WHERE username='$session_username';";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$bio = $Row[0];
$url = $Row[1];

?>
<BR>
<H2 align=center>Welcome <?echo $session_username;?></H2>
<div align="center"><br>
  <br>
  
  
    <!-- LARGE TABLE -->
  <TABLE width=700 cellpadding=0 cellspacing=0>
    <TR ALIGN=RIGHT> <!-- First Row in Table -->
	 <TD><!-- Beginning of first TD -->
             
    <!-- Upper PROFILE TABLE Left TABLE  -->
   
     
        <TABLE width=200 ALIGN=LEFT cellpadding=0 cellspacing=2>
          <TR><TH colspan=2 bgcolor=79888E>Hi <?echo $alias;?></TH></TR>
          <TR><TD>
              <div class="box">
              <TABLE align=center cellpadding=4 cellspacing=4 width=200>
                <TD>
                  <div class="box">
                    <TR>
                     <CENTER> <TD width=150 valign=top><a href=profile.php><img src="<?echo $image;?>" alt=<?echo $caption;?> border=0></a>
                        <LEFT>
                          
                          <A  HREF=edit_user_info.php>Edit Account pic and Bio</A><BR><BR> 
                         
                         
						 <BR><BR>
                       
                        </LEFT>		    		    
				     </TD></CENTER>
					</TR>
					</div>
				   </TD>
		    </table>
	    </table>  
		  
		<!-- End of PROFILE TABLE Left TABLE  -->
		
		
	</TD>  <!-- End of first TD --> 
	
		
      <TD><!-- Beginning of Second TD -->
<!--  ###########################  BIO  TABLE  -->
        <div align="center">
          <TABLE width=250 ALIGN=CENTER cellpadding=0 cellspacing=0 width=225>
            <TR><TH bgcolor=79888E><?echo $alias;?>'s Bio</TH></TR>
            <TR><TD>
              <div class="box">
                <TABLE>
                  <TR><TD>
                    <DIV style="width: 250; height: 200; overflow:auto; padding: 4; ">
                      <?echo $bio;?>
                      <?echo $url;?>                     
      					</TD>
					</TR>
                 </TABLE>
      			</DIV>
          </TD></TR>
        </TABLE> <!-- End of Bio Table -->
		</div>
	</TD>	
		
	<TD> <!-- Third TD -->
	
	<!-- STATS TABLE #################################### -->	
  <TABLE ALIGN=CENTER width=200 cellpadding=0 cellspacing=0>
      <TR><TH colspan=2 bgcolor=79888E>My Stats</TH></TR>
      <TR>
	     <TD>
            <div class="box">
         <TABLE width=200>
          <TR>
		     <TD align=center>
               
            
			   <tr>
                  <td>Bikes Registered</td>
                  <td><?echo $bikes;?></td>
         	   </tr>
			   <tr>
                  <td>
				   <? echo "<a HREF= http://www.cyclerestorer.com/pages/user_library.php?user_library_var=$session_username&type_entry_var=Registry>Owned Bikes</a>"; ?>
				   </td>
                  <td><?echo $active_bikes;?></td>
         	   </tr>
			     <tr>
                  <td><? echo "<a align=left href=user_library.php?user_library_var=$session_username&type_entry_var=Sold>Previously Owned</a>"; ?></td>
                  <td><?echo $sold_bikes;?></td>
         	   </tr>
			   <tr>
			      
	          </tr>
			<BR>
         </TD>
	   </TR>
      </TABLE>
      </DIV>
    
   </TR>
</TABLE>


<!-- END OF STATS TABLE -->

</TD>
</TR>  <!-- End of first row -->



<!-- ############################END OF MESSAGES TABLE -->	

</TABLE> <!-- END OF FIRST LARGE TABLE -->
<TABLE width=700 cellpadding=0 cellspacing=0>   <!-- Second Table -->
<TR> <!-- Second Row -->
    <br><br> 	
<TD>
    <!-- Lower Left TABLE -->
   
  

        
           </DIV>
    </TABLE>
	
</TD>



</TR>	
	
<!-- <TR>

<!-- RIGHT COLUMN 
<TD width=425 valign=top align=right>-->

<!-- #########################################################   Bikes TABLE -->
<!-- 
<TR>
<TD>
<TABLE  ALIGN=CENTER width=400 bgcolor=eeeeee cellpadding=0 cellspacing=0>
<TR><TH bgcolor=79888E colspan=2><?echo $alias;?>'s Bikes</TH></TR>
<TR><TD>
<div class=box>
<TABLE width=95% align=center> -->

<?php 

$Query = "SELECT manufacturer,  year, model FROM registry WHERE username='$session_username' ORDER BY manufacturer, year, model";
$Result = mysql_db_query ($DBName, $Query, $Link);
$results = 0;

while ($Row = mysql_fetch_array ($Result)) 

{

$manufacturer = $Row[0];
$year = $Row[1];
$model = $Row[2];

#$cpv = $Row[3];
/*print ("
<TR>
<TD>  $year $manufacturer $model
</TD>
</TR>
<TR><TD colspan=2></TD></TR>

");
$results = $results + 1;

}
print ("</table>");
if ($results == 0) 
{print ("<TR><TD align=center colspan=2><HR>$alias does not have any bikes<HR></TD></TR>");}

*/

}
?>


</TABLE>
</DIV>
</TD></TR>
</TABLE>
<BR>
<TD>
</TR>

<TR>




<?php

mysql_close ($Link);
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
#}
?>

</TR>
</body>
</html>