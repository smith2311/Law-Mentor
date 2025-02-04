<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reset_token = $_POST['reset_token'];
    $new_password = $_POST['password'];

    if (strlen($new_password) < 8) {
        echo "Password must be at least 8 characters.";
        exit();
    }

    // Verify if the token in the form matches the token stored in the database
    $query = $con->prepare("SELECT email FROM users WHERE reset_token = :reset_token AND token_expiry > NOW()");
    $query->bindParam(":reset_token", $reset_token, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        echo "Invalid or expired token.";
        exit();
    }

    $email = $result['email'];

    // Update the password, clear the token and expiry in the database
    $updateQuery = $con->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE email = :email");
    $updateQuery->bindParam(":password", $new_password, PDO::PARAM_STR);
    $updateQuery->bindParam(":email", $email, PDO::PARAM_STR);

    if ($updateQuery->execute()) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password.";
    }
}
?>
