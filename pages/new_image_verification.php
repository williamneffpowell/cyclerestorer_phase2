<?PHP
Header("Content-Type: image/png");

/* initialize a session. */
session_start();
$new_string;
session_register('new_string');
$im = ImageCreate(200, 40);  
$white = ImageColorAllocate($im, 255, 255, 255);
$black = ImageColorAllocate($im, 0, 0, 0);
srand((double)microtime()*1000000); 
$string = md5(rand(0,9999)); 
$new_string = substr($string, 17, 5); 
ImageFill($im, 0, 0, $black);
ImageString($im, 4, 70, 10, $new_string, $white);
ImagePNG($im, "verify.png");
ImageDestroy($im); 
echo "<img src=\"verify.png\">";
echo "<br><br>";
echo "Type the code you see in the image in the box below. (case sensitive)";
echo " <form action=\"formhandler.php\" method=post>";
echo "<input name=\"random\" type=\"text\" value=\"\">";
echo "<input type=\"submit\">";
echo "</form>";
echo "</body>";
echo "</html>";




?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
