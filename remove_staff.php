<?php
session_start();

// Check if the staff is logged in
if (!isset($_SESSION['staff_name'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
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

// Check if staff ID is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $staffID = $_GET['id'];

    // Prepare SQL statement to delete staff member
    $stmt = $conn->prepare("DELETE FROM staff WHERE staffID = ?");
    $stmt->bind_param("i", $staffID);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['remove_message'] = "Staff member removed successfully.";
    } else {
        $_SESSION['remove_message'] = "Error removing staff member: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    $_SESSION['remove_message'] = "Invalid staff ID.";
}

$conn->close(); // Close database connection

// Redirect back to the staff home page
header("Location: staffPage.php");
exit();
?>
