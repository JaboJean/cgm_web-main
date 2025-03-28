<?php require("configs/globals.php");

if (isset($_GET["service"])) {
$type = $_GET["service"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php print $type; ?> Registration </title>
    <link rel="icon" type="image/x-icon" href=""/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
    <!--  END CUSTOM STYLE FILE  -->

    <style>
        .required{
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
    <?php
    require("templates/sideBar.php");
    ?>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">
            <div class="col-xl-9 col-lg-6 col-md-7 col-sm-12 layout-top-spacing offset-md-1">
                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <form action="" method="post" enctype="multipart/form-data" class="pb-5">
                            <h3 class="">Child Profile Registration</h3>
                            <?php require("scripts/main.php"); ?>
                              
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="full_name">Full Name<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="full_name" placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="date_of_birth" placeholder="Select date of birth" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="join_date">Join Date<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="join_date" placeholder="Select join date" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="gender">Gender<span class="required">*</span></label>
                                        <select class="form-control" name="gender" required>
                                            <option value="">-- Select Gender --</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="father">Father's Names/Guardian<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="father" placeholder="Enter father's or guardian's name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="mother">Mother's Names/Guardian<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="mother" placeholder="Enter mother's or guardian's name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Parent/Guardian Phone">Parent/Guardian Phone<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="parent_phone" placeholder="Phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Parent/Guardian Email">Parent/Guardian Email<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="weight">Weight<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="weight" placeholder="Enter weight" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
    <div class="form-group">
        <label for="birth_certificate">Birth Certificate<span class="required">*</span></label>
        <input type="file" class="form-control" name="birth_certificate" required>
    </div>
</div>

                                <div class="col-lg-12">
                                    <button class="btn btn-primary float-right" type="submit" name="addchild">Add Child Profile</button>
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
        $(".<?php print $type; ?>").addClass("active");
        $(".<?php print $type; ?>").addClass("show");
        App.init();
    });
</script>
<script src="assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>

<?php } else {
    ?>
    <script>history.back();</script>
    <?php
} ?>