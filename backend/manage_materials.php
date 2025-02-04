<?php
session_start();
include 'db.php'; // Include database connection

$admin_name = isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin';

// Query to get all the study materials from the database
$stmt = $conn->prepare("SELECT * FROM study_materials");
$stmt->execute();
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle File Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    $title = $_POST['title'];
    $targetDir = "uploads/";

    // Ensure the uploads directory exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        $stmt = $conn->prepare("INSERT INTO study_materials (title, file_path) VALUES (?, ?)");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $targetFilePath, PDO::PARAM_STR);
        $stmt->execute();
        echo "<script>alert('File uploaded successfully!');</script>";
    } else {
        echo "<script>alert('File upload failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Study Materials</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
    }

    /* Navbar */
    .navbar {
        background-color: rgb(27, 121, 214);
        color: #fff;
        padding: 15px;
    }
    .navbar a {
        color: #fff;
        text-decoration: none;
        margin-left: 15px;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: rgb(32, 126, 221);
        color: #fff;
        height: 100vh;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
    }
    .sidebar a {
        display: block;
        color: #fff;
        padding: 10px;
        text-decoration: none;
        margin: 5px 0;
        border-radius: 5px;
        font-size: 16px;
    }
    .sidebar a:hover {
        background-color: #1abc9c;
    }

    .sidebar i {
        margin-right: 10px; /* Space between icon and text */
    }

    /* Main Content */
    .main-content {
        margin-left: 270px;
        padding: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .main-content {
            margin-left: 0;
        }
    }
</style>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary p-3">
        <h2 class="text-white">LMS Dashboard</h2>
        <div>
            <span class="text-white">Welcome, <?php echo $admin_name; ?> | </span>
            <a href="profile.php" class="text-white">Profile</a>
            <a href="logout.php" class="text-white">Logout</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar bg-primary text-white p-3 position-fixed h-100">
        <h3>Admin Menu</h3>
        <a href="profile.php" class="text-white d-block p-2">
            <i class="fas fa-user"></i> Profile
        </a>
        <a href="manage_quiz.php" class="text-white d-block p-2">
            <i class="fas fa-question-circle"></i> Manage Quiz
        </a>
        <a href="manage_student.php" class="text-white d-block p-2">
            <i class="fas fa-users"></i> Manage Students
        </a>
        <a href="manage_materials.php" class="text-white d-block p-2">
            <i class="fas fa-book"></i> Manage Study Materials
        </a>
        <a href="manage_Video_Lectures.php" class="text-white d-block p-2">
            <i class="fas fa-video"></i> Manage Video Lectures
        </a>
        <a href="manage_jobs.php" class="text-white d-block p-2">
            <i class="fas fa-briefcase"></i> Manage Jobs & Internships
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Manage Study Materials</h2>

        <!-- Upload Form -->
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Enter title" required class="form-control mb-2">
            <input type="file" name="file" required class="form-control mb-2">
            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        </form>

        <hr>

        <!-- Display Uploaded Materials -->
        <h3>Uploaded Materials</h3>
        <table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>File</th>
        <th>Uploaded At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($materials as $row) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><a href="<?php echo $row['file_path']; ?>" target="_blank">View</a></td>
            <td>
                <?php
                // Format the timestamp to a readable format (e.g., Y-m-d H:i:s)
                echo date('Y-m-d H:i:s', strtotime($row['uploaded_at']));
                ?>
            </td>
            <td>
                <a href="edit_material.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete_material.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>
