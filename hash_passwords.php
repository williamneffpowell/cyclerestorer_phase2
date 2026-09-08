<?php
// **BACK UP YOUR DATABASE BEFORE RUNNING THIS SCRIPT!!!**

include 'includes/dbconnect.inc.php';

// Connect to the database
$link = mysqli_connect($Host, $User, $Password, $DBName) or
    die("Connection Unsuccessful");

// Select all users with plain-text passwords (assuming 'password' column currently stores plain text)
$sql = "SELECT userID, password FROM auth_user";
$result = mysqli_query($link, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['userID'];
        $plain_text_password = $row['password'];

        // Hash the password
        $hashed_password = password_hash($plain_text_password, PASSWORD_DEFAULT);

        // Update the database with the hashed password
        $update_sql = "UPDATE auth_user SET password = '$hashed_password' WHERE userID = $user_id";
        if (mysqli_query($link, $update_sql)) {
            echo "Password updated for user ID: $user_id <br>";
        } else {
            echo "Error updating password for user ID: $user_id - " . mysqli_error($link) . "<br>";
        }
    }
} else {
    echo "Error selecting users: " . mysqli_error($link);
}

mysqli_close($link);
?>