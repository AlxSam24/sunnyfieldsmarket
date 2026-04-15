<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="Registerpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="icon" type="image/x-icon" href="LogoNoBackground.png">
<title>Sunny Fields Market Registration</title>
</head>
<body>

<form action="" method="POST">
    <h2>Customer Registration</h2>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" placeholder="example@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

    <label for="re-enter_email">Re-enter email:</label>
    <input type="email" id="re-enter_email" name="re-enter_email" value="<?php echo isset($_POST['re-enter_email']) ? htmlspecialchars($_POST['re-enter_email']) : ''; ?>" required>
    <div class="password-container">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="Password123" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
    
    <div class="show-hide-btn" onclick="togglePasswordVisibility()">Show</div>
    
</div>

<script>
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






    <label for="re-enter_password">Re-enter password:</label>
    <input type="password" id="re-enter_password" name="re-enter_password" value="<?php echo isset($_POST['re-enter_password']) ? htmlspecialchars($_POST['re-enter_password']) : ''; ?>" required>

    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" placeholder="John Doe" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">

    <label for="birthdate">Date of Birth:</label>
    <input type="date" id="birthdate" name="birthdate" placeholder="01/01/2001" value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>" required>

    <input type="submit" value="Register">
</form>

</body>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sunnyfielddata";
$conn =  mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $reenter_email = $_POST["re-enter_email"];
    $entered_password = $_POST["password"];
    $reenter_password = $_POST["re-enter_password"];
    $fullname = $_POST["fullname"];
    $birthdate = $_POST["birthdate"];

    $errors = array();

    // Check if entered email and re-entered email match
    if ($email != $reenter_email) {
        $errors[] = "The entered email does not match. Please try again.";
    }

    // Check if entered password and re-entered password match
    if ($entered_password != $reenter_password) {
        $errors[] = "The entered password does not match. Please try again.";
    }

    $forbiddenPasswords = array("password123", "Password123");
    if (in_array(strtolower($reenter_password), $forbiddenPasswords)) {//the strlower converts the string to lowercase
        $errors[] = "The chosen password is not allowed. Please choose a different password.";
    }

    if (strlen($entered_password) < 10) { // if the password is smaller than 10 characters output an error 
        $errors[] = "The password entered must be greater than 10 characters";
    } else {
        // Hash the password if it passes all checks
        $password = password_hash($entered_password, PASSWORD_DEFAULT);
    }
     // Calculate age based on birthdate
     date_default_timezone_set('Europe/London'); // Sets the time zone to the uk time 
     $today = new DateTime();//stores todays date in the vairable today 
     $birthdate = new DateTime($birthdate);//Calculates the age based on the entered birthdate 
     $formatted_birthdate = $birthdate->format('Y-m-d'); // Format the birthdate as 'YYYY-MM-DD' string
     $age = $today->diff($birthdate)->y;//Compares the values 
 
     // Check if user is under 13 years old
     if ($age < 13) {
         $errors[] = "You must be at least 13 to register for an account.";
     }

    if (empty($errors)) {
        // Check if the email is already registered
        $check_query = "SELECT * FROM customers WHERE email = '$email'";
        $check_result = $conn->query($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            $errors[] = "You have already registered with this email. Please use a different email address or sign in on the previous page.";
        } else {
            // Insert user data into the database
            $insert_query = "INSERT INTO customers (email, password_hash, fullname, birthdate) VALUES ('$email', '$password', '$fullname', '$formatted_birthdate')";

            if (mysqli_query($conn, $insert_query)) {
                echo "<div class='user-message-success'>
                    <h2>Thank You for Registering!</h2>
                    <p>Redirecting you to sign in page...</p>
                </div>";
                header("refresh: 2; url=http://localhost:81/my-app/Account.php");
                exit; // Prevent the rest of the code from executing after successful registration
            } else {
                $errors[] = "Error inserting data: " . mysqli_error($conn);
            }
        }
    }

    // Display errors if any
    if (!empty($errors)) {
        echo "<div class='user-message-fail'>
        <h2>Error</h2>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
}
?>

</html>
