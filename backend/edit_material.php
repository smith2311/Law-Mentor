<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM study_materials WHERE id = $id");
    $material = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $file_path = $material['file_path'];

    if (!empty($_FILES["file"]["name"])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $file_path = $targetDir . $fileName;
        move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);
    }

    $stmt = $conn->prepare("UPDATE study_materials SET title = ?, file_path = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $file_path, $id);
    $stmt->execute();
    header("Location: manage_materials.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Material</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Study Material</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $material['id']; ?>">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $material['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Upload New File (optional)</label>
            <input type="file" name="file" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
    </form>
</div>

</body>
</html>
