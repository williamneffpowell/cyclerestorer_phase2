<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'includes/dbconnect.inc.php';

require 'vendor/autoload.php'; // Include PHPMailer

$message = "";

function generate_token() {
    return bin2hex(random_bytes(32));
}

function send_reset_email($email, $token) {
    global $Host, $User, $Password, $DBName;

    $reset_link = "https://cyclerestorer.com/reset_password.php?token=" . $token;

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Set to 0 for production, 2 for debugging
        $mail->isSMTP();
        $mail->Host       = 'mail.cyclerestorer.com';  // Your GoDaddy SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'webmaster@cyclerestorer.com';  // Your GoDaddy email address
        $mail->Password   = '1975!Gl1000!!';           // Your GoDaddy email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Use SMTPS
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('Webmaster@cyclerestorer.com', 'Cycle Restorer'); // Set appropriate From name
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "<html>
                            <head>
                                <title>Password Reset</title>
                            </head>
                            <body>
                                <p>A password reset has been requested for your account.</p>
                                <p>Please click the following link to reset your password:</p>
                                <p><a href='" . $reset_link . "'>" . $reset_link . "</a></p>
                                <p>This link will expire in 1 hour.</p>
                                <p>If you did not request this password reset, you can ignore this email.</p>
                            </body>
                            </html>";
        $mail->AltBody = "A password reset has been requested for your account. Please click the following link to reset your password: " . $reset_link . " This link will expire in 1 hour. If you did not request this password reset, you can ignore this email.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Forgot password email failed: {$mail->ErrorInfo}");
        return false;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reset_request'])) {
        $email = $_POST['email'];
        $link = mysqli_connect($Host, $User, $Password, $DBName) or die("Database connection error.");
        $stmt = $link->prepare("SELECT userID, email FROM auth_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row['userID'];
            $user_email = $row['email'];

            $token = generate_token();
            $expires_at = date("Y-m-d H:i:s", time() + 3600);

            // Store token in database
            $stmt = $link->prepare("INSERT INTO password_reset_tokens (token, user_id, email, expires_at) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $token, $user_id, $user_email, $expires_at);
            if ($stmt->execute()) {
                if (send_reset_email($user_email, $token)) {
                    $message = "A password reset link has been sent to your email address. Please check your inbox.";
                } else {
                    $message = "Failed to send reset email. Please try again.";
                }
            } else {
                $message = "Failed to store reset token in database.";
            }
            $stmt->close();
        } else {
            $message = "Email address not found.";
        }
        mysqli_close($link);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
      form table td input[type="email"] {
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
        form table td input[type="email"] {
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
        <h2>Forgot Password</h2>
        <?php echo $message; ?>

        <?php if (!isset($_GET['token'])): ?>
        <p>Please enter your email address to receive a password reset link.</p>
        <form method="post" action="forgot_password.php">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="reset_request" value="Reset Password"></td>
                </tr>
            </table>
        </form>
        <?php endif; ?>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
