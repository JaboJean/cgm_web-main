<?php
require("configs/globals.php");

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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0/css/bootstrap-select.min.css">
        <!-- END GLOBAL MANDATORY STYLES -->

        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
        <link href="assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
        <?php require("templates/sideBar.php"); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-spacing">

                    <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing offset-md-2">

                        <div class="skills layout-spacing ">
                            <div class="widget-content widget-content-area">
                                <form action="" method="post" enctype="multipart/form-data" class="pb-5">

                                    <h3 class="">Roles Assigning</h3>
                                    <?php require("scripts/main.php"); ?>

                                    <div class="row">
                                        <div class="col-lg-6 ">
                                            <div class="form-group">
                                                <label for="gender">Role name<span class="required">*</span></label>
                                                <select name="service" id="" class="form-control" required>
                                                    <option value="Lectors">Lectors</option>
                                                    <option value="Eucharistic Ministers">Eucharistic Ministers</option>
                                                    <option value="Altar Servers">Altar Servers</option>
                                                    <option value="Choir Members and Musicians">Choir Members and Musicians</option>
                                                    <option value="Ushers and Greeters">Ushers and Greeters</option>
                                                    <option value="Catechists">Catechists</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="names">Names<span class="required">*</span></label>
                                                <select name="names" id="names" class="selectpicker form-control" multiple data-live-search="true" required data-style="btn-light">
                                                    <?php
                                                    // Fetching volunteer names from the database
                                                    $query = mysqli_query($connection, "SELECT * FROM volunteer") or die(mysqli_error($connection));
                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                        $fullname = $data["fname"] . ' ' . $data["lname"];
                                                        ?>
                                                        <option value="<?php echo $data['volunteer_id']; ?>"><?php echo $fullname; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <script>
                                             function validateInput(e) {
                                                const input = e.target.value;
                                                const regex = /^[a-zA-Z\s]*$/; // Allow only letters and spaces
                                                if (!regex.test(input)) {
                                                    e.target.value = input.replace(/[^a-zA-Z\s]/g, ''); // Remove invalid characters
                                                }
                                            }
 
                                            document.getElementById('fname').addEventListener('input', validateInput);
                                            document.getElementById('lname').addEventListener('input', validateInput);
                                        </script>

                                        <?php
                                        // Database connection
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "cgm";

                                        $connection = mysqli_connect($servername, $username, $password, $dbname);

                                        if (!$connection) {
                                            die("Connection failed: " . mysqli_connect_error());
                                        }

                                        // Fetch events from the database
                                        $query = "SELECT DISTINCT `type`, `time` FROM `events` ORDER BY `type` ASC";
                                        $result = mysqli_query($connection, $query);
                                        ?>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="event">Event/Mass<span class="required">*</span></label>
                                                <select class="form-control" name="event" id="event" required>
                                                    <option value="">--Select from planned events--</option>
                                                    <?php
                                                    if (mysqli_num_rows($result) > 0) {
                                                        // Output data of each row
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<option value="' . $row["type"] . '" data-time="' . $row["time"] . '">' . $row["type"] . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">No events available</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        // Close the database connection
                                        mysqli_close($connection);
                                        ?>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="datetime">Date and Time<span class="required">*</span></label>
                                                <div class="input-group">
                                                    <!-- Date input -->
                                                    <input type="date" class="form-control" name="date" id="date" required>
                                                    <!-- Time input -->
                                                    <input type="time" class="form-control" name="time" id="time" required>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            // JavaScript to handle event change
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var eventSelect = document.getElementById('event');
                                                var dateInput = document.getElementById('date');
                                                var timeInput = document.getElementById('time');

                                                eventSelect.addEventListener('change', function () {
                                                    var selectedOption = eventSelect.options[eventSelect.selectedIndex];
                                                    var selectedTime = selectedOption.getAttribute('data-time');

                                                    // Set date and time inputs based on selected event
                                                    if (selectedTime) {
                                                        var eventTime = new Date(selectedTime);
                                                        var formattedDate = eventTime.toISOString().slice(0, 10); // YYYY-MM-DD format
                                                        var formattedTime = eventTime.toTimeString().slice(0, 5); // HH:MM format

                                                        dateInput.value = formattedDate;
                                                        timeInput.value = formattedTime;
                                                    } else {
                                                        dateInput.value = '';
                                                        timeInput.value = '';
                                                    }
                                                });
                                            });
                                        </script>
                         
                                    </div>
                                    
                                     
                                    
                                    <input type="hidden" name="service" value="<?php print $_GET['service'] ?>">
                                    <button class="btn btn-primary float-right" type="submit" name="addTask">Add Task</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap-select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    </body>
    </html>

<?php 
} else {
    ?>
    <script>history.back();</script>
    <?php
} 
?>
