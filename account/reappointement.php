<?php
require 'configs/globals.php';
require '../libs/PHPMailer/PHPMailerAutoload.php'; // Adjust path as needed

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to send approval email
function sendApprovalEmail($email, $fname) {
    $subject = "Appointment Approved";

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // Disable debugging
    $mail->Host = 'devslab.io'; // Your SMTP host
    $mail->Port = 465; // SMTP port
    $mail->SMTPSecure = 'ssl'; // Encryption
    $mail->SMTPAuth = true; // Authentication
    $mail->Username = "notifications@devslab.io"; // Your SMTP username
    $mail->Password = "Us)ZpH1LpMh1"; // Your SMTP password
    $mail->setFrom('notifications@devslab.io', 'Child Growth Minder');
    $mail->addReplyTo('notifications@devslab.io', 'Child Growth Minder');
    $mail->addAddress($email, $fname);
    $mail->Subject = $subject;
    $mail->isHTML(true);

    $mail->Body = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Appointment Approved</title>
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
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class='container'>
    <div class='header'>
        <h1>Appointment Approved</h1>
    </div>
    <div class='content'>
        <p>Hello " . htmlspecialchars($fname) . ",</p>
        <p>We are pleased to inform you that your appointment request has been approved. If you have any questions or need further assistance, please feel free to contact us.</p>
        <p>Best regards,</p>
        <p>Child Growth Minder Team</p>
    </div>
    <div class='footer'>
        <p>&copy; 2024 Child Growth Minder . All rights reserved.</p>
    </div>
</div>
</body>
</html>";

    try {
        if (!$mail->send()) {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        file_put_contents('mail_error_log.txt', $e->getMessage(), FILE_APPEND);
    }
}

// Initialize success message
$success_message = "Success";

// Check if an appointment approval request was made
if (isset($_GET['approve_id']) && is_numeric($_GET['approve_id'])) {
    $appointment_id = $_GET['approve_id'];

    // Fetch appointment details
    $stmt = $connection->prepare("SELECT a.appointment_id, a.request_status, u.email, u.fname FROM appointment a JOIN users u ON a.user_id = u.user_id WHERE a.appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $userEmail = $row['email'];
        $userFname = $row['fname'];

        // Prepare and execute the update statement
        $updateStmt = $connection->prepare("UPDATE appointment SET request_status = 'Approved' WHERE appointment_id = ?");
        $updateStmt->bind_param("i", $appointment_id);
        $updateStmt->execute();

        // Set success message
        if ($updateStmt->affected_rows > 0) {
            // Send email
            sendApprovalEmail($userEmail, $userFname);

            $success_message = "Appointment approved successfully.";
        } else {
            $success_message = "Appointment approval failed.";
        }
        $updateStmt->close();
    } else {
        $success_message = "No such appointment found.";
    }
    $stmt->close();

    // Redirect after processing
    header("Location: reappointement.php?success_message=" . urlencode($success_message));
    exit();
}
$token  = $_COOKIE["CGMTOKEN"];
    $query  = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
    $data   = mysqli_fetch_assoc($query);
    $userId = $data["user_id"];
// Fetch appointment data
$sql = "SELECT a.appointment_id, a.request_type, a.pediatrician, a.appointment_date, a.appointment_time, a.request_status, a.notes, u.fname, u.lname
        FROM appointment a
        JOIN users u ON a.user_id = u.user_id WHERE a.pediatrician = '$userId'" ;
$result = $connection->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Requests</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
    <style>
        .required {
            color: red;
        }
        .status-pending {
            color: red;
            font-weight: bold;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body class="sidebar-noneoverflow">

<!-- BEGIN NAVBAR -->
<?php require("templates/navBar.php"); ?>
<!-- END NAVBAR -->

<!-- BEGIN MAIN CONTAINER -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="cs-overlay"></div>
    <div class="search-overlay"></div>

    <!-- BEGIN SIDEBAR -->
    <?php require("templates/sideBar.php"); ?>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT AREA -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-md-12">
                    <?php require("scripts/main.php"); ?>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
                    <?php if (!empty($_GET['success_message'])): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($_GET['success_message']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive">
                            <table id="appointments-table" class="table table-hover table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Names</th>
                                        <th>Request Type</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                              while ($row = $result->fetch_assoc()) {
                                        $statusClass = $row['request_status'] == 'Pending' ? 'status-pending' : '';
                                        echo "<tr>
                                            <td>{$count}</td>
                                            <td>{$row['fname']} {$row['lname']}</td>
                                            <td>{$row['request_type']}</td>
                                            <td>{$row['appointment_date']}</td>
                                            <td>{$row['appointment_time']}</td>
                                            <td class='{$statusClass}'>{$row['request_status']}</td>
                                            <td>{$row['notes']}</td>
                                            <td>";
                                        if ($row['request_status'] == 'Pending') {
                                            echo "<a href='?approve_id={$row['appointment_id']}' class='btn btn-primary'>Approve</a>";
                                        }
                                        echo "</td>
                                        </tr>";
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT AREA -->

    <!-- BEGIN FOOTER -->
    <?php require("templates/footer.php"); ?>
    <!-- END FOOTER -->
</div>
<!-- END MAIN CONTAINER -->

<!-- JS SCRIPTS -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/table/datatable/datatables.js"></script>
<script src="plugins/table/datatable/custom_dt_html5.js"></script>
<script src="plugins/table/datatable/dt-global_style.js"></script>
<script>
    $(document).ready(function () {
        $('#appointments-table').DataTable();
    });
</script>
</body>
</html>
