<?php
$host = "localhost";
$username = "root"; 
$pass = ""; 
$dbname = "lms_law";

try {
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
