<?php
$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="cgm";

$connection = mysqli_connect($db_host,$db_user,$db_password,$db_name) or die(mysqli_error($connection));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $health_info_id = $_POST['health_info_id'] ?? null;
    $child_id = $_POST['child_id'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $bmi = $_POST['bmi'] ?? null;
    $bmi_status = $_POST['bmi_status'] ?? null;
    $record_date = $_POST['record_date'] ?? null;
    $nutrition_info = $_POST['nutrition_info'] ?? null;
    $condition = $_POST['condition'] ?? null;

    // Handle file upload
    $health_info_doc = '';
    if (isset($_FILES['health_info_doc']) && $_FILES['health_info_doc']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['health_info_doc']['tmp_name'];
        $fileName = $_FILES['health_info_doc']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Define the allowed file extensions
        $allowedExts = array('jpg', 'jpeg', 'png', 'pdf');
        
        if (in_array($fileExtension, $allowedExts)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $health_info_doc = $newFileName;
            } else {
                $message = 'There was an error uploading the file.';
                header("Location: /cgm-main/CGM-main/admin/childprofile.php?message=" . urlencode($message));
                exit();
            }
        } else {
            $message = 'Upload failed. Allowed file types: jpg, jpeg, png, pdf.';
            header("Location: /cgm-main/CGM-main/admin/childprofile.php?message=" . urlencode($message));
            exit();
        }
    }

    // Insert or update health information (assuming health_info_id is set)
    if ($health_info_id) {
        $query = "UPDATE health_info SET 
                    height = ?, weight = ?, bmi = ?, bmi_status = ?, record_date = ?, nutrition_info = ?, `condition` = ?, health_info_doc = ?
                  WHERE health_info_id = ?";
        $stmt = mysqli_prepare($connection, $query);
    } else {
        $query = "INSERT INTO health_info (child_id, height, weight, bmi, bmi_status, record_date, nutrition_info, `condition`, health_info_doc) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
    }

    if ($stmt === false) {
        $message = "Failed to prepare statement: " . mysqli_error($connection);
        header("Location: /cgm-main/CGM-main/admin/childprofile.php?message=" . urlencode($message));
        exit();
    }

    if ($health_info_id) {
        mysqli_stmt_bind_param($stmt, 'ddssssssi', $height, $weight, $bmi, $bmi_status, $record_date, $nutrition_info, $condition, $health_info_doc, $health_info_id);
    } else {
        mysqli_stmt_bind_param($stmt, 'iddssssss', $child_id, $height, $weight, $bmi, $bmi_status, $record_date, $nutrition_info, $condition, $health_info_doc);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        // Update the status in the child table
        $update_query = "UPDATE child SET status = 'Complete' WHERE child_id = ?";
        $update_stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'i', $child_id);
        mysqli_stmt_execute($update_stmt);

        $message = "Health information updated successfully.";
    } else {
        $message = "Error updating health information: " . mysqli_error($connection);
    }

    header("Location: /cgm-main/CGM-main/admin/childprofile.php?message=" . urlencode($message));
    exit();
}
?>
