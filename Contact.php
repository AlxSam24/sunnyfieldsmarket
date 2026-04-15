<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="HomeCss.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
<title>Sunny Fields Market</title>
</head>
<body> 
<a target="_self" href="http://localhost:81/my-app/Home.php" title="Sunny Fields"><img src="Logo.jpg" alt="Sunny Fields" width="100" height="100" class="ccm-image-block img-responsive bID-215" title="Sunny Fields"></a>
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
  <hr style="height:2px;border-width:0;color:gray;background-color:white">
  
  <section>
  <?php
    $server = "localhost";
    $username = "root";
    $password = "root";
    $database = "sunnyfielddata";

    $conn = new mysqli($server, $username, $password, $database);
    
    if (isset($_SESSION['user'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Fetch CustomerID based on the logged-in user's email
            $email = $_SESSION['user'];
            $stmt = $conn->prepare("SELECT User_ID FROM customers WHERE email = ?");
            
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $customerId = $user['User_ID'];

            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $contactPreference = isset($_POST['contact_preference']) ? $_POST['contact_preference'] : 'no';

            // Insert feedback into the database
            $stmt = $conn->prepare("INSERT INTO feedback (CustomerID, Contents, feedbackDate) VALUES (?, ?, NOW())");
            

            $stmt->bind_param("ss", $customerId, $message);

            if ($stmt->execute()) {
                // Display thank you message
                echo "Thanks for your feedback!";

                // If the user wants to be contacted, display a message
                if ($contactPreference === 'yes') {
                    echo " You will hear from us soon.";
                }
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Display the contact form with user information
            $customerId = $_SESSION['user'];
            $email = $_SESSION['user'];
            $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
            
            // Check for errors in the prepare statement
            if (!$stmt) {
                die("Error in statement preparation: " . $conn->error);
            }
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $_SESSION['user_details'] = $user;
            $name = $user['fullname'];
            $email = $user['email'];
            echo '<form action="" method="post">
                    <input type="hidden" name="user_id" value="' . $customerId . '">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required value="'. $name.'" readonly >

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" size="30" required value="'. $email. '" readonly>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" size="7" required></textarea>

                    <label for="contact_preference">Would you like to be contacted by one of our colleagues?</label>
                    <input type="radio" id="yes" name="contact_preference" value="yes" checked>
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" name="contact_preference" value="no">
                    <label for="no">No</label>

                    <button type="submit">Submit</button>
                </form>';
        }
    } else {
        // Redirect to login page if the user is not logged in
        header('Location: http://localhost:81/my-app/ContactLog.php');
        exit();
    }
?>



    </section>
 





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