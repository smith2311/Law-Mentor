<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admins WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if admin exists and the password matches
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];

        header('Location: Home.php');
        exit;
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Admin Login</h3>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                                <i class="fas fa-eye-slash" id="toggle-password" style="position: absolute; right: 10px; top: 35px; cursor: pointer;"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                            <p class="text-center mt-3">Don't have an account? <a href="Registration.php">Register here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
    // Password visibility toggle function
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    
    togglePassword.addEventListener('click', function () {
        // Toggle the type between password and text
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        
        // Toggle the eye icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>
