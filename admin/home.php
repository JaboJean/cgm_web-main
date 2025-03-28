<?php 
require("configs/globals.php");

// Initialize $type with a default value
$type = 'default_type'; // Replace 'default_type' with a suitable default value for your context

if (isset($_GET["type"])) {
    $type = $_GET["type"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php print $type; ?></title>
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
                    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                        <?php require("scripts/main.php"); ?>
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Description</th>
                                            <th>Parent</th>
                                            <th>Child</th>
                                            <th>Appointment Date</th>
                                            <th>Parent Phone Number</th>
                                            <th>Pediatrician</th>
                                            <th>Request Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8">
                                                <form method="GET" action="home.php">
                                                    <div class="form-group">
                                                        <label for="age_group">Select Age Group:</label>
                                                        <select id="age_group" name="age_group" class="form-control">
                                                            <option value="1-3">1-3 years</option>
                                                            <option value="4-8">4-8 years</option>
                                                            <!-- Add more age groups as needed -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bmi_category">Select BMI Category:</label>
                                                        <select id="bmi_category" name="bmi_category" class="form-control">
                                                            <option value="Underweight">Underweight</option>
                                                            <option value="Normal weight">Normal weight</option>
                                                            <option value="Overweight">Overweight</option>
                                                            <option value="Obese">Obese</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" name="action" value="nutrition" class="btn btn-primary">Get Nutrition Info</button>
                                                        <button type="submit" name="action" value="recipes" class="btn btn-secondary">Get Recipes</button>
                                                        <button type="submit" name="action" value="meal_plans" class="btn btn-success">Get Meal Plans</button>
                                                    </div>
                                                </form>

                                                <?php
                                                if (isset($_GET['age_group']) && isset($_GET['bmi_category']) && isset($_GET['action'])) {
                                                    $age_group = $_GET['age_group'];
                                                    $bmi_category = $_GET['bmi_category'];
                                                    $action = $_GET['action'];

                                                    $api_url = "http://localhost/CGM-main/CGM-main/admin/extended_nutrition_api.php?endpoint={$action}&age_group={$age_group}&bmi_category=" . urlencode($bmi_category);
                                                    $response = file_get_contents($api_url);
                                                    $data = json_decode($response, true);

                                                    if (isset($data['error'])) {
                                                        echo "<p>Error: " . $data['error'] . "</p>";
                                                    } else {
                                                        echo "<h5>" . ucfirst($action) . " for Age Group {$age_group} and BMI Category {$bmi_category}</h5>";
                                                        if ($action == 'recipes' || $action == 'meal_plans') {
                                                            echo "<div class='row'>";
                                                            foreach ($data as $item) {
                                                                echo "<div class='col-md-4'>";
                                                                echo "<div class='card mb-4'>";
                                                                echo "<div class='card-body'>";
                                                                echo "<h5 class='card-title'>" . (isset($item['title']) ? $item['title'] : 'No title') . "</h5>";
                                                                echo "<p class='card-text'>" . (isset($item['description']) ? $item['description'] : 'No description') . "</p>";
                                                                if (isset($item['ingredients'])) {
                                                                    echo "<h6>Ingredients:</h6>";
                                                                    echo "<ul>";
                                                                    foreach ($item['ingredients'] as $ingredient) {
                                                                        echo "<li>" . $ingredient . "</li>";
                                                                    }
                                                                    echo "</ul>";
                                                                }
                                                                if (isset($item['instructions'])) {
                                                                    echo "<h6>Instructions:</h6>";
                                                                    echo "<p>" . $item['instructions'] . "</p>";
                                                                }
                                                                echo "</div>";
                                                                echo "</div>";
                                                                echo "</div>";
                                                            }
                                                            echo "</div>";
                                                        } elseif ($action == 'nutrition') {
                                                            echo "<div class='row'>";
                                                            foreach ($data as $item) {
                                                                echo "<div class='col-md-4'>";
                                                                echo "<div class='card mb-4'>";
                                                                echo "<div class='card-body'>";
                                                                echo "<h5 class='card-title'>" . (isset($item['title']) ? $item['title'] : 'No title') . "</h5>";
                                                                echo "<p class='card-text'>" . (isset($item['nutrition_info']) ? $item['nutrition_info'] : 'No nutrition information') . "</p>";
                                                                echo "</div>";
                                                                echo "</div>";
                                                                echo "</div>";
                                                            }
                                                            echo "</div>";
                                                        } else {
                                                            echo "<pre>" . print_r($data, true) . "</pre>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Description</th>
                                            <th>Parent</th>
                                            <th>Child</th>
                                            <th>Appointment Date</th>
                                            <th>Parent Phone Number</th>
                                            <th>Pediatrician</th>
                                            <th>Request Status</th>
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
        <!-- END CONTENT AREA -->
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
            $(".<?php print $type; ?>").addClass("active");
            $(".<?php print $type; ?>").addClass("show");
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
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<i class="flaticon-left-arrow"></i>',
                    "sNext": '<i class="flaticon-right-arrow"></i>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<i class="flaticon-search-1"></i>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_"
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10 
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
