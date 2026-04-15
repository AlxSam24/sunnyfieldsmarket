<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StaffPageCss.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Stock</title>
    <style>
        th:nth-child(1), td:nth-child(1) {
            background-color: rgb(23, 8, 165); /* Color for first column */
        }
        th:nth-child(2), td:nth-child(2) {
            background-color: rgb(129, 18, 114); /* Color for second column */
        }
        th:nth-child(3), td:nth-child(3) {
            background-color: rgb(187, 94, 17); /* Color for third column */
        }
        th:nth-child(4), td:nth-child(4) {
            background-color: rgb(127, 12, 180); /* Color for fourth column */
        }
        .message-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: green;
            border: 2px solid white;
            padding: 20px;
            z-index: 9999;
            display: none; 
        }
        .error-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: red;
            border: 2px solid white;
            padding: 20px;
            z-index: 9999;
            display: none; 
        }
    </style>
</head>
<body>
<div class="back-button">
    <a href="http://localhost:81/my-app/staffPage.php" class="back-button">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
        <span>Back</span>
    </a>
</div>
<h2>Groceries</h2>
<p><i> For staff information to make changes to the groceries on the site, the form is located at the bottom of this table</p></i>
<form method="post" action="">
    <label for="search"><i><b>Search:</b></i></label>
    <input type="text" id="search" name="search" placeholder="Search for Stock">
    <button type="submit">Search</button>
</form>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Action</th>
    </tr>
    <?php
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "sunnyfielddata";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission for search
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $search = $_POST['search'];
        $sql = "SELECT * FROM groceries WHERE name LIKE '%$search%'";
        $result = $conn->query($sql);
    } else {
        // If no search query provided, fetch all grocery items
        $result = $conn->query("SELECT * FROM groceries");
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['grocery_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td><form method='post' action=''><input type='hidden' name='delete_id' value='" . $row['grocery_id'] . "'><button class=btn-remove type='submit' name='delete_btn'>Delete</button></form></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No groceries found</td></tr>";
    }
    ?>
</table>

<h2>Update Stock:</h2>
<form action="" method="POST" id="updateStockForm">
    <label for="grocery_name">Select Grocery Item:</label>
    <select id="grocery_name" name="grocery_name" required>
        <?php
        // Fetch all grocery items from the database
        $result = $conn->query("SELECT Name FROM groceries");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="new_quantity">Enter New Quantity:</label>
    <input type="text" id="new_quantity" name="new_quantity" required><br><br>
    <button type="submit">Update Quantity</button>
</form>

<h2>Update Price:</h2>
<form action="" method="POST" id="updatePriceForm">
    <label for="grocery_name_price">Select Grocery Item:</label>
    <select id="grocery_name_price" name="grocery_name_price" required>
        <?php
        // Fetch all grocery items from the database
        $result = $conn->query("SELECT Name FROM groceries");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
        }
        ?>
    </select><br><br>
    <label for="new_price">Enter New Price:</label>
    <input type="text" id="new_price" name="new_price" required><br><br>
    <button type="submit">Update Price</button>
</form>

<h2>Add New Grocery:</h2>
<form action="" method="POST" id="addGroceryForm">
    <label for="grocery_name">Grocery Name:</label>
    <input type="text" id="grocery_name" name="grocery_name" required><br><br>
    <label for="grocery_price">Grocery Price:</label>
    <input type="text" id="grocery_price" name="grocery_price" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity" required><br><br>
    <label for="image_path">Image Path:</label>
    <input type="text" id="image_path" name="image_path" required><br><br>
    <button type="submit">Add Grocery</button>
</form>

<?php
// Handle form submission for updating stock
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grocery_name']) && isset($_POST['new_quantity'])) {
    $groceryName = $_POST['grocery_name'];
    $newQuantity = $_POST['new_quantity'];

    // Check if new quantity is an integer
    if (!ctype_digit($newQuantity)) {
        $ErrorMessage = "Error: New quantity must be a number.";
    } else {
        // Update the quantity in the groceries table
        $stmt = $conn->prepare("UPDATE groceries SET quantity = ? WHERE name = ?");
        $stmt->bind_param("is", $newQuantity, $groceryName);

        if ($stmt->execute()) {
            $NumMessage = "Stock updated successfully.";
        } else {
            $ErrorMessage = "Error updating stock: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Handle form submission for updating price
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grocery_name_price']) && isset($_POST['new_price'])) {
    $groceryNamePrice = $_POST['grocery_name_price'];
    $newPrice = $_POST['new_price'];

    // Check if new price is a number
    if (!is_numeric($newPrice)) {
        $ErrorMessage = "Error: New price must be a number.";
    } else {
        // Update the price in the groceries table
        $stmt = $conn->prepare("UPDATE groceries SET price = ? WHERE name = ?");
        $stmt->bind_param("ds", $newPrice, $groceryNamePrice);

        if ($stmt->execute()) {
            $NumMessage = "Price updated successfully.";
        } else {
            $ErrorMessage = "Error updating price: " . $stmt->error;
        }

        $stmt->close();
    }
}


// Handle form submission for deleting grocery
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_btn']) && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Delete the grocery from the groceries table
    $stmt = $conn->prepare("DELETE FROM groceries WHERE grocery_id = ?");
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        $NumMessage = "Grocery deleted successfully.";
    } else {
        $ErrorMessage = "Error deleting grocery: " . $stmt->error;
    }

    $stmt->close();
}

// Handle form submission for adding new grocery
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grocery_name']) && isset($_POST['grocery_price']) && isset($_POST['quantity']) && isset($_POST['image_path'])) {
    $groceryName = $_POST['grocery_name'];
    $groceryPrice = $_POST['grocery_price'];
    $quantity = $_POST['quantity'];
    $imagePath = $_POST['image_path'];

    // Check if grocery name is a string
    if (!is_string($groceryName)) {
        $ErrorMessage = "Error: Grocery name entered incorrectly.";
    } elseif (!is_numeric($groceryPrice)) {
        // Check if price is a number
        $ErrorMessage = "Error: Price must be a number.";
    } elseif (!ctype_digit($quantity)) {
        // Check if quantity is an integer
        $ErrorMessage = "Error: Quantity must be a number.";
    } else {
        // Insert new grocery into the groceries table
        $stmt = $conn->prepare("INSERT INTO groceries (name, price, quantity, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $groceryName, $groceryPrice, $quantity, $imagePath);

        if ($stmt->execute()) {
            $NumMessage = "New grocery added successfully.";
        } else {
            $ErrorMessage = "Error updating stock";
        }
        
        $stmt->close();
    }
}
// Close database connection
$conn->close();
?>

<div id="message-box" class="message-box" style="display: <?php echo !empty($NumMessage) ? 'block' : 'none'; ?>"><?php echo $NumMessage; ?></div>
<div id="error-box" class="error-box" style="display: <?php echo !empty($ErrorMessage) ? 'block' : 'none'; ?>"><?php echo $ErrorMessage; ?></div>
<script>
    // Function to hide the message box after 2 seconds
    setTimeout(function(){
        document.getElementById("message-box").style.display = "none";
        document.getElementById("error-box").style.display = "none";
    }, 2000);
</script>

</body>
</html>
