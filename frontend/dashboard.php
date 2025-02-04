<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");


require_once('db_connection.php');

if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
    echo json_encode(["error" => "User ID is missing"]);
    exit();
}

$user_id = trim($_GET['id']);

$query = "SELECT full_name FROM users WHERE id = ?";
$stmt = $con->prepare($query);

if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare the query: " . $con->error]);
    exit();
}

$stmt->bind_param("s", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["full_name" => $row['full_name']]);
} else {
    echo json_encode(["error" => "User not found"]);
}

$stmt->close();
$con->close();

?>
