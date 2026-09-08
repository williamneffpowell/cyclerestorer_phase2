<?PHP
//view_collection_info.php

require '../includes/auth_check.inc.php';
$request->enable_super_globals();
session_start();
//$sessionID = $_SESSION['sessionID'];  // Removed direct access, see below
//$session_username = $_SESSION['user_name'];
//$userID = $_SESSION['user_ID'];
include '../includes/dbconnect.inc.php';

$link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");



//$query = ("SELECT * from auth_user WHERE (sesnID='$sessionID')");

// Check if sessionID is set before using it
if (isset($_SESSION['sessionID'])) {
    $sessionID = $_SESSION['sessionID'];
    $query = "SELECT * FROM auth_user WHERE sesnID = ?";
    $stmt = $link->prepare($query);
    if ($stmt) { //check if prepare was successful
        $stmt->bind_param("s", $sessionID);  // Assuming $sessionID is a string
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) { //check if result is valid
            $Row = $result->fetch_array(MYSQLI_ASSOC);
        } else {
             error_log("Error: " . mysqli_error($link));
        }
        $stmt->close();
    } else {
        error_log("Error: " . mysqli_error($link));
    }
} else {
    $Row = null; // Or set to a default value, to avoid errors later.
    //error_log("Session ID not set"); // Log the error.  IMPORTANT
}






$stmt = $link->prepare("SELECT b.restoration_title, b.username FROM before_after AS b WHERE b.row_id = ?");
if($stmt){
$stmt->bind_param("i", $id_temp_var);
$stmt->execute();
$result = $stmt->get_result();
 if ($result) {
     $Row2 = $result->fetch_array(MYSQLI_NUM); //use a different variable name
 }
 $stmt->close();
} else {
    error_log("Error preparing statement: " . mysqli_error($link));
}






#**************************************************************************
# The row to select from the Before_after Page selection
$reg_picID = $_REQUEST['picID'] ?? '0';
$reg_rowID = $_REQUEST['edit_row'] ?? '0';
$_SESSION['reg_rowID'] = "$reg_rowID";
#******************************************************************
if ($is_logged_in) {
    $logged_in_var = "yes";
    # LOGIN OK
}
#$Query = "UPDATE auth_user SET sesnID='$sid' WHERE username='$username'";
#if ($reg_picID <> "" )
#{
#$reg_picID = "0";
#}

#####################################################################################################
###                                            End of Login Information                                                                                             ######
#####################################################################################################


$Query = "SELECT p.filename, p.caption, r.comments, r.manufacturer,r.model,r.year,r.username,r.userID,r.type_of_entry,r.serial_number,r.engine_number,b.row_id FROM tb_pictures AS p
 LEFT JOIN registry AS r ON r.row_ID=$reg_rowID
 LEFT JOIN before_after as b on r.row_id=b.registration_row_id
 WHERE '$reg_picID'=p.picID";



$Result = mysqli_query($link, $Query);
if($Result){
    $Row = mysqli_fetch_array($Result, MYSQLI_ASSOC);
} else {
  error_log("Error with query: ". mysqli_error($link));
}


if (isset($Row['filename']) && $Row['filename'] != "") {
    $mainpic = $Row['filename'];
} else {
    $mainpic = "default.jpg";
}
$caption = $Row['caption'] ?? '0';
$comments = $Row['comments'] ?? '0';
$manufacturer = $Row['manufacturer'] ?? '0';
$model = $Row['model'] ?? '0';
$year = $Row['year'] ?? '0';
$username = $Row['username'] ?? '0';
$reg_userID = $Row['userID'] ?? '0';
$type_of_entry = $Row['type_of_entry'] ?? '0';
$frame_number = $Row['serial_number'] ?? '0';
$engine_number = $Row['engine_number'] ?? '0';
$before_after_row_id = $Row['row_id'] ?? '0';
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<script>
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=800,left = 340,top = 212');");
}</script>

    <title>Collection Information</title>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
  <h1>&nbsp;</h1>
<H2 align=center>View Collection Information</H2>
<?php
If ($logged_in_var == "yes" and $userID == $reg_userID) { // Changed $userID to $reg_userID
    echo "<table>";
    echo "<tr><td>";
    echo "<a href=edit_registry.php?edit_row=$reg_rowID&picID=$reg_picID>Edit</a>";
    echo "</td></tr>";
    echo "</table>";
}

?>
<TABLE align=center width=300 bgcolor=eeeeee>
<div class="box">
  <TR><TH colspan=2 bgcolor=79888E><?echo $alias;?></TH></TR>
<tr>
<TD align="left"><strong>Owner: </strong><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?></TD>

<tr><TD><strong>Manufacturer:</strong> <?echo $manufacturer;?></TD></tr>
<TR><TD><strong>Model:</strong> <?echo $model;?></TD></TR>
<TR><TD><strong>Year:</strong> <?echo $year;?></TD></TR>
<TR><TD><strong>Frame Serial Number:</strong> <?echo $frame_number;?></TD></TR>
<TR><TD><strong>Engine Serial Number:</strong> <?echo $engine_number;?></TD></TR>
<TR><TD colspan=3><strong>Comments:</strong> <?echo $comments;?></TD></TR>
<TR><TD>
<?php
###########################################################
//$session_username = $session_username; // Removed
if (isset($_SESSION['username']) && $username == $_SESSION['username'] )
{
echo "<a href=edit_registry.php?edit_row=$reg_rowID&picID=$reg_picID>Edit Bike Registration</a>";

}
############################################################
?>
</TD></TR>
<TR><TD>
<?php
#####################################################
if ( $before_after_row_id > 0 )
{
echo "<a href=restoration_pics.php?edit_row=$before_after_row_id>Restoration Information</a>";
}
########################################################
?>
</TD></TR>



<?php



if  ($type_of_entry == "Sold")
{

 echo "\t\t<td><a align=center href=user_library.php?user_library_var=$username&type_entry_var=Sold>SOLD</a>\n";

}
?>
</TD>
<tr><TD>
<?php
echo "</div>";
echo "<TR><TD><strong>Videos:</strong> </TD></TR>";
echo "<tr><td>";


$Query2 = "SELECT v.videoID, v.title FROM tb_video AS v  WHERE v.reg_rowID = $reg_rowID"; //Changed Query name

$Result2 = mysqli_query($link, $Query2); // Changed result name
$results = 0;
echo "</td></tr>";
$videotable = "";
while ($Row2 = mysqli_fetch_array($Result2, MYSQLI_NUM)){ // Changed row name

    $videotable = $videotable . ("
    <TR bgcolor=ffffff>
    <TD><A HREF=watchvideo.php?videoID=$Row2[0]>$Row2[1]</A></TD>
    <TD align=center>$Row2[2]</TD>
    <TD align=center>
    $Row2[3]
    </TD>

    </TR>
    ");
    $results = $results + 1;

    }

    echo "$videotable";

If (isset($_SESSION['username']) && $username == $_SESSION['username'] ) //changed from phpbb user check
{
    if ($results == 0)  
    { $videotable = $videotable . ("<TR bgcolor=ffffff><TD colspan=6 align=center><BR><BR>No videos Listed. <A HREF=add_video.php>Click here to add a video</A><BR><BR>        </TD></TR>");
    #$tdis = "disabled";
    }
}


?>
</TD>
</tr>
</TABLE>
<TABLE width=600 ALIGN=CENTER>
<TR align="center">
<TD align="center">
<IMG align=center SRC="../image_upload/<?echo $mainpic;?>" alt="<?echo $caption;?>">
</TD>
</TR>
<TR>
<TD align="center">Image Caption: <?echo $caption;?></TD></TR>

</TABLE>  

<HR>
<BR>



<?PHP

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
mysqli_close($link);

?>

<p>&nbsp;</p>
</body>
</html>
