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
    <h2>Customer Feedback</h2>
    <table>
        <tr>
            <th>Feedback Entry ID</th>
            <th>Customer ID</th>
            <th>Contents</th>
            <th>Feedback Date</th>
            <th>Action</th>
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

        // Check if the feedback ID is provided and delete the corresponding record
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])) {
            $delete_id = $_GET["delete_id"];
            $delete_sql = "DELETE FROM feedback WHERE FeedbackEntryID = $delete_id";
            if ($conn->query($delete_sql) === TRUE) {
                echo "<script>alert('Feedback entry deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting feedback entry: " . $conn->error . "');</script>";
            }
        }

        // Fetch customer feedback data from the database
        $feedback_sql = "SELECT * FROM feedback";
        $feedback_result = $conn->query($feedback_sql);

        if ($feedback_result->num_rows > 0) {
            // Output data of each row
            while($feedback_row = $feedback_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $feedback_row["FeedbackEntryID"] . "</td>";
                echo "<td>" . $feedback_row["CustomerID"] . "</td>";
                echo "<td>" . $feedback_row["Contents"] . "</td>";
                echo "<td>" . $feedback_row["FeedbackDate"] . "</td>";
                echo "<td><button class=btn-remove onclick='deleteFeedback(" . $feedback_row["FeedbackEntryID"] . ")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No customer feedback found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<script>
    function deleteFeedback(feedbackID) {
        if (confirm("Are you sure you want to delete this feedback entry?")) {
            window.location.href = "CustomerFeedback.php?delete_id=" + feedbackID;
        }
    }
</script>

</body>
</html>
