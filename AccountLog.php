<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Account.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
    <title>Account</title>
</head>
<body> 
    <a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields">
        <img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields">
    </a>

    <header>
        <hr style="height:2px;border-width:0;color:gray;background-color:white">
        <nav>
            <li title="Home"><b><a class="active" href="http://localhost:81/my-app/Home.php">Home</b></a></li>
            <li title ="About Us" ><b><a href="http://localhost:81/my-app/AboutUs.php">About Us</b></a></li>
            <li title ="Account"><b><a href="http://localhost:81/my-app/AccountLog.php">Account</b></a></li>
            <li title ="Contact"><b><a href="http://localhost:81/my-app/Contact.php">Contact</b></a></li>
            <li title ="Previous Orders"><b><a href="http://localhost:81/my-app/PreviousOrders.php">Previous Orders</b></a></li>
        </nav>
        <hr style="height:2px;border-width:0;color:gray;background-color:white">
    </header>

    <?php
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "root";
    $database = "sunnyfielddata";

    $conn = new mysqli($server, $username, $password, $database);

    // Check if the user is not logged in and the cookie is not set
    if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {
        header("Location: Account.php"); // Redirect to login if not logged in
        exit();
    }

    // If the session is not set but the cookie is, restore the session
    if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
        $_SESSION['user'] = $_COOKIE['user'];
    }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details using the session information
    $email = $_SESSION['user'];
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Store user details in a session variable
        $_SESSION['user_details'] = $user;

        // Display user details
        $name = $user['fullname'];
        $email = $user['email'];
        $birth = $user['birthdate'];

        echo "<div class='user-info'>
        <h2>Welcome: $name</h2>
        <p>Date of Birth: $birth</p>
        <p>Email: $email</p>
        </div>";

        // Close the database connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle the case where user details are not found
        $userDetails = "<p>User details not found</p>";
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Account</title>

        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    </head>
    </body>
    </html>

    <hr>
    <footer>
        <div class="text-only-nav">
            <nav>
                <li style="text-align: right;">© <date>2023</date> Sunny Fields Market ltd. All Rights Reserved</li>
                <li><a style="text-align: right;" href="http://localhost:81/my-app/privacyPolicy.php">Privacy Policy</a></li>
            </nav>
        </div>
    </footer>

</body>
</html>
