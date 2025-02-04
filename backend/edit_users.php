<?php
session_start();
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request");
}

$id = $_GET['id'];

// Fetch user details using PDO
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="container mt-5">

<h2 class="text-center">Edit User</h2>

<form action="update_user.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <div class="mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="enrollment" class="form-label">Enrollment</label>
        <input type="text" class="form-control" name="enrollment" value="<?php echo htmlspecialchars($user['enrollment']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <input type="password" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
            <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update User</button>
    <a href="manage_student.php" class="btn btn-secondary">Cancel</a>
</form>

<script>
    // Password visibility toggle function
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');
    
    togglePassword.addEventListener('click', function () {
        // Toggle the type between password and text
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        
        // Toggle the eye icon
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
</script>

</body>
</html>
