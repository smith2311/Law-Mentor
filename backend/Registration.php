<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password']; 
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));

    if (!empty($username) && !empty($email) && !empty($password) && !empty($phone_number)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (preg_match('/^\d{10}$/', $phone_number)) { // Validates exactly 10-digit numbers
                if (strlen($password) >= 8 &&
                    preg_match('/[A-Z]/', $password) &&
                    preg_match('/[a-z]/', $password) &&
                    preg_match('/[0-9]/', $password) &&
                    preg_match('/[\W]/', $password)) {
                    
                    // Check if email already exists
                    $checkEmail = $conn->prepare("SELECT COUNT(*) FROM admins WHERE email = :email");
                    $checkEmail->execute(['email' => $email]);
                    if ($checkEmail->fetchColumn() > 0) {
                        echo "<script>alert('Email already registered. Please use a different email.');</script>";
                    } else {

                        $sql = "INSERT INTO admins (username, email, password, phone_number) VALUES (:username, :email, :password, :phone_number)";
                        $stmt = $conn->prepare($sql);

                        try {
                            $stmt->execute([
                                'username' => $username,
                                'email' => $email,
                                'password' => $password,
                                'phone_number' => $phone_number
                            ]);
                            echo "<script>alert('Registration Successful'); window.location.href='login.php';</script>";
                        } catch (PDOException $e) {
                            error_log($e->getMessage(), 3, 'errors.log');
                            echo "<script>alert('An unexpected error occurred. Please try again later.');</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Password must be at least 8 characters long and include uppercase, lowercase, a number, and a special character.');</script>";
                }
            } else {
                echo "<script>alert('Invalid phone number. It must be exactly 10 digits.');</script>";
            }
        } else {
            echo "<script>alert('Invalid email format');</script>";
        }
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Admin Registration</h3>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" id="phone_number" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                            <p class="text-center mt-3">Already registered? <a href="Login.php">Login here</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
