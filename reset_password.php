<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/dbconnect.inc.php'; // Include your database connection file
require 'vendor/autoload.php';  // Include PHPMailer autoloader

$message = "";

// Function to send the password reset confirmation email using PHPMailer
function send_reset_confirmation_email($email, $new_password) {
    global $Host, $User, $Password, $DBName;

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Set to 0 for production, 2 for debugging
        $mail->isSMTP();
        $mail->Host       = 'mail.cyclerestorer.com';  // Use your GoDaddy SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'webmaster@cyclerestorer.com';  // Your GoDaddy email address
        $mail->Password   = '1975!Gl1000!!';           // Your GoDaddy email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Use SMTPS
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('Webmaster@cyclerestorer.com', 'Cycle Restorer'); // Set appropriate From name
        $mail->addAddress($email); //  recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Password Has Been Reset';
        $mail->Body    = "<html>
                            <head>
                                <title>Password Reset Confirmation</title>
                            </head>
                            <body>
                                <p>Your password has been successfully reset to:</p>
                                <p><strong>" . htmlspecialchars($new_password) . "</strong></p>  
                                <p>Please log in and change your password as soon as possible.</p>
                            </body>
                            </html>";
        $mail->AltBody = "Your password has been successfully reset to: " . $new_password . ". Please log in and change your password as soon as possible.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Password reset email failed: {$mail->ErrorInfo}"); // Log the error
        return false;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];
    $link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection error.");

    // Verify the token
    $stmt = $link->prepare("SELECT user_id, expires_at, used, email FROM password_reset_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $expires_at = strtotime($row['expires_at']);
        $used = $row['used'];
        $user_email = $row['email']; //added user email


        if ($used) {
            $message = "<p style='color: red;'>This reset link has already been used.</p>";
        } elseif (time() > $expires_at) {
            $message = "<p style='color: red;'>This reset link has expired. Please request a new password reset.</p>";
            // Optionally, delete the expired token from the database
            $stmt = $link->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
        } else {
            // Token is valid, show the password reset form
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Reset Password</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
                <style>
                  /* Custom styles for larger fonts and mobile-friendly layout */
                  body {
                    font-size: 18px;
                    line-height: 1.6;
                  }
                  h2 {
                    font-size: 28px;
                    margin-bottom: 20px;
                  }
                  form table {
                    width: 100%;
                    max-width: 400px;
                    margin: 0 auto;
                  }
                  form table td {
                    padding: 12px;
                    text-align: left;
                  }
                  form table td input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    font-size: 18px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-sizing: border-box;
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
                    width: 100%;
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
                  @media screen and (max-width: 600px) {
                    form table td {
                      display: block;
                      width: 100%;
                    }
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
                    <h2>Reset Your Password</h2>
                    <?php echo $message; ?>
                    <form method="post" action="reset_password.php">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <table>
                            <tr>
                                <td>New Password:</td>
                                <td><input type="password" name="new_password" required></td>
                            </tr>
                            <tr>
                                <td>Confirm New Password:</td>
                                <td><input type="password" name="confirm_password" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="reset_password" value="Reset Password"></td>
                            </tr>
                        </table>
                    </form>
                    <p><a href="login.php">Back to Login</a></p>
                </div>
            </body>
            </html>
            <?php
            exit(); // Stop further execution, so the rest of the file is not shown.
        }
    } else {
        $message = "<p style='color: red;'>Invalid reset link.</p>";
    }
    $stmt->close();
    mysqli_close($link);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    // Handle the password reset form submission
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        $message = "<p style='color: red;'>Passwords do not match.</p>";
        goto display_form;
    }

    if (strlen($new_password) < 8) {
        $message = "<p style='color: red;'>Password must be at least 8 characters long.</p>";
        goto display_form;
    }


    $link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection error.");
    $stmt = $link->prepare("SELECT user_id, expires_at, used, email FROM password_reset_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        $message = "<p style='color: red;'>Invalid or expired reset link.</p>";
        goto display_page;
    }

    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    $expires_at = strtotime($row['expires_at']);
    $used = $row['used'];
    $user_email = $row['email']; //added

    if ($used) {
        $message = "<p style='color: red;'>This reset link has already been used.</p>";
        goto display_page;
    } elseif (time() > $expires_at) {
        $message = "<p style='color: red;'>This reset link has expired. Please request a new password reset.</p>";
        $stmt = $link->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        goto display_page;
    }


    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the auth_user table
    $stmt = $link->prepare("UPDATE auth_user SET password = ? WHERE userID = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    if ($stmt->execute()) {
        $message = "<p style='color: green;'>Your password has been successfully reset.  You will be redirected to the login page in 5 seconds.</p>";

        // Send confirmation email
        if (send_reset_confirmation_email($user_email, $new_password)) {
            $message .= "<p style='color: green;'>A confirmation email has been sent to " . htmlspecialchars($user_email) . ".</p>";
        } else {
            $message .= "<p style='color: orange;'>Failed to send confirmation email. Please check your email settings.</p>"; //Added color
        }

        //update the used status
        $stmt = $link->prepare("UPDATE password_reset_tokens SET used = TRUE WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        // Redirect to login page after successful password reset
        header("refresh:5;url=login.php");
        goto display_page;
    } else {
        $message = "<p style='color: red;'>Failed to update password. Please try again.</p>";
        goto display_form;
    }
    $stmt->close();
    mysqli_close($link);
}

display_page:
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <style>
      /* Custom styles for larger fonts and mobile-friendly layout */
      body {
        font-size: 18px;
        line-height: 1.6;
      }
      h2 {
        font-size: 28px;
        margin-bottom: 20px;
      }
      form table {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }
      form table td {
        padding: 12px;
        text-align: left;
      }
      form table td input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
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
        width: 100%;
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
      @media screen and (max-width: 600px) {
        form table td {
          display: block;
          width: 100%;
        }
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
        <h2>Reset Your Password</h2>
        <?php echo $message; ?>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
<?php
goto end_page;
display_form:
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <style>
      /* Custom styles for larger fonts and mobile-friendly layout */
      body {
        font-size: 18px;
        line-height: 1.6;
      }
      h2 {
        font-size: 28px;
        margin-bottom: 20px;
      }
      form table {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }
      form table td {
        padding: 12px;
        text-align: left;
      }
      form table td input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
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
        width: 100%;
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
      @media screen and (max-width: 600px) {
        form table td {
          display: block;
          width: 100%;
        }
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
        <h2>Reset Your Password</h2>
        <?php echo $message; ?>
        <form method="post" action="reset_password.php">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <table>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="new_password" required></td>
                </tr>
                <tr>
                    <td>Confirm New Password:</td>
                    <td><input type="password" name="confirm_password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="reset_password" value="Reset Password"></td>
                </tr>
            </table>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
<?php
end_page:
?>
