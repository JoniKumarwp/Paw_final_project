<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "hotel_booking_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>