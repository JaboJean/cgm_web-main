<?php require("configs/globals.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Coaches Registration </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
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

                    <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing offset-md-2">

                        <div class="skills layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <h3 class="">Staff Registration</h3>
                                    <?php require("scripts/addCoaches.php"); ?>

                                    <div class="row">
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="First Name" name="fname" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="First Name" name="lname" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="National ID/ Passport No" name="nid" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <select name="gender" id="" required class="form-control">
                                                    <option value="">Gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="W">Female</option>
                                                </select>
                                            </div>
                                        </div>

                                      
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <select class="form-control basic" name='countryId'>
                                                    <option value="">Nationality</option>
                                                    <?php
                                                    require("configs/connection.php");
                                                    $query = mysqli_query($connection, "SELECT * FROM countries") or die(mysqli_error($connection));
                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php print $data["country_id"]; ?>"><?php print $data["country_name"]; ?> (<?php print $data["country_code"]; ?>)</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Telephone" name="phone" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Email" name="email" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Date of Birth</label>
                                                <input type="date" class="form-control"  name="dob" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Valid From</label>
                                                <input type="date" class="form-control"  name="validFrom" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Valid Until</label>
                                                <input type="date" class="form-control"  name="validTo" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit" name="addCoach">Save Info</button>
                                </form>
                            </div>
                        </div>
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
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>

    <script>
        $(document).ready(function() {
            $(".coaches").addClass("active");
            App.init();
        });

        var ss = $(".basic").select2({
            tags: true,
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>

</html>