<?php
// Database connection parameters
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

// Connect to the database
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$connection) {
    $message = urlencode('Connection failed: ' . mysqli_connect_error());
    $message_type = 'danger';
    header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
    exit();
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $child_id = $_POST['child_id'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bmi = $_POST['bmi'];
    $bmi_status = $_POST['bmi_status'];
    $record_date = $_POST['record_date'];
    $nutrition_info = $_POST['nutrition_info'];
    $condition = $_POST['condition'];

    // File upload handling
    $health_info_doc = null;
    if (isset($_FILES['health_info_doc']) && $_FILES['health_info_doc']['error'] == UPLOAD_ERR_OK) {
        $health_info_doc = $_FILES['health_info_doc']['name'];
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['health_info_doc']['name']);
        if (!move_uploaded_file($_FILES['health_info_doc']['tmp_name'], $upload_file)) {
            $message = urlencode("Failed to upload file.");
            $message_type = 'danger';
            header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
            exit();
        }
    }

    // Check if there is a recent record
    $check_recent_record_query = "SELECT health_info_id, record_date FROM health_info WHERE child_id = ? ORDER BY record_date DESC LIMIT 1";
    if ($stmt_check = $connection->prepare($check_recent_record_query)) {
        $stmt_check->bind_param("i", $child_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->bind_result($existing_record_id, $last_record_date);
            $stmt_check->fetch();

            // Calculate the difference in months since the last record
            $now = new DateTime();
            $last_record_date = new DateTime($last_record_date);
            $interval = $last_record_date->diff($now);

            // Prevent update if less than one month has passed
            if ($interval->y == 0 && $interval->m < 1) {
                $message = urlencode("Update not allowed. You can only insert new health information once per month.");
                $message_type = 'warning';
                $stmt_check->close();
                $connection->close();
                header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
                exit();
            }

            // Archive the existing record
            $archive_query = "INSERT INTO health_info_archive (health_info_id, child_id, basic_info, height, weight, bmi, bmi_status, record_date, health_info_doc, nutrition_info, `Condition`, archive_date) SELECT health_info_id, child_id, basic_info, height, weight, bmi, bmi_status, record_date, health_info_doc, nutrition_info, `Condition`, CURDATE() FROM health_info WHERE health_info_id = ?";
            if ($stmt_archive = $connection->prepare($archive_query)) {
                $stmt_archive->bind_param("i", $existing_record_id);
                $stmt_archive->execute();
                $stmt_archive->close();
            } else {
                $message = urlencode("Error preparing archive query: " . $connection->error);
                $message_type = 'danger';
                header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
                exit();
            }
        }
        $stmt_check->close();
    } else {
        $message = urlencode("Error preparing recent record check query: " . $connection->error);
        $message_type = 'danger';
        header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
        exit();
    }

    // Insert new health information
    $insert_health_query = "INSERT INTO health_info (child_id, height, weight, bmi, bmi_status, record_date, health_info_doc, nutrition_info, `Condition`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt_insert = $connection->prepare($insert_health_query)) {
        $stmt_insert->bind_param("iddssssss", $child_id, $height, $weight, $bmi, $bmi_status, $record_date, $health_info_doc, $nutrition_info, $condition);

        if ($stmt_insert->execute()) {
            if ($stmt_insert->affected_rows > 0) {
                // Update child status to 'Complete'
                $update_child_status_query = "UPDATE child SET status = 'Complete', last_updated = NOW() WHERE child_id = ?";
                if ($stmt_update_status = $connection->prepare($update_child_status_query)) {
                    $stmt_update_status->bind_param("i", $child_id);

                    if ($stmt_update_status->execute()) {
                        if ($stmt_update_status->affected_rows > 0) {
                            $message = urlencode("Health information updated successfully.");
                            $message_type = 'success';
                        } else {
                            $message = urlencode("Child status was already Complete or not updated.");
                            $message_type = 'warning';
                        }
                    } else {
                        $message = urlencode("Error updating child status: " . $stmt_update_status->error);
                        $message_type = 'danger';
                    }
                    $stmt_update_status->close();
                } else {
                    $message = urlencode("Error preparing child status update query: " . $connection->error);
                    $message_type = 'danger';
                }
            } else {
                $message = urlencode("Failed to insert health information.");
                $message_type = 'danger';
            }
        } else {
            $message = urlencode("Error inserting health information: " . $stmt_insert->error);
            $message_type = 'danger';
        }
        $stmt_insert->close();
    } else {
        $message = urlencode("Error preparing health information insert query: " . $connection->error);
        $message_type = 'danger';
    }

    // Close the database connection
    $connection->close();
    
    // Redirect to childprofile.php with message
    header('Location: ../childprofile.php?message=' . $message . '&message_type=' . $message_type);
    exit();
}
?>
