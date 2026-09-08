
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form name="form1" method="post" action="" enctype="multipart/form-data"> 
<input type="file" name="imagefile"> 
<br> 
<input type="submit" name="Submit" value="Submit"> 

<?php

if(isset( $Submit )) 
{ 
//If the Submitbutton was pressed do: 
print "ISSET WORKED \n";
if ($_FILES['imagefile']['type'] == "image/jpg"){ 

    copy ($_FILES['imagefile']['tmp_name'], "files/".$_FILES['imagefile']['name']) or die ("Could not copy");  

        echo "";  
        echo "Name: ".$_FILES['imagefile']['name']."";  
        echo "Size: ".$_FILES['imagefile']['size']."";  
        echo "Type: ".$_FILES['imagefile']['type']."";  
        echo "Copy Done....";  
        } 

        else { 
            echo "<br><br>"; 
            echo "Could Not Copy, Wrong Filetype (".$_FILES['imagefile']['name'].")<br>"; 
        } 
}

else
{
print "that did not work \n";
}

?>   
</form>
