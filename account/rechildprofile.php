<?php 
require("configs/globals.php");
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_COOKIE["CGMTOKEN"])) {
    $token = $_COOKIE["CGMTOKEN"];
    
    // Database connection
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "cgm";

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get parent email from the token or session
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
                <title>Child Information</title>
                <link rel="icon" type="image/x-icon" href=""/>
                <!-- BEGIN GLOBAL MANDATORY STYLES -->
                <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
                <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
                <!-- END GLOBAL MANDATORY STYLES -->
                <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
                <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
                <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
                <!-- END PAGE LEVEL CUSTOM STYLES -->
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
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div class="widget-content widget-content-area br-6">
                                    <div class="table-responsive mb-4 mt-4">
                                        <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="30">No</th>
                                                    <th>Full Name</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th>Weight</th>
                                                    <th>Height</th>    
                                                    <th>BMI Status</th>                     
                                                    <th>Condition</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php
    // Initialize $no before starting the loop
    $no = 1;

    // Retrieve the token from cookies
    $token = $_COOKIE["CGMTOKEN"];

    // Query to get the user data based on the token
    $query = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
    $data = mysqli_fetch_assoc($query);
    $userId = $data["user_id"];

    // Query to get the child data based on the user's ID
    $querychild = mysqli_query($connection, "SELECT * FROM child WHERE father_id = '$userId'") or die(mysqli_error($connection));
    
    // Loop through the child records and fetch corresponding health data
    while($child = mysqli_fetch_assoc($querychild)) {
        // Fetch health data for the current child
        $childId = $child['child_id']; // Assuming 'child_id' is the primary key in the child table
        $queryHealth = mysqli_query($connection, "SELECT * FROM health_info WHERE child_id = '$childId'") or die(mysqli_error($connection));
        $healthInfo = mysqli_fetch_assoc($queryHealth);
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($child['full_name']); ?></td>
            <td><?php echo htmlspecialchars($child['date_of_birth']); ?></td>
            <td><?php echo htmlspecialchars($child['gender']); ?></td>
            <td><?php echo htmlspecialchars($healthInfo['weight'] ?? 'N/A'); ?></td> <!-- Handle null values -->
            <td><?php echo htmlspecialchars($healthInfo['height'] ?? 'N/A'); ?></td> <!-- Handle null values -->
            <td><?php echo htmlspecialchars($healthInfo['bmi_status'] ?? 'N/A'); ?></td> <!-- Handle null values -->

            <td><?php echo htmlspecialchars($healthInfo['Condition'] ?? 'N/A'); ?></td> <!-- Handle null values -->

            <!-- Add more fields as necessary -->
        </tr>
    <?php } ?>
</tbody>













 
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th width="30">No</th>
                                                    <th>Full Name</th>
                                                    <th>DOB</th>
                                                     <th>Gender</th>
                                                    <th>Weight</th>
                                                    <th>Height</th>    
                                                    <th>BMI Status</th>                     
                                                    <th>Condition</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php require("templates/footer.php"); ?>
                </div>
                <!--  END CONTENT AREA  -->
            </div>
            <!-- END MAIN CONTAINER -->

            <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
            <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
            <script src="bootstrap/js/popper.min.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="assets/js/app.js"></script>

            <script>
                $(document).ready(function () {
                    $(".<?php echo $type; ?>").addClass("active");
                    $(".<?php echo $type; ?>").addClass("show");
                    App.init();
                });
            </script>
            <script src="assets/js/custom.js"></script>
            <!-- END GLOBAL MANDATORY SCRIPTS -->

            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="plugins/table/datatable/datatables.js"></script>
            <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
            <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
            <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
            <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
            <script>
                $('#zero-config').DataTable({
                    dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                    buttons: {
                        buttons: [{
                            extend: 'copy',
                            className: 'btn'
                        },
                            {
                                extend: 'csv',
                                className: 'btn'
                            },
                            {
                                extend: 'excel',
                                className: 'btn'
                            },
                            {
                                extend: 'print',
                                className: 'btn'
                            }
                        ]
                    }
                });
            </script>
            <!-- END PAGE LEVEL SCRIPTS -->

            </body>
            </html>

            <?php
        } ?>
