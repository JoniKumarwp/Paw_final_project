<?php
session_start();
require 'koneksi.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE name='$name' LIMIT 1");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if (isset($_SESSION['redirect_to'])) {
                $redir = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header("Location: $redir");
                exit;
            }

            if ($user['role'] === 'admin') {
                header("Location: owner_dashboard.php");
            } else {
                header("Location: customer_dashboard.php");
            }
            exit;

        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "User tidak ditemukan!";
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/Login.css">
</head>

<body>
    <div class="overlay"></div>

    <div class="login-wrapper">
        <h2>Login</h2>

        <?php if (!empty($error))
            echo "<div class='error'>$error</div>"; ?>

        <form method="post">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>

            <p style="margin-top:10px;">
                Belum punya akun?
                <a href="register.php">Register</a>
            </p>
        </form>
    </div>

</body>

</html>