<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Child Nutrition Information</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
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
                                <table id="zero-config" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Child Names</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI</th>
                                            <th>BMI Status</th>
                                            <th>Updated Record Date</th>
                                            <th width="50">Meal Recommendation</th>
                                            <th width="50">Growth Chart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Connect to the database
                                        $conn = new mysqli("localhost", "root", "mysql", "cgm");

                                        // Check the connection
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        // Fetch child nutrition information
                                        $sql = "SELECT child.child_id, child.full_name, child.gender, TIMESTAMPDIFF(YEAR, child.date_of_birth, CURDATE()) AS age,
                                                health_info.height, health_info.weight, health_info.bmi, health_info.bmi_status, health_info.record_date AS updated_record_date
                                                FROM child
                                                LEFT JOIN health_info ON child.child_id = health_info.child_id";

                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $no = 0;
                                            while ($data = $result->fetch_assoc()) {
                                                $no++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo htmlspecialchars($data["full_name"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["age"]); ?></td>
                                                    <td><?php echo htmlspecialchars($data["gender"]); ?></td>
                                                    <td><?php echo isset($data["height"]) ? htmlspecialchars($data["height"]) : "N/A"; ?></td>
                                                    <td><?php echo isset($data["weight"]) ? htmlspecialchars($data["weight"]) : "N/A"; ?></td>
                                                    <td><?php echo isset($data["bmi"]) ? htmlspecialchars($data["bmi"]) : "N/A"; ?></td>
                                                    <td><?php echo isset($data["bmi_status"]) ? htmlspecialchars($data["bmi_status"]) : "N/A"; ?></td>
                                                    <td><?php echo isset($data["updated_record_date"]) ? htmlspecialchars($data["updated_record_date"]) : "N/A"; ?></td>
                                                    <td>
                                                        <a href="childnutrition.php?child_id=<?php echo urlencode($data['child_id']); ?>" class="btn btn-primary btn-sm">View Meal</a>
                                                    </td>
                                                    <td>
                                                        <a href="growthchart.php?child_id=<?php echo urlencode($data['child_id']); ?>" class="btn btn-success btn-sm">View</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="11">No records found.</td>
                                            </tr>
                                        <?php
                                        }

                                        $conn->close();
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Child Names</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Height</th>
                                            <th>Weight</th>
                                            <th>BMI</th>
                                            <th>BMI Status</th>
                                            <th>Updated Record Date</th>
                                            <th width="50">Meal Recommendation</th>
                                            <th width="50">Growth Chart</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
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
    <script src="assets/js/libs/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/custom.js"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <script>
        $(document).ready(function () {
            $('#zero-config').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
