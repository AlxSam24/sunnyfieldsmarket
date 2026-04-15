<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Account.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Sign in to your account</title>
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
        </nav>
        <hr style="height:2px;border-width:0;color:gray;background-color:white">
    </header>
    <hr style="height:2px;border-width:0;color:gray;background-color:white">
    <!-- Sign in form -->
    <div class="container">
        <h2>Sign in</h2>
        <form action="" method="post">
            <label for="username">Email:</label>
            <input type="text" id="email" name="email" required>
            <div class="password-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
                <div class="show-hide-btn" onclick="togglePasswordVisibility()">Show</div>
            </div>
            <input type="submit" value="Submit">
            <p style="font-family:Arial, sans-serif; color:whitesmoke;"> New to Sunny Fields Market?</p>       
            <a href="http://localhost:81/my-app/Registerpage.php" class="register-button"><b> Register</b></a>
        </form>
    </div>
    <?php
//Sets up the databse conection 
$server = "localhost";
$username = "root";
$password = "root";
$database = "sunnyfielddata";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Perform user authentication against the customers and staff tables
    $customerStmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $customerStmt->bind_param("s", $email);
    $customerStmt->execute();
    $customerResult = $customerStmt->get_result();

    $staffStmt = $conn->prepare("SELECT * FROM staff WHERE Email = ?");
    $staffStmt->bind_param("s", $email);
    $staffStmt->execute();
    $staffResult = $staffStmt->get_result();

    if ($customerResult->num_rows > 0) {
        $user = $customerResult->fetch_assoc();

        // Verify the hashed password
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = $email;
            header('Location: AccountLog.php'); // Redirect to the main page after successful login
            exit();
        } else {
            echo '<p style=color:red><b>Invalid password</b></p>';
        }
    } elseif ($staffResult->num_rows > 0) {
        $user = $staffResult->fetch_assoc();

        // Verify the hashed password for staff members
        if (password_verify($password, $user['Staff_Password'])) {
            // Store the staff member's name in the session
            $_SESSION['staff_name'] = $user['Name'];

            // Redirect staff to a different page
            header('Location: StaffPage.php');
            exit();
        } else {
            echo '<p style=color:red><b>Invalid password</b></p>';
        }
    } else {
        echo '<p style = color:red><b>User not found</b></p>';
    }

    $customerStmt->close();
    $staffStmt->close();
}

// Close the database connection 
?>


<script>
//This code is for the show and hide password function to allow users to see the password they are typing 
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var showHideBtn = document.querySelector(".show-hide-btn");

    if (passwordInput.type === "password") {
         passwordInput.type = "text";
         showHideBtn.textContent = "Hide";
    } else {
        passwordInput.type = "password";
        showHideBtn.textContent = "Show";
    }
}
</script>


<hr>
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
