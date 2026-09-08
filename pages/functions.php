<?php



function br2nl($str) {
  $str = preg_replace("/(\r\n|\n|\r)/", "", $str);
  return preg_replace("=<br */?>=i", "\n", $str);
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




print ("
<HTML>
<HEAD>
<meta http-equiv=\"description\" content=\"A site for Motorcycle Restoration.\">
<!-- <meta http-equiv=\"keywords\" content=\"promote your video, get more views, promote video\"> -->
<TITLE>Cyclerestorer.com - Information about Motorcycle Restoration</TITLE>
<LINK HREF=\"../css/cyclerestorer.css\" TYPE=\"text/css\" REL=\"stylesheet\">
</HEAD>
<BODY BGCOLOR=#C7C7C7 >

<TABLE ALIGN=CENTER WIDTH=756 CELLPADDING=0 CELLSPACING=0 BGCOLOR=ffffff>


<!--START PAGE HEADER-->
<TR><TD>

<TABLE WIDTH=100%>
<TR>
<TD width=288 align=center>
<A HREF=http://www.cyclerestorer/index.php>
<!-- <IMG SRC=images/view4view.jpg alt=\"View4View.com Logo\" border=0> -->
</A>
</TD>
<TD width=468 align=right>
");

#echo show_ad(1);  

print ("
</TD></TR>
</FORM>
</TABLE>
</TD></TR>
<!--END PAGE HEADER-->


<!--START PAGE MENU-->
<TR><TD>

<TABLE WIDTH=100% bgcolor=79888E>
<TR>
<TD width=650>
$home
$mem&nbsp; <FONT COLOR=ffffff>|</FONT> &nbsp;
<!-- <A HREF=\"watchvideo.php\" class=\"menu\">Watch Videos</A>&nbsp; <FONT COLOR=ffffff>|</FONT> &nbsp; -->
<!-- <A HREF=\"search.php\" class=\"menu\">Browse Categories</A>&nbsp; <FONT COLOR=ffffff>|</FONT> &nbsp; -->
<!-- <A HREF=\"about.php\" class=\"menu\">About</A>&nbsp; <FONT COLOR=ffffff>|</FONT> &nbsp; -->
<!-- <A HREF=\"faq.php\" class=\"menu\">FAQ</A>&nbsp; <FONT COLOR=ffffff>|</FONT> &nbsp; -->


$login &nbsp;

</TD>
<TD align=right>
");

print ("
$remcred
</TD>
</TR>
</TABLE>


</TD></TR>
<!--END PAGE MENU-->
<TR><TD>
");





function print_footer($username) {

$page = $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'];
$refer = $_SESSION['refer'];

if ($username != "Guest") {
#$mem = "<A HREF=myaccount.php class=menu>My Account</A>";
$login = "<A HREF=logout.php class=menu>Logout</A>";
}
else {
$mem = "<A HREF=signup.php class=menu>Signup</A>";
$login = "<A HREF=login.php class=menu>Login</A>";
}

print ("

</TD></TR>

<TR><TD>
<!--START PAGE FOOTER-->
<TR><TD>
<TABLE ALIGN=CENTER WIDTH=100% HEIGHT=19 BGCOLOR=79888E>
<TR>
<TD>

<A HREF=../index.php class=menu>Home</A>&nbsp; &nbsp; &nbsp;
$mem&nbsp; &nbsp; &nbsp;


<A HREF=terms.php class=menu>Terms</A>&nbsp; &nbsp; &nbsp;
<A HREF=privacy_policy.html class=menu>Privacy</A>&nbsp; &nbsp; &nbsp;
$login&nbsp; &nbsp; &nbsp;


</TD>
</TR>
</TABLE>



</TD></TR>
<!--END PAGE FOOTER-->

<script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\">
</script>
<script type=\"text/javascript\">
_uacct = \"UA-3030942-2\";
urchinTracker();
</script>

</TABLE>
<p align=center class=\"copyright\">Copyright &copy; cyclerestorer.com. All rights reserved.</p>
<BR>
</BODY>
</HTML>
");
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';


}






function upload_image($FILE, $imagetarget, $thumbtarget, $imagedir, $thumbdir) {

$tempdir = "tempdir";

$filename = createRandomPassword() . createRandomPassword();


// CHECK FILE TYPE AND SET NEW FILE NAME

if ($FILE['type'] =="image/pjpeg" || $FILE['type'] =="image/jpeg") {
$filename = $filename . ".jpg";
}
elseif ($FILE['type']=="image/gif") {
$filename = $filename . ".gif";
}
else {
return "Error";
exit;
}
// END CHECK FILE TYPE AND SET NEW FILE NAME
// GET IMAGE SIZE

list($w, $h) = getimagesize($FILE['tmp_name']);

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

error_reporting(E_ALL);
ini_set("display_errors", 1);


$origfile = "$tempdir/" . $filename;

if(move_uploaded_file ($FILE['tmp_name'], $origfile)){
chmod("$origfile",0777);
}
else {
return "Error";
}



//THUMBNAILS

/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
if ($FILE['type']=="image/gif")
{
$im=ImageCreateFromGIF($origfile);
$newimage=imagecreatetruecolor($thumbwidth,$thumbheight);
imageCopyResized($newimage,$im,0,0,0,0,$thumbwidth,$thumbheight,$w,$h);
if (function_exists("imagegif")) {
// Header("Content-type: image/gif");
ImageGIF($newimage,"$thumbdir/$filename");
}
elseif (function_exists("imagejpeg")) {
// Header("Content-type: image/jpeg");
ImageJPEG($newimage,"$thumbdir/$filename");
}
//chmod("$thumbdir",0777);
}////////// end of gif file thumb nail creation//////////



////////////// starting of JPG thumb nail creation//////////
if($FILE['type']=="image/jpg" || $FILE['type'] =="image/jpeg"){
$im=ImageCreateFromJPEG($origfile); 
$newimage=imagecreatetruecolor($thumbwidth,$thumbheight);                 
imageCopyResized($newimage,$im,0,0,0,0,$thumbwidth,$thumbheight,$w,$h);
ImageJpeg($newimage,"$thumbdir/$filename");
//chmod("$tsrc",0777);
}
////////////////  End of JPG thumb nail creation //////////

//REGULAR IMAGES

/////////////////////////////////////////////// Starting of GIF  creation///////////
if ($FILE['type']=="image/gif")
{
$im=ImageCreateFromGIF($origfile);
$newimage=imagecreatetruecolor($imagewidth,$imageheight);
imageCopyResized($newimage,$im,0,0,0,0,$imagewidth,$imageheight,$w,$h);
if (function_exists("imagegif")) {
// Header("Content-type: image/gif");
ImageGIF($newimage,"$imagedir/$filename");
}
elseif (function_exists("imagejpeg")) {
// Header("Content-type: image/jpeg");
ImageJPEG($newimage,"$imagedir/$filename");
}
}////////// end of gif file thumb nail creation//////////



////////////// starting of JPG  nail creation//////////
if($FILE['type']=="image/pjpeg" || $FILE['type'] =="image/jpeg"){
$im=ImageCreateFromJPEG($origfile); 
$newimage=imagecreatetruecolor($imagewidth,$imageheight);                 
imageCopyResized($newimage,$im,0,0,0,0,$imagewidth,$imageheight,$w,$h);
ImageJpeg($newimage,"$imagedir/$filename");
}
////////////////  End of JPG thumb nail creation //////////

return "$filename";
}
function show_ad($type) {

if ($type == 1) {
print ("

<script type=\"text/javascript\">
google_ad_client = \"pub-5047590468181460\";
google_ad_slot = \"0527510916\";
google_ad_width = 468;
google_ad_height = 60;
</script>
<script type=\"text/javascript\"
src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>
");
}

else if ($type == 2) {
print ("


<script type=\"text/javascript\">
google_ad_client = \"pub-5047590468181460\";
google_ad_slot = \"8948794150\";
google_ad_width = 160;
google_ad_height = 600;
</script>
<script type=\"text/javascript\"
src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>





");

}

else if ($type == 3) {
print ("

<script type=\"text/javascript\"><!--
google_ad_client = \"pub-5047590468181460\";
google_ad_slot = \"9480025115\";
google_ad_width = 250;
google_ad_height = 250;
//--></script>
<script type=\"text/javascript\"
src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>




");
}

}

function resize_video($embedcode, $newwidth) {

$w1= strpos($embedcode, "width=");
if ($w1 > 0) {
$width = substr ($embedcode, $w1+7, 3);
}
else  {
//try revver
$w1= strpos($embedcode, "width:");
$width = substr ($embedcode, $w1+6, 3);
}


$h1= strpos($embedcode, "height=");
if ($h1 > 0) {
$height = substr ($embedcode, $h1+8, 3);
}
else {
$h1= strpos($embedcode, "height:");
$height = substr ($embedcode, $h1+7, 3);
}

if (intval($width) > 100 && intval($height) > 100) {
$newheight = round($height * ($newwidth / $width));

$embedcode = str_replace("$height", "$newheight", $embedcode);
$embedcode = str_replace("$width", "$newwidth", $embedcode);
$embedcode = str_replace("autoplay=1", "autoplay=0", $embedcode);
$embedcode = str_replace("flashvars:autoStart=true;", "", $embedcode);

return $embedcode;
}
else {return -1;}

}

?>