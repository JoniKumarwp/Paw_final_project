<?php include "header.php"; ?>

<?php

// If not logged in → go to login
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// If customer tries to open owner page → block
if ($_SESSION['role'] !== 'admin') {
    header("Location: customer_dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
 

</body>
</html>