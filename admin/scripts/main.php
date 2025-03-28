<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

if (isset($_POST["signin"])) {

    $id = TestData($_POST["id"]);
    $password = TestData($_POST["password"]);
    $query = mysqli_query($connection, "SELECT * FROM admins WHERE (admin_phone ='$id' OR admin_email='$id') AND admin_password ='$password' AND admin_status ='active'") or die(mysqli_error($connection));
    $count = mysqli_num_rows($query);

    if ($count == 1) {

        $data = mysqli_fetch_assoc($query);
        $alert = "success";
        $msg = "You have successfully signed in.";

        // GENERATE TOKEN

        function getRandomString($length = 500)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = '';

            for ($i = 0; $i < $length; $i++) {
                $string .= $characters[mt_rand(0, strlen($characters) - 1)];
            }

            return $string;
        }

        $token = getRandomString();

        $adminId = $data["admin_id"];
        $query = mysqli_query($connection, "UPDATE admins SET admin_token ='$token' WHERE admin_id ='$adminId'") or die(mysqli_error($connection));


        setcookie("CGMTOKEN", $token, time() + (86400 * 30), "/");
        setcookie("cgm_ADMIN", $data["admin_name"], time() + (86400 * 30), "/");

        $home = "dashboard.php";


        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "<?php print($home) ?>";
            }, 3000);
        </script>
        <?php
    } else {
        $alert = "danger";
        $msg = "Invalid login information, please try again.sssssssss";
    }

    require "templates/alert.php";
}


// Check if form is submitted
if (isset($_POST["addchild"])) {
    $full_name = $_POST["full_name"] ?? '';
    $date_of_birth = $_POST["date_of_birth"] ?? '';
    $join_date = $_POST["join_date"] ?? '';
    $gender = $_POST["gender"] ?? '';
    $father_name = $_POST["father_name"] ?? '';
    $mother_name = $_POST["mother_name"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $email = $_POST["email"] ?? '';
    $weight = $_POST["weight"] ?? '';
    $nid = NULL;
    $pin = $password = rand(0000, 9999);

    $password = sha1(rand(0000, 9999));

    $name_parts = explode(" ", $father_name, 2); // Limit to 2 parts to handle names with multiple parts
    $role = "Parent";
    $status = "Incomplete";
    $token = sha1(rand(00000, 99999));

    // Check if the split resulted in two parts
    if (count($name_parts) == 2) {
        $first_name = $name_parts[0];
        $last_name = $name_parts[1];
    } else {
        // Handle cases where there is no space in the name
        $first_name = $name_parts[0]; // Use the full name as the first name
        $last_name = ''; // No last name
    }

    // Check if the phone number already exists
    $query = mysqli_query($connection, "SELECT * FROM users WHERE phone = '$phone'");
    if (mysqli_num_rows($query) > 0) {
        $alert = "danger";
        $msg = "User already exists!";
        require("templates/alert.php");
        exit;
    }

    // Check if the email already exists
    $query = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($query) > 0) {
        $alert = "danger";
        $msg = "User already exists!";
        require("templates/alert.php");
        exit;
    }

    // INSERT USER INFORMATION
    $query = mysqli_query($connection, "INSERT INTO users (fname, lname, phone, email, nid, gender, password, token, role, status) VALUES ('$first_name', '$last_name', '$phone', '$email', '$nid', '$gender', '$password', '$token', '$role', '$status')");

    $parent_id = mysqli_insert_id($connection);

    // REGISTER CHILD
    $birth_certificate = ''; // Set this to the appropriate value if available
    $vaccinations = ''; // Set this to the appropriate value if available
    $last_updated = date('Y-m-d H:i:s'); // Current timestamp

    // Handle birth certificate upload
    $valid = 0;
    $fileName = isset($_FILES["birth_certificate"]["name"]) ? $_FILES["birth_certificate"]["name"] : '';
    $fileSize = isset($_FILES["birth_certificate"]["size"]) ? $_FILES["birth_certificate"]["size"] / 1024 : 0;
    $fileType = isset($_FILES["birth_certificate"]["type"]) ? $_FILES["birth_certificate"]["type"] : '';
    $fileTmpName = isset($_FILES["birth_certificate"]["tmp_name"]) ? $_FILES["birth_certificate"]["tmp_name"] : '';

    // Allowed file types
    $allowedTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

    if (in_array($fileType, $allowedTypes)) {
        $valid = 1;

        // New file name (sha1 hash to ensure uniqueness)
        $random = sha1(rand());
        $newFileName = $random . "_" . $fileName;

        // File upload directory (create if it doesn't exist)
        $uploadDir = "uploads/birth_certificates/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // File upload path
        $uploadPath = $uploadDir . $newFileName;

        // Move uploaded file to destination
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            $birth_certificate_path = $newFileName;  // Store the new file name
        } else {
            die("Error uploading birth certificate.");
        }
    } else {
        die("Invalid file type.");
    }

    $query = mysqli_query($connection, "INSERT INTO child (full_name, date_of_birth, join_date, gender, father_id, mother_id, weight, birth_certificate, status, vaccinations, last_updated) VALUES ('$full_name', '$date_of_birth', '$join_date', '$gender', '$parent_id', '$parent_id', '$weight', '$birth_certificate_path', '$status', '$vaccinations', '$last_updated')");
    if ($query) {


        // Prepare and send email with credentials
        require '../libs/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'devslab.io';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "notifications@devslab.io";
        $mail->Password = "Us)ZpH1LpMh1";
        $mail->setFrom('notifications@devslab.io', 'cgm');
        $mail->addReplyTo('notifications@devslab.io', 'cgm');
        $mail->addAddress($email, $father_name);
        $mail->Subject = 'Your CGM Account Details';
        $mail->isHTML(true);

        $mail->Body = "
                    <!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Account Creation Confirmation</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #fff;
                                border-radius: 5px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            }
                            .header {
                                text-align: center;
                                margin-bottom: 20px;
                            }
                            .logo {
                                max-width: 100px;
                                height: auto;
                            }
                            .content {
                                padding: 20px;
                                border-top: 1px solid #ccc;
                            }
                            .footer {
                                text-align: center;
                                margin-top: 20px;
                            }
                        </style>
                    </head>
                    <body>
                    <div class='container'>
                        <div class='header'>
                           <h1>cgm</h1>
                        </div>
                        <div class='content'>
                            <p>Hello " . htmlspecialchars($father_name) . ",</p>
                            <p>I'm delighted to inform you that your account has been successfully created. Welcome to cgm! Below, you'll find your login credentials:</p>
                            <ul>
                                <li><strong>User id:</strong> " . htmlspecialchars($phone) . "</li>
                                <li><strong>Password:</strong> " . htmlspecialchars($pin) . "</li>
                            </ul>
                            <p>If you have any questions, feel free to contact us.</p>
                            <p>Best regards,</p>
                        </div>
                        <div class='footer'>
                            <p>&copy; 2023 cgm. All rights reserved.</p>
                        </div>
                    </div>
                    </body>
                    </html>";

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            // Prevent form resubmit on refresh
            require("configs/deny.resubmit.php");

            $alert = "success";
            $msg = "You have successfully registered a new child's information and email has been sent!";
            require("templates/alert.php");
        }

    } else {
        $alert = "danger";
        $msg = "There was an error registering the child!";
        require("templates/alert.php");
    }
}


// Add a user
if (isset($_POST["addUser"])) {
    // Database connection
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "cgm";

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die(mysqli_error($connection));

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Validate and sanitize input
    $role = isset($_POST["role"]) ? TestData($_POST["role"]) : ''; // Retrieve role from the form
    $fname = TestData($_POST["fname"]);
    $lname = TestData($_POST["lname"]);
    $nid = TestData($_POST["nid"]);
    $phone = TestData($_POST["phone"]);
    $email = TestData($_POST["email"]);
    $gender = TestData($_POST["gender"]);

    $valid = 0;

    // Validate National Identification Number
    $pattern = "/^119\d{13}$/";
    if (preg_match($pattern, $nid)) {
        $valid = 1;
    } else {
        // Invalid NID
        $alert = "danger";
        $msg = "Invalid National Identification Number!";
        require("templates/alert.php");
    }

    // Generate a random password
    $digits_needed = 6;
    $random_number = ''; // set up a blank string
    $count = 0;

    while ($count < $digits_needed) {
        $random_digit = mt_rand(0, 9);
        $random_number .= $random_digit;
        $count++;
    }
    $password = $random_number;

    // Hash the password
    $passwords = rand(10000, 99999);
    $password = sha1($passwords);

    // Generate a unique token
    $token = bin2hex(random_bytes(16));

    if ($valid == 1) {
        // Insert user into the database
        $sql_user = "INSERT INTO users (fname, lname, phone, email, nid, gender, password, token, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')";
        $stmt_user = $connection->prepare($sql_user);
        $stmt_user->bind_param("sssssssss", $fname, $lname, $phone, $email, $nid, $gender, $password, $token, $role);

        if ($stmt_user->execute()) {
            require("email.temp.create.php");
            // Prevent form resubmit on refresh
            require("configs/deny.resubmit.php");

            $alert = "success";
            $msg = "You have successfully registered a new user!";
            require("templates/alert.php");
        } else {
            echo "Error: " . $stmt_user->error;
        }
    }

    // Close statements and connection

}

ob_end_flush();


/**/
/**/
##################################### APPROVE USER ####################################

if (isset($_GET["approve_user"])) {

    $applyId = TestData($_GET["approve_user"]);
    $approve_type = TestData($_GET["type"]);

    $querySelect = mysqli_query($connection, "SELECT * FROM users WHERE id =$applyId") or die(mysqli_error($connection));
    $dataSelected = mysqli_fetch_assoc($querySelect);

    $email = $dataSelected['email'];
    $fname = $dataSelected['fname'];

    $query = mysqli_query($connection, "UPDATE `users` SET `status` = 'active' WHERE `users`.`id` = $applyId;") or die(mysqli_error($connection));

    if ($query) {

        require("email.temp.approve.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "Approve $approve_type successfully!";
        $home = "users?type=$approve_type";
        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "<?php print($home) ?>";
            }, 3000);
        </script>
        <?php
        require("templates/alert.php");
    }
}

##################################### APPROVE USER ####################################

if (isset($_GET["reject_user"])) {

    $applyId = TestData($_GET["reject_user"]);
    $approve_type = TestData($_GET["type"]);

    $querySelect = mysqli_query($connection, "SELECT * FROM users WHERE id =$applyId") or die(mysqli_error($connection));
    $dataSelected = mysqli_fetch_assoc($querySelect);

    $email = $dataSelected['email'];
    $fname = $dataSelected['fname'];

    $query = mysqli_query($connection, "UPDATE `users` SET `status` = 'reject' WHERE `users`.`id` = $applyId;") or die(mysqli_error($connection));

    if ($query) {

        require("email.temp.reject.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "Reject $approve_type successfully!";
        $home = "users?type=$approve_type";
        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "<?php print($home) ?>";
            }, 3000);
        </script>
        <?php
        require("templates/alert.php");
    }
}

if (isset($_POST["addProhibitedAreas"])) {
    $area_type = TestData($_POST["area_type"]);
    $area_id = TestData($_POST["area_id"]);
    $prohibition_reason = TestData($_POST["prohibition_reason"]);
    $prohibition_reason_description = TestData($_POST["prohibition_reason_description"]);
    $start_date = TestData($_POST["start_date"]);
    $end_date = TestData($_POST["end_date"]);

    $query = mysqli_query($connection, "INSERT INTO `prohibited_areas` (
        `prohibited_area_id`, 
    `area_type`, 
    `area_id`, 
    `prohibition_reason`, 
    `prohibition_reason_description`, 
    `start_date`, 
    `end_date`, 
    `status`) VALUES (
        NULL, 
    '$area_type', 
    '$area_id', 
    '$prohibition_reason', 
    '$prohibition_reason_description', 
    '$start_date', 
    '$end_date', 
    'pending');") or die(mysqli_error($connection));

    if ($query) {
        require("configs/deny.resubmit.php");

        $alert = "success";
        $msg = "You have successfully registered prohibited areas!";
        require("templates/alert.php");
    }
}

##################################### APPROVE USER ####################################

if (isset($_GET["Active_area"])) {

    $applyId = TestData($_GET["Active_area"]);

    $query = mysqli_query($connection, "UPDATE `prohibited_areas` SET `status` = 'active' WHERE `prohibited_areas`.`prohibited_area_id` = $applyId;") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "Activate area successfully!";
        require("templates/alert.php");
    }
}


##################################### APPROVE USER ####################################

if (isset($_GET["Inactive_area"])) {

    $applyId = TestData($_GET["Inactive_area"]);

    $query = mysqli_query($connection, "UPDATE `prohibited_areas` SET `status` = 'inactive' WHERE `prohibited_areas`.`prohibited_area_id` = $applyId;") or die(mysqli_error($connection));

    if ($query) {

        // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
        require("configs/deny.resubmit.php");
        // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

        $alert = "success";
        $msg = "Activate area successfully!";
        require("templates/alert.php");
    }
}


#################### Add Event #########################

if (isset($_POST["addevent"])) {
    $type = TestData($_POST["type"]);
    $description = TestData($_POST["description"]);
    $time = TestData($_POST["time"]);
    $bible_passages = TestData($_POST["bible_passages"]);
    $songs = TestData($_POST["songs"]);


    // Convert the datetime-local input to a proper datetime format for MySQL
    $time = date('Y-m-d H:i:s', strtotime($time));

    // Debugging statement


    // Insert the data into the database
    $query = mysqli_query($connection, "INSERT INTO `events` (`eventid`, `type`, `description`, `time`, `bible_passages`, `songs`) VALUES (NULL, '$type', '$description', '$time', '$bible_passages', '$songs');") or die(mysqli_error($connection));

    if ($query) {
        require("configs/deny.resubmit.php");

        $alert = "success";
        $msg = "You have successfully registered an Event!";
        require("templates/alert.php");
    }
}


#################### Add a song #########################


if (isset($_POST["addsong"])) {
    $title = TestData($_POST["title"]);
    $artist = TestData($_POST["artist"]);
    $album = TestData($_POST["album"]);
    $key = TestData($_POST["key"]);
    $duration = TestData($_POST["duration"]); // corrected
    $lyrics = TestData($_POST["lyrics"]); // assuming you have lyrics in your form

    // Capture the current timestamp when the data is inserted
    $timestamp = date('Y-m-d H:i:s'); // Format the timestamp as 'YYYY-MM-DD HH:MM:SS'

    // Prepare the INSERT query
    $query = "INSERT INTO `songs` (`Title`, `Artist`, `Album`, `Key`, `Lyrics`, `Duration`, `CreatedBy`, `CreatedAt`, `UpdatedAt`) 
            VALUES (?, ?, ?, ?, ?, ?, NULL, ?, ?)";

    // Prepare the statement
    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssssss", $title, $artist, $album, $key, $lyrics, $duration, $timestamp, $timestamp);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            require("configs/deny.resubmit.php");

            $alert = "success";
            $msg = "You have successfully registered a Song!";
            require("templates/alert.php");
        } else {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        die("Prepare failed: " . mysqli_error($connection));
    }
}

###############################   task/role assignment  ################################


###############################   delete category   ################################
if (isset($_GET['deleted_area'])) {
    $delete_id = TestData($_GET['deleted_area']);
    $delete = mysqli_query($connection, "DELETE FROM `prohibited_areas` WHERE `prohibited_areas`.`prohibited_area_id` = $delete_id");
    if ($delete) {
        $alert = "success";
        $msg = "delete, successfully.";
    } else {
        $alert = "success";
        $msg = "failed to delete.";
    }

    require "templates/alert.php";

}


?>


