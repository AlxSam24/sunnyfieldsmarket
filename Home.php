<?php
session_start();
require_once 'databaseSetUp.php';
?>


<?php

// Database connection 
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";
$conn = new mysqli($servername, $username, $password, $dbname); // establish the database connection 

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display error message if connection fails
}

$status = ""; // Variable to store the messages

// Handle adding items to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grocery_id'])) { 
    // Check if user is logged in
    if (!isset($_SESSION['user'])) { // Check if 'user' session variable is set
        $status = "You must be logged in to add items to the basket."; // Update message if user is not logged in
    } else {
        $productID = $_POST['grocery_id']; // get the grocery ID from the POST data
        $result = $conn->query("SELECT * FROM `groceries` WHERE `grocery_id`='$productID'"); // sql query to fetch the product details based on the grocery ID

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            $name = $row['name']; // Get the name of the product
            $price = $row['price']; // Get the price of the product
            $image = $row['image_path']; // Get the image path(image file) of the product
            $quantity_in_stock = $row['quantity']; // Get the quantity in stock of the product

            // Check if there's enough stock
            if ($quantity_in_stock > 0) { // Check if there is stock available
                // Check if the product is already in the basket
                if (isset($_SESSION["shopping_cart"][$productID])) { // Check if the product ID is already present in the shopping cart session 
                    // If the quantity in the basket is less than or equal to 5, prevent updating the quantity
                    if ($_SESSION["shopping_cart"][$productID]['quantity'] <= 1) { // Check if the quantity in the cart is less than or equal to 1
                        $status = "Item already in the basket!"; // Set status message if item is already in the basket
                    } else {
                        $_SESSION["shopping_cart"][$productID]['quantity'] += 1; // Increment the quantity of the product in the cart
                        $status = "Product added to your basket!"; // Set status message indicating that the product was added to the cart
                    }
                } else { // If the product is not already in the basket
                    $cartArray = array( // Create an array with product details
                        'name' => $name,
                        'grocery_id' => $productID,
                        'price' => $price,
                        'quantity' => 1,
                        'image_path' => $image
                    );

                    $_SESSION["shopping_cart"][$productID] = $cartArray; // Add the product details to the shopping cart session 
                    $status = "Product is added to your basket!"; // Set status message indicating that the product was added to the cart
                }
            } elseif ($quantity_in_stock == 0) { // Check if there is no stock available
                $status = "Not enough in stock!"; // Set status message indicating that there is not enough stock available
            } elseif ($quantity_in_stock < 5) { // Check if the stock is low (less than 5)
                $status = "Low stock!"; // Set status message indicating that the stock is low
            }
        } else { // If the query didn't return any results
            $status = "Product not found!"; // Set status message indicating that the product was not found
        }
    }
}

// Check if cart is not empty
if (!empty($_SESSION["shopping_cart"])) { // Check if the shopping cart session variable is not empty
    $cart_count = count($_SESSION["shopping_cart"]); // Count the number of items in the shopping cart
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sunny Fields Market</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="HomeCss.css">
<link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
<style>
.message-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: green;
    border: 2px solid white;
    padding: 20px;
    z-index: 9999;
    display: <?php echo isset($status) && !empty($status) ? 'block' : 'none'; ?>;
}
</style>
</head>
<body>
<a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields"><div class="logo"><img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields"></a></div>
<header>
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
  <nav>
    <li title="Home"  style=><b><a class="active" href="http://localhost:81/my-app/Home.php">Home</b></a></li>
    <li title ="About Us" ><b><a href="http://localhost:81/my-app/AboutUs.php">About Us</b></a></li>
    <li title ="Account"><b><a href="http://localhost:81/my-app/AccountLog.php">Account</b></a></li>
    <li title ="Contact"><b><a href="http://localhost:81/my-app/Contact.php">Contact</b></a></li>
    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        // Display the "Previous Orders" link
        echo '<li title="Previous Orders"><b><a href="http://localhost:81/my-app/PreviousOrders.php">Previous Orders</a></b></li>';
    }
    ?>
  </nav>
  <div class="cart_div">
    <?php if (isset($_SESSION['user'])): ?>
        <a href="http://localhost:81/my-app/basket.php"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Cart: <span><b><?php echo isset($cart_count) ? $cart_count : 0; ?></b></span></a>
    <?php endif; ?>
</div>
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
</header>

<!-- Hero Section -->
<div class="hero-image">
  <div class="hero-text">
    <h1 style="font-size:60px"><mark>Welcome to Sunny Fields Market</mark></h1>
    <h3><mark>Harvesting Happiness, One Aisle at a Time</mark></h3>
  </div>
</div>

<!-- Search Form -->
<br>
<form method="post" action="">
    <label for="search"><i><b>Search:</i></b></label>
    <input type="text" id="search" name="search" placeholder="Search for groceries">
    <button type="submit" onclick="removeTrailingSpaces()">Search</button>
    <script>
        function removeTrailingSpaces() {
            let searchInput = document.getElementById("search");
            searchInput.value = searchInput.value.trim();
            document.getElementById("demo2").innerHTML = searchInput.value;
        }
    </script>
</form>

<!-- Product Container -->
<div class="product-container">
<?php
// Display products based on search or fetch all products if no search is performed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) { // Check if the request method is POST and if the 'search' parameter is set
    $searchTerm = mysqli_real_escape_string($conn, $_POST["search"]); // Get the search term from the POST data and escape special characters
    $sql = "SELECT * FROM groceries WHERE name LIKE '%$searchTerm%'"; // Construct the SQL query to search for products based on the name
} else {
    $sql = "SELECT * FROM groceries"; // If no search term is provided, fetch all products
}

$result = $conn->query($sql); // Execute the SQL query

if ($result->num_rows > 0) { // Check if there are rows returned by the query
    while ($row = $result->fetch_assoc()) { // Loop through each row in the result set
        echo '<div class="product">'; // Start product div
        echo '<img src="' . $row["image_path"] . '" alt="' . $row["name"] . '">'; // Display product image
        echo '<div class="product-details">'; // Start product details div
        echo '<h2>' . $row["name"] . '</h2>'; // Display product name
        echo '<p>'; // Remove "Quantity" label
        if ($row["quantity"] <= 0) { // Check if the quantity is zero
            echo '<span class="no-stock">NO STOCK</span>'; // Display "NO STOCK" message
        } elseif ($row["quantity"] <= 5) { // Check if the quantity is less than or equal to 5
            echo '<span class="low-stock">Low stock</span>'; // Display "Low stock" message
        } else { // If the quantity is greater than 5
            echo '<span class="in-stock">In Stock</span>'; // Display "In Stock" message
        }
        echo '</p>'; // Close "Quantity" paragraph
        echo '<p><b>Price: £' . $row["price"] . '</b></p>'; // Display product price
        echo '</div>'; // Close product details div
        echo '<form method="post" action="">'; // Start form for adding to cart
        echo '<input type="hidden" name="grocery_id" value="' . $row["grocery_id"] . '">'; // Hidden input field for product ID
        if ($row["quantity"] > 0) { // Check if the product is in stock
            echo '<button class="add-to-basket" type="submit"><i class="basket-button">🛒</i>Add to Basket</button>'; // Display "Add to Basket" button
        }
        echo '</form>'; // Close form
        echo '</div>'; // Close product div
    }
} else { // If no rows are returned by the query
    echo '<p>No results found.</p>'; // Display "No results found" message
}
?>
</div>

<div style="clear:both;"></div>

<!-- Message Box -->
<div id="message-box" class="message-box"><?php echo $status; ?></div>

<hr style="height:2px;border-width:0;color:gray;background-color:white">

<!-- Footer Section -->
<footer>
    <div class="text-only-nav">
        <nav>
            <li style="text-align: right;">© <date>2023</date> Sunny Fields Market ltd. All Rights Reserved</li>
            <li><a style ="text-align: right;" href="http://localhost:81/my-app/privacyPolicy.php">Privacy Policy</a></li>
        </nav>
    </div>
</footer>

<script>
    // Function to hide the message box after 2 seconds
    setTimeout(function(){
        document.getElementById("message-box").style.display = "none";
    }, 2000);
</script>

</body>
</html>