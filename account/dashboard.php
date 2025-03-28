<?php require("configs/globals.php"); ?>
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
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />

    <style>
    .chart-container {
        width: 100%;
        max-width: 200px; /* Set to desired width */
        max-height: 150px; /* Set to desired height */
        margin: auto;
    }
    canvas {
        max-width: 400px; /* Adjust width */
        max-height: 350px; /* Adjust height */
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
            // Query for pediatricians
            $querypediatrician = mysqli_query($connection, "SELECT * FROM users WHERE role = 'pediatrician'") or die(mysqli_error($connection));
            $numpediatrician = mysqli_num_rows($querypediatrician);
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?php echo $numpediatrician; ?></h6>
                                <p class="">Pediatricians</p>
                            </div>
                            <div class="" onclick="javascript:window.location='users.php?type=pediatrician'">
                                <div class="w-icon">
                                    <i data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <?php
                                $maxPediatricians = 100; // Maximum value for percentage calculation
                                $percentagePediatricians = ($numpediatrician / $maxPediatricians) * 100;
                            ?>
                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $percentagePediatricians; ?>%"
                                 aria-valuenow="<?php echo $percentagePediatricians; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Query for children
            $querychild = mysqli_query($connection, "SELECT * FROM child") or die(mysqli_error($connection));
            $numchild = mysqli_num_rows($querychild);
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?php echo $numchild; ?></h6>
                                <p class="">Children</p>
                            </div>
                            <div class="" onclick="javascript:window.location='users.php?type=child'">
                                <div class="w-icon">
                                    <i data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress">
                            <?php
                                $maxChildren = 100; // Maximum value for percentage calculation
                                $percentageChildren = ($numchild / $maxChildren) * 100;
                            ?>
                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?php echo $percentageChildren; ?>%"
                                 aria-valuenow="<?php echo $percentageChildren; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 chart-container">

    <?php

    $token  = $_COOKIE["CGMTOKEN"];
    $query  = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
    $data   = mysqli_fetch_assoc($query);
    $userId = $data["user_id"];

    $querychild = mysqli_query($connection, "SELECT * FROM child WHERE father_id = '$userId'") or die(mysqli_error($connection));
    while($row = mysqli_fetch_assoc($querychild)) {
        echo $row['full_name'];
        echo "<br>";
    }
    ?>
    
</div>
<div class="container mt-5 chart-container">
    <div class="row">
        <div class="col-md-12">
            <canvas id="bmiChart"></canvas>
        </div>
    </div>
</div>

<?php
// Database connection for BMI chart
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cgm";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT bmi_status, COUNT(*) as count FROM health_info GROUP BY bmi_status";
$result = $conn->query($sql);
$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
$data_json = json_encode($data);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var data = <?php echo $data_json; ?>;
    var labels = data.map(function(item) { return item.bmi_status; });
    var counts = data.map(function(item) { return item.count; });

    var backgroundColors = {
        'Underweight': 'rgba(255, 99, 132, 0.2)',
        'Obese': 'rgba(54, 162, 235, 0.2)',
        'Normal weight': 'rgba(75, 192, 192, 0.2)',
        'Overweight': 'rgba(255, 206, 86, 0.2)',
        'Other': 'rgba(153, 102, 255, 0.2)'
    };

    var borderColors = {
        'Underweight': 'rgba(255, 99, 132, 1)',
        'Obese': 'rgba(54, 162, 235, 1)',
        'Normal weight': 'rgba(75, 192, 192, 1)',
        'Overweight': 'rgba(255, 206, 86, 1)',
        'Other': 'rgba(153, 102, 255, 1)'
    };

    var ctx = document.getElementById('bmiChart').getContext('2d');
    var bmiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Children',
                data: counts,
                backgroundColor: labels.map(status => backgroundColors[status] || 'rgba(0, 0, 0, 0.1)'),
                borderColor: labels.map(status => borderColors[status] || 'rgba(0, 0, 0, 0.1)'),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value; // Display the number on Y-axis
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        generateLabels: function(chart) {
                            return labels.map(function(label) {
                                return {
                                    text: label + ': ' + counts[labels.indexOf(label)],
                                    fillStyle: backgroundColors[label] || 'rgba(0, 0, 0, 0.1)',
                                    hidden: false
                                };
                            });
                        }
                    }
                }
            }
        }
    });
</script>
