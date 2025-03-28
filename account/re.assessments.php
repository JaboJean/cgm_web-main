<?php
require("configs/globals.php");

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
            // Insert into database
            $sql = "INSERT INTO assessments (title, description, questionnaire_doc, comment) VALUES (?, ?, ?, ?)";
            if ($stmt = $connection->prepare($sql)) {
                $stmt->bind_param("ssss", $title, $description, $target_file, $comment);
                if ($stmt->execute()) {
                    echo "The file " . htmlspecialchars(basename($_FILES["questionnaire_doc"]["name"])) . " has been uploaded and data has been inserted.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Requests</title>
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
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
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
                                   role="tab" aria-controls="pills-home" aria-selected="true">My Assessments</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="pills-reports-tab" data-toggle="pill" href="#pills-reports"
                                   role="tab" aria-controls="pills-reports" aria-selected="false">My Responses</a>
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
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Questionnaire Doc</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT id, title, description, questionnaire_doc, comment FROM assessments";
                                            $result = $connection->query($sql);
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["id"] . "</td>";
                                                    echo "<td>" . $row["title"] . "</td>";
                                                    echo "<td>" . $row["description"] . "</td>";
                                                    echo "<td><a href='" . $row["questionnaire_doc"] . "' target='_blank'>View</a></td>";
                                                    echo "<td>" . $row["comment"] . "</td>";
                                                    echo "<td>";
                                                    echo "<button type='button' class='btn btn-danger' onclick='respond(" . $row["id"] . ")'>Respond</button>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No assessments found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Questionnaire Doc</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-add-new" role="tabpanel" aria-labelledby="pills-add-new-tab">
                                <div class="card col-md-10 mt-4">
                                    <div class="card-body">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <!-- Form fields -->
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="title">Title<span class="required">*</span></label>
                                                    <input type="text" name="title" id="title" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="description">Description<span class="required">*</span></label>
                                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="questionnaire_doc">Questionnaire Doc<span class="required">*</span></label>
                                                    <input type="file" name="questionnaire_doc" id="questionnaire_doc" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="comment">Comment</label>
                                                <textarea name="comment" id="comment" class="form-control"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" name="sendRequest" class="btn btn-primary btn-sm">Send request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config2" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Questionnaire Doc</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PHP code to fetch and display responses -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Questionnaire Doc</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
        $('#zero-config1').DataTable({
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
                }]
            },
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

    function respond(id) {
        // Handle the respond action
        window.location.href = 'respondAssessment.php?id=' + id;
    }
</script>

</body>
</html>
