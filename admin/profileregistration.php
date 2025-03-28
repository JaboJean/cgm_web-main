<?php require("configs/globals.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Child Profile Registration</title>
    <link rel="icon" type="image/x-icon" href=""/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
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
            <div class="row layout-spacing">
                <div class="col-xl-9 col-lg-6 col-md-7 col-sm-12 layout-top-spacing offset-md-1">
                    <div class="card">
                        <div class="card-body">
                            <form id="registrationForm" method="post" enctype="multipart/form-data" class="pb-5">
                                
                                <?php require("scripts/main.php"); ?>

                                <ul class="nav nav-tabs mb-3" id="registration-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="father-tab" data-toggle="tab" href="#father-info" role="tab" aria-controls="father-info" aria-selected="true">Father Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="mother-tab" data-toggle="tab" href="#mother-info" role="tab" aria-controls="mother-info" aria-selected="false">Mother Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="child-tab" data-toggle="tab" href="#child-info" role="tab" aria-controls="child-info" aria-selected="false">Child Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="health-tab" data-toggle="tab" href="#health-info" role="tab" aria-controls="health-info" aria-selected="false">Other Details</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="registration-tabs-content">
                                    <!-- Father Information Tab -->
                                    <div class="tab-pane fade show active" id="father-info" role="tabpanel" aria-labelledby="father-tab">
                                        <div class="form-group">
                                            <label for="father">Father's Names/Guardian<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="father_name" placeholder="Enter father's or guardian's name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="father_phone">Father/Guardian Phone<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="father_phone" placeholder="Phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="father_email">Father/Guardian Email<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="father_email" placeholder="Email" required>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="nextTab('mother-info')">Next</button>
                                    </div>

                                    <!-- Mother Information Tab -->
                                    <div class="tab-pane fade" id="mother-info" role="tabpanel" aria-labelledby="mother-tab">
                                        <div class="form-group">
                                            <label for="mother">Mother's Names/Guardian<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="mother_name" placeholder="Enter mother's or guardian's name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="mother_phone">Mother/Guardian Phone<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="mother_phone" placeholder="Phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="mother_email">Mother/Guardian Email<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="mother_email" placeholder="Email" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="prevTab('father-info')">Previous</button>
                                        <button type="button" class="btn btn-primary" onclick="nextTab('child-info')">Next</button>
                                    </div>

                                    <!-- Child Information Tab -->
                                    <div class="tab-pane fade" id="child-info" role="tabpanel" aria-labelledby="child-tab">
                                        <div class="form-group">
                                            <label for="full_name">Full Name<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="full_name" placeholder="Enter full name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth<span class="required">*</span></label>
                                            <input type="date" class="form-control" name="date_of_birth" placeholder="Select date of birth" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="join_date">Join Date<span class="required">*</span></label>
                                            <input type="date" class="form-control" name="join_date" placeholder="Select join date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender<span class="required">*</span></label>
                                            <select class="form-control" name="gender" required>
                                                <option value="">-- Select Gender --</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="prevTab('mother-info')">Previous</button>
                                        <button type="button" class="btn btn-primary" onclick="nextTab('health-info')">Next</button>
                                    </div>

                                    <!-- Health Information Tab -->
                                    <div class="tab-pane fade" id="health-info" role="tabpanel" aria-labelledby="health-tab">
                                        <div class="form-group">
                                            <label for="weight">Weight<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="weight" placeholder="Enter weight" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="birth_certificate">Birth Certificate<span class="required">*</span></label>
                                            <input type="file" class="form-control" name="birth_certificate" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="prevTab('child-info')">Previous</button>
                                        <button type="submit" class="btn btn-primary" name="addchild">Add Child Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->

<?php require("templates/footer.php"); ?>
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/select2/custom-select2.js"></script>

<script>
    $(document).ready(function () {
        App.init();
    });

    function nextTab(tabId) {
        $('#registration-tabs a[href="#' + tabId + '"]').tab('show');
    }

    function prevTab(tabId) {
        $('#registration-tabs a[href="#' + tabId + '"]').tab('show');
    }
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>