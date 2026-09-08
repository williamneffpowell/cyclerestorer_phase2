<?php
$tdir = "c:\temp4";
$twidth = "200";   // Maximum Width For Thumbnail Images 
$theight = "200";   // Maximum Height For Thumbnail Images 
if (!isset($_GET['subpage'])) {
?> 
<HTML>
<HEAD>
<TITLE>Upload a Picture</TITLE>
</HEAD>
<form method="post" action="uploadfile.php?subpage=upload" enctype="multipart/form-data"> 
Upload an image (must be jpeg format)<BR>
  <input type="file" name="imagefile" class="form"> 
<BR>
OR type URL of image
<BR>
<INPUT TYPE=TEXT SIZE=35 MaxLength=90 Name=image_url>
 <BR><BR>
  <input name="submit" type="submit" value="Submit" class="form">  <input type="reset" value="Clear" class="form"> 
  </form> 
<? 
} 
else  if (isset($_GET['subpage']) && $_GET['subpage'] == 'upload') {   
srand(time());
$r = (rand() % 999999999);
if ($_POST['image_url'] == "") {
$url = $tdir . "img" . $r . $_FILES['imagefile']['name'];
	if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] ==				"image/pjpeg") { 
							$file_ext = strrchr($_FILES['imagefile']['name'], '.');   
							$simg = imagecreatefromjpeg($_FILES['imagefile']['tmp_name']);   // Make A New Temporary Image To Create The Thumbanil From 
							$currwidth = imagesx($simg);   // Current Image Width 
							$currheight = imagesy($simg);   // Current Image Height 
      if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
         $zoom = $twidth / $currheight;   // Length Ratio For Width 
         $newheight = $theight;   // Height Is Equal To Max Height 
         $newwidth = $currwidth * $zoom;   // Creates The New Width 
      } else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
        $zoom = $twidth / $currwidth;   // Length Ratio For Height 
        $newwidth = $twidth;   // Width Is Equal To Max Width 
        $newheight = $currheight * $zoom;   // Creates The New Height 
      } 
      $dimg = imagecreate($newwidth, $newheight);   // Make New Image For Thumbnail 
      imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It) 
      imagejpeg($dimg, $url);   // Saving The Image 
      imagedestroy($simg);   // Destroying The Temporary Image 
      imagedestroy($dimg);   // Destroying The Other Temporary Image 
} else { 
    print '<font color="#FF0000">ERROR: Wrong filetype (has to be a .jpg or .gif.';   // Error Message If Filetype Is Wrong 
        print '.</font>'; 
  } 
}
else {$url = $_POST['image_url'];}
print ("
<HTML>
<HEAD>
<meta http-equiv=Expires content=0>
<script language=JavaScript>
<!--
function refreshParent() {
window.opener.document.images.upload.src=\"$url\";
window.opener.document.listing.image.value = \"$url\";
if (window.opener.progressWindow)
{
window.opener.progressWindow.close();
}
window.close();
}
//-->
</script> 
<TITLE>Refreshing...</TITLE>
</HEAD>
<BODY onload=\"refreshParent();\">
</BODY>
</HTML>
");
} 
?> 

