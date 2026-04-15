<?php
session_start();
$status = "";

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the action is to remove an item from the cart
if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        $keyToRemove = $_POST["code"];
        if (isset($_SESSION["shopping_cart"][$keyToRemove])) {
            unset($_SESSION["shopping_cart"][$keyToRemove]);
            $status = "<div class='box' style='color:whitesmoke;'>Product is removed from your cart!</div>";
        } else {
            $status = "<div class='box' style='color:whitesmoke;'>Product not found in your cart!</div>";
        }
    }
}

// Check if the action is to change the quantity of an item in the cart
if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['grocery_id'] === $_POST["grocery_id"]) {
            $value['quantity'] = $_POST["quantity"];
            break; // Stop the loop after we've found the product
        }
    }
}

// Clear all items from the cart
if (isset($_POST['clear_cart'])) {
    unset($_SESSION["shopping_cart"]);
    $status = "<div class='box' style='color:whitesmoke;'>Your cart is cleared!</div>";
}

// Retrieve stock quantity of each product from groceries table
$stock_quantities = [];
$sql = "SELECT grocery_id, quantity FROM groceries";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $stock_quantities[$row["grocery_id"]] = $row["quantity"];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="HomeCss.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Basket</title>
</head>
<body>
<header>
    <div class=back-button>
        <a href="http://localhost:81/my-app/Home.php" class="back-button">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </div>
</header>
<div class="cart">
    <?php
    if (isset($_SESSION["shopping_cart"])) {
        $total_price = 0;
        ?>
        <table class="table">
            <tbody>
            <tr>
                <td></td>
                <td>Item Name</td>
                <td>Quantity</td>
                <td>Item Price</td>
                <td>Subtotal:</td>
            </tr>
            <?php
            // Loop through each product in the shopping cart
            foreach ($_SESSION["shopping_cart"] as $productKey => $product) {
                // Get the grocery ID and stock quantity of the product
                $grocery_id = $product['grocery_id'];
                $stock_quantity = isset($stock_quantities[$grocery_id]) ? $stock_quantities[$grocery_id] : 0;
                // Determine whether the quantity selector should be disabled based on stock quantity
                $disabled = ($stock_quantity <= 5) ? "disabled" : "";
                ?>
                <tr>
                    <td>
                        <img src='<?php echo $product["image_path"]; //Ouptuts the grocery image in the basket?>' width="50" height="40" />
                    </td>
                    <td><?php echo $product["name"]; ?><br />
                        <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $productKey; ?>" />
                            <input type='hidden' name='action' value="remove" />
                            <button type='submit' class='remove'>Remove Item</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='grocery_id' value="<?php echo $product["grocery_id"]; ?>" />
                            <input type='hidden' name='action' value="change" />
                            <?php if ($disabled): ?>
                                <select name='quantity' class='quantity' disabled>
                                    <option selected="selected"><?php echo $product["quantity"]; ?></option>
                                </select>
                                <span class='low-stock-message'>Low Stock: Only one can be purchased.</span>
                            <?php else: ?>
                                <select name='quantity' class='quantity' onChange="this.form.submit()">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo "<option " . ($product["quantity"] == $i ? "selected" : "") . " value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td><?php echo "£" . number_format($product["price"], 2);//displays total price of one item  ?></td>
                    <td><?php echo "£" . number_format($product["price"] * $product["quantity"], 2);//displpays the subtotal the product  ?></td>
                </tr>
                <?php
                $total_price += ($product["price"] * $product["quantity"]);//Calcualtes the total price 
            }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <strong>Total: <?php echo "£" . number_format($total_price, 2);//displays the total price ?></strong>
                </td>
            </tr>
            </tbody>
        </table>
        <form method="post" action="">
            <button type="submit" name="clear_cart" class="clear-cart">Clear Cart</button>
        </form>
        <a href="http://localhost:81/my-app/Checkout.php" class="checkout-button">
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
            <span>Continue to Checkout</span>
            <?php
        } else {
            echo "<h3>Your cart is empty!</h3>";
        }
        ?>
</div>
<div style="clear:both;"></div>
<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
</body>
</html>
