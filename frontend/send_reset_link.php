<?php
include 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Set PHP default time zone
date_default_timezone_set('Asia/Kolkata');  // Set to your local time zone (for example: 'Asia/Kolkata')

// Ensure the time zone in MySQL matches PHP's time zone
$query = "SET time_zone = '+05:30'";  // Adjust based on your time zone offset
$con->exec($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Check if email exists
    $query = $con->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
        $reset_token = bin2hex(random_bytes(32));  // Generate a reset token
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));  // Set expiry to 1 hour (adjusted to your time zone)

        // Update the database with the reset token and expiry
        $updateQuery = $con->prepare("UPDATE users SET reset_token = :reset_token, token_expiry = :expiry WHERE email = :email");
        $updateQuery->bindParam(":reset_token", $reset_token);
        $updateQuery->bindParam(":expiry", $expiry);
        $updateQuery->bindParam(":email", $email);
        $updateQuery->execute();

        $reset_link = "http://192.168.237.243/LMS_backend/frontend/reset_password.php?reset_token=" . $reset_token;

        // Send the reset email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "whitehat231101@gmail.com";  // Your email
            $mail->Password = "amne sgza qheg hyup";  // Your password or app-specific password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('whitehat231101@gmail.com', 'LMS_LAW');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Click <a href="' . $reset_link . '">here</a> to reset your password.';

            $mail->send();
            echo "Password reset link sent.";
        } catch (Exception $e) {
            echo "Email sending failed: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found.";
    }
}
?>
