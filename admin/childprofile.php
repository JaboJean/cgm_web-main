<?php require("configs/globals.php");

if (isset($_GET["type"])) {
    $type = $_GET["type"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php print $type; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/logoos.jpg"/>
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

    <!-- Additional Custom Styles -->
 


<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Child Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateForm" action="scripts/update_child_process.php" method="POST">
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#parentInfo" role="tab">Parent Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#childInfo" role="tab">Child Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vaccinationsInfo" role="tab">Vaccinations</a>
                        </li>
                    </ul>

                    <!-- Tab panes --> 
                    <div class="tab-content">
                        <div class="tab-pane active" id="parentInfo" role="tabpanel">
                            
                            <!-- Parent Info Form Fields -->
                             
                            <div class="form-group">
                                <label for="father">Father/Guardian:</label>
                                <input type="text" id="father" name="father" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="mother">Mother/Guardian:</label>
                                <input type="text" id="mother" name="mother" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="parent_phone">Parent/Guardian Phone<span class="required">*</span></label>
                                <input type="text" class="form-control" id="parent_phone" name="parent_phone" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Parent/Guardian Email<span class="required">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="tab-pane" id="childInfo" role="tabpanel">
                            <!-- Child Info Form Fields -->
                            <input type="hidden" id="child_id" name="child_id" value="">
                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="join_date">Join Date<span class="required">*</span></label>
                                <input type="date" class="form-control" id="join_date" name="join_date" placeholder="Select join date" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender<span class="required">*</span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="vaccinationsInfo" role="tabpanel">
                            <!-- Vaccinations Info Form Fields -->
                            <div class="form-group">
                                <label for="vaccinations">Vaccinations Taken:</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="measles_rubella" name="vaccinations[]" value="Measles-Rubella">
                                    <label class="form-check-label" for="measles_rubella">Measles-Rubella</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="vitamin_a" name="vaccinations[]" value="Vitamin A">
                                    <label class="form-check-label" for="vitamin_a">Vitamin A Supplementation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deworming" name="vaccinations[]" value="Deworming">
                                    <label class="form-check-label" for="deworming">Deworming</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="booster_doses" name="vaccinations[]" value="Booster Doses">
                                    <label class="form-check-label" for="booster_doses">Booster Doses (DTP)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="typhoid_vaccine" name="vaccinations[]" value="Typhoid Vaccine">
                                    <label class="form-check-label" for="typhoid_vaccine">Typhoid Vaccine</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="completeInfoModal" tabindex="-1" role="dialog" aria-labelledby="completeInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeInfoModalLabel">Complete Missing Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
        <!-- Your form and other content -->

        <?php
        if (isset($_GET['message'])) {
            $message = htmlspecialchars($_GET['message']);
            echo '<div class="alert alert-info">' . $message . '</div>';
        }
        ?>

        <!-- Rest of your page content -->
    </div>
<!-- Your form HTML goes here -->

            <form id="completeInfoForm" action="scripts/complete_info_process.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Existing form fields -->
                    <input type="hidden" id="health_info_id" name="health_info_id" value="">
                    <input type="hidden" id="child_id" name="child_id" value="">
                    <!-- BMI Calculation fields -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="height">Height (cm):<span class="text-danger">*</span></label>
                            <input type="number" id="height" name="height" class="form-control" placeholder="Enter Height" required>
                        </div>
                        <div class="col-md-6">
                            <label for="weight">Weight (kg):<span class="text-danger">*</span></label>
                            <input type="number" id="weight" name="weight" class="form-control" placeholder="Enter Weight" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="bmi">BMI:<span class="text-danger">*</span></label>
                            <input type="text" id="bmi" name="bmi" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="bmi_status">BMI Status:<span class="text-danger">*</span></label>
                            <input type="text" id="bmi_status" name="bmi_status" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="record_date">Record Date:<span class="text-danger">*</span></label>
                            <input type="date" id="record_date" name="record_date" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="health_info_doc">Health Info Document:</label>
                            <input type="file" id="health_info_doc" name="health_info_doc" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="nutrition_info">Nutrition Info:<span class="text-danger">*</span></label>
                            <input type="text" id="nutrition_info" name="nutrition_info" class="form-control" placeholder="Enter Nutrition Info" required>
                        </div>
                        <div class="col-md-6">
                            <label for="condition">Condition:<span class="text-danger">*</span></label>
                            <input type="text" id="condition" name="condition" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



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
                <?php require("scripts/main.php"); ?>
                <div class="widget-content widget-content-area br-6">
                   <!-- Date Filter Form -->
                   <form method="GET" class="mb-4">
                        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
                        <div class="form-row">
                            <div class="col">
                                <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                            </div>
                            <div class="col">
                                <input type="date" name="end_date" class="form-control" placeholder="End Date" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="30">No</th>
                                    <th>Full Name</th>
                                    <th>DOB</th>
                                    <th>Join Date</th> 
                                    <th>Gender</th>
                                    <th>Father/Gdian</th>
                                    <th>Mother/Gdian</th>
                                    <th>Status</th>
                                    <th>More</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                            $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                            $query = "SELECT 
                                        child.child_id,
                                        child.full_name,
                                        child.date_of_birth,
                                        child.join_date,
                                        child.gender,
                                        father.fname AS father_fname,
                                        father.lname AS father_lname,
                                        mother.fname AS mother_fname,
                                        mother.lname AS mother_lname,
                                        child.weight,
                                        child.status
                                    FROM 
                                        child
                                    LEFT JOIN 
                                        users AS father ON child.father_id = father.user_id
                                    LEFT JOIN 
                                        users AS mother ON child.mother_id = mother.user_id";

                            if ($startDate && $endDate) {
                                $query .= " WHERE child.date_of_birth BETWEEN '$startDate' AND '$endDate'";
                            }

                            // Remove the debugging line
                            // echo "<pre>$query</pre>";

                            $queryResult = mysqli_query($connection, $query) or die(mysqli_error($connection));
                            $no = 0;

                            // Check if there are any results
                            if (mysqli_num_rows($queryResult) > 0) {
                                while ($data = mysqli_fetch_assoc($queryResult)) {
                                    $no++;
                                    $statusStyle = ($data["status"] == "Incomplete") ? 'style="color: red;"' : 'style="color: green;"';
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo htmlspecialchars($data["full_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($data["date_of_birth"]); ?></td>
                                        <td><?php echo htmlspecialchars($data["join_date"]); ?></td>
                                        <td><?php echo htmlspecialchars($data["gender"]); ?></td>
                                        <td><?php echo htmlspecialchars($data["father_fname"] . ' ' . $data["father_lname"]); ?></td>
                                        <td><?php echo htmlspecialchars($data["mother_fname"] . ' ' . $data["mother_lname"]); ?></td>
                                        <td <?php echo $statusStyle; ?>><?php echo htmlspecialchars($data["status"]); ?></td>
                                        <td>
                                        
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item update-link" href="#" data-toggle="modal" data-target="#updateModal"
                       data-childid="<?php echo htmlspecialchars($data["child_id"]); ?>"
                       data-fullname="<?php echo htmlspecialchars($data["full_name"]); ?>"
                       data-dob="<?php echo htmlspecialchars($data["date_of_birth"]); ?>"
                       data-joindate="<?php echo htmlspecialchars($data["join_date"]); ?>"
                       data-gender="<?php echo htmlspecialchars($data["gender"]); ?>"
                       data-fatherfname="<?php echo htmlspecialchars($data["father_fname"]); ?>"
                       data-fatherlname="<?php echo htmlspecialchars($data["father_lname"]); ?>"
                       data-motherfname="<?php echo htmlspecialchars($data["mother_fname"]); ?>"
                       data-motherlname="<?php echo htmlspecialchars($data["mother_lname"]); ?>"
                       data-weight="<?php echo isset($data["weight"]) ? htmlspecialchars($data["weight"]) : ''; ?>"
                       data-parentphone="<?php echo isset($data["parent_phone"]) ? htmlspecialchars($data["parent_phone"]) : ''; ?>"
                       data-email="<?php echo isset($data["email"]) ? htmlspecialchars($data["email"]) : ''; ?>">Update</a>
         









                        <a class="dropdown-item complete-info-link" href="#" data-toggle="modal" data-target="#completeInfoModal"
                           data-healthinfoid="<?php echo isset($data["health_info_id"]) ? $data["health_info_id"] : ''; ?>"
                           data-childid="<?php echo isset($data["child_id"]) ? $data["child_id"] : ''; ?>"
                           data-basicinfo="<?php echo isset($data["basic_info"]) ? $data["basic_info"] : ''; ?>"
                           data-height="<?php echo isset($data["height"]) ? $data["height"] : ''; ?>"
                           data-weight="<?php echo isset($data["weight"]) ? $data["weight"] : ''; ?>"
                           data-bmi="<?php echo isset($data["bmi"]) ? $data["bmi"] : ''; ?>"
                           data-bmistatus="<?php echo isset($data["bmi_status"]) ? $data["bmi_status"] : ''; ?>"
                           data-recorddate="<?php echo isset($data["record_date"]) ? $data["record_date"] : ''; ?>"
                           data-healthinfodoc="<?php echo isset($data["health_info_doc"]) ? $data["health_info_doc"] : ''; ?>"
                           data-nutritioninfo="<?php echo isset($data["nutrition_info"]) ? $data["nutrition_info"] : ''; ?>"
                           data-condition="<?php echo isset($data["condition"]) ? $data["condition"] : ''; ?>">
                           Complete Missing Information
                        </a>
                    </div>
                </div>
            </td>
            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>No records found for the selected date range.</td></tr>";
                                }
                                ?>
</tbody>

                                <tfoot>
                                    <tr>
                                        <th width="30">No</th>
                                        <th>Full Name</th>
                                        <th>DOB</th>
                                        <th>Join Date</th> 
                                        <th>Gender</th>
                                        <th>Father/Gdian</th>
                                        <th>Mother/Gdian</th>
                                        <th>Status</th>
                                        <th>More</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- <a href="addchildprofile.php?service=<?php print $type; ?>" class="btn btn-primary btn-rounded btn-floated"><i
                                data-feather="plus-circle"></i> Add a profile</a> -->

                                
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
 <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
<script>
 $(document).on("click", ".update-link", function() {
    var child_id = $(this).data("childid");
    var full_name = $(this).data("fullname");
    var date_of_birth = $(this).data("dob");
    var join_date = $(this).data("joindate");
    var gender = $(this).data("gender");
    var father = $(this).data("father");
    var mother = $(this).data("mother");
    var parent_phone = $(this).data("parentphone");
    var email = $(this).data("email");
    

    $("#child_id").val(child_id);
    $("#full_name").val(full_name);
    $("#date_of_birth").val(date_of_birth);
    $("#join_date").val(join_date);
    $("#gender").val(gender);
    $("#father").val(father);
    $("#mother").val(mother);
    $("#parent_phone").val(parent_phone);
    $("#email").val(email);
    
});

        $('#completeInfoModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var healthInfoId = button.data('healthinfoid');
            var childId = button.data('childid');
            var basicInfo = button.data('basicinfo');
            var height = button.data('height');
            var weight = button.data('weight');
            var bmi = button.data('bmi');
            var bmiStatus = button.data('bmistatus');
            var recordDate = button.data('recorddate');
            var healthInfoDoc = button.data('healthinfodoc');
            var nutritionInfo = button.data('nutritioninfo');
            var condition = button.data('condition');

            var modal = $(this);
            modal.find('#health_info_id').val(healthInfoId);
            modal.find('#child_id').val(childId);
            modal.find('#basic_info').val(basicInfo);
            modal.find('#height').val(height);
            modal.find('#weight').val(weight);
            modal.find('#bmi').val(bmi);
            modal.find('#bmi_status').val(bmiStatus);
            modal.find('#record_date').val(recordDate);
            modal.find('#health_info_doc').val(healthInfoDoc);
            modal.find('#nutrition_info').val(nutritionInfo);
            modal.find('#condition').val(condition);
        });
    
    
    </script>
<script>
    $(document).ready(function() {
        // Function to calculate BMI
        function calculateBMI() {
            var height = parseFloat($('#height').val()) / 100; // Convert to meters
            var weight = parseFloat($('#weight').val());
            if (!isNaN(height) && !isNaN(weight) && height > 0) {
                var bmi = weight / (height * height);
                $('#bmi').val(bmi.toFixed(2));

                if (bmi < 18.5) {
                    $('#bmi_status').val("Underweight");
                } else if (bmi < 24.9) {
                    $('#bmi_status').val("Normal weight");
                } else if (bmi < 29.9) {
                    $('#bmi_status').val("Overweight");
                } else {
                    $('#bmi_status').val("Obese");
                }

                if (bmi < 18.5) {
                    $('#condition').val("Worst");
                } else if (bmi < 24.9) {
                    $('#condition').val("Good");
                } else if (bmi < 29.9) {
                    $('#condition').val("Bad");
                } else {
                    $('#condition').val("Worst");
                }
            } else {
                $('#bmi').val('');
                $('#bmi_status').val('');
                $('#condition').val('');
            }
        }

        // Bind calculateBMI function to input events
        $('#height').on('input', calculateBMI);
        $('#weight').on('input', calculateBMI);

        // Reset BMI fields on modal show
        $('#completeInfoModal').on('show.bs.modal', function(event) {
            $('#height').val('');
            $('#weight').val('');
            $('#bmi').val('');
            $('#bmi_status').val('');
            $('#condition').val('');

            // Set current date in the record_date field
            var today = new Date().toISOString().split('T')[0];
            $('#record_date').val(today);
        });
    });
</script>


<!-- END PAGE LEVEL SCRIPTS -->
</body>
</html>

<?php 
} else {
    ?>
    <script>history.back();</script>
    <?php
} ?>
