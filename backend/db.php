<?php
// Database connection
$host = 'localhost';
$dbname = 'lms_law';
$username = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
