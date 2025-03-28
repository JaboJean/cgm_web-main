<?php
require("configs/globals.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["questionnaire_doc"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a valid type
    $valid_types = array("pdf", "doc", "docx");
    if (!in_array($fileType, $valid_types)) {
        echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["questionnaire_doc"]["tmp_name"], $target_file)) {
            // File uploaded successfully
            echo "The file ". htmlspecialchars(basename($_FILES["questionnaire_doc"]["name"])) . " has been uploaded.";
            // Insert into database if necessary
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch user ID based on token
$token = $_COOKIE["CGMTOKEN"];
$query = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
$data = mysqli_fetch_assoc($query);
$userId = $data["user_id"];

// Query to get child data based on the user's ID
$querychild = mysqli_query($connection, "SELECT * FROM child WHERE father_id = '$userId'") or die(mysqli_error($connection));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Vaccinations</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
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
                        <div class="table-responsive mb-4 mt-4">
                            <table id="vaccinations-table" class="table table-hover non-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Vaccinations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($querychild->num_rows > 0) {
                                        $counter = 1; // Initialize counter
                                        while ($row = $querychild->fetch_assoc()) {
                                            $vaccinations = !empty($row["vaccinations"]) ? htmlspecialchars($row["vaccinations"]) : "N/A";
                                            echo "<tr>";
                                            echo "<td>" . $counter . "</td>"; // Display counter value
                                            echo "<td>" . $vaccinations . "</td>";
                                            echo "</tr>";
                                            $counter++; // Increment counter
                                        }
                                    } else {
                                        echo "<tr><td colspan='2'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Vaccinations</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END CONTENT AREA -->
        </div>
    </div>

    <!-- BEGIN FOOTER -->
    <?php require("templates/footer.php"); ?>
    <!-- END FOOTER -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/table/datatable/datatables.js"></script>
<script src="plugins/table/datatable/custom_dt_html5.js"></script>
<script src="assets/js/app.js"></script>
<script>
    $(document).ready(function () {
        $('#vaccinations-table').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn'
                },
                {
                    extend: 'print',
                    className: 'btn'
                }
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
