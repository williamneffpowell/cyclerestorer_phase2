<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session

include 'includes/dbconnect.inc.php';

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sessionID = session_id();

    // Connect to the database
    $link = mysqli_connect($Host, $User, $Password, $DBName) or
        die("Database connection error. Please try again later."); //More general message for user


    // Use prepared statements to prevent SQL injection
    $stmt = $link->prepare("SELECT userID, username, password FROM auth_user WHERE username = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . mysqli_error($link));
        die("Database error: Could not prepare statement.");
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        error_log("get_result failed: " . mysqli_error($link));
        die("Database error: Could not retrieve result.");
    }
    $user_data = $result->fetch_assoc();

    if ($user_data) {
        //  USE PASSWORD_VERIFY
        $hashed_password_from_db = $user_data['password'];
        if (password_verify($password, $hashed_password_from_db)) {
            // Authentication successful
            $_SESSION['user_id'] = $user_data['userID'];
            $_SESSION['username'] = $user_data['username'];

            // Update sesnID and lastlogin
            $update_stmt = $link->prepare("UPDATE auth_user SET sesnID = ?, lastlogin = NOW() WHERE userID = ?");
            if ($update_stmt === false) {
                error_log("Prepare failed: " . mysqli_error($link));
                die("Database error: Could not prepare update statement.");
            }
            $update_stmt->bind_param("si", $sessionID, $user_data['userID']);
            $update_stmt->execute();
            if ($update_stmt === false) {
                error_log("Update execute failed: " . mysqli_error($link));
                die("Database error: Could not execute update.");
            }
            $update_stmt->close();

            header("Location: index.php"); // Redirect to the homepage
            exit();
        } else {
            $error_message = "Invalid username or password.";
            error_log("Invalid password attempt for user: $username");
        }
    } else {
        $error_message = "Invalid username or password.";
        error_log("Invalid username attempt: $username");
    }

    $stmt->close();
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <style>
      /* Custom styles for larger fonts and mobile-friendly layout */
      body {
        font-size: 18px; /* Increase default font size */
        line-height: 1.6;  /* Improve line height for readability */
      }
      h2 {
        font-size: 28px;  /* Increase heading size */
        margin-bottom: 20px;
      }
      form table {
        width: 100%; /* Make table width responsive */
        max-width: 400px; /* Limit maximum width */
        margin: 0 auto;  /* Center the form */
      }
      form table td {
        padding: 12px;
        text-align: left;
      }
      form table td input[type="text"],
      form table td input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 18px; /* Increase input field font size */
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;  /* Include padding and border in element's total width and height */
      }
      form table td input[type="submit"] {
        padding: 12px 24px;
        font-size: 18px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%; /* Make button width responsive */
      }
      form table td input[type="submit"]:hover {
        background-color: #45a049;
      }
      p {
        font-size: 18px;
        margin-top: 15px;
      }
      a {
        font-size: 18px;
      }

      /* Media query for mobile devices */
      @media screen and (max-width: 600px) {
        form table td {
          display: block;  /* Stack table cells vertically on small screens */
          width: 100%;
        }
        form table td input[type="text"],
        form table td input[type="password"] {
          width: 100%;
        }
        form table td input[type="submit"] {
           width: 100%;
        }
      }
    </style>
</head>
<body>
    <div align="center">
        <h2>Login</h2>
        <?php if ($error_message) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" action="login.php">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>
        <p> <a href="forgot_password.php">Forgot Password?</a></p>
        <p> <a href="registration_page.php?mode=register">Register</a></p>
        <p> <a href="index.php">Home Page</a></p>
    </div>
</body>
</html>
