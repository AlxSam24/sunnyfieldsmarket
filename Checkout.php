<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Retrieve user details from session
    $user = $_SESSION['user_details'];
    $customerId = $user['user_id'];
    $fullName = $user['fullname'];
    $email = $user['email'];
} else {
    // If user is not logged in, redirect to login page
    header('Location: http://localhost:81/my-app/Account.php');
    exit();
}

// Calculate total price and total quantity
$total_price = 0;
$total_quantity = 0;
if(isset($_SESSION['shopping_cart'])) {
    foreach ($_SESSION['shopping_cart'] as $product) {
        $total_price += $product['price'] * $product['quantity'];
        $total_quantity += $product['quantity'];
    }
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $address = $_POST['address'];
    $postcode = $_POST['postcode']; 
    $cardNumber = $_POST['cardnumber']; 
    $expiryMonth = $_POST['expmonth'];
    $expiryYear = $_POST['expyear'];
    $cvv = $_POST['cvv'];

    // Hash the card number (You should use a stronger hashing algorithm and never store plain card numbers)
    $hashedCardNumber = hash('sha256', $cardNumber);

    // Insert data into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (order_date, order_total, customer_id, address, postcode, card_number, expiry_month, expiry_year, cvv) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("dsssssss", $total_price, $customerId, $address, $postcode, $hashedCardNumber, $expiryMonth, $expiryYear, $cvv);

    if ($stmt->execute()) {
        // Retrieve the order ID of the inserted order
        $order_id = $stmt->insert_id;

        // Update the quantity of each product in the grocery table
        foreach ($_SESSION['shopping_cart'] as $product) {
            $grocery_id = $product['grocery_id'];
            $quantity = $product['quantity'];
            
            // Update the quantity in the grocery table
            $stmt_update = $conn->prepare("UPDATE groceries SET quantity = quantity - ? WHERE grocery_id = ?");
            $stmt_update->bind_param("ii", $quantity, $grocery_id);
            $stmt_update->execute();
            $stmt_update->close();
            
            // Insert into the order_product table
            $stmt_insert_order_product = $conn->prepare("INSERT INTO order_product (grocery_id, quantity, order_id) VALUES (?, ?, ?)");
            $stmt_insert_order_product->bind_param("iii", $grocery_id, $quantity, $order_id);
            $stmt_insert_order_product->execute();
            $stmt_insert_order_product->close();
        }

        echo "Order placed successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $_SESSION['order_success'] = true;

    // Redirect to Order_Success.php
    header('Location: http://localhost:81/my-app/Order_process.php');
    exit();

    $stmt->close();
}

// Close database connection
$conn->close();
$_SESSION['order_success'] = true;

?>

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
<header>
    <div class="back-button">
        <a href="http://localhost:81/my-app/basket.php" class="back-button">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <span>Back to basket</span>
        </a>
    </div>
</header>

<div class="row">
    <div class="col-75">
        <div class="container">
            <form method="post" action="">
                <div class="row">
                    <div class="col-50">
                        <h3>Billing Address</h3>
                        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        <input type="text" id="fname" name="firstname" placeholder="John M. Doe" value="<?php echo $fullName; ?>" readonly>
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input type="text" id="email" name="email" placeholder="john@example.com" value="<?php echo $email; ?>" readonly>
                        <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                        <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required>
                        <label for="city"><i class="fa fa-institution"></i> City</label>
                        <input type="text" id="city" name="city" placeholder="New York" required>

                        <div class="row">
                            <div class="col-50">
                                <label for="state">County</label>
                                <input type="text" id="County" name="state" placeholder="Greater London" required>
                            </div>
                            <div class="col-50">
                                <label for="postcode">Zip</label>
                                <input type="text" name="postcode" id="postcode" pattern="[A-Za-z]{2}[0-9]{2} [0-9][A-Za-z]{2}" title="Please enter a postcode in the format LLNN NLL" placeholder="LLNN NLN" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Payment</h3>
                        <label for="fname">Accepted Cards</label>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:navy;"></i>
                            <i class="fa fa-cc-amex" style="color:blue;"></i>
                            <i class="fa fa-cc-mastercard" style="color:red;"></i>
                            <i class="fa fa-cc-discover" style="color:orange;"></i>
                        </div>
                        <label for="cname">Name on Card</label>
                        <input type="text" id="cname" name="cardname" placeholder="John More Doe" required>
                        <label for="ccnum">Credit card number</label>
                        <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" maxlength="16" required>
                        <label for="expmonth">Exp Month</label>
                        <input type="text" id="expmonth" name="expmonth" placeholder="September" maxlength="9" required>
                        <div class="row">
                            <div class="col-50">
                                <label for="expyear">Exp Year</label>
                                <input type="text" id="expyear" name="expyear" placeholder="2018" maxlength="4" required>
                            </div>
                            <div class="col-50">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="352" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                </div>
                <label>
                    <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                </label>
                <input type="submit" value="Complete order" class="btn">
            </form>
        </div>
    </div>
    <div class="col-25">
        <div class="container">
            <h4>Cart <span class="price" style="color:whitesmoke"><i class="fa fa-shopping-cart"></i> <b><?php echo $total_quantity; ?></b></span></h4>
            <?php foreach ($_SESSION['shopping_cart'] as $product): ?>
                <div class=BasketInfo><p><?php echo $product['name']; ?> <span class="price"><?php echo "£" . $product['price']; ?></span><span class="quantity"> x<?php echo $product['quantity']; ?></span></p></div>
            <?php endforeach; ?>
            <hr>
            <p>Total <span class="price" style="color:whitesmoke"><b>£<?php echo number_format($total_price, 2); ?></b></span></p>
        </div>
    </div>
</div>

</body>
</html>
