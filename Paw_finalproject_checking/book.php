<?php
session_start();
require 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = "pemesanan.php?id_kamar=" . $_GET['id_kamar'];
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id_kamar'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    hanya contoh
</body>

</html>