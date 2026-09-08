<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'includes/dbconnect.inc.php'; // Database connection details

$error_message = "";
$success_message = "";

// CAPTCHA settings (reCAPTCHA v2 -  you'll need to get your own keys from Google)
$recaptcha_secret = "6LdtICorAAAAAPkqWKjsSJ0ifd4-U9z3gEU7kpRB"; // Replace with your secret key
$recaptcha_sitekey = "6LdtICorAAAAAGSZHNBNXqAdEy-neujPlWmFPiA5"; // Add this line

function validate_captcha($response_key, $secret_key) {
    // Basic validation - check if response key is provided.
    if (!$response_key) {
        return false;
    }

    //Construct the POST request.
     $params = array(
        'secret'    => $secret_key,
        'response'  => $response_key
    );

    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $response = curl_exec($ch);
    curl_close($ch);
    $decodedResponse = json_decode($response, true);

    return $decodedResponse['success'] === true;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Connect to the database *before* any database operations
    $link = mysqli_connect($Host, $User, $Password, $DBName);
    if (!$link) {
        die("Database connection error: " . mysqli_connect_error());
    }

    // Validate CAPTCHA
    $captcha_valid = validate_captcha($recaptcha_response, $recaptcha_secret);

    // Basic input validation
     if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($first_name) || empty($last_name) || empty($address_1)  || empty($city) || empty($state) || empty($zipcode)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password != $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } elseif (!$captcha_valid) {
        $error_message = "Invalid CAPTCHA. Please try again.";
    } else {
        // Check if username already exists 
        $check_stmt = $link->prepare("SELECT username FROM auth_user WHERE username = ?");
        if (!$check_stmt) {
            die("Prepare failed: " . mysqli_error($link));
        }
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if (!$check_result) {
            die("Could not get result: " . mysqli_error($link));
        }

        if ($check_result->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            //  Removed sesnID, logged_in, lastlogin, status, bio, picID, url, recieve_email
          
          
          
         $insert_stmt = $link->prepare("INSERT INTO auth_user (username, password, email, first_name, last_name, address_1, address_2, city, state, zipcode, joindate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())");
if (!$insert_stmt) {
    die("Prepare failed: " . mysqli_error($link));
}
// Explicitly declare the type of each variable
$bind_types = "ssssssssss"; // Ten 's' characters to match the ten variables
$bind_params = array(
    &$username,      // string
    &$hashed_password, // string
    &$email,         // string
    &$first_name,    // string
    &$last_name,     // string
    &$address_1,     // string
    &$address_2,     // string
    &$city,          // string
    &$state,         // string
    &$zipcode        // string
);

$result = call_user_func_array(array($insert_stmt, 'bind_param'), array_merge(array($bind_types), $bind_params));

if ($result === false) {
    die("bind_param failed: " . $insert_stmt->error . ". Types: " . $bind_types . ". Count: " . count($bind_params));
}

if ($insert_stmt->execute()) {
    $success_message = "Registration successful! You can now log in.";
} else {
    $error_message = "Registration failed. Please try again.";
    error_log("Database error: " . $insert_stmt->error);
}
$insert_stmt->close();

   
        }
        $check_stmt->close();
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
      /* Styles for larger screens */
      @media (min-width: 768px) {
        .container {
          width: 50%;
        }
        table {
            width: 100%;
        }
      }
      /* Styles for smaller screens */
      @media (max-width: 767px) {
        .container {
          width: 95%;
        }
        table {
            width: 100%;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
          width: 90%;
          margin-bottom: 10px;
        }
        .g-recaptcha {
            transform: scale(0.8);
            transform-origin: 0 0;
        }
      }
      .container {
        margin: auto;
        padding: 20px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        margin-top: 50px;
      }
      table {
        margin: auto;
        border-collapse: collapse;
      }
      table td {
        padding: 12px;
        text-align: left;
      }
      h2 {
        color: #333;
        font-size: 28px;
        margin-bottom: 20px;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 15px;
        box-sizing: border-box;
        font-size: 16px;
      }
      input[type="submit"] {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 15px;
        font-size: 18px;
      }
      input[type="submit"]:hover {
        background-color: #0056b3;
      }
      .error-message {
        color: red;
        margin-bottom: 15px;
        font-size: 16px;
      }
      .success-message {
        color: green;
        margin-bottom: 15px;
        font-size: 16px;
      }
      a {
        color: #007bff;
        text-decoration: none;
        font-size: 16px;
      }
      a:hover {
        text-decoration: underline;
      }
      .label-large {
        font-size: 18px;
      }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if ($error_message) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <?php if ($success_message) { ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php } ?>
        <form method="post" action="registration_page.php">
            <table>
                <tr>
                    <td class="label-large">Username:</td>
                    <td><input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Email:</td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">First Name:</td>
                    <td><input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Last Name:</td>
                    <td><input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Address 1:</td>
                    <td><input type="text" name="address_1" value="<?php echo htmlspecialchars($address_1 ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Address 2:</td>
                    <td><input type="text" name="address_2" value="<?php echo htmlspecialchars($address_2 ?? ''); ?>"></td>
                </tr>
                <tr>
                    <td class="label-large">City:</td>
                    <td><input type="text" name="city" value="<?php echo htmlspecialchars($city ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">State:</td>
                    <td><input type="text" name="state" value="<?php echo htmlspecialchars($state ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Zipcode:</td>
                    <td><input type="text" name="zipcode" value="<?php echo htmlspecialchars($zipcode ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <td class="label-large">Password:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td class="label-large">Confirm Password:</td>
                    <td><input type="password" name="confirm_password" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_sitekey; ?>"></div>  </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>
        <p> <a href="login.php">Login</a></p> </div>
</body>
</html>
