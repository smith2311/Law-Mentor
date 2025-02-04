<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user ID is passed in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the user ID to the prepared statement using PDO's bindValue
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

        // Execute the query and check if successful
        if ($stmt->execute()) {
            // Redirect to the manage students page with success message
            $_SESSION['message'] = "User deleted successfully!";
            header("Location: manage_student.php");
            exit();
        } else {
            // If there was an error in executing the query
            $_SESSION['message'] = "Error deleting user. Please try again.";
            header("Location: manage_student.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Database error. Please try again.";
        header("Location: manage_student.php");
        exit();
    }
} else {
    // If no user ID is provided, redirect with an error message
    $_SESSION['message'] = "Invalid request. No user ID specified.";
    header("Location: manage_student.php");
    exit();
}

$conn = null; // Close the PDO connection
?>
