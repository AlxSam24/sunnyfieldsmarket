<?php
session_start();

// Check if the staff is logged in
if (!isset($_SESSION['staff_name'])) {
    header("Location: Account.php"); // Redirect to login page if not logged in
    exit();
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variable to store success message
$successMessage = "";
// Variable to store error message
$error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email confirmation matches
    if ($_POST['email'] != $_POST['confirm_email']) {
        $error = "Email confirmation does not match.";
    }
    // Check if password confirmation matches
    elseif ($_POST['password'] != $_POST['confirm_password']) {
        $error = "Password confirmation does not match.";
    } else {
        // If no error, proceed with adding staff member
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $address = $_POST['address'];
        $postcode = $_POST['postcode'];
        $dob = $_POST['dob'];

        $sql = "INSERT INTO staff (Name, Email, staff_password, Address, Postcode, DateOfBirth) VALUES ('$name', '$email', '$password', '$address', '$postcode', '$dob')";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "New staff member added successfully.";
        } else {
            $error = "Error adding new staff member: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StaffPageCss.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Staff Home</title>
</head>
<body>
<div class='logged-in'>Logged in as: <?php echo $_SESSION['staff_name']; ?></div>

<h1>Staff Home</h1>
<h2>Store Stock Table</h2>
<div class=Stock-Link>
        <a href="http://localhost:81/my-app/StockTable.php" class="Stock-Link">
            <span>Store Stock</span>
        </a>
    </div>
<hr>
<h2>The Store Orders Table </h2>
<div class=Stock-Link>
        <a href="http://localhost:81/my-app/OrdersTable.php" class="Stock-Link">
            <span>Store Orders</span>
        </a>
    </div>
<hr>
<h2>Customer Accounts</h2>
<div class=Stock-Link>
        <a href="http://localhost:81/my-app/CustomerAccounts.php" class="Stock-Link">
            <span>Customer Accounts</span>
        </a>
    </div>
<hr>
<h2>Customer Accounts</h2>
<div class=Stock-Link>
        <a href="http://localhost:81/my-app/CustomerFeedback.php" class="Stock-Link">
            <span>Customer Feedback and Questions</span>
        </a>
    </div>
<hr>

<h2>Add New Staff Member</h2>
<!-- Display success message in a message box -->
<?php if (!empty($successMessage)): ?>
    <div class="message-box"><?php echo $successMessage; ?></div>
<?php endif; ?>
<!-- Display error message in a message box -->
<?php if (!empty($error)): ?>
    <div class="error-box"><?php echo $error; ?></div>
<?php endif; ?>
<form method="post" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required><br><br>

    <label for="confirm_email">Confirm Email:</label>
    <input type="email" id="confirm_email" name="confirm_email" value="<?php echo isset($_POST['confirm_email']) ? htmlspecialchars($_POST['confirm_email']) : ''; ?>" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required><br><br>

    <label for="postcode">Postcode:</label>
    <input type="text" id="postcode" name="postcode" value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode']) : ''; ?>" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required><br><br>
    
    <input type="submit" value="Add Staff Member">
</form>
<hr>
<?php
// Display existing staff members for removal
echo "<h2>Remove Staff Member:</h2>";
echo "<table>";
echo "<tr><th>Staff ID<th>Name</th><th>Email</th><th>Action</th></tr>";
$stmt = $conn->query("SELECT * FROM staff WHERE Name != '{$_SESSION['staff_name']}'");
while ($row = $stmt->fetch_assoc()) {
    echo "<tr>";
    echo "<td>". $row['staffID']."</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td><button class='btn-remove' onclick=\"confirmRemoval(" . $row['staffID'] . ")\">Remove</button></td>";
    echo "</tr>";
}
echo "</table>";

$conn->close(); // Close database connection
?>

<script>
    function confirmRemoval(staffID) {
        if (confirm("Are you sure you want to remove this staff member?")) {
            window.location.href = "remove_staff.php?id=" + staffID;
            // After redirection, display a message
        }
    }
</script>

<br>
<form action="logout.php" method="post">
    <button type="submit" name="logout">Logout</button>
</form>
</body>
</html>
