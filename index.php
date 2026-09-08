<?php
// index.php on cyclerestorer.com

session_start();
// include 'includes/dbconnect.inc.php';  // Removed direct database connection - not needed in index.php
// Removed the direct database connection and query for session ID.  We'll rely on session variables.

define('IN_PHPBB', true);
$phpbb_root_path = './phpBB3/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup();

// ***************************************************
$registration_var = ''; // Initialize the variable

if (isset($_SESSION['user_id'])) {
    // User is logged in
    $logged_in_username = $_SESSION['username']; //get username from session
    $registration_var = ' <table align="center">
        <tr align="center">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td> <div align="center"><a href="logout.php">Logout</a></div></td>
            <td>&nbsp;</td>
            <td align="center"> <div align="center"><a href="pages/myaccount.php">My Account</a></div></td>
        </tr>
    </table>';
    printf("User is logged in. User ID: %s, Username: %s\n", $_SESSION['user_id'], $logged_in_username);
} else {
    // User is not logged in
    $registration_var = '<table align="center">
        <tr align="center">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td> <div align="center"><a href="login.php">Login</a></div></td>
            <td>&nbsp;</td>
            <td><div align="center"><a href="registration_page.php">Registration</a></div></td>
        </tr>
    </table>';
    printf("User is not logged in.\n");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
<head>
    <meta name="verify-v1" content="6xbzK+VQ5IjySCWXF1cUK46EcH3+yHF6/NXSwkqPdAM="/>
    <title>Cyclerestorer.com</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="css" rel="stylesheet" type="text/css">
    <style type="text/css"></style>
    <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    </style>
</head>
<div align="center">
    <table width="60%" border="5" cellpadding="1" bordercolor="#9D4122" bgcolor="#CCB474">
        <tr>
            <th scope="col">
                <table width="99%" border="0" cellpadding="1" bgcolor="#044557" class='index'>
                    <tr>
                        <th align="center" valign="middle" bgcolor="#044557">
                            <div align="center"><img src="Images/cycle.jpg" width="299" height="97" align="bottom"></div>
                        </th>
                        <th height="126" align="center" valign="middle" bgcolor="#044557">
                            <h1 align="center"><span class="style7">Restorer</span></h1>
                        </th>
                    </tr>
                </table>
            </th>
        </tr>
    </table>
    </br>
</div>
<table width="65%" border="2" align="center" bordercolor="#044557" border-style="solid" class='index'>
    <tr>
        <td width="1%">
            <div align="center">
                <table width="175" height="531" class='index' border="0">
                    <tr>
                        <td>
                            <table width="100%" border="0" class='index' cellpadding="1">
                                <tr>
                                    <th scope="col"><a href="pages/links.php"><img src="Images/link_thumb.jpg"
                                                                                alt="Links" width="96" height="73"
                                                                                border="0" align="middle"></a></th>
                                </tr>
                                <tr>
                                    <td height="20">
                                        <div align="center"><a href="pages/links.php">Links</a></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><a href="pages/restoration_techniques.php">Restoration<br>Techniques</a></td>
                    </tr>
                    <tr>
                        <td>
                            <p align="center">&nbsp;</p>
                            <p align="center">&nbsp;</p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div align="center"><a href="/phpBB3/">Forum</a></div>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <div align="center"><a href="pages/serial_number_reference.php"><img
                                                            src="Images/serial_numbers.jpg" alt="Serial Number Reference" width="82"
                                                            height="55" border="0" align="absmiddle"></a></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="center"><a href="pages/serial_number_reference.php">Serial Number
                                    Reference</a></div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div align="center">
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div align="center"><a href="pages/classified_ads.php"><img
                                                            src=" classified_ad_image_upload/thumbs/rotate.php" alt="Classified Ads/Parts"
                                                            width="118" height="102" border="0" align="middle"></a></div>
                        </td>
                    </tr>
                    <td>
                        <p align="center"><a href="pages/classified_ads.php">Classified Ads/Parts</a></p>
                    </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <p align="center" class="style1"><a href="pages/advertising.php">Site Sponsors</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>

                    </tr>
                </table>
            </div>
        <td width="21%">
            <div align="center">
                <table width="100%" border="0" class='index' cellpadding="1">
                    <tr>
                        <th scope="col">A Site For The Motorcycle Restorer and Motorcycle Restoration</th>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div align="center">
                <table width="88%" border="0" class='index' cellpadding="1">
                    <tr>
                        <td width="1%">
                            <div align="center"></div>
                        </td>

                        <td width="87%">
                            <div align="center"><img src="image_upload/rotate.php" alt="before_after" width="432"
                                                        height="324"></div>
                        </td>
                        <td width="12%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center">
                                <p>&nbsp;</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <h5><?php echo $registration_var; ?>
                                <div align="center"></div>
                            </h5>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align='center'><?php //  echo "$registration_var"; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        <td width="18%">
            <div align="center">
                <p>&nbsp;</p>
                <p><a href="http://www.cyclerestorer.com/pages/library.php"><img
                                src="Images/mid_ohio/thumbs/mid_ohio097.JPG" alt="Member Collections" border="0"></a><br>
                    <a href="pages/library.php">Member Collections</a></p>
                <p>&nbsp;</p>
            </div>
            <table width="214" class='index' border="0">
                <tr>
                    <th width="208" scope="col">
                        <div align="center"></div>
                    </th>
                </tr>

                <tr>
                    <td>
                        <div align="center"><a href="pages/image_library.php"><img
                                                        src="image_library_upload/thumbs/rotate.php" alt="Image Library" width="90"
                                                        height="63" border="0" align="absbottom"></a></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div align="center">
                            <p><a href="pages/image_library.php">Image Library</a></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>

            </table>
            <table width="100%" height="352" border="0" class='index' cellpadding="1">
                <tr>
                    <th><a href="pages/before_after.php">Restoration Projects </a></th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th height="242">
                        <div align="center">
                            <table width=210 height=201 border=0 cellpadding=0 class='index' cellspacing=0
                                    background="Images/cl77speedo.jpg">
                                <tr>
                                    <td width=6 height=31><br></td>
                                    <td width=6 height=31><br></td>
                                    <td width=48>&nbsp;</td>
                                    <td width=99>&nbsp;</td>
                                    <td width=51 height=31><br></td>
                                </tr>

                                <tr>
                                    <td height=37>&nbsp;</td>
                                    <td height=37>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td height=37>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height=115><br></td>
                                    <td width=6 height=115>
                                        <div align="justify"><br>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <table width="74" height="49" border="0" class='index' cellpadding="0"
                                                cellspacing="0">
                                            <tr>
                                                <?php
                                                include 'includes/dbconnect.inc.php'; // Include the database connection
                                                $query = 'SELECT count FROM simplecount';
                                                $result = mysqli_query($query) or die('Query failed: ' . mysqli_error($connection));  // corrected mysql_error() to mysqli_error()
                                                $num = mysqli_result($result, 0);
                                                mysqli_close($connection); // Close the connection

                                                // Echo the number directly within the <td>
                                                echo "<td colspan='6' align='center'><h1>$num</h1></td>";

                                                $second = '0.jpg';
                                                $third = '0.jpg';
                                                $fourth = '0.jpg';
                                                $fifth = '0.jpg';
                                                $sixth = '0.jpg';

                                                $str_length_var = strlen($num);

                                                if ($str_length_var == 6) {
                                                    $sixth = (substr($num, 0, 1) . '.jpg');
                                                    $fifth = (substr($num, 1, 1) . '.jpg');
                                                    $fourth = (substr($num, 2, 1) . '.jpg');
                                                    $third = (substr($num, 3, 1) . '.jpg');
                                                    $second = (substr($num, 4, 1) . '.jpg');
                                                    $first = (substr($num, 5, 1) . '.jpg');
                                                } elseif ($str_length_var == 5) {
                                                    $fifth = (substr($num, 0, 1) . '.jpg');
                                                    $fourth = (substr($num, 1, 1) . '.jpg');
                                                    $third = (substr($num, 2, 1) . '.jpg');
                                                    $second = (substr($num, 3, 1) . '.jpg');
                                                    $first = (substr($num, 4, 1) . '.jpg');
                                                } elseif ($str_length_var == 4) {
                                                    $fourth = (substr($num, 0, 1) . '.jpg');
                                                    $third = (substr($num, 1, 1) . '.jpg');
                                                    $second = (substr($num, 2, 1) . '.jpg');
                                                    $first = (substr($num, 3, 1) . '.jpg');
                                                } elseif ($str_length_var == 3) {
                                                    $third = (substr($num, 0, 1) . '.jpg');
                                                    $second = (substr($num, 1, 1) . '.jpg');
                                                    $first = (substr($num, 2, 1) . '.jpg');
                                                } elseif ($str_length_var == 2) {
                                                    $second = (substr($num, 0, 1) . '.jpg');
                                                    $first = (substr($num, 1, 1) . '.jpg');
                                                } elseif ($str_length_var == 1) {
                                                    $first = (substr($num, 0, 1) . '.jpg');
                                                }
                                                ?>
                                                </tr>
                                        </table>
                                    </td>
                                    <td height=115><br></td>
                                </tr>
                                <tr>
                                    <td height=18>&nbsp;</td>
                                    <td height=18>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td height=18>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th scope="col">&nbsp;
                        Visits to Cyclerestorer
                    </th>
                </tr>
                <tr>
                    <br>
                    <td>
                        <h5>
                            <div align="center"><a href="/phpBB3/memberlist.php">Member List</a></div>
                        </h5>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <p align="center"><a href="pages/cycle_shows.php">Cycle Shows</a></p>
        </td>
        <td>
            <div align="center"><a href="pages/privacy_policy.html">Privacy Policy</a></div>
        </td>
        <td>
            <h5>
                <div align="center"><a
                                href="mailto:webmaster@cyclerestorer.com?subject=Suggestions for Cyclerestorer">Email
                        Suggestions</a></div>
            </h5>
        </td>

    </tr>
</table>
<p>&nbsp;</p>

<?php
include 'includes/analytics.inc.php';
?>
</body>
</html>
