<?php
include 'db_connection.php';

// Check if the reset token is provided in the URL
if (!isset($_GET['reset_token'])) {
    echo "Invalid token!";
    exit();
}

$reset_token = $_GET['reset_token'];

// Verify the token in the database and check its expiry
$query = $con->prepare("SELECT email FROM users WHERE reset_token = :reset_token AND token_expiry > NOW()");
$query->bindParam(":reset_token", $reset_token, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch();

if (!$result) {
    echo "Invalid or expired token!";
    exit();
}

$email = $result['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="confirmation-box">
            <h2>✅ Email Verified!</h2>
            <p>Your email has been confirmed. You can now reset your password.</p>
        </div>

        <div class="reset-box">
            <h2>Reset Your Password</h2>
            <form action="update_password.php" method="POST">
                <!-- Pass the reset token via hidden input -->
                <input type="hidden" name="reset_token" value="<?php echo htmlspecialchars($reset_token); ?>">
                <label for="password">New Password:</label>
                <input type="password" name="password" required minlength="8">
                <button type="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
