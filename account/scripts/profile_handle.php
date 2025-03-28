<?php
// Include your database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cgm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];  // Ensure this is correct

    // Check if passwords match
    if ($password !== $re_password) {
        echo "<div class='alert alert-danger'>Passwords do not match!</div>";
        return;
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Password updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating password!</div>";
    }

    $stmt->close();
}
?>
