<?php
session_start();
$conn = new mysqli("localhost", "root", "", "adiva");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitize input
    $password = md5($_POST['password']);  // Ensure the password is properly hashed

    // Check the credentials
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    // If login is successful
    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $username; // Store session for admin
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Login Admin</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
                <button type="button" class="btn" onclick="redirectToHome()">Pembeli</button>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            </form>
        </div>
    </div>

    <script>
        function redirectToHome() {
            window.location.href = 'home.php';
        }
    </script>
</body>
</html>
