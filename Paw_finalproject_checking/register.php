<?php
session_start();
require 'koneksi.php';

$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = 'customer';


    $cek = mysqli_query($conn, "SELECT * FROM users WHERE name='$name' LIMIT 1");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $hash, $role);

        if ($stmt->execute()) {
            $success = "Registrasi berhasil! Silakan login.";
            header("Refresh: 2; url=login.php");
        } else {
            $error = "Gagal menyimpan data.";
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/Login.css">
</head>

<body>
    <div class="overlay"></div>

    <div class="login-wrapper">
        <h2>Register</h2>

        <?php
        if (!empty($error)) {
            echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
        }

        if (!empty($success))
            echo '<p style="color:green;">' . htmlspecialchars($success) . '</p>';
        ?>

        <form method="post">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <button type="submit">Daftar</button>

            <p style="margin-top:10px;">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </form>
    </div>
    </main>
</body>

</html>