<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress ='../edit_cycle_shows.php';
   //including phpBB3 stuff   
   include('../phpBB3/common.php');
   include('../phpBB3/includes/functions_display.php');

// Start phpbb3 session management
   $user->session_begin();
   $auth->acl($user->data);
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;

#$session_username = $_SESSION['user_name'];

include '../includes/dbconnect.inc.php';

$Link = mysql_connect ($Host, $User, $Password);



//Session doesn't exist
if ($user->data['is_registered'])
{
#print_edit_add();
#print "logged in ";

}
if (!$user->data['is_registered'])
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}

if ($logged_on == "no")
{
$target_url_in = '/pages/edit_cycle_shows.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$edit_row = $_REQUEST['edit_row'];
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT * FROM cycle_shows  where (showID ='$edit_row')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
#$user_tab = $Row[3];
#$model_tab = $Row[6];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Edit Cycle Show </title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><body>
   <p class="wh_tnr_12">&nbsp;</p>
   <div align="center">

<script language="javascript" type="text/javascript" src="datetimepicker.js">

//Date Time Picker script- by TengYong Ng of http://www.rainforestnet.com
//Script featured on JavaScript Kit (http://www.javascriptkit.com)
//For this script, visit http://www.javascriptkit.com 

</script>
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

function validate_form(editform)
{
with (editform)
{
if (validate_required(manufacturer,"The 'Manufacturer' field must be filled out!")==false)
  {manufacturer.focus();return false}
if (validate_required(model,"Email must be filled out!")==false)
  {model.focus();return false}
if (validate_required(year,"The 'Year' field must be filled out!")==false)
  {year.focus();return false}
if (validate_required(message,"The 'Started By' field must be filled out!")==false)
  {message.focus();return false}  
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
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
<form name=editform onSubmit="return validate_form(this)" method="POST" >
<br>
<br>
     <div align="center"><h1><b>Edit Cycle Show</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
	
		         
		   <tr>
          <td class="wh_tnr_12"><div align="left">Show Name:</div></td>
          <td><div align="left">
            <input type="text" name="show_name_fd" value="<?PHP echo $Row[0]; ?>">
			 <input type="hidden" name="showID" value= "<?php echo $edit_row;?> ">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Show Address</div></td>
          <td><div align="left">
            <input type="text" name="show_address_fd" value="<?PHP echo $Row[2]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Show City:</div></td>
          <td><div align="left">
            <input type="text" name="show_city_fd" value="<?PHP echo $Row[3]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Show State:</div></td>
          <td><div align="left">
            <input type="text" name="show_state_fd" value="<?PHP echo $Row[4]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		
		
          <tr>
          <td width="210" class="wh_tnr_12"><div align="left">Show Zipcode</div></td>
           <td >
          <input type="text" name="show_zipcode_fd" value ="<?PHP echo $Row[5]; ?>">
        </td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		
		<tr>
          <td width="210" class="wh_tnr_12"><div align="center">Comment:</div></td>
         <td align="center" width="50" height="5"><textarea  name="comment_fd" rows="10" cols="40"><?PHP echo $Row[6]; ?></textarea >
         </td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		
		
        <tr>
          <td class="wh_tnr_12"><div align="center">Start Date:<a href="javascript:NewCal(\'demo1\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick a Start date"></a></div></td>
          <td><div align="left">
            <input id="demo1" type="text" name="start_date_fd" value="<?PHP echo $Row[7]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
		
          <td class="wh_tnr_12"><div align="center">End Date:<a href="javascript:NewCal(\'demo1\',\'YYYYMMDD\')"><img src="../Images/cal.gif" width="16" height="16" border="0" alt="Pick a Start date"></a></div></td>
          <td><div align="left">
            <input type="text" name="end_date_fd" value="<?PHP echo $Row[8]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
          <td>&nbsp;</td>
        </tr>      
     </table>
       <br>
       <input type="submit" name="submit" value="Submit">
	   <input type="submit" name="delete" value="delete">
       <br>

 
  
       </textarea>
    
     </div>
</form> 
	</body>
</html>
 


<?PHP


 if ($_REQUEST['submit']) { 
        $show_name=$_REQUEST['show_name_fd'];
		$show_address=$_REQUEST['show_address_fd'];
		$show_city=$_REQUEST['show_city_fd'];
		$show_state=$_REQUEST['show_state_fd'];
		$show_zipcode=$_REQUEST['show_zipcode_fd'];
		$comment=$_REQUEST['comment_fd'];
		$start_date=$_REQUEST['start_date_fd'];
		$end_date=$_REQUEST['end_date_fd'];
		$show_id=$_REQUEST['showID'];
		$enter_date=date("Y-m-d h:i:s");
		
			
	 $Query = "UPDATE cycle_shows SET  show_name = '$show_name', show_address = '$show_address',show_city = '$show_city',show_zipcode = '$show_zipcode', comment = '$comment', start_date = '$start_date', end_date = '$end_date', enter_date = '$enter_date' WHERE showID = '$show_id' ";
		
		#print " Query $query \n";
		$result=mysql_query($Query) or die ('Insert Query Failed' . mysql_error());
			
		if    ($result) 
		{ 
			mysql_close ($Link);
				  echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/cycle_shows.php"</script>';
		  }
		  else 
		  {
		  echo "<b>ERROR: unable to post.</b>"; 
		  mysql_close ($Link);
		  }
	}	  
		  

 if ($_REQUEST['delete']) { 
		$for_sale_wanted=$_REQUEST['for_sale_wanted_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$description=$_REQUEST['description_fd'];
		$price=$_REQUEST['price_fd'];
		$state=$_REQUEST['state_fd'];
		$country=$_REQUEST['country_fd'];
		$show_id=$_REQUEST['showID'];
	     $Query2 = "Delete from cycle_show where showID = '$show_id'";
		 	  
		  
		$result=mysql_query($Query2) or die ('Update Query Failed $Query2');
		
		
		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/classified_ads.php" </script>';
			}
		  else 
		 {
		  echo "<b>ERROR: unable to delete.</b>"; 
	    } 
}

?>
 



</div>
<p>
<?php 
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

