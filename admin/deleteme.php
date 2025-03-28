<?php
require("configs/globals.php");

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Ensure $userId is an integer
    
    // Prepare and execute the delete query
    $query = "DELETE FROM users WHERE user_id = ?";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to nurse.php with a success message
            header("Location: nurses.php?message=User deleted successfully");
            exit(); // Ensure no further code is executed
        } else {
            // Handle the error and display an appropriate message
            echo "Error deleting user: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        // Handle the error and display an appropriate message
        echo "Error preparing statement: " . mysqli_error($connection);
    }
    
    // Close the database connection
    mysqli_close($connection);
} else {
    echo "No user ID provided.";
}
?>
