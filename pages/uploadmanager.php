<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<form action="uploadmanager.php" enctype=multipart/form-data" method="post">
Last Name:<br /> <input type="text" name="tmp_name" value="" /><br />
Class Notes:<br /> <input type="file" name="classnotes" value="" /><br />
<p><input type="submit" name="submit" value="Submit Notes" /></p>
</form>

<?php
/*set a few constants */
define ("FILEREPOSITORY","./");
$repository_var = FILEREPOSITORY."$repository_var" ;
print "Repository_var $repository_var \n";
/* Make sure that the file was POSTed. */
if (is_uploaded_file($_FILES['classnotes']['tmp_name'])) 
{
/* Was the file a gif? */
Print "IN THE IF \n";
	if ($_FILES['classnotes']['type'] != "application/gif") {
	 echo "<p>Class notes must be uploaded in GIF format.</p>";
	 } else {
	 /* move uploade file to final destination */
	 	$name = $_POST['name'];
		$result = move_uploaded_file($_FILES['classnotes']['tmp_name'],
		FILEREPOSITORY."/$name.gif");
		
		if ($result==1) echo "<p>File successfully uploaded.</p>";
			else echo "<p>There was a problem uploading the file.</p>";
			
	} #endIF	
	
	
}  #endIF
			
print "AT THE BOTTOM \n";




?>
</body>
</html>
