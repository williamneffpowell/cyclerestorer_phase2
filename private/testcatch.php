<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
$Fname = $_POST["Fname"];
$Lname = $_POST["Lname"];
$gender = $_POST["gender"];
$food = $_POST["food"];
$quote = $_POST["quote"];
$education = $_POST["education"];
$TofD = $_POST["TofD"];
if (!isset($_POST['submit'])) { // if page is not submitted to itself echo the form
?>
<html>
<head>
<title>Personal INFO</title>
</head>
<body>
<form method="post" action="<?php echo $PHP_SELF;?>">
First Name:<input type="text" size="12" maxlength="12" name="Fname"><br />
Last Name:<input type="text" size="12" maxlength="36" name="Lname"><br />

<br />
:<br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4:<input type="checkbox" value="3" name="food[]"><br />
<br />
 2 :<input type="checkbox" value="2" name="food[]"><br />
<br />
 4:<input type="checkbox" value="4" name="food[]"><br />
<br />
 3:<input type="checkbox" value="3" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 4 :<input type="checkbox" value="4" name="food[]"><br />
<br />
 3 :<input type="checkbox" value="3" name="food[]"><br />
<br />
 4:<input type="checkbox" value="4" name="food[]"><br />
<br />
 4:<input type="checkbox" value="4" name="food[]"><br />
<br />
4  :<input type="checkbox" value="4" name="food[]"><br />
<br />
  3 :<input type="checkbox" value="3" name="food[]"><br />
<br />
 4 : <input type="checkbox" value="4" name="food[]"><br />
<br />
 3: <input type="checkbox" value="4" name="food[]"><br />





<input type="submit" value="submit" name="submit">
</form>
<?
} else {
echo "Hello, ".$Fname." ".$Lname.".<br />";

foreach ($food as $f) {
$G=$f + $G;
#echo $f."<br />";
}
echo "Total time  = $G\n";
echo "<br>";
}

?> 

</body>
</html>
