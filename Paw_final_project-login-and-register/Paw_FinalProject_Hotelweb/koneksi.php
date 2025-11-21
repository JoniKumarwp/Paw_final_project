<?php

$conn = mysqli_connect('localhost', 'root', '', 'hotel_booking');
if (!$conn) {
    echo "koneksi error";
}