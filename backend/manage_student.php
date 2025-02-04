<?php
session_start();
include 'db.php'; // Include database connection

$admin_name = isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin';

// Fetch all users from the database
$sql = "SELECT id, full_name, enrollment, phone, email, password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Dashboard</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }
        .sidebar a:hover {
            background-color: #1abc9c;
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
    <div class="main-content" style="margin-left: 270px; padding: 20px;">
        <h2 class="text-center mb-4">Student Details</h2>

        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-dark text-white">
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Enrollment</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['enrollment']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['password']); ?></td>
                        <td>
                        <a href="edit_users.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                        <i class="fas fa-trash-alt"></i> Delete
                        </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
