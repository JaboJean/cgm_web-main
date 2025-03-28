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
                                <form action="" method="post" enctype="multipart/form-data" class="pb-5">

                                    <h3 class="">Users Registration</h3>
                                    <?php require("scripts/main.php"); ?>

                                    <div class="row">
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label for="fname">First Name<span class="required">*</span></label>
                                                <input type="text" class="form-control" placeholder="First Name"
                                                       name="fname" id="fname" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label for="lname">Last Name<span class="required">*</span></label>
                                                <input type="text" class="form-control" placeholder="Last Name"
                                                       name="lname" id="lname" value="" required>
                                            </div>
                                        </div>

                                        <script>
                                            // Function to validate input and prevent numbers and special characters
                                            function validateInput(e) {
                                                const input = e.target.value;
                                                const regex = /^[a-zA-Z\s]*$/; // Allow only letters and spaces
                                                if (!regex.test(input)) {
                                                    e.target.value = input.replace(/[^a-zA-Z\s]/g, ''); // Remove invalid characters
                                                }
                                            }

                                            // Add event listeners to the input fields
                                            document.getElementById('fname').addEventListener('input', validateInput);
                                            document.getElementById('lname').addEventListener('input', validateInput);
                                        </script>

                                       
<div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label for="gender">Gender<span class="required">*</span></label>
                                                <select name="gender" id="" class="form-control" required>
                                                    <option value="">Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label for="gender">Service<span class="required">*</span></label>
                                                <select name="service" id="" class="form-control" required>
                                                    <option value="Clergy">Clergy</option>
                                                    <option value="pr_Lectors">PR. of Lectors</option>
                                                    <option value="pr_Eucharistic_Ministers">PR. of Eucharistic Ministers</option>
                                                    <option value="pr_Altar_Servers">PR. of Altar Servers</option>
                                                    <option value="pr_Choir_Members_and_Musicians">PR.of Choir Members and Musicians</option>
                                                    <option value="pr_Ushers_and_Greeters">PR.of Ushers and Greeters</option>
                                                    <option value="pr_Catechists">PR.of Catechists</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phone">Telephone<span class="required">*</span></label>
                                                <input type="text" class="form-control" placeholder="Telephone"
                                                       name="phone" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email<span class="required">*</span></label>
                                                <input type="text" class="form-control" placeholder="Email" name="email"
                                                       value="" required>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="col-lg-6">
            <div class="form-group">
                <label for="picture">Profile Picture<span class="required">*</span></label>
                <input type="file" class="form-control" name="picture" required>
            </div>
        </div>
   

                                    <input type="hidden" name="service" value="<?php print $_GET['service'] ?>">
                                    <button class="btn btn-primary float-right" type="submit" name="addUser">Add user
                                    </button>
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