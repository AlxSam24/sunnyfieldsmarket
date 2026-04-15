<?php
session_start();//starts the session
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="PreviousOrders.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Previous Orders</title>
</head>
<body> 
    <a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields">
        <img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields">
    </a>
    <header>
        <hr style="height:2px;border-width:0;color:gray;background-color:white">
        <nav>
            <li title="Home"><b><a class="active" href="http://localhost:81/my-app/Home.php">Home</b></a></li>
            <li title="About Us"><b><a href="http://localhost:81/my-app/AboutUs.php">About Us</b></a></li>
            <li title="Account"><b><a href="http://localhost:81/my-app/AccountLog.php">Account</b></a></li>
            <li title="Contact"><b><a href="http://localhost:81/my-app/Contact.php">Contact</b></a></li>
            <li title="Previous Orders"><b><a href="http://localhost:81/my-app/PreviousOrders.php">Previous Orders</a></b></li>
        </nav>
        <hr style="height:2px;border-width:0;color:gray;background-color:white">
    </header>

    <section>
        <?php
        if (isset($_SESSION['user'])) {
            // Connect to the database
            $server = "localhost";
            $username = "root";
            $password = "root";
            $database = "sunnyfielddata";
            $conn = new mysqli($server, $username, $password, $database);

            // Check for connection errors
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve orders associated with the logged-in customer
            $user = $_SESSION['user_details']; // Retrieve customer ID from session
            $customerId= $user['user_id'];
            $stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ?");//select customer orders from the customer orders database with the customer id of the logged in user 
            $stmt->bind_param("s", $customerId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display orders in a table
            if ($result->num_rows > 0) {
                echo "<h2>Previous Orders</h2>";
                echo "<table>";
                echo "<tr><th>Order Number</th><th>Date</th><th>Total Price Of the Order</th><th>Order Details </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";//code which outputs all of the customers order details
                    echo "<td>" . $row['orderID'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>£" . $row['order_total'] . "</td>";
                    echo "<td>";
                    $order_id = $row["orderID"];
                    $order_product_sql = "SELECT * FROM order_product WHERE order_id = $order_id";//selects the products ordered by the customer and adds it to the order table on the webpage
                    $order_product_result = $conn->query($order_product_sql);
                    if ($order_product_result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><th>Grocery Name</th><th>Quantity</th></tr>";
                        while($order_product_row = $order_product_result->fetch_assoc()) {
                            $grocery_id = $order_product_row["grocery_id"];
                            $grocery_sql = "SELECT name FROM groceries WHERE grocery_id = $grocery_id";// sql command to get the groceries name from the groceries table based on the grocery id from the order_product table 
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
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No previous orders found.";
            }

            // Close the database connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Please log in to view previous orders.";
        }
        ?>
    </section>
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

    <hr style="height:2px;border-width:0;color:gray;background-color:white">

    <footer>
        <div class="text-only-nav">
            <nav>
                <li style="text-align: right;">© <date>2023</date> Sunny Fields Market ltd. All Rights Reserved</li>
                <li><a style ="text-align: right;" href="http://localhost:81/my-app/privacyPolicy.php">Privacy Policy</a></li>
            </nav>
        </div>
    </footer>
</body>
</html>
