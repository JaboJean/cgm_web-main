<?php
// Single page PHP file to handle both fetching and displaying data
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

// Initialize variables for date range
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Build the SQL query with date of birth filter
$sql = "
    SELECT 
        c.child_id, 
        c.full_name, 
        c.date_of_birth, 
        c.weight AS child_weight, 
        c.status,
        h.height, 
        h.weight AS health_weight, 
        h.bmi_status, 
        h.record_date, 
        h.nutrition_info
    FROM child c
    LEFT JOIN health_info h ON c.child_id = h.child_id 
    WHERE bmi_status='Underweight'";

if ($startDate && $endDate) {
    $sql .= " AND c.date_of_birth BETWEEN '$startDate' AND '$endDate'";
}

$result = $conn->query($sql);
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
    <style>
        .required {
            color: red;
        }
    </style>

</head>

<body class="sidebar-noneoverflow">

<!--  BEGIN NAVBAR  -->
<?php require("templates/navBar.php"); ?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="cs-overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <?php require("templates/sideBar.php"); ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
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
                               role="tab" aria-controls="pills-home" aria-selected="true">Underweight</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-add-new-tab" data-toggle="pill" href="#pills-add-new"
                               role="tab" aria-controls="pills-add-new" aria-selected="false">Overweight</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-reports-tab" data-toggle="pill" href="#pills-reports"
                               role="tab" aria-controls="pills-reports" aria-selected="false">Obese</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Children Tab -->
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">

                            <!-- Date Filter Form -->
                            <form method="GET" class="mb-4">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= htmlspecialchars($startDate) ?>">
                                    </div>
                                    <div class="col">
                                        <input type="date" name="end_date" class="form-control" placeholder="End Date" value="<?= htmlspecialchars($endDate) ?>">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config1" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($data as $index => $item): ?>
                                        <?php
                                            // Determine the Bootstrap class based on BMI status
                                            $bmiClass = '';
                                            switch (strtolower($item['bmi_status'])) {
                                                case 'success':
                                                    $bmiClass = 'badge badge-success'; // Bootstrap class for green
                                                    break;
                                                case 'overweight':
                                                    $bmiClass = 'badge badge-warning'; // Bootstrap class for yellow
                                                    break;
                                                case 'obese':
                                                case 'underweight':
                                                    $bmiClass = 'badge badge-danger';  // Bootstrap class for red
                                                    break;
                                                default:
                                                    $bmiClass = 'badge badge-secondary';   // Bootstrap class for gray
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= !empty($item['full_name']) ? htmlspecialchars($item['full_name']) : 'N/A' ?></td>
                                            <td><?= !empty($item['date_of_birth']) ? htmlspecialchars($item['date_of_birth']) : 'N/A' ?></td>
                                            <td><?= !empty($item['height']) ? htmlspecialchars($item['height']) : 'N/A' ?></td>
                                            <td><?= !empty($item['health_weight']) ? htmlspecialchars($item['health_weight']) : 'N/A' ?></td>
                                            <td><span class="<?= $bmiClass ?>"><?= !empty($item['bmi_status']) ? htmlspecialchars($item['bmi_status']) : 'N/A' ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>

            </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Nutrition Tab -->
                        <div class="tab-pane fade" id="pills-add-new" role="tabpanel" aria-labelledby="pills-add-new-tab">
                             <!-- Date Filter Form -->
                             <form method="GET" class="mb-4">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= htmlspecialchars($startDate) ?>">
                                    </div>
                                    <div class="col">
                                        <input type="date" name="end_date" class="form-control" placeholder="End Date" value="<?= htmlspecialchars($endDate) ?>">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <?php
// Single page PHP file to handle both fetching and displaying data
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

// Initialize variables for date range
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Build the SQL query with date range filter
$sql = "
    SELECT 
        c.child_id, 
        c.full_name, 
        c.date_of_birth, 
        c.weight AS child_weight, 
        
        c.status,
        h.height, 
        h.weight AS health_weight, 
        h.bmi_status, 
        h.record_date, 
        h.nutrition_info
    FROM child c
    LEFT JOIN health_info h ON c.child_id = h.child_id 
    WHERE bmi_status='Overweight'";

if ($startDate && $endDate) {
    $sql .= " AND h.record_date BETWEEN '$startDate' AND '$endDate'";
}

$result = $conn->query($sql);
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config3" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($data as $index => $item): ?>
                                        <?php
                                            // Determine the Bootstrap class based on BMI status
                                            $bmiClass = '';
                                            switch (strtolower($item['bmi_status'])) {
                                                case 'success':
                                                    $bmiClass = 'badge badge-success'; // Bootstrap class for green
                                                    break;
                                                case 'overweight':
                                                    $bmiClass = 'badge badge-warning'; // Bootstrap class for yellow
                                                    break;
                                                case 'obese':
                                                case 'underweight':
                                                    $bmiClass = 'badge badge-danger';  // Bootstrap class for red
                                                    break;
                                                default:
                                                    $bmiClass = 'badge badge-secondary';   // Bootstrap class for gray
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= !empty($item['full_name']) ? htmlspecialchars($item['full_name']) : 'N/A' ?></td>
                                            <td><?= !empty($item['date_of_birth']) ? htmlspecialchars($item['date_of_birth']) : 'N/A' ?></td>
                                            <td><?= !empty($item['height']) ? htmlspecialchars($item['height']) : 'N/A' ?></td>
                                            <td><?= !empty($item['health_weight']) ? htmlspecialchars($item['health_weight']) : 'N/A' ?></td>
                                            <td><span class="<?= $bmiClass ?>"><?= !empty($item['bmi_status']) ? htmlspecialchars($item['bmi_status']) : 'N/A' ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>

             
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Assessments Tab -->
                        <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
                             <!-- Date Filter Form -->
                             <form method="GET" class="mb-4">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?= htmlspecialchars($startDate) ?>">
                                    </div>
                                    <div class="col">
                                        <input type="date" name="end_date" class="form-control" placeholder="End Date" value="<?= htmlspecialchars($endDate) ?>">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <?php
// Single page PHP file to handle both fetching and displaying data
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

// Initialize variables for date range
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Build the SQL query with date range filter
$sql = "
    SELECT 
        c.child_id, 
        c.full_name, 
        c.date_of_birth, 
        c.weight AS child_weight, 
        
        c.status,
        h.height, 
        h.weight AS health_weight, 
        h.bmi_status, 
        h.record_date, 
        h.nutrition_info
    FROM child c
    LEFT JOIN health_info h ON c.child_id = h.child_id 
    WHERE bmi_status='Obese'";

if ($startDate && $endDate) {
    $sql .= " AND h.record_date BETWEEN '$startDate' AND '$endDate'";
}

$result = $conn->query($sql);
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config4" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($data as $index => $item): ?>
                                        <?php
                                            // Determine the Bootstrap class based on BMI status
                                            $bmiClass = '';
                                            switch (strtolower($item['bmi_status'])) {
                                                case 'success':
                                                    $bmiClass = 'badge badge-success'; // Bootstrap class for green
                                                    break;
                                                case 'overweight':
                                                    $bmiClass = 'badge badge-warning'; // Bootstrap class for yellow
                                                    break;
                                                case 'obese':
                                                case 'underweight':
                                                    $bmiClass = 'badge badge-danger';  // Bootstrap class for red
                                                    break;
                                                default:
                                                    $bmiClass = 'badge badge-secondary';   // Bootstrap class for gray
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= !empty($item['full_name']) ? htmlspecialchars($item['full_name']) : 'N/A' ?></td>
                                            <td><?= !empty($item['date_of_birth']) ? htmlspecialchars($item['date_of_birth']) : 'N/A' ?></td>
                                            <td><?= !empty($item['height']) ? htmlspecialchars($item['height']) : 'N/A' ?></td>
                                            <td><?= !empty($item['health_weight']) ? htmlspecialchars($item['health_weight']) : 'N/A' ?></td>
                                            <td><span class="<?= $bmiClass ?>"><?= !empty($item['bmi_status']) ? htmlspecialchars($item['bmi_status']) : 'N/A' ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th width="30">No</th>
                                            <th>Names</th>
                                            <th>Date of Birth</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
                    <script src="bootstrap/js/popper.min.js"></script>
                    <script src="bootstrap/js/bootstrap.min.js"></script>
                    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
                    <script src="assets/js/app.js"></script>

                    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
   $(document).ready(function () {
    $('#zero-config1, #zero-config3, #zero-config4').DataTable({
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        buttons: [
            { extend: 'copy', className: 'btn btn-outline-secondary' },
            { extend: 'csv', className: 'btn btn-outline-secondary' },
            { extend: 'excel', className: 'btn btn-outline-secondary' },
            { extend: 'print', className: 'btn btn-outline-secondary' }
        ],
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [8, 10, 20, 50],
        "pageLength": 8
    });
});


                    </script>

                    </body>

                    </html>
