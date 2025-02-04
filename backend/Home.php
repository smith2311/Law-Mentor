<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: Login.php');
    exit;
}

$admin_name = isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .navbar {
            background-color: rgb(27, 121, 214);
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 1rem;
        }
        .sidebar {
            width: 250px;
            background-color: rgb(32, 126, 221);
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar h3 {
            margin-bottom: 1rem;
        }
        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin: 0.5rem 0;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
        }
        .sidebar i {
            margin-right: 10px; /* Space between icon and text */
        }
        .main-content {
            margin-left: 260px;
            padding: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .card h3 {
            margin: 0 0 1rem;
        }
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
    <script>
        function confirmLogout(event) {
            event.preventDefault(); 
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = event.currentTarget.href;
            }
        }
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-dark bg-primary p-3">
        <h2 class="text-white">LMS Dashboard</h2>
        <div>
            <span class="text-white">Welcome, <i><?php echo $admin_name; ?></i> | </span>
            <a href="profile.php" class="text-white">Profile</a>
            <a href="logout.php" class="text-white" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
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
        <h2>Welcome to LMS Dashboard</h2>
        <p>Select an option from the sidebar to manage content.</p>
    </div>

</body>
</html>