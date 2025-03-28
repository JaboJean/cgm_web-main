<?php
require("configs/globals.php");

// Check if 'id' is set and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Prepare and execute the update statement
    $stmt = $connection->prepare("UPDATE appointment SET request_status = 'Approved' WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
} else {
    echo "invalid";
}
$connection->close();
?>
