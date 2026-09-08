<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?php 
$idir = "../image_upload/";   // Path To Images Directory 
$tdir = "..../image_upload/thumbs/";   // Path To Thumbnails Directory 
$pwidth="800";
$pheight="800";
$twidth = "125";   // Maximum Width For Thumbnail Images 
$theight = "100";   // Maximum Height For Thumbnail Images 

if (!isset($_GET['subpage'])) {   // Image Upload Form Below   ?>
<? } else  if (isset($_GET['subpage']) && $_GET['subpage'] == 'upload') {   // Uploading/Resizing Script 
  $url = $_FILES['imagefile']['name'];   // Set $url To Equal The Filename For Later Use 
  if ($_FILES['imagefile']['type'] == "image/jpg" || $_FILES['imagefile']['type'] == "image/jpeg" || $_FILES['imagefile']['type'] == "image/pjpeg") { 
    $file_ext = strrchr($_FILES['imagefile']['name'], '.');   // Get The File Extention In The Format Of , For Instance, .jpg, .gif or .php 
    $copy = copy($_FILES['imagefile']['tmp_name'], "$idir" . $_FILES['imagefile']['name']);   // Move Image From Temporary Location To Permanent Location 
    if ($copy) {   // If The Script Was Able To Copy The Image To It's Permanent Location 
      print 'Image uploaded successfully.<br />';   // Was Able To Successfully Upload Image 
      $simg = imagecreatefromjpeg("$idir" . $url);   // Make A New Temporary Image To Create The Thumbanil From 
      $currwidth = imagesx($simg);   // Current Image Width 
      $currheight = imagesy($simg);   // Current Image Height 
      if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
         $zoom = $twidth / $currheight;   // Length Ratio For Width 
         $newtheight = $theight;   // Height Is Equal To Max Height 
         $newtwidth = $currwidth * $zoom;   // Creates The New Width 
      } else {    // Otherwise, Assume Width Is Greater Than Height (Will Produce Same Result If Width Is Equal To Height) 
        $zoom = $twidth / $currwidth;   // Length Ratio For Height 
        $newtwidth = $twidth;   // Width Is Equal To Max Width 
        $newtheight = $currheight * $zoom;   // Creates The New Height 
      }
	  
	  if ($currheight > $currwidth) {   // If Height Is Greater Than Width 
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
      imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newtwidth, $newtheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It) 
      imagejpeg($dimg, "$tdir" . $url);   // Saving The Image 
	  $dimg = imagecreate($newpwidth, $newpheight);   // Make New Image For Thumbnail 
      imagetruecolortopalette($simg, false, 256);   // Create New Color Pallete 
      $palsize = ImageColorsTotal($simg); 
      for ($i = 0; $i < $palsize; $i++) {   // Counting Colors In The Image 
       $colors = ImageColorsForIndex($simg, $i);   // Number Of Colors Used 
       ImageColorAllocate($dimg, $colors['red'], $colors['green'], $colors['blue']);   // Tell The Server What Colors This Image Will Use 
      } 
      imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newpwidth, $newpheight, $currwidth, $currheight);   // Copy Resized Image To The New Image (So We Can Save It) 
      imagejpeg($dimg, "$idir" . $url);   // Saving The Image 
      imagedestroy($simg);   // Destroying The Temporary Image 
      imagedestroy($dimg);   // Destroying The Other Temporary Image 
      print 'Image thumbnail created successfully.';   // Resize successful 
    } else { 
      print '<font color="#FF0000">ERROR: Unable to upload image.</font>';   // Error Message If Upload Failed 
    } 
  } else { 
    print '<font color="#FF0000">ERROR: Wrong filetype (has to be a .jpg or .jpeg. Yours is ';   // Error Message If Filetype Is Wrong 
    print $file_ext;   // Show The Invalid File's Extention 
    print '.</font>'; 
  } 
} ?>



</body>
</html>
