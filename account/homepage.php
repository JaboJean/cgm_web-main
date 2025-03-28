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
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <style>
        .chart-container {
            width: 100%;
            max-width: 1000px; /* Adjust to desired width */
            margin: auto;
        }
        canvas {
            max-width: 100%; /* Adjust width */
            max-height: 500px; /* Adjust height */
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
                    <div class="col-md-12">
                    <?php


if ($data["status"] == "Incomplete") { ?>
    <div class="col-md-12">
        <div class="alert alert-warning"><b>Important</b> Please click here to complete your profile
        </div>
    </div>
<?php } ?>
                        <?php
                        // Fetch the logged-in user's ID
                        $token = $_COOKIE["CGMTOKEN"];
                        $query = mysqli_query($connection, "SELECT * FROM users WHERE token = '$token'") or die(mysqli_error($connection));
                        $data = mysqli_fetch_assoc($query);
                        $userId = $data["user_id"];

                        // Query to get health information data based on the user's children
                        $queryArchive = mysqli_query($connection, "
                            SELECT MONTH(record_date) AS month, weight 
                            FROM health_info_archive 
                            WHERE child_id IN (SELECT child_id FROM child WHERE father_id = '$userId') 
                            ORDER BY record_date
                        ") or die(mysqli_error($connection));

                        // Initialize arrays to store weights by month and find min/max weights
                        $weightByMonth = array_fill(1, 12, 0); // Initialize with 0 for each month (1-12)
                        $minWeight = PHP_INT_MAX;
                        $maxWeight = 0;

                        while ($row = mysqli_fetch_assoc($queryArchive)) {
                            $month = $row['month'];
                            $weight = $row['weight'];
                            $weightByMonth[$month] = $weight; // Store weight for each month

                            if ($weight < $minWeight) $minWeight = $weight;
                            if ($weight > $maxWeight) $maxWeight = $weight;
                        }

                        // Set default minimum weight to 8 if no data exists
                        if ($minWeight > 8) $minWeight = 8;

                        ?>
                    </div>
                </div>

                <div class="container mt-5 chart-container">
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="weightChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var weightData = <?php echo json_encode(array_values($weightByMonth)); ?>;
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Set y-axis min to 8 and max to dynamic max weight
        var minWeight = <?php echo $minWeight; ?>;
        var maxWeight = <?php echo $maxWeight; ?>;
        if (minWeight < 8) minWeight = 8; // Ensure minimum weight is at least 8 kg

        var ctx = document.getElementById('weightChart').getContext('2d');
        var weightChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Weight (kg)',
                    data: weightData,
                    backgroundColor: weightData.map(weight => weight > 0 ? 'rgba(75, 192, 192, 0.2)' : 'rgba(255, 255, 255, 0)'),
                    borderColor: weightData.map(weight => weight > 0 ? 'rgba(75, 192, 192, 1)' : 'rgba(255, 255, 255, 0)'),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true,
                        min: 8, // Minimum value for y-axis
                        max: Math.max(maxWeight, 15), // Maximum value for y-axis
                        ticks: {
                            callback: function(value) {
                                if (value === 0) return '';
                                return value + ' kg';
                            }
                        }
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
</body>
</html>
