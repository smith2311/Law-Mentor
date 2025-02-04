<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: manage_materials.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM study_materials WHERE id=?");
$stmt->bindParam(1, $id, PDO::PARAM_INT); // Correct parameter binding
$stmt->execute();
$stmt->closeCursor();

header("Location: manage_materials.php");
exit();
?>
