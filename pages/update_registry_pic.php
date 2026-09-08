<?PHP
error_reporting(E_ALL);
 ini_set("display_startup_errors","1");
 ini_set("display_errors","1"); 
 
require '../includes/auth_check.inc.php';
$Link = mysql_connect ($Host, $User, $Password); 
if ($is_logged_in)
{
# LOGIN OK
$logged_in_var = "yes";

}
else
{
$logged_on = "no";
$target_url_in = 'pages/update_registry_pic.php';
$_SESSION['target_url'] = "$target_url_in";
	

$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';
}
########################################################################################################
#             End of Login
########################################################################################################################

$imagefile =basename($_FILES['imagefile']['name']);
if ($imagefile <> "") {
if ($_FILES['imagefile']['name']<> "") 
{
$imageFilename = upload_image($_FILES['imagefile']['name'], 800, 150, "../image_upload/","../image_upload/thumbs/");
}
else 
{
$imageFilename = "";
}
if ($imageFilename == "Error") {
print ("Error uploading image. Please make sure that the images are either GIF or JPEG ");
}
else {
#**************************************************************************
# The row to select from the Before_after Page selection 

#******************************************************************
// INSERT PICTURE

mysql_select_db("$DBName") or die(mysql_error());																	
if ($imageFilename <> "") {
$Query = "INSERT INTO tb_pictures VALUES ('', '$imageFilename', '$caption')";
$Result = mysql_query ($Query) or die ('Query Failed: ' .mysql_error());
$Query = "SELECT picID FROM tb_pictures WHERE filename='$imageFilename';";
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$picID = $Row[0];
}
// UPDATE USER
$reg_rowID = $_SESSION['PASSED_ROW_ID'];
$Query = "UPDATE registry SET picID=$picID  WHERE row_ID=$reg_rowID";
$Result = mysql_db_query ($DBName, $Query, $Link);
} // END WAS PICTURE UPLOAD OK

} // END CHECK IF FORM IS COMPLETE

else {print ("incomplete form");
#print "Reg row id $reg_rowID ";
}


/* echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/edit_registry.php?edit_row=<?php print "$reg_rowID"?>"</script>';
				*/
############################################################################################################################
############################################################################################################################
############################################################################################################################

 function upload_image($FILE, $imagetarget, $thumbtarget, $imagedir, $thumbdir) {
$tempdir = "../image_upload/";
$filename = createRandomPassword() . createRandomPassword();
// CHECK FILE TYPE AND SET NEW FILE NAME
$file_ext = strrchr($FILE, '.'); 
if ($file_ext == ".jpg" || $file_ext ==".jpeg") {
$filename = $filename . ".jpg";
}
elseif ($file_ext ==".gif") {
$filename = $filename . ".gif";
}
else {
return "Error, file is not of type .jpg, .jpeg, or .gif";
exit;
}
// END CHECK FILE TYPE AND SET NEW FILE NAME
// GET IMAGE SIZE  

list($w, $h) = getimagesize($_FILES['imagefile']['tmp_name']);
if ($w > $imagetarget) {
$imagewidth = $imagetarget;
$imageheight = $h * ($imagetarget / $w);
}
else {
$imagewidth = $w;
$imageheight = $h;
}
if ($w > $thumbtarget) {
$thumbwidth = $thumbtarget;
$thumbheight = $h * ($thumbtarget / $w);
}
else {
$thumbwidth = $w;
$thumbheight = $h;
}
//END GET IMAGE SIZE
$origfile = "$tempdir/" . $filename;
if(move_uploaded_file ($_FILES["imagefile"]["tmp_name"], $origfile)){
chmod("$origfile",0777);
}
//THUMBNAILS
/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
if ($file_ext ==".gif")
{
$im=ImageCreateFromGIF($origfile);
$newimage=imagecreatetruecolor($thumbwidth,$thumbheight);
imageCopyResized($newimage,$im,0,0,0,0,$thumbwidth,$thumbheight,$w,$h);
if (function_exists("imagegif")) {
// Header("Content-type: image/gif");
imagegif($newimage,"$thumbdir/$filename");
}
elseif (function_exists("imagejpeg")) {
// Header("Content-type: image/jpeg");
imagejpeg($newimage,"$thumbdir/$filename");
}
}
//chmod("$thumbdir",0777);
////////// end of gif file thumb nail creation//////////
////////////// starting of JPG thumb nail creation//////////
if($file_ext==".jpeg" || $file_ext ==".jpg"){
$im=ImageCreateFromJPEG($origfile); 
$newimage=imagecreatetruecolor($thumbwidth,$thumbheight);                 
imageCopyResized($newimage,$im,0,0,0,0,$thumbwidth,$thumbheight,$w,$h);
ImageJpeg($newimage,"$thumbdir/$filename");
//chmod("$tsrc",0777);
}
////////////////  End of JPG thumb nail creation //////////
//REGULAR IMAGES
/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
if ($file_ext==".gif")
{
$im=ImageCreateFromGIF($origfile);
$newimage=imagecreatetruecolor($imagewidth,$imageheight);
imageCopyResized($newimage,$im,0,0,0,0,$imagewidth,$imageheight,$w,$h);
if (function_exists("imagegif")) {
// Header("Content-type: image/gif");
ImageGIF($newimage,"$thumbdir/$filename");
}
elseif (function_exists("imagejpeg")) {
// Header("Content-type: image/jpeg");
ImageJPEG($newimage,"$thumbdir/$filename");
}
}////////// end of gif file thumb nail creation//////////
############################################################################((((((((((((((((((((((((((((((((((((((((((((((((((((((((
# Routine to resize the original image. 
if($file_ext==".jpeg" || $file_ext ==".jpg" || $file_ext ==".gif"){
$im=ImageCreateFromJPEG($origfile); 
$newlargeimage=imagecreatetruecolor($imagewidth,$imageheight);                 
imageCopyResized($newlargeimage,$im,0,0,0,0,$imagewidth,$imageheight,$w,$h);
ImageJpeg($newlargeimage,"$imagedir/$filename");
}
######################################################################################################################
######################################################################################################################
return "$filename";
}
function createRandomPassword() {    
$chars = "abcdefghijkmnopqrstuvwxyz023456789";    
srand((double)microtime()*1000000);    
$i = 0;    
$pass = '' ;    
while ($i <= 7) {        
$num = rand() % 33;        
$tmp = substr($chars, $num, 1);        
$pass = $pass . $tmp;        
$i++;    }    
return $pass;
}




###################################################################################################################
###################################################################################################################
#include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
#echo "I made it above the redirectd. ";

#echo "new pic id = $new_picID and reg_rowID=$reg_rowID ";
/*echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/edit_registry.php?edit_row=<PHP echo "$reg_rowID" ?>&<PHP echo "$new_picid" ?>" </script>';
/*echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/serial_number_reference.php" </script>'; */
$query = "SELECT picID FROM registry  where row_id ='$reg_rowID'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$new_picID = $Row[0];


mysql_close ($Link);

 header("Location: http://www.cyclerestorer.com/pages/view_collection_info.php?edit_row=$reg_rowID&picID=$new_picID"); 




				
				
				
?>
