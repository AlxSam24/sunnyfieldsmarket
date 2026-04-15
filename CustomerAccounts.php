<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StaffPageCss.css">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sunny Fields Market Customer Accounts</title>
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
    </style>
</head>
<body>
<header>
    <div class="back-button">
        <a href="http://localhost:81/my-app/staffPage.php" class="back-button">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            <span>Back to Staff Page</span>
        </a>
    </div>
</header>

<div class="container">
    <h2>Customer Accounts</h2>
    <form method="post" action="">
        <label for="search"><i><b>Search:</b></i></label>
        <input type="text" id="search" name="search" placeholder="Search for Accounts">
        <button type="submit">Search</button>
    </form>
    <br>
    <table>
        <tr>
            <th>User ID</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Password Hash</th>
            <th>Full Name</th>
            <th>Change Password</th>
        </tr>
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

// Check if the form is submitted and if the "search" field is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    // Get the search input
    $search = $_POST["search"];
    
    // Fetch customer accounts data from the database based on search input
    $sql = "SELECT * FROM customers WHERE email LIKE '%$search%' OR fullname LIKE '%$search%'";
    $result = $conn->query($sql);
} else {
    // Fetch all customer accounts data from the database
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["birthdate"] . "</td>";
        echo "<td>" . $row["password_hash"] . "</td>";
        echo "<td>" . $row["fullname"] . "</td>";
        echo "<td>";
        if(isset($_POST['new_password']) && isset($_POST['user_id']) && $_POST['user_id'] == $row['user_id']) {
            // Update the password in the database
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE customers SET password_hash = '$hashed_password' WHERE user_id = " . $row['user_id'];
            if ($conn->query($update_sql) === TRUE) {
                echo "Password updated successfully";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
            echo "<input type='password' name='new_password' placeholder='New Password' required>";
            echo "<button type='submit'>Change</button>";
            echo "</form>";
        }
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No customer accounts found</td></tr>";
}
$conn->close();
?>


    </table>
</div>

</body>
</html>
