<?php
session_start();
require 'koneksi.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['last_booking_id'])) {
    header('Location: customer_dashboard.php');
    exit;
}

$booking_id = (int) $_SESSION['last_booking_id'];

$sql = "SELECT b.*, u.name AS user_name 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        WHERE b.id = $booking_id";
$result = mysqli_query($conn, $sql);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    echo "<p>Booking not found!</p>";
    exit;
}

$sql_rooms = "SELECT br.*, r.title, r.city 
              FROM booking_rooms br
              JOIN rooms r ON br.room_id = r.id
              WHERE br.booking_id = $booking_id";
$result_rooms = mysqli_query($conn, $sql_rooms);
$rooms = mysqli_fetch_all($result_rooms, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_method'])) {
    $pay_method = mysqli_real_escape_string($conn, $_POST['pay_method']);
    $amount = $booking['total_amount'];

    $sql_payment = "INSERT INTO payments 
        (booking_id, amount, method, status, created_at)
        VALUES ($booking_id, $amount, '$pay_method', 'pending', NOW())";

    if (mysqli_query($conn, $sql_payment)) {
        mysqli_query($conn, "UPDATE bookings SET status='pending' WHERE id=$booking_id");

        unset($_SESSION['last_booking_id']);
        $_SESSION['payment_success'] = "Payment recorded via $pay_method!";
        header('Location: customer_dashboard.php');
        exit;
    } else {
        $error = "Payment failed: " . mysqli_error($conn) . " | Query: $sql_payment";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/payment.css">
</head>

<body>
    <div class="payment-wrapper">
        <div class="payment-header">
            <h1>Payment</h1>
            <p>Booking Code: <strong><?php echo htmlspecialchars($booking['booking_code']); ?></strong></p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="payment-card">
            <h2>Booking Summary</h2>
            <ul>
                <?php foreach ($rooms as $room): ?>
                    <li>
                        <span><?php echo htmlspecialchars($room['title']) . " (" . htmlspecialchars($room['city']) . ")"; ?></span>
                        <span>Rp <?php echo number_format($room['subtotal']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="total-amount">Total: Rp <?php echo number_format($booking['total_amount']); ?></div>

            <form method="post">
                <div class="payment-methods">
                    <label><input type="radio" name="pay_method" value="Bank Transfer" required> Bank Transfer</label>
                    <label><input type="radio" name="pay_method" value="QRIS"> QRIS</label>
                    <label><input type="radio" name="pay_method" value="Gopay"> Gopay</label>
                    <label><input type="radio" name="pay_method" value="Cash"> Pay At Hotel Kasir</label>
                </div>
                <button type="submit" class="btn-pay">Confirm Payment</button>
            </form>
        </div>
    </div>
</body>

</html>