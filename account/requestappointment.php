<?php
require("configs/globals.php");

// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

// Establish database connection
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die(mysqli_error($connection));

// Retrieve token from cookie and get user_id
if (isset($_COOKIE["CGMTOKEN"])) {
    $token = $_COOKIE["CGMTOKEN"];
    $query = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);
    $userId = $data["user_id"];
    
    // SQL query to join appointment with users to get full names for both parent and pediatrician
    $query = "
        SELECT 
            appointment.*, 
            parent.fname AS parent_fname, 
            parent.lname AS parent_lname,
            pediatrician.fname AS pediatrician_fname,
            pediatrician.lname AS pediatrician_lname
        FROM 
            appointment
        INNER JOIN 
            users AS parent ON appointment.user_id = parent.user_id
        LEFT JOIN 
            users AS pediatrician ON appointment.pediatrician = pediatrician.user_id
        WHERE 
            appointment.user_id = '$userId'
    ";

    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
} else {
    // Handle case where token is not set
    die("User is not authenticated.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Requests</title>
    <link rel="icon" type="image/x-icon" href=""/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL CUSTOM STYLES -->

    <style>
        .required {
            color: red;
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

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                   role="tab" aria-controls="pills-home" aria-selected="true">My requests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                   role="tab" aria-controls="pills-profile" aria-selected="false">Add New</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                 aria-labelledby="pills-home-tab">

                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config1" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Type</th>
                                            <th>Parent</th>
                                            <th>Pediatrician</th>
                                            <th>Request Date</th>
                                            <th>Request Time</th>
                                            <th>Status</th>
                                            <th width="50">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        if ($result !== false) {
                                            $no = 0;
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                $no++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo htmlspecialchars($data['request_type']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['parent_fname'] . ' ' . $data['parent_lname']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['pediatrician_fname'] . ' ' . $data['pediatrician_lname']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['appointment_date']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['appointment_time']); ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $statusClass = '';
                                                        if ($data['request_status'] == 'Pending') {
                                                            $statusClass = 'badge badge-danger';
                                                        } elseif ($data['request_status'] == 'Approved') {
                                                            $statusClass = 'badge badge-success';
                                                        }
                                                        ?>
                                                        <span class="<?php echo $statusClass; ?>">
                                                            <?php echo htmlspecialchars($data['request_status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
    <div class="btn-group">
        <!-- Dropdown Toggle Button -->
        <button type="button" class="btn btn-da btn-sm dropdown-toggle" id="dropdownMenuReference<?php echo $no; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            More
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
        <!-- Dropdown Menu -->
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference<?php echo $no; ?>">
            <?php if($data["request_status"] == "Pending"){ ?>
                <a class="dropdown-item text-warning" href="rescheduleAppointment.php?request=<?php echo $data['request_id']; ?>">Reschedule</a>
                <a class="dropdown-item text-danger" href="?cancelRequest=<?php echo $data['request_id']; ?>">Cancel</a>
            <?php } ?>
           
        </div>
    </div>
</td>

                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "Error: " . mysqli_error($connection);
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Type</th>
                                            <th>Parent</th>
                                            <th>Pediatrician</th>
                                            <th>Request Date</th>
                                            <th>Request Time</th>
                                            <th>Status</th>
                                            <th width="50">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                <div class="card col-md-10 mt-4">
                                    <div class="card-body">

                                        <form action="" method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="request_type">Appointment type<span class="required">*</span></label>
                                                    <select name="request_type" id="type" class="form-control" required>
                                                        <option value="">-- Select request --</option>
                                                        <option value="Diagnosis">Diagnosis</option>
                                                        <option value="Vaccination">Vaccination</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="pediatrician">Pediatricians<span class="required">*</span></label>
                                                    <select name="pediatrician" id="pediatrician" class="form-control" required>
                                                        <option value="">-- Select Pediatrician --</option>
                                                        <?php
                                                        // Fetch pediatricians from the database
                                                        $pediatriciansQuery = mysqli_query($connection, "SELECT user_id, fname, lname FROM users WHERE role = 'pediatrician'") or die(mysqli_error($connection));
                                                        while ($pediatrician = mysqli_fetch_assoc($pediatriciansQuery)) {
                                                            echo "<option value='{$pediatrician['user_id']}'>" . htmlspecialchars($pediatrician['fname'] . ' ' . $pediatrician['lname']) . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="request_date">Date<span class="required">*</span></label>
                                                    <input type="date" name="request_date" id="request_date" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="request_time">Time<span class="required">*</span></label>
                                                    <input type="time" name="request_time" id="request_time" class="form-control" required>
                                                </div>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- BEGIN FOOTER -->
        <?php require("templates/footer.php"); ?>
        <!-- END FOOTER -->

    </div>
    <!-- END CONTENT AREA -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="assets/js/libs/jquery-ui.min.js"></script>
<script src="plugins/table/datatable/datatables.js"></script>
<script src="plugins/table/datatable/custom_dt_html5.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

</html>

<?php
// Handle cancellation request
if (isset($_GET['cancelRequest'])) {
    $requestId = $_GET['cancelRequest'];
    $cancelQuery = "UPDATE appointment SET request_status = 'Cancelled' WHERE request_id = '$requestId'";
    if (mysqli_query($connection, $cancelQuery)) {
        header("Location: requests.php");
        exit();
    } else {
        echo "Error cancelling request: " . mysqli_error($connection);
    }
}

// Handle reschedule request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestType = $_POST['request_type'];
    $pediatrician = $_POST['pediatrician'];
    $requestDate = $_POST['request_date'];
    $requestTime = $_POST['request_time'];

    $insertQuery = "INSERT INTO appointment (user_id, request_type, pediatrician, appointment_date, appointment_time, request_status) 
                    VALUES ('$userId', '$requestType', '$pediatrician', '$requestDate', '$requestTime', 'Pending')";

    if (mysqli_query($connection, $insertQuery)) {
        echo "<div class='alert alert-success'>Request submitted successfully.</div>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
