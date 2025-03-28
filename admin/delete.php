<?php
require("configs/globals.php");

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Ensure $userId is an integer
    
    // Prepare and execute the delete query
    $query = "DELETE FROM users WHERE user_id = ?";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: pediatrician.php?type=your_type_here&message=User deleted successfully");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error deleting user: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
    
    // Close the database connection
    mysqli_close($connection);
} else {
    echo "No user ID provided.";
}
?>
