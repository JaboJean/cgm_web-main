<?php
require("configs/globals.php");

// Database connection
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "cgm";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count children per day by BMI status
$sqlChildrenByBMI = "SELECT DATE(record_date) as day, bmi_status, COUNT(*) as count
                      FROM health_info
                      GROUP BY day, bmi_status
                      ORDER BY day, bmi_status";
$resultChildrenByBMI = $conn->query($sqlChildrenByBMI);

$childrenByBMIGrouped = [];
if ($resultChildrenByBMI->num_rows > 0) {
    while ($row = $resultChildrenByBMI->fetch_assoc()) {
        $day = $row['day'];
        $bmiStatus = $row['bmi_status'];
        $count = $row['count'];
        
        if (!isset($childrenByBMIGrouped[$bmiStatus])) {
            $childrenByBMIGrouped[$bmiStatus] = [];
        }
        $childrenByBMIGrouped[$bmiStatus][$day] = $count;
    }
}

// Convert data to JSON format for use in JavaScript
$childrenByBMIGroupedJson = json_encode($childrenByBMIGrouped);

$sqlChildrenPerDay = "SELECT DATE(record_date) as day, COUNT(*) as count
                      FROM health_info
                      GROUP BY day
                      ORDER BY day";
$resultChildrenPerDay = $conn->query($sqlChildrenPerDay);

$childrenData = [];
if ($resultChildrenPerDay->num_rows > 0) {
    while ($row = $resultChildrenPerDay->fetch_assoc()) {
        $childrenData[] = $row;
    }
}

$sqlBMIStatus = "SELECT bmi_status, COUNT(*) as count FROM health_info GROUP BY bmi_status";
$resultBMIStatus = $conn->query($sqlBMIStatus);

$bmiData = [];
if ($resultBMIStatus->num_rows > 0) {
    while ($row = $resultBMIStatus->fetch_assoc()) {
        $bmiData[] = $row;
    }
}
$conn->close();

$childrenDataJson = json_encode($childrenData);
$bmiDataJson = json_encode($bmiData);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CGM - Home</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <style>
        .chart-container {
            width: 100%;
            max-width: 500px; /* Adjusted width */
            height: 300px; /* Adjusted height */
            margin: 0;
            padding: 10px;
        }
        .chart-row {
            display: flex;
            justify-content: flex-start; /* Align charts to the left */
            align-items: flex-start;
            flex-wrap: wrap; /* Allow wrapping if necessary */
        }
        .chart-item {
            flex: 0 0 auto; /* Prevent items from growing or shrinking */
            margin: 0 10px; /* Space between charts */
        }
    </style>
</head>

<body>
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <?php require("templates/navBar.php"); ?>

    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <?php require("templates/sideBar.php"); ?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    <?php
                    // Query for nurses
                    $queryOfficers = mysqli_query($connection, "SELECT * FROM users WHERE role = 'nurse'") or die(mysqli_error($connection));
                    $numOfficers = mysqli_num_rows($queryOfficers);
                    ?>
                    
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <h6 class="value"><?php echo $numOfficers; ?></h6>
                                        <p class="">Nurse(s)</p>
                                    </div>
                                    <div class="" onclick="javascript:window.location='users.php?type=Officer'">
                                        <div class="w-icon">
                                            <a href='nurses.php'><i data-feather="users"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress">
                                    <?php
                                        $maxOfficers = 100; 
                                        $percentageOfficers = ($numOfficers / $maxOfficers) * 100;
                                    ?>
                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $percentageOfficers; ?>%"
                                         aria-valuenow="<?php echo $percentageOfficers; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Query for children
                    $queryVeterinary = mysqli_query($connection, "SELECT * FROM child") or die(mysqli_error($connection));
                    $numVeterinary = mysqli_num_rows($queryVeterinary);
                    ?>
                    
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <h6 class="value"><?php echo $numVeterinary; ?></h6>
                                        <p class="">Children</p>
                                    </div>
                                    <div class="" onclick="javascript:window.location='users.php?type=Veterinary'">
                                        <div class="w-icon">
                                            <a href='childprofile.php'><i data-feather="users"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress">
                                    <?php
                                        $maxVeterinary = 100; 
                                        $percentageVeterinary = ($numVeterinary / $maxVeterinary) * 100;
                                    ?>
                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $percentageVeterinary; ?>%"
                                         aria-valuenow="<?php echo $percentageVeterinary; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    // Query for assessments
                    $queryAssessments = mysqli_query($connection, "SELECT * FROM assessments") or die(mysqli_error($connection));
                    $numAssessments = mysqli_num_rows($queryAssessments);
                    ?>
                    
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <h6 class="value"><?php echo $numAssessments; ?></h6>
                                        <p class="">Assessments</p>
                                    </div>
                                    <div class="" onclick="javascript:window.location='users.php?type=Assessments'">
                                        <div class="w-icon">
                                            <a href='assessment.php'><i data-feather="file-text"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress">
                                    <?php
                                        $maxAssessments = 100; 
                                        $percentageAssessments = ($numAssessments / $maxAssessments) * 100;
                                    ?>
                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $percentageAssessments; ?>%"
                                         aria-valuenow="<?php echo $percentageAssessments; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="chart-row">
                            <!-- Bar chart -->
                            <div class="chart-item">
                                <canvas id="bmiBarChart" class="chart-container"></canvas>
                            </div>

                            <!-- Line chart -->
                            <div class="chart-item">
                                <canvas id="childrenLineChart" class="chart-container"></canvas>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Data for BMI Bar Chart
                        var bmiData = <?php echo $bmiDataJson; ?>;
                        var bmiLabels = bmiData.map(function(item) { return item.bmi_status; });
                        var bmiCounts = bmiData.map(function(item) { return item.count; });
                        var bmiColors = ['red', 'green', 'blue', 'orange'];

                        // Bar Chart
                        new Chart("bmiBarChart", {
                            type: "bar",
                            data: {
                                labels: bmiLabels,
                                datasets: [{
                                    backgroundColor: bmiColors,
                                    data: bmiCounts
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'BMI Status'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Count'
                                        },
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true
                                    }
                                }
                            }
                        });

                        // Data for Children Per Day Line Chart by BMI Status
                        var childrenByBMIGrouped = <?php echo $childrenByBMIGroupedJson; ?>;

                        var labels = [];
                        var datasets = [];

                        // Helper function to get sorted dates
                        function getSortedDates(data) {
                            var dates = Object.keys(data);
                            dates.sort();
                            return dates;
                        }

                        // Colors for different BMI statuses
                        var bmiColors = {
                            'Underweight': 'red',
                            'Normal weight': 'green',
                            'Overweight': 'blue',
                            'Obese': 'orange'
                        };

                        // Prepare datasets
                        for (var status in childrenByBMIGrouped) {
                            var data = childrenByBMIGrouped[status];
                            var dataset = {
                                label: status,
                                borderColor: bmiColors[status],
                                backgroundColor: bmiColors[status],
                                fill: false,
                                data: []
                            };

                            // Collecting all dates
                            var dates = getSortedDates(data);
                            labels = labels.concat(dates);

                            // Filling dataset data
                            dates.forEach(function(date) {
                                dataset.data.push(data[date] || 0);
                            });

                            datasets.push(dataset);
                        }

                        // Remove duplicate dates
                        labels = Array.from(new Set(labels)).sort();

                        // Ensure each dataset has data for all dates
                        datasets.forEach(function(dataset) {
                            var newData = labels.map(function(label) {
                                return dataset.data[labels.indexOf(label)] || 0;
                            });
                            dataset.data = newData;
                        });

                        // Create Line Chart
                        new Chart("childrenLineChart", {
                            type: "line",
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        },
                                        ticks: {
                                            maxRotation: 90,
                                            minRotation: 45
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Number of Children'
                                        },
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>
