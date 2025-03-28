<?php require("configs/globals.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Players</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
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
        <?php require("templates/sideBar.php");  ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing" id="cancel-row">

                    <?php if (isset($_GET["profile"])) {
                        $playerId = $_GET["profile"];
                        $query = mysqli_query($connection, "SELECT * FROM  players, countries WHERE players.country_id = countries.country_id AND player_id ='$playerId'") or die(mysqli_error($connection));
                        $data = mysqli_fetch_assoc($query);
                    ?>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="user-profile layout-spacing">
                                <div class="widget-content widget-content-area">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="">Profile</h3>
                                        <a href="updatePlayer?p=<?php print($data["player_id"]); ?>" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg></a>
                                    </div>
                                    <div class="text-center user-info">
                                        <img src="http://E-TUNGO.itdevs.rw/catalog/pictures/<?php print($data["profile_picture"]); ?>" alt="avatar" class="img-fluid">
                                        <p class=""></p>
                                    </div>
                                    <div class="user-info-list">

                                        <div class="row">
                                            <div class="col">
                                                <ul class="contacts-block list-unstyled">
                                                    <li class="text-success">
                                                        <i data-feather="user-check"></i><b>License: </b><?php print($data["license_no"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <a href="#"><i data-feather="user"></i><b>Names: </b></a><?php print($data["player_fname"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <a href="#"><i data-feather="phone"></i><b>Phone: </b> </a><?php print($data["phone"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="flag"></i><b>Nationality:</b> <?php print($data["country_name"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="calendar"></i><b>D.O.B: </b> <?php print($data["dob"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="link-2"></i><b>Gender: </b> <?php print($data["gender"]); ?>
                                                    </li>

                                                    <li class="contacts-block__item">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["declaration"]); ?>">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file-text"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["payment_proof"]); ?>">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file-text"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col">
                                                <ul class="contacts-block list-unstyled">
                                                    <li class="text-success">
                                                        <i data-feather="user-check"></i><b>License: </b><?php print($data["license_no"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <a href="#"><i data-feather="user"></i><b>Names: </b></a><?php print($data["player_fname"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <a href="#"><i data-feather="phone"></i><b>Phone: </b> </a><?php print($data["phone"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="flag"></i><b>Nationality:</b> <?php print($data["country_name"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="calendar"></i><b>D.O.B: </b> <?php print($data["dob"]); ?>
                                                    </li>
                                                    <li class="">
                                                        <i data-feather="link-2"></i><b>Gender: </b> <?php print($data["gender"]); ?>
                                                    </li>

                                                    <li class="contacts-block__item">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["declaration"]); ?>">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file-text"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["payment_proof"]); ?>">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">
                                                                    <div class="social-icon">
                                                                        <i data-feather="file-text"></i>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-9 layout-spacing">
                        <?php } else { ?>
                            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <?php } ?>
                            <?php require("scripts/main.php"); ?>
                            <div class="widget-content widget-content-area br-6">
                                <div class="table-responsive mb-4 mt-4">
                                    <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>License No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Country</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th width="50">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            $query = mysqli_query($connection, "SELECT * FROM  players, countries WHERE players.country_id = countries.country_id AND club_id ='$CLUBID' ORDER BY player_id  DESC") or die(mysqli_error($connection));
                                            $no = 0;
                                            while ($data = mysqli_fetch_assoc($query)) {
                                                $no++; ?>
                                                <tr>
                                                    <td><?php print($no) ?></td>
                                                    <td><span class="text-success"><?php print($data["license_no"]); ?></span></td>
                                                    <td><?php print($data["player_fname"]); ?></td>
                                                    <td><?php print($data["player_lname"]); ?></td>
                                                    <td><?php print($data["country_name"]); ?></td>
                                                    <td><?php print($data["phone"]); ?></td>
                                                    <td><?php print($data["player_status"]); ?></td>
                                                    <td>

                                                        <div class="btn-group">

                                                            <button type="button" class="btn btn-default btn-sm">More</button>
                                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference<?php print($no) ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="profile?profile=<?php print($data["player_id"]); ?>">View Profile</a>
                                                                <a class="dropdown-item" target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["declaration"]); ?>">Declaration</a>
                                                                <a class="dropdown-item" target="_blank" href="http://E-TUNGO.itdevs.rw/catalog/docs/<?php print($data["payment_proof"]); ?>">Payment Proof</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item text-info" href="updatePlayer?p=<?php print($data["player_id"]); ?>">Edit</a>
                                                            </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th width="30">No</th>
                                                <th>License No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Country</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th width="50">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <a href="addPlayer" class="btn btn-primary btn-rounded btn-floated"><i data-feather="plus-circle"></i></a>

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
            $(document).ready(function() {
                $(".players").addClass("active");
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