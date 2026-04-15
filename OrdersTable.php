<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to delete order
function deleteOrder($conn, $orderId) {
    $sql = "DELETE FROM orders WHERE orderID = $orderId";
    if ($conn->query($sql) === TRUE) {
        return "Order deleted successfully"; // Return success message
    } else {
        return "Error deleting order: " . $conn->error; // Return error message
    }
}

// Check if delete button is clicked
if(isset($_POST["btn_delete"])) {
    $orderIdToDelete = $_POST["order_id"];
    $deleteMessage = deleteOrder($conn, $orderIdToDelete); // Get the message from the function
    if (strpos($deleteMessage, "Error") !== false) {
        $OrderError = $deleteMessage; // Set error message
    } else {
        $OrderSuccess = $deleteMessage; // Set success message
    }
}

// Fetch orders data from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StaffPageCss.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Orders</title>
    <style>
         table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: rgb(57,57,57);
            color: white;
        }
        tr:hover {
            background-color: #575757;
        }
        .order-details {
            display: none;
        }
        .order-details.active {
            display: block;
        }
        .order-details table {
            border-collapse: collapse;
            width: 100%;
        }
        .order-details th, .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .order-details th {
            background-color: rgb(57,57,57);
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
<header>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StaffPageCss.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Orders</title>
    <div class="back-button">
        <a href="http://localhost:81/my-app/staffPage.php" class="back-button">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <span>Back to Staff Page</span>
        </a>
    </div>
</header>

<div class="container">
    <h2>Orders</h2>
    <p><i>Make sure once orders have been delivered to delete them</i></p>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Total Price</th>
            <th>Customer ID</th>
            <th>Address</th>
            <th>Postcode</th>
            <th>Order Details</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["orderID"] . "</td>";
                echo "<td>" . $row["order_date"] . "</td>";
                echo "<td>" . $row["order_total"] . "</td>";
                echo "<td>" . $row["customer_id"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["postcode"] . "</td>";
                echo "<td><button class='detail-btn'>Show Details</button>";
                echo "<div class='order-details'>";
                
                $order_id = $row["orderID"];
                $order_product_sql = "SELECT * FROM order_product WHERE order_id = $order_id";
                $order_product_result = $conn->query($order_product_sql);
                
                if ($order_product_result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Grocery Name</th><th>Quantity</th></tr>";
                    while($order_product_row = $order_product_result->fetch_assoc()) {
                        $grocery_id = $order_product_row["grocery_id"];
                        $grocery_sql = "SELECT name FROM groceries WHERE grocery_id = $grocery_id";
                        $grocery_result = $conn->query($grocery_sql);
                        if ($grocery_result->num_rows > 0) {
                            $grocery_row = $grocery_result->fetch_assoc();
                            $grocery_name = $grocery_row["name"];
                            echo "<tr><td>" . $grocery_name . "</td><td>" . $order_product_row["quantity"] . "</td></tr>";
                        }
                    }
                    echo "</table>";
                } else {
                    echo "No order details found.";
                }
                
                echo "</div></td>";
                echo "<td><form method='post' action='".$_SERVER["PHP_SELF"]."'>";
                echo "<input type='hidden' name='order_id' value='" . $row["orderID"] . "'/>";
                echo "<button class='btn-remove' type='submit' name='btn_delete'>Delete</button></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No orders found</td></tr>";
        }
        ?>
    </table>
</div>

<script>
    // Toggle order details visibility
    var toggleButtons = document.querySelectorAll('.detail-btn');
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var details = this.parentElement.querySelector('.order-details');
            details.classList.toggle('active');
            if (details.classList.contains('active')) {
                this.textContent = 'Hide Details';
            } else {
                this.textContent = 'Show Details';
            }
        });
    });
</script>
<div id="message-box" class="message-box" style="display: <?php echo !empty($OrderSuccess) ? 'block' : 'none'; ?>"><?php echo $OrderSuccess; ?></div>
<div id="error-box" class="error-box" style="display: <?php echo !empty($OrderError) ? 'block' : 'none'; ?>"><?php echo $OrderError; ?></div>
<script>
    // Function to hide the message box after 2 seconds
    setTimeout(function(){
        document.getElementById("message-box").style.display = "none";
        document.getElementById("error-box").style.display = "none";
    }, 2000);
</script>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
