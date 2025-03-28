<?php
// Include database connection
require("configs/globals.php");

// Check if role is provided via POST
if (isset($_POST['role'])) {
    $role = $_POST['role'];
    $emails = [];

    // Query to fetch emails based on selected role
    $query = "SELECT email FROM volunteer WHERE service = '$role'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $emails[] = $row['email'];
        }
        echo implode(", ", $emails); // Output emails as comma-separated string
    } else {
        echo "Error fetching emails";
    }

    mysqli_close($connection);
}
?>
