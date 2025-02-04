<?php
// Database connection
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "lms_law";

// Create connection
$con = new mysqli($servername, $username, $pass, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted data
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // SQL query to check if email and password match
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $con->query($sql);

        $response = array();

        if ($result->num_rows > 0) {
            // Login successful
            $row = $result->fetch_assoc();
            $response["status"] = "success";
            $response["full_name"] = $row["full_name"]; // Send the user's full name
        } else {
            // Login failed
            $response["status"] = "error";
            $response["message"] = "Invalid email or password";
        }

        // Return the response as JSON
        echo json_encode($response);
    } else {
        // Missing email or password in POST data
        echo json_encode(array("status" => "error", "message" => "Email or password not provided"));
    }
} else {
    // Invalid request method
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$con->close();
?>
