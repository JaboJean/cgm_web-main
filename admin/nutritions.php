<?php require("configs/globals.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Nutritions</title>
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
                        <?php require("scripts/nutrition_in.php"); ?>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                       role="tab" aria-controls="pills-home" aria-selected="true">Nutritions</a>
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
                                                <th>Age Group</th>
                                                <th>BMI Category</th>
                                                <th>Calories</th>
                                                <th>Protein</th>
                                                <th>Meal Plans</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query = mysqli_query($connection, "SELECT * FROM nutrition ORDER BY id ASC") or die(mysqli_error($connection));

                                            $no = 0;
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $no++; ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo htmlspecialchars($data["age_group"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["bmi_category"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["calories"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["protein"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["meal_plans"]); ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>Age Group</th>
                                                <th>BMI Category</th>
                                                <th>Calories</th>
                                                <th>Protein</th>
                                                <th>Meal Plans</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="card col-md-10 mt-4">
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="age_group">Age Group<span class="required">*</span></label>
                                                        <select name="age_group" id="age_group" class="form-control" required>
                                                            <option value="">Select Age Group</option>
                                                            <option value="1-3">1-3 years</option>
                                                            <option value="3-4">3-4 years</option>
                                                            <option value="4-6">4-6 years</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="bmi_category">BMI Category<span class="required">*</span></label>
                                                        <select name="bmi_category" id="bmi_category" class="form-control" required>
                                                            <option value="">Select BMI Category</option>
                                                            <option value="Underweight">Underweight</option>
                                                            <option value="Normal weight">Normal weight</option>
                                                            <option value="Overweight">Overweight</option>
                                                            <option value="Obesity">Obesity</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="calories">Calories<span class="required">*</span></label>
                                                        <input type="number" step="0.01" name="calories" id="calories" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="protein">Protein<span class="required">*</span></label>
                                                        <input type="number" step="0.01" name="protein" id="protein" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="meal_plans">Meal Plans<span class="required">*</span></label>
                                                        <textarea name="meal_plans" id="meal_plans" class="form-control" required></textarea>
                                                    </div>
                                                </div>

                                                <button type="submit" name="sendRequest" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php require("templates/footer.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT AREA -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <!-- Include DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#zero-config1').DataTable({
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: [
                    {
                        extend: 'print',
                        className: 'btn btn-primary'
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
                "pageLength": 8,
                "pagingType": "full_numbers",
                "responsive": true
            });
        });
    </script>
</body>

</html>
