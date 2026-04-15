<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CheckoutCss.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Checkout</title>
</head>
<body>
<?php
session_start();

// Check if order placement was successful
if(isset($_SESSION['order_success']) && $_SESSION['order_success'] === true) {
    // Display the order success message
    echo "<h1>Order Placed Successfully!</h1>";
    echo "<p>Thank you for your order. We look forward to you shopping with us again soon.</p>";
    echo "<a href='http://localhost:81/my-app/Home.php' style='color: whitesmoke;'>Go to Home Page</a>";

    // Clear the shopping cart
    unset($_SESSION['shopping_cart']);
    // Clear the session variable
    unset($_SESSION['order_success']);
} else {
    // If the session variable is not set or is false, redirect to the home page
    header('Location: http://localhost:81/my-app/Home.php');
    exit();
}
?>
</body>
</html>
