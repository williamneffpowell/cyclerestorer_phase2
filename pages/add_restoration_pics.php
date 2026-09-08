<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_restoration_pics.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
   
session_start();


include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password); 

#**************************************************************************
# The row to select from the Before_after Page selection 
$id_temp_add_var = $_REQUEST['bfore_aftr_row_id'];
#******************************************************************
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

<!--function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=600,left = 340,top = 212');");
}</script>
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

function validate_form(picture_upload)
{
with (picture_upload)
{
if (validate_required(photo_comment,"The 'Photo Comment' field must be filled out!")==false)
  {photo_comment.focus();return false}
if (validate_required(file_name,"You Must Select A File to Upload")==false)
  {file_name.focus();return false}
}
}
</script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

</style>
</head>
<body>
<br>
<br>
  <table width="200" border="0" cellpadding="0" align = "center"   >
    <tr>
      <th scope="col"></th>
      <th scope="col">Add Restoration Images </th>
    </tr>
</table>
<TABLE align=center width=600 bgcolor=eeeeee>
<TR><TH bgcolor=79888E>Image Upload Policy</TH>
<TR><TD>
<CENTER><B>(<FONT COLOR=ff0000>Violating any of the below will result in removal from the site</FONT>)</B></CENTER>

<UL>
<LI>Please do not upload copyrighted images 
<LI>Do not upload pornographic pictures
<LI>Do not use this website to post SPAM or Ads for other products or services
</UL>
<CENTER>* Images must be GIF or JPEG and no greater than 1 MB in size.</CENTER>
</TD></TR>
</TABLE>	
<?PHP
if ($user->data['is_registered'])
{
# LOGIN OK



$add_picture_form = '<form name=picture_upload onsubmit="return validate_form(this)" align="center" ENCTYPE="multipart/form-data" action="'.$PHP_SELF.'"  method="POST" ><div align="center">

     <table width="50%" border="0" bgcolor="#CCCCCC">
        <caption>&nbsp;
        </caption>
         
        <tr>
          <td width="110" align="right"><div align="center" class="style3">
            
          </div></td> 
		    <input type="hidden" name="bef_aft_val" value="'.$id_temp_add_var.'">
              <input type="file" Name="file_name">
            </div></td>
          <td>
            <div align="left">
        </tr>
		
        <tr>
          <td height="40"><div align="center" class="style2">
            <div align="right" class="BK_12pt_bld"><strong>Photo Comment</strong></div>
          </div></td>
          <td><input name="photo_comment" type="text" size="150"></td>
        </tr>	
           <td><div align="center" class="style1"></div></td>
          <td><div align="center">
            <input  type="submit" name="submit" value="Upload">
         </div></td>
        </tr>
     </table>
       <a href="../index.php"></a> 
      <table width="1500">
    </table>
       </div>
</form>';


print "$add_picture_form";
}
if (!$user->data['is_registered'])
# The link below must be change when it is ported to production, must be changed! 
#This is the production Link: http://www.cyclerestorer.com/pages/login.php
#This is the test link: http://localhost:8080/redbug/_no_task/cyclerestorer/pages/login.php

{
$target_url_in = '/pages/add_restoration_pics.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
#print "Not logged on\n";
#$registration_var = '<div align="center"><span class="style1"><a href="pages/user_registration.html">User Registration</a></span></div>';
$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php">
<div align="center"><span class="style1"><b>User Login</b></span>
       <table width="261" border="0">
        <caption>&nbsp;-------------------------------`
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
	   <input type="reset" name="Clear" value="Clear Form and Start Over">
       <br>
     </div></Form>';
	echo "$login_var";

}
//END CHECK LOGIN
#########################################################################################################################################################

$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
mysql_select_db("$DBName") or die(mysql_error());
#$result = mysql_query($query) or die('Query failed: ' . mysql_error());
#$Link = mysql_connect ($Host, $User, $Password); 

echo '</tr>';

echo '</table>';
$idir = "../image_upload/";   // Path To Images Directory 
$tdir = "../image_upload/thumbs/";   // Path To Thumbnails Directory 
$pwidth="800";
$pheight="800";
$twidth = "125";   // Maximum Width For Thumbnail Images 
$theight = "100";   // Maximum Height For Thumbnail Images 

function random_num($n=5) //Random Number Generator to add a number to the file name. 
{
return rand(0, pow(10, $n));
}



#if (!isset($_FILES['file_name'])) exit;
if (is_uploaded_file($_FILES['file_name']['tmp_name']))
  { 
   // Uploading/Resizing Script 
    $url = $_FILES['file_name']['name'];   // Set $url To Equal The Filename For Later Use 
	
	
   if ($_FILES['file_name']['type'] == "image/jpg" || $_FILES['file_name']['type'] == "image/jpeg" || $_FILES['file_name']['type'] == "image/pjpeg") 
    { 
      $file_ext = strrchr($_FILES['file_name']['name'], '.');   // Get The File Extention In The Format Of , For Instance, .jpg, .gif or .php 
	                                                                                                                                                                                                                                                                                            
      $copy = copy($_FILES['file_name']['tmp_name'],"$idir".$_FILES['file_name']['name']);   // Move Image From Temporary Location To Permanent Location 
	  
	 
    if ($copy) 
	  {   // If The Script Was Able To Copy The Image To It's Permanent Location 
      print '<h3>Image uploaded successfully.</h3><br />';   // Was Able To Successfully Upload Image 
      $simg = imagecreatefromjpeg("$idir" . $url);   // Make A New Temporary Image To Create The Thumbanil From 
	  #print $simg;
      $currwidth = imagesx($simg);   // Current Image Width 
      $currheight = imagesy($simg);   // Current Image Height 
	 
	  
	  
      if ($currheight > $currwidth) 
	   {   // If Height Is Greater Than Width 
         $zoom = $twidth / $currheight;   // Length Ratio For Width 
         $newtheight = $theight;   // Height Is Equal To Max Height 
         $newtwidth = $currwidth * $zoom;   // Creates The New Width 
       } 
	   else 
	   {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
        $zoom = $twidth / $currwidth;   // Length Ratio For Height 
        $newtwidth = $twidth;   // Width Is Equal To Max Width 
        $newtheight = $currheight * $zoom;   // Creates The New Height 
       }	  
	 
	if ($currheight > $currwidth) 
	  {   // If Height Is Greater Than Width 
         $zoom = $pwidth / $currheight;   // Length Ratio For Width 
         $newpheight = $pheight;   // Height Is Equal To Max Height 
         $newpwidth = $currwidth * $zoom;   // Creates The New Width 
      } else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
        $zoom = $pwidth / $currwidth;   // Length Ratio For Height 
        $newpwidth = $pwidth;   // Width Is Equal To Max Width 
        $newpheight = $currheight * $zoom;   // Creates The New Height 
      }
	  $dimg = imagecreate($newtwidth, $newtheight);   // Make New Image For Thumbnail 
      imagetruecolortopalette($simg, false, 256);   // Create New Color Pallete 
      $palsize = ImageColorsTotal($simg);
	
	
      for ($i = 0; $i < $palsize; $i++) {   // Counting Colors In The Image 
       $colors = ImageColorsForIndex($simg, $i);   // Number Of Colors Used 
       ImageColorAllocate($dimg, $colors['red'], $colors['green'], $colors['blue']);   // Tell The Server What Colors This Image Will Use 
      } 
	  $temp_th_url = random_num().$url; //create temporary thumbnail url
      imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newtwidth, $newtheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It) 
      imagejpeg($dimg, "$tdir" . $temp_th_url);   // Saving The Image to the temporary directory
	  $dimg = imagecreate($newpwidth, $newpheight);   // Make New Image For Thumbnail 
      imagetruecolortopalette($simg, false, 256);   // Create New Color Pallete 
      $palsize = ImageColorsTotal($simg); 
      for ($i = 0; $i < $palsize; $i++) {   // Counting Colors In The Image 
       $colors = ImageColorsForIndex($simg, $i);   // Number Of Colors Used 
       ImageColorAllocate($dimg, $colors['red'], $colors['green'], $colors['blue']);   // Tell The Server What Colors This Image Will Use 
      } 
	  # $temp_n_url = random_num().$url; //create temporary normal url
      imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newpwidth, $newpheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It) 

       imagejpeg($dimg, "$idir" . $temp_th_url);   // Saving The Image 
     # imagedestroy($simg);   // Destroying The Temporary Image 
      imagedestroy($dimg);   // Destroying The Other Temporary Image 
      #print 'Image thumbnail created successfully.';   // Resize successful 
    } 
	
	else 
	{ 
      print '<font color="#FF0000">ERROR: Unable to upload image.</font>';   // Error Message If Upload Failed 
    }	 
  }   
  else   
  { 
    print '<font color="#FF0000">ERROR: Wrong filetype (has to be a .jpg or .jpeg. Yours is ';   // Error Message If Filetype Is Wrong 
    print $file_ext;   // Show The Invalid File's Extention 
    print '.</font>'; 
  }     
# ********************************************************************************
#  Now that it uploaded, record the information into the before_after Database.
#*********************************************************************************
}

if (is_uploaded_file($_FILES['file_name']['tmp_name']))
{
$Link = mysql_connect ($Host, $User, $Password);
#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";;

#$host_server_link= "localhost:8080/redbug/_no_task/cyclerestorer";
mysql_select_db("$DBName") or die(mysql_error());


$photo_comment=$_REQUEST['photo_comment'];
//$file_var=$_FILES['file_name']['name'];
$bef_pic_row_id=$_REQUEST["bef_aft_val"];
$today = date("Y-m-d h:i:s");

$Link = mysql_connect ($Host, $User, $Password); 
mysql_select_db("$DBName") or die(mysql_error());


$sql = "SELECT COUNT(*) FROM before_after_pics where before_after_row_id = '$bef_pic_row_id'";
$results = mysql_query($sql) or die(mysql_error());
$total_rows = mysql_fetch_row($results); 
$total_plus_one = $total_rows[0] + 1;

$Link = mysql_connect ($Host, $User, $Password); 
mysql_select_db("$DBName") or die(mysql_error());

$query ="INSERT INTO before_after_pics (pic_comment,filename,pic_enter_date,before_after_row_id,pic_display_order) VALUES('$photo_comment','$temp_th_url','$today','$bef_pic_row_id','$total_plus_one')"; 	

#print $query;
		$result=mysql_query($query) or die (print '<h5>Insert Query Failed</h5>' . mysql_error());
	mysql_close ($Link);
echo '<script language="JavaScript" type="text/javascript">
			//	window.location.href="http://www.cyclerestorer.com/pages/restoration_pics.php?edit_row=',"$bef_pic_row_id",'"</script>';	 
echo "\n";
$my_file = $_FILES['file_name']['name']; 

}
echo "<br>";
echo "<h3><a href=restoration_pics.php?edit_row=$id_temp_add_var>Back to Picture Layout</a></h3>";
?>

<p>

</p>
<p>&nbsp;</p>
<?PHP
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

<p>&nbsp;</p>
</body>
</html>