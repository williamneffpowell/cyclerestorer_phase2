<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../add_classified_ads.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
session_start();
include '../includes/dbconnect.inc.php';
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
$session_username = $user->data['username'];
$failed = 0;

if ($user->data['is_registered'])
{
$logged_in = "yes";
$login_var = "";
print_html_add();

}
if (!$user->data['is_registered'])
{
$target_url_in = '/pages/add_classified_ads.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];

$login_var = '<form method="POST" action="http://www.cyclerestorer.com/pages/login.php"><div align="center">
<div align="center"><span class="style1"><b></b></span>
       <table width="261" border="0" class="index">
        <caption>&nbsp;
        </caption>
       </table>
       <br>
       <input type="submit" name="submit" value="Login to Edit your bike or send a Message">
       <br>
     </div></Form>';

$failed = 1;
}
//No Session Variable


	  # if(!mysql_db_query($dbname,$query,$link_id)) die(mysql_error());
		# echo "success in database entry.";	
//END CHECK LOGIN ##################################################################################################
#print "usernameagain $username\n";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Add Classified Ads </title>
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

function validate_form(adform)
{
with (adform)
{
if (validate_required(your_name_fd,"The 'Your Name' field must be filled out!")==false)
  {your_name_fd.focus();return false}
if (validate_required(email_fd,"Email must be filled out!")==false)
  {email_fd.focus();return false}
if (validate_required(description_fd,"The Description field must be filled out!")==false)
  {description_fd.focus();return false}
if (validate_required(country_fd,"The 'Country' field must be filled out!")==false)
  {country_fd.focus();return false}  
}
}
</script>
<script language="javascript" type="text/javascript" src="javascript/tiny_mce/tiny_mce_gzip.js"></script>

<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,'+ 
        'searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras',
	themes : 'simple,advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>


<script language="javascript" type="text/javascript">
	tinyMCE.init ({
		mode : "textareas",
		theme : "advanced",
		plugins : "emotions,preview,zoom,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_disable : "image,cleanup,removeformat,formatselect,styleselect,sub,sup,separator,outdent,indent,help,anchor,code,hr,visualaid,charmap",
		theme_advanced_buttons1_add : "fontselect",
		theme_advanced_buttons2_add : "preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "emotions,cut,copy,paste,separator,search,separator",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "example_word.css",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false,	
		theme_advanced_statusbar_location : "none"
	
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-color: #CC0033;
}
-->
</style>
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1 align='center'>Add Classified Ads</h1>
<br>
<h3 align='center'>* = Required </h3>






<?


function print_html_add() {
print '
<form name=adform method="POST" onsubmit="return validate_form(this)">
     <div align="center"><h1><b>Classified Ads</h1></b> </div>
  <div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
		<tr>
          <td width="210"><div align="center"><strong>* Title:</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="title_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		
		<tr>
          <td width="210"><div align="center"><strong>phone: (Hidden)</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="phone_fd">
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
          <tr>
          <td width="210"><div align="center"><strong>For Sale or Wanted:</strong></div></td>
           <td >
          <select name="for_Sale_wanted_fd" >
         <option value="For Sale">For Sale</option>
         <option value="Wanted">Wanted</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		<tr>
          <td width="210"><div align="center"><strong>Condition:</strong></div></td>
           <td >
          <select name="condition_fd" >
         <option value="Poor">Poor</option>
         <option value="Good">Good</option>
		 <option value="Excellent">Excellent</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>

        <tr>
          <td width="210"><div align="center"><strong>Manufacturer</strong></div></td>
          <td width="148"><div align="center">
            <input type="text" name="manufacturer_fd">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>Model</strong></div></td>
          <td><input type="text" name="model_fd"></td>
          <td>&nbsp;</td>
        </tr> 
		      <tr>
          <td><div align="center"><strong>* Description</strong></div></td>
        
		  <td align="center" width="50" height="5"><textarea name="description_fd" cols="40" rows="10"></textarea> </td>
         
          <td>&nbsp;</td>
        </tr>
		        <tr>
          <td width="210"><div align="center"><strong>Price</div></td>
          <td width="148"><div align="center">
            <input type="text" name="price_fd">
          </div></td>
          <td>&nbsp;</td>
        </tr>         
         <tr>
          <td><div align="center"><strong>State</strong></div></td>
          <td><input type="text" name="state_fd"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
          <td><div align="center"><strong>* Country</strong></div></td>
          <td><input type="text" name="country_fd"></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
          <td><div align="center"><strong>IS THIS A PARTS BIKE?</strong></div></td>
          <td><input type="checkbox" name="parts_bike" value="YES" /></td>
          <td>&nbsp;</td>
        </tr>      
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	    <input type="reset" name="Clear" value="Clear Form and Start Over">
       <br>
       <br>
       <table width="200">
         <tr>
           </tr>
       </table>
       <br>
       </textarea>
       <br>
     </div>
</form> 
	</body>
</html>
'; 
}
$session_username = $user->data['username'];
$today = date("Y-m-d h:i:s");
 if ($_REQUEST['submit']) { 
 		$title=$_REQUEST['title_fd'];
        $for_sale_wanted=$_REQUEST['for_Sale_wanted_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$description=$_REQUEST['description_fd'];
		$price=$_REQUEST['price_fd'];
		$state=$_REQUEST['state_fd'];
		$country=$_REQUEST['country_fd'];
		$item_condition=$_REQUEST['condition_fd'];
		$phone=$_REQUEST['phone_fd'];

		$email=$_REQUEST['email_fd'];
		$parts_bike=$_REQUEST['parts_bike'];
$user_temp = $user->data['username'];
$user_id_temp = $user->data['user_id'];
		
mysql_connect("$Host","$User","$Password");
mysql_select_db($DBName) or die(mysql_error());  
$Link = mysql_connect ($Host, $User, $Password);		 
		 
$query ="INSERT INTO for_sale_wanted(title,phone,user_name,for_sale_wanted,date_entered,manufacturer,model,description,price,state,country,item_condition,parts_bike,username,userid)
 VALUES ('$title','$phone','$user_temp','$for_sale_wanted','$today','$manufacturer','$model','$description','$price','$state','$country','$item_condition','$parts_bike','$session_username','$user_id_temp')"; 
			#print "user_var = $user_var\n";  
		#print " Query $query \n";
		$result=mysql_query($query) or die ('Insert Query Failed' . mysql_error());
			
		if    ($result) 
		{ 
		echo "Successfully Entered" ;
	
		  }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link);
		  }
		  
		  if ($parts_bike)
		  {
		  #shouldn't you pass the number of the bike that has the parts? 
		  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/classified_ads.php"</script>';
		  }
		  
	 } 
		
		
?>



<?php 
include 'bottom_index_table.php';
?>
</body>

</html>