<?php
require '../includes/auth_check.inc.php';
//CHECK LOGIN - PUT THIS CODE ON ALL PROTECTED PAGES
session_start();
$failed = 0;
$session_temp_var=$_SESSION['sessionID'];
$session_username = $_SESSION['user_name'];
include '../includes/dbconnect.inc.php';
if ($session_temp_var <> "") {
$Link = mysql_connect ($Host, $User, $Password);
$Query = "SELECT username FROM auth_user WHERE (sesnID='$session_temp_var');";
#print $username[0];
$Result = mysql_db_query ($DBName, $Query, $Link);
$Row = mysql_fetch_array ($Result);
$username = $Row[0];
//Session doesn't exist
if ($is_logged_in)
{
#print_edit_add();
#print "logged in ";

}
if (!$is_logged_in)
{
$logged_on = "no";
//No Session Variable
$failed = 1;
}
}
if ($logged_on == "no")
{
$target_url_in = '/pages/edit_classified_ad.php';
$_SESSION['target_url'] = "$target_url_in";
$target_url_goto= $_SESSION['target_url'];
echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/login.php"</script>';

}
##########################################################################################################################################
####################################  Done Login Test    #################################################################################
##########################################################################################################################################
$id_temp_var = $_REQUEST['edit_row'];
mysql_connect("$Host","$User","$Password");
mysql_select_db("$DBName") or die(mysql_error());
// Performing SQL query
$query = "SELECT * FROM for_sale_wanted  where (item_row_id ='$id_temp_var')";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$Row = mysql_fetch_array($result);
$user_tab = $Row[3];
#$model_tab = $Row[6];



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
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
<script type="text/javascript" src="javascript/checkbox.js"></script> 
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
     <div align="center"><h1><b>Edit Your Classified Ad</b></h1> </div>
   </form>
   <form method="POST" ><div align="center">
     <table width="384" border="0">
        <caption>&nbsp;
        </caption>
	
		   <tr>
          <td class="wh_tnr_12"><div align="left">Title:</div></td>
          <td><div align="left">
            <input type="text" name="title_fd" value="<?PHP echo $Row[19]; ?>">
          </div></td>
          <td>&nbsp;</td>      
		   <tr>
          <td class="wh_tnr_12"><div align="left">Your Name:</div></td>
          <td><div align="left">
            <input type="text" name="your_name_fd" value="<?PHP echo $Row[1]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Your email (hidden):</div></td>
          <td><div align="left">
            <input type="text" name="contact_email_fd" value="<?PHP echo $Row[2]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td class="wh_tnr_12"><div align="left">Phone (hidden):</div></td>
          <td><div align="left">
            <input type="text" name="phone_fd" value="<?PHP echo $Row[4]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		
		
          <tr>
          <td width="210" class="wh_tnr_12"><div align="left">For Sale or Wanted:</div></td>
           <td >
          <select name="for_sale_wanted_fd" value ="<?PHP echo $Row[0]; ?>" size="1">
         <option value="For Sale">For Sale</option>
         <option value="Wanted">Wanted</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		
		<tr>
          <td width="210" class="wh_tnr_12"><div align="left">Condition:</div></td>
           <td >
          <select name="item_condition_fd" value ="<?PHP echo $Row[12]; ?>"  >
         <option value="Poor">Poor</option>
         <option value="Good">Good</option>
		 <option value="Excellent">Excellent</option>
          </select></font></td>
            <br>
          </div></td>
          <td width="12">&nbsp;</td>
        </tr>
		
		
        <tr>
          <td class="wh_tnr_12"><div align="left">Manufacturer:</div></td>
          <td><div align="left">
            <input type="text" name="manufacturer_fd" value="<?PHP echo $Row[5]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="wh_tnr_12"><div align="left">Model:</div></td>
          <td><div align="left">
            <input type="text" name="model_fd" value="<?PHP echo $Row[6]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		       <tr>
          <td class="wh_tnr_12"><div align="left">Year:</div></td>
          <td><div align="left">
            <input type="text" name="year_fd" value="<?PHP echo $Row[18]; ?>">
          </div></td>
          <td>&nbsp;</td>
        </tr>
		 <tr>
          <td class="wh_tnr_12"><div align="left">Description:</div></td>
		  <TD><textarea  name="description_fd" rows="10" cols="40"><? echo $Row[7];?></TEXTAREA></TD>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="wh_tnr_12"><div align="left">Price:</div></td>
          <td><input type="text" name="price_fd" value="<?PHP echo $Row[8]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
           <td class="wh_tnr_12"><div align="left">State:</div></td>
          <td><input type="text" name="state_fd" value="<?PHP echo $Row[10]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
         
         <tr>
           <td class="wh_tnr_12"><div align="left">Country:</div></td>
          <td><input type="text" name="country_fd" value="<?PHP echo $Row[11]; ?>"></td>
          <td>&nbsp;</td>
        </tr>  
		<tr>
          <td class="wh_tnr_12"><div align="left">This is a Part or Parts Bike:</div></td>
		  
          <td>
		  <input type="checkbox" name="parts_bike_fd[]"  <?PHP if ($Row[16] == "YES" )
		  { echo ' value="YES';
		    
			 echo '" CHECKED'; }
		 else
		 { echo 'value="NO"'; }
		  
		  ?>></td>
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
        $your_name=$_REQUEST['your_name_fd'];
		$contact_email=$_REQUEST['contact_email_fd'];
		$item_condition=$_REQUEST['item_condition_fd'];
		$for_sale_wanted=$_REQUEST['for_sale_wanted_fd'];
		$phone=$_REQUEST['phone_fd'];
		$manufacturer=$_REQUEST['manufacturer_fd'];
		$model=$_REQUEST['model_fd'];
		$year=$_REQUEST['year_fd'];
		$description=$_REQUEST['description_fd'];
		$price=$_REQUEST['price_fd'];
		$state=$_REQUEST['state_fd'];
		$country=$_REQUEST['country_fd'];
		$date_entered = date("Y-m-d h:i:s");
		$title = $_REQUEST['title_fd'];
		#$parts_bike = $_REQUEST['parts_bike_fd'];
		
$session_username = $session_username;		
		if(isset($_POST['parts_bike_fd']))
		 {
		  $parts_bike = "YES";
		  }
		  else
		  {
		  $parts_bike= "NO";
		  }
		
		
	     $Query2 = "UPDATE for_sale_wanted SET item_condition = '$item_condition',phone = '$phone', title = '$title',user_name = '$your_name', contact_email = '$contact_email', for_sale_wanted = '$for_sale_wanted', manufacturer = '$manufacturer', model = '$model', year = '$year',username = '$session_username',date_entered = '$date_entered',description = '$description',price = '$price',parts_bike = '$parts_bike',";
		  $Query2.= "state = '$state', country = '$country' WHERE item_row_id = '$id_temp_var'";
		 	  
		  
		$result=mysql_query($Query2) or die ( 'Update Query Failed $Query2'. mysql_error());	
		
		if  ($result) 
			{
		    	mysql_close ($Link);
				echo '<script language="JavaScript" type="text/javascript">
				window.location.href="http://www.cyclerestorer.com/pages/classified_ads.php" </script>';
			
			}
		  else 
		 {
		  echo "<b>ERROR: unable to update.</b>"; 
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
		
	     $Query2 = "Delete from for_sale_wanted where item_row_id = '$id_temp_var'";
		 	  
		  
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
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
   <title>Edit Classified Ad Page </title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><body>
   <p class="wh_tnr_12">&nbsp;</p>
   <div align="center">
<!--  <table width="33%" height="65">
    <tr>
      <th width="35%" scope="col">&nbsp;</th>
      <th width="32%" scope="col">&nbsp;</th>
      <th width="33%" scope="col">&nbsp;</th>
    </tr>

   
  </table> -->
</div>
<p>
<?php 
include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>
</body>
</html>

