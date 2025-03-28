<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

// Check if form is submitted
if (isset($_POST["signin"])) {
    $user_id = TestData($_POST["user_id"]);
    $password = TestData($_POST["password"]);
    $hashed_password = sha1($password);

    $query = mysqli_query($connection, "SELECT * FROM users WHERE phone ='$user_id' OR email='$user_id' AND password ='$hashed_password'") or die(mysqli_error($connection));
    $count = mysqli_num_rows($query);


    if ($count == 1) {
        $data = mysqli_fetch_assoc($query);
        $alert = "success";
        $msg = "You have successfully signed in.";
        
        $token = $data["token"];
        $userId = $data["user_id"];

        // Set cookie
        setcookie("CGMTOKEN", $token, time() + (86400 * 30), "/");

        // Redirect to dashboard
        $home = "homepage.php";
        if($data["role"] == "pediatrician"){
            $home = "reappointement.php";
        }
        ?>
        <script type="text/javascript">
            setTimeout(function () {
                window.location = "<?php echo $home; ?>";
            }, 3000);
        </script>

        <?php
    } else {
        $alert = "danger";
        $msg = "Invalid login information, please try again.";
    }

    require "templates/alert.php";
}


//add child


if (isset($_POST["addchild"])) {


    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Sanitize form data
    $full_name = TestData($_POST["full_name"]);
    $date_of_birth = TestData($_POST["date_of_birth"]);
    $join_date = TestData($_POST["join_date"]);
    $gender = TestData($_POST["gender"]);
    $father = TestData($_POST["father"]);
    $mother = TestData($_POST["mother"]);
    $parent_phone = TestData($_POST["parent_phone"]);
    $email = TestData($_POST["email"]);
    $weight = TestData($_POST["weight"]);

    // Handle birth certificate upload
    $valid = 0;
    $fileName = $_FILES["birth_certificate"]["name"];
    $fileSize = $_FILES["birth_certificate"]["size"] / 1024;
    $fileType = $_FILES["birth_certificate"]["type"];
    $fileTmpName = $_FILES["birth_certificate"]["tmp_name"];

    // Allowed file types for birth certificate
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
            $valid = 1;
        } else {
            $valid = 0;
            $alert = "danger";
            $msg = "Failed to upload birth certificate!";
            require("templates/alert.php");
        }
    } else {
        $valid = 0;
        $alert = "danger";
        $msg = "Birth certificate must be in PDF or image format only!";
        require("templates/alert.php");
    }

    // If file upload was successful, insert data into database
    if ($valid == 1) {
        $query = "INSERT INTO `child` (`full_name`, `date_of_birth`, `join_date`, `gender`, `father`, `mother`, `parent_phone`, `email`, `weight`, `birth_certificate`,`status`)
                  VALUES ('$full_name', '$date_of_birth', '$join_date', '$gender', '$father', '$mother', '$parent_phone', '$email', '$weight', '$newFileName','Incomplete')";

        if ($connection->query($query) === TRUE) {
            // Success message
            $alert = "success";
            $msg = "Child profile added successfully!";
            require("templates/alert.php");
        } else {
            // Error message
            $alert = "danger";
            $msg = "Error: " . $query . "<br>" . $connection->error;
            require("templates/alert.php");
        }
    }

    // Close database connection
    $connection->close();
}


//add user


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Get form data and sanitize it
    $fname = $connection->real_escape_string($_POST['fname']);
    $lname = $connection->real_escape_string($_POST['lname']);
    $phone = $connection->real_escape_string($_POST['phone']);
    $email = $connection->real_escape_string($_POST['email']);
    $password = password_hash($connection->real_escape_string($_POST['password']), PASSWORD_DEFAULT);

    // Generate a unique token
    $token = bin2hex(random_bytes(16));

    $gender = '';  // Adjust as necessary
    $role = '';     // Adjust as necessary
    $status = 'Inactive';

    // Check for duplicates
    $check_sql = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
    $result = $connection->query($check_sql);

    if ($result->num_rows > 0) {
        // Duplicate found
        $valid = 0;
        $alert = "danger";
        $msg = "User exists in the system!";
        require("templates/alert.php");
    } else {
        // No duplicates, proceed with insertion
        $sql = "INSERT INTO users (fname, lname, nid, gender, email, phone, password, role, token, status) VALUES ('$fname', '$lname', '', '$gender', '$email', '$phone', '$password', '$role', '$token', '$status')";

        if ($connection->query($sql) === TRUE) {
            $alert = "success";
            $msg = "Account successfully created!";
            require("templates/alert.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
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


if (isset($_POST["addUser"])) {
    $service = TestData($_POST["service"]);
    $fname = TestData($_POST["fname"]);
    $lname = TestData($_POST["lname"]);
    $service = TestData($_POST["service"]);
    $phone = TestData($_POST["phone"]);
    $email = TestData($_POST["email"]);
    $gender = TestData($_POST["gender"]);
    $picture = $_FILES["picture"];
    $valid = 0;

    // GENERATE PASSWORD
    $digits_needed = 6;
    $random_number = '';
    $count = 0;

    while ($count < $digits_needed) {
        $random_digit = mt_rand(0, 9);
        $random_number .= $random_digit;
        $count++;
    }
    $password = $random_number;

    // This is the temporary password to be changed after adding notifications
    $passwords = rand(10000, 99999);
    $password_hashed = sha1($passwords);

    // PROFILE PICTURE
    $fileName = $_FILES["picture"]["name"];
    $fileSize = $_FILES["picture"]["size"] / 1024;
    $fileType = $_FILES["picture"]["type"];
    $fileTmpName = $_FILES["picture"]["tmp_name"];

    if (
        $fileType == "image/png"
        || $fileType == "image/PNG"
        || $fileType == "image/JPG"
        || $fileType == "image/jpg"
        || $fileType == "image/jpeg"
        || $fileType == "image/JPEG"
        || $fileType == "image/gif"
    ) {
        $valid = 1;

        // New file name
        $random = sha1(rand());
        $newFileName = $random . $fileName;

        // File upload path
        $uploadPath = "catalog/pictures/" . $newFileName;

        move_uploaded_file($fileTmpName, $uploadPath);
    } else {
        $valid = 0;
        $alert = "danger";
        $msg = "Profile picture has to be an image format only!";
        require("templates/alert.php");
    }

    if ($valid == 1) {
        $token = sha1(rand());
        $status = 'inactive'; // Set a default status if needed

        $query = mysqli_query($connection, "INSERT INTO `volunteer` (`volunteer_id`, `fname`, `lname`, `service`, `phone`, `email`, `gender`, `picture`, `password`, `token`, `status`) VALUES (NULL, '$fname', '$lname', '$service', '$phone', '$email', '$gender', '$newFileName', '$password_hashed', '$token', '$status')") or die(mysqli_error($connection));

        if ($query) {
            require("email.temp.create.php");
            // Prevent form resubmit on refresh
            require("configs/deny.resubmit.php");

            $alert = "success";
            $msg = "You have successfully registered a new user!";
            require("templates/alert.php");
        }
    }
}

ob_end_flush();

 

 
////////////////////////////REQUESST APPOINTMENT?????//////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sendRequest'])) {
    // Retrieve data from form
    $request_type = mysqli_real_escape_string($connection, $_POST['request_type']);
    $pediatrician_id = mysqli_real_escape_string($connection, $_POST['pediatrician']); 
    $appointment_date = mysqli_real_escape_string($connection, $_POST['date']);
    $appointment_time = mysqli_real_escape_string($connection, $_POST['time']);
    $notes = mysqli_real_escape_string($connection, $_POST['notes']);

    $token = $_COOKIE["CGMTOKEN"];
    $query = mysqli_query($connection, "SELECT user_id FROM users WHERE token = '$token'") or die(mysqli_error($connection));
    $parent = mysqli_fetch_assoc($query);
    $user_id = $parent['user_id'];

  
    $pediatrician_query = mysqli_query($connection, "SELECT email FROM users WHERE user_id = '$pediatrician_id' AND role = 'pediatrician'") or die(mysqli_error($connection));
    $pediatrician_row = mysqli_fetch_assoc($pediatrician_query);

    if ($pediatrician_row) {
        $pediatrician_email = $pediatrician_row['email'];

    
        $check_query = "SELECT * FROM appointment WHERE user_id = '$user_id' AND request_type = '$request_type' AND appointment_date = '$appointment_date' AND appointment_time = '$appointment_time'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) == 0) {
           
            $insert_query = "INSERT INTO appointment (user_id, request_type, pediatrician, appointment_date, appointment_time, request_status, notes) VALUES ('$user_id', '$request_type', '$pediatrician_id', '$appointment_date', '$appointment_time', 'Pending', '$notes')";
            if (mysqli_query($connection, $insert_query)) {
          
                $alert = "Appointments requested successfully";
                $msg = "Success!";
                require("templates/alert.php");

      
                require '../libs/PHPMailer/PHPMailerAutoload.php';
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'devslab.io';
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';
                $mail->SMTPAuth = true;
                $mail->Username = "notifications@devslab.io";
                $mail->Password = "Us)ZpH1LpMh1";
                $mail->setFrom('notifications@devslab.io', 'WPS');
                $mail->addReplyTo('notifications@devslab.io', 'WPS');
                $mail->addAddress($pediatrician_email); 
                $mail->Subject = 'New Appointment Request';
                $mail->msgHTML(file_get_contents('../libs/PHPMailer/contents.html'), dirname(__FILE__));

                $mail->Body = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>New Appointment Request</title>
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
       <h1>WPS</h1>
    </div>
    <div class='content'>
        <p>Hello,</p>
        <p>A new appointment request has been made. Here are the details:</p>
        <ul>
            <li><strong>Request Type:</strong> $request_type</li>
            <li><strong>Appointment Date:</strong> $appointment_date</li>
            <li><strong>Appointment Time:</strong> $appointment_time</li>
            <li><strong>Notes:</strong> $notes</li>
        </ul>
        <p>If you have any questions, feel free to contact us.</p>
        <p>Best regards,</p>
    </div>
    <div class='footer'>
        <p>&copy; 2024 WPS. All rights reserved.</p>
    </div>
</div>
</body>
</html>";

                $mail->SMTPDebug = 2; 

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message sent!";
                }

            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
           
            $alert = "danger";
            $msg = "Duplicate appointment request detected.";
            require("templates/alert.php");
        }
    } else {
        echo "Error: Pediatrician email not found.";
    }

    // Close the database connection after all operations
    mysqli_close($connection);
}
