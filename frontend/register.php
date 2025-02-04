<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['full_name'], $_POST['enrollment'], $_POST['phone'], $_POST['email'], $_POST['password'])) {

        error_log("POST data received: " . print_r($_POST, true));

        // Trim input values
        $full_name = trim($_POST['full_name']);
        $enrollment = trim($_POST['enrollment']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Check if email already exists
        $check_stmt = $con->prepare("SELECT email FROM users WHERE email = ?");
        $check_stmt->execute([$email]);

        if ($check_stmt->rowCount() > 0) {
            echo "email_exists"; // Response handled in Java
            exit;
        }

        // Prepare the SQL query for insertion
        $stmt = $con->prepare("INSERT INTO users (full_name, enrollment, phone, email, password) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->execute([$full_name, $enrollment, $phone, $email, $password]);
            echo "Registered Successfully";
        } else {
            echo "Registration Failed: " . $con->errorInfo()[2];
        }
    } else {
        echo "Invalid request: Missing required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
