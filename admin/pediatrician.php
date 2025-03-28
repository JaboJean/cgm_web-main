<?php
require("configs/globals.php");

if (isset($_GET["type"])) {
    $type = htmlspecialchars($_GET["type"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $type; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
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
                                            <th width="30">No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>National ID</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($connection, "SELECT user_id, fname, lname, nid, gender, email, phone FROM users WHERE role='pediatrician'") or die(mysqli_error($connection));

                                        $no = 0;
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $no++;
                                        ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo htmlspecialchars($data["fname"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["lname"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["nid"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["gender"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["email"]); ?></td>
                                                <td><?php echo htmlspecialchars($data["phone"]); ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $no; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            More
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $no; ?>">
                                                            <a class="dropdown-item update-btn"
                                                               data-userid="<?php echo htmlspecialchars($data['user_id']); ?>"
                                                               data-firstname="<?php echo htmlspecialchars($data['fname']); ?>"
                                                               data-lastname="<?php echo htmlspecialchars($data['lname']); ?>"
                                                               data-nationalid="<?php echo htmlspecialchars($data['nid']); ?>"
                                                               data-gender="<?php echo htmlspecialchars($data['gender']); ?>"
                                                               data-email="<?php echo htmlspecialchars($data['email']); ?>"
                                                               data-phonenumber="<?php echo htmlspecialchars($data['phone']); ?>">
                                                               Update
                                                            </a>
                                                            <a class="dropdown-item" href="delete.php?id=<?php echo urlencode($data['user_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>National ID</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <a href="addpediatrician.php?service=<?php echo urlencode($type); ?>" class="btn btn-primary btn-rounded btn-floated"><i data-feather="plus-circle"></i> Add a user</a>
                    </div>
                </div>
            </div>
            <?php require("templates/footer.php"); ?>
        </div>
        <!-- END CONTENT AREA -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.6.0.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
    $(document).ready(function () {
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

        // Handle the Update button click
        $('body').on('click', '.dropdown-item.update-btn', function () {
            var userId = $(this).data('userid');
            var firstName = $(this).data('firstname');
            var lastName = $(this).data('lastname');
            var nationalID = $(this).data('nationalid');
            var gender = $(this).data('gender');
            var email = $(this).data('email');
            var phoneNumber = $(this).data('phonenumber');

            // Populate the modal with user data
            $('#updateFirstName').val(firstName);
            $('#updateLastName').val(lastName);
            $('#updateNationalID').val(nationalID);
            $('#updateGender').val(gender);
            $('#updateEmail').val(email);
            $('#updatePhoneNumber').val(phoneNumber);
            $('#updateUserId').val(userId);

            // Show the modal
            $('#updateModal').modal('show');
        });

        // Handle form submission
        $('#updateForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#updateModal').modal('hide'); // Hide the modal
                    $('#zero-config').DataTable().ajax.reload(); // Reload the DataTable
                },
                error: function () {
                    alert('Error updating record');
                }
            });
        });
    });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <!-- Modal HTML -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" action="update_user.php" method="post">
                        <div class="form-group">
                            <label for="updateFirstName">First Name</label>
                            <input type="text" class="form-control" id="updateFirstName" name="firstName">
                        </div>
                        <div class="form-group">
                            <label for="updateLastName">Last Name</label>
                            <input type="text" class="form-control" id="updateLastName" name="lastName">
                        </div>
                        <div class="form-group">
                            <label for="updateNationalID">National ID</label>
                            <input type="text" class="form-control" id="updateNationalID" name="nationalID">
                        </div>
                        <div class="form-group">
                            <label for="updateGender">Gender</label>
                            <input type="text" class="form-control" id="updateGender" name="gender">
                        </div>
                        <div class="form-group">
                            <label for="updateEmail">Email</label>
                            <input type="email" class="form-control" id="updateEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="updatePhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="updatePhoneNumber" name="phoneNumber">
                        </div>
                        <input type="hidden" id="updateUserId" name="userId">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
} else {
    echo '<script>history.back();</script>';
}
?>
