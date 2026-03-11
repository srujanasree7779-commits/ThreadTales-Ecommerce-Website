<?php
include 'db.php';

if(isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($check->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {

        $conn->query("INSERT INTO users (name, email, password)
                      VALUES ('$name', '$email', '$password')");

        echo "<script>alert('Registration Successful! Please Login'); window.location='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="register" class="auth-btn">Register</button>
        </form>

        <a href="login.php" class="auth-link">
            Already have account? Login
        </a>
    </div>
</div>
</body>
</html>