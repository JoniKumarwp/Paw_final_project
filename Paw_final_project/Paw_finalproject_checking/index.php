<?php include "header.php"; ?>


<?php /* PURE DESIGN TEMPLATE - no backend yet */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hotel Homepage</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>

    <!-- HEADER -->
    <!-- <header class="header">
        <div class="container flex-between">
            <div class="logo">MyHotel</div>
            <nav class="nav">
                <a href="#rooms">Rooms</a>
                <a href="#about">About</a>
                <a href="room.php">Room Page</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header> -->

    <!-- HERO -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Find Your Perfect Stay</h1>
            <p>Modern rooms, luxury comfort, and the best locations.</p>
        </div>
    </section>

    <!-- SEARCH BOX -->
    <section class="search-section">
        <div class="container search-box">
            <input type="text" placeholder="Search City or Hotel">
            <select>
                <option>Room Type</option>
                <option>Standard</option>
                <option>Deluxe</option>
                <option>Suite</option>
            </select>
            <input type="number" placeholder="Guests">
            <button>Search</button>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="about container">
        <div class="about-left">
            <img src="https://images.unsplash.com/photo-1528909514045-2fa4ac7a08ba" alt="">
        </div>
        <div class="about-right">
            <h2>About Our Hotel</h2>
            <p>We provide modern and luxurious rooms with the best hospitality experience.</p>
            <p>Enjoy premium comfort at affordable prices.</p>
        </div>
    </section>

    <!-- ROOMS -->
    <section id="rooms" class="container rooms">
        <h2 class="section-title">Our Rooms</h2>

        <div class="room-grid">

            <!-- ROOM CARD 1 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1501117716987-c8e7f3a8f0a3" alt="">
                <div class="room-info">
                    <h3>Deluxe Room</h3>
                    <p>Beautiful interior, king bed, city view.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

            <!-- ROOM CARD 2 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750" alt="">
                <div class="room-info">
                    <h3>Suite Room</h3>
                    <p>Luxury suite with private balcony.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

            <!-- ROOM CARD 3 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb" alt="">
                <div class="room-info">
                    <h3>Standard Room</h3>
                    <p>Comfortable stay with modern lighting.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

            <!-- ROOM CARD 4 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb" alt="">
                <div class="room-info">
                    <h3>Family Room</h3>
                    <p>Spacious room for family stays.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

            <!-- ROOM CARD 5 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae" alt="">
                <div class="room-info">
                    <h3>Premium Suite</h3>
                    <p>Ultimate luxury with premium services.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

            <!-- ROOM CARD 6 -->
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750" alt="">
                <div class="room-info">
                    <h3>Executive Room</h3>
                    <p>Modern room with business workspace.</p>
                    <a href="room.php" class="btn">View Details</a>
                    <a href="room.php" class="btn2">Book Now</a>
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 MyHotel — All Rights Reserved</p>
    </footer>

</body>

</html>