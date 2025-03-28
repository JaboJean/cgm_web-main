<?php require("configs/globals.php");

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

                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <?php require("scripts/main.php"); ?>
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th width="30">No</th>
                                        <th>F Name</th>
                                        <th>L Name</th>
                                        <th>Service</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>                       
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

$query = mysqli_query($connection, "SELECT * FROM  tasks ORDER BY task_id DESC") or die(mysqli_error($connection));
$no = 0;
while ($data = mysqli_fetch_assoc($query)) {
    $no++; ?>     
    <tr>
        <td><?php print($no) ?></td>
        <td><?php print($data["fname"]); ?></td>
        <td><?php print($data["lname"]); ?></td>
        <td><?php print($data["service"]); ?></td>
        <td><?php print($data["phone"]); ?></td>
        <td><?php print($data["email"]); ?></td>
        <td><?php print($data["gender"]); ?></td>
       
 

                                            
                                            <td><?php print($data["status"]); ?></td>
                                            <td>
                                                <div class="btn-group">

                                                    <button type="button" class="btn btn-default btn-sm">More</button>
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference<?php print($no) ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- <a class="dropdown-item" href="#">View More deatils</a> -->
                                                        <a class="dropdown-item text-info" href="?approve_user=<?php echo $data['id']; ?>&type=<?php echo $type; ?>">Approve</a>
                                                        <a class="dropdown-item text-warning" href="?reject_user=<?php echo $data['id']; ?>&type=<?php echo $type; ?>">Reject </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                    <th width="30">No</th>
                                        <th>F Name</th>
                                        <th>L Name</th>
                                        <th>Service</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <a href="addtask.php?service=<?php print $type; ?>" class="btn btn-primary btn-rounded btn-floated"><i
                                    data-feather="plus-circle"></i> Assign Task</a>
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
            $(".<?php print $type; ?>").addClass("active");
            $(".<?php print $type; ?>").addClass("show");
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
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
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
    </body>

    </html>

