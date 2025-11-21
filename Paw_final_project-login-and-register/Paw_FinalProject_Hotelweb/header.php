<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Site</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>

<nav style="
    background:#fff;
    padding:15px 20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    display:flex;
    justify-content:space-around;
    align-items:center;
    font-family:Poppins, sans-serif;
">
    <!-- LOGO -->
    <div style="font-size:20px; font-weight:600; color:#c59d5f;">
        Hotel Web
    </div>

    <!-- MENU -->
   
<ul>

    <!-- PUBLIC MENU (NOT LOGGED IN) -->
    <?php if (!isset($_SESSION['role'])) : ?>
        <li><a style="color: #c59d5f;" href="index.php">Home</a></li>
        <li><a style="color: #c59d5f;" href="#about.php">About Us</a></li>
        <li><a style="color: #c59d5f;" href="#rooms.php">Rooms</a></li>
        <li><a style="color: #c59d5f;" href="login.php">Login</a></li>
        <li><a style="color: #c59d5f;" href="register.php">Register</a></li>
    <?php endif; ?>


    <!-- LOGGED IN: SHOW HOME -->
    <?php if (isset($_SESSION['role'])) : ?>
        <li><a style="color: #c59d5f;" href="index.php">Home</a></li>
    <?php endif; ?>


    <!-- ADMIN MENU -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
        <li><a style="color: #c59d5f;" href="owner_dashboard.php">Owner Dashboard</a></li>
    <?php endif; ?>


    <!-- CUSTOMER MENU -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer') : ?>
        <li><a style="color: #c59d5f;" href="customer_dashboard.php">Customer Dashboard</a></li>
    <?php endif; ?>


    <!-- LOGOUT -->
    <?php if (isset($_SESSION['role'])) : ?>
        <li><a style="color: #c59d5f;" href="logout.php">Logout</a></li>
    <?php endif; ?>

</ul>

</nav>

<br>
