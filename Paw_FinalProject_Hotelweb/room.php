<?php /* PURE DESIGN TEMPLATE */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Room Details</title>
<link rel="stylesheet" href="./assets/style.css">
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="container flex-between">
        <div class="logo">MyHotel</div>
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="#rooms">Rooms</a>
        </nav>
    </div>
</header>

<!-- ROOM HERO -->
<section class="room-hero">
    <div class="room-hero-overlay"></div>
    <h1>Deluxe Luxury Room</h1>
</section>

<!-- ROOM DETAILS -->
<section class="container room-details">

    <div class="room-images">
        <img src="./upload/photo-1.jpeg" class="main-img">
        <div class="thumb-row">
            <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb">
            <img src="https://images.unsplash.com/photo-1505691723518-36a3b43f2c27">
            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2">
        </div>
    </div>

    <div class="room-info-box">
        <h2>Room Description</h2>
        <p>Spacious deluxe room with king-size bed, modern lighting, premium furniture, and panoramic city view.</p>

        <h3>Amenities</h3>
        <ul class="amenities">
            <li>✔ Free Wi-Fi</li>
            <li>✔ King Bed</li>
            <li>✔ Air Conditioning</li>
            <li>✔ Smart TV</li>
            <li>✔ Balcony View</li>
        </ul>

        <div class="price-box">
            <strong>$120</strong> / night
        </div>

        <button class="btn book-btn">Book Now</button>
    </div>

</section>

<!-- FOOTER -->
<footer class="footer">
    <p>© 2025 MyHotel — All Rights Reserved</p>
</footer>

</body>
</html>
