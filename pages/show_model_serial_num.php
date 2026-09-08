<?php
define('IN_PHPBB', true);
$phpbb_root_path = '../phpBB3/';
$phpEx = "php";
$returnAddress = '../show_model_serial_num.php';

// Including phpBB3 core
include($phpbb_root_path . 'common.php');
include($phpbb_root_path . 'includes/functions_display.php');

$request->enable_super_globals();

// Start phpBB session
$user->session_begin();
$auth->acl($user->data);

// Connect to database
include '../includes/dbconnect.inc.php';
$link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection failed");
mysqli_set_charset($link, 'utf8mb4');

// Check login status
$loginvar = '';
if ($user->data['is_registered']) {
    $loginvar = '<form align="center">
    <input type="button" value="Add a New Serial Number Entry" onClick="goToadd_link()">
    </form>';
} else {
    $_SESSION['target_url'] = '/pages/show_man_serial_num.php';
    $loginvar = '<table align="center"><form align="center">
    <input type="button" value="Log In to add Serial Numbers" onClick="goToLogin()">
    </form></table>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Serial Number Reference Page</title>
    <link href="../css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function goToadd_link() {
            window.location = "http://www.cyclerestorer.com/pages/add_serial_numbers.php";
        }
        function goToLogin() {
            window.location = "http://www.cyclerestorer.com/pages/login.php";
        }
    </script>
</head>
<body>
    <div align="center">
        <table width="74%" border="0">
            <tr>
                <td width="37%"></td>
                <td width="19%" align="center">
                    <h1>Cyclerestorer</h1>
                    <h4>Serial Number Reference</h4>
                    <p><img src="../Images/serial_numbers.jpg" width="138" height="89"></p>
                </td>
                <td width="44%"></td>
            </tr>
        </table>
    </div>

<?php
// Handle request parameters safely
$manufacturer = $_REQUEST['manufacturer'] ?? '';
$bike_model = $_REQUEST['bike_model'] ?? '';
$sort_field_url = $_REQUEST['sort_field'] ?? '';

switch ($sort_field_url) {
    case 7:
        $sort_field_in = "ORDER BY s.model";
        break;
    case 4:
        $sort_field_in = "ORDER BY s.bike_year";
        break;
    case 5:
        $sort_field_in = "ORDER BY s.manufacturer";
        break;
    default:
        $sort_field_in = "ORDER BY s.manufacturer";
        break;
}

// Prepare SQL query to prevent SQL injection
$query = "SELECT 
            s.engine_number, s.frame_number, s.bike_year, s.model, s.ccs, s.num_cyl, s.fuel_tank_color, s.manufacturer, 
            s.user_name, s.serial_row_id, s.nickname, r.year, r.model, r.picID, r.row_id 
          FROM serial_numbers AS s 
          LEFT JOIN registry AS r ON r.model = s.model AND r.year = s.bike_year 
          WHERE s.manufacturer = ? AND s.model = ? $sort_field_in";

$stmt = $link->prepare($query);
$stmt->bind_param('ss', $manufacturer, $bike_model);
$stmt->execute();
$result = $stmt->get_result();

// Display results
echo "<table class='registry' width='100%' align='center'>\n";
echo "<tr>
        <th width='2%'></th>
        <th width='3%'>Year</th>
        <th width='2%'>Model</th>
        <th width='2%'>Nickname</th>
        <th width='2%'>CCs</th>
        <th width='2%'># of Cylinders</th>
        <th width='2%'>Tank Color</th>
        <th width='15%'>Engine Number</th>
        <th width='15%'>Frame Number</th>
        <th width='15%'>Members with Bike</th>
      </tr>";

$bgcolor = "BBBBBB";

while ($Row = $result->fetch_array(MYSQLI_NUM)) {
    // Alternate row colors
    $bgcolor = ($bgcolor == "BBBBBB") ? "777777" : "BBBBBB";
    $fcolor = ($bgcolor == "BBBBBB") ? "000000" : "FFFFFF";

    list($engine_number, $frame_number, $bike_year, $bike_model_row, $ccs, $num_cyl, $fuel_tank_color, $bike_manufacturer,
        $user_tab, $row_id_tab, $nickname, $registration_year, $registration_model, $picID, $row_id) = $Row;

    // Check if user is owner
    $edit_link = ($user_tab === $user->data['username']) ? "<a href='edit_serial_number.php?edit_row=$row_id_tab'>Edit</a>" : "";

    // Check for member bike
    $member_bike = '';
    if (trim($registration_year) === trim($bike_year) && trim($registration_model) === trim($bike_model_row)) {
        $member_bike = "<a href='view_collection_info.php?picID=$picID&edit_row=$row_id'>View</a>";
    }

    echo "<tr bgcolor='#$bgcolor'>
            <td><font color='#$fcolor'>$edit_link</td>
            <td><font color='#$fcolor'>$bike_year</td>
            <td><font color='#$fcolor'>$bike_model_row</td>
            <td><font color='#$fcolor'>$nickname</td>
            <td><font color='#$fcolor'>$ccs</td>
            <td><font color='#$fcolor'>$num_cyl</td>
            <td><font color='#$fcolor'>$fuel_tank_color</td>
            <td><font color='#$fcolor'>$engine_number</td>
            <td><font color='#$fcolor'>$frame_number</td>
            <td><font color='#$fcolor'>$member_bike</td>
          </tr>";
}

echo "</table>\n";
echo "<br>";
echo "<table align='center'><tr><td>$loginvar</td></tr></table>";

// Close database connection
$stmt->close();
mysqli_close($link);

include 'bottom_index_table.php';
include '../includes/analytics.inc.php';
?>

</body>
</html>
