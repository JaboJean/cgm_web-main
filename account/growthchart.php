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
            max-width: 800px; /* Adjust width */
            max-height: 400px; /* Adjust height */
            margin: auto;
        }
        canvas {
            max-width: 100%; /* Adjust width */
            max-height: 100%; /* Adjust height */
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

                    // SQL query to fetch data for comparison
                    $sql = "
                        SELECT bmi_status, COUNT(*) as count, 'Period 1' as period
                        FROM health_info
                        WHERE record_date BETWEEN '2023-01-01' AND '2023-06-30'
                        GROUP BY bmi_status
                        UNION
                        SELECT bmi_status, COUNT(*) as count, 'Period 2' as period
                        FROM health_info
                        WHERE record_date BETWEEN '2023-07-01' AND '2023-12-31'
                        GROUP BY bmi_status
                    ";

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

                    <script>
                    var data = <?php echo $data_json; ?>;
                    var labels = [...new Set(data.map(item => item.bmi_status))];
                    var period1Counts = [];
                    var period2Counts = [];

                    labels.forEach(label => {
                        var period1 = data.find(item => item.bmi_status === label && item.period === 'Period 1');
                        var period2 = data.find(item => item.bmi_status === label && item.period === 'Period 2');
                        period1Counts.push(period1 ? period1.count : 0);
                        period2Counts.push(period2 ? period2.count : 0);
                    });

                    var ctx = document.getElementById('bmiChart').getContext('2d');
                    var bmiChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Period 1',
                                    data: period1Counts,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Period 2',
                                    data: period2Counts,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }
                            ]
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
                                            return chart.data.datasets.map((dataset, index) => {
                                                return {
                                                    text: dataset.label,
                                                    fillStyle: dataset.backgroundColor,
                                                    hidden: false,
                                                    index: index
                                                };
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
