<?php
// Database connection
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die(mysqli_error($connection));

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to get count of children by BMI status and date
$sql = "SELECT 
            record_date, 
            bmi_status, 
            COUNT(*) as count 
        FROM health_info 
        GROUP BY record_date, bmi_status 
        ORDER BY record_date";
$result = $connection->query($sql);

// Store fetched data in arrays
$dates = [];
$bmiCounts = [
    'Underweight' => [],
    'Normal weight' => [],
    'Overweight' => [],
    'Obese' => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = $row["record_date"];
        $status = $row["bmi_status"];
        $count = (int) $row["count"];

        if (!in_array($date, $dates)) {
            $dates[] = $date;
        }

        if (!isset($bmiCounts[$status][$date])) {
            $bmiCounts[$status][$date] = 0;
        }
        $bmiCounts[$status][$date] += $count;
    }
}
 

// Prepare data for Chart.js
$data = [
    'dates' => $dates,
    'bmiCounts' => $bmiCounts
];

$data_json = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <style>
        /* CSS styles to control the chart size and positioning */
        .chart-container {
            width: 50%; /* Adjust width as needed */
            margin: 0 auto; /* Center the chart horizontally */
            padding: 20px; /* Add some padding around the chart */
        }
        canvas {
            max-width: 100%; /* Ensure the canvas does not exceed container width */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="bmiLineChart"></canvas>
    </div>

    <script>
        // Get data from PHP
        const data = <?php echo $data_json; ?>;
        const dates = data.dates;
        const bmiCounts = data.bmiCounts;

        // Create dataset for different BMI statuses
        const dataset = {
            'Underweight': {
                label: 'Underweight',
                data: [],
                borderColor: 'blue',
                borderWidth: 2,
                pointBackgroundColor: 'blue',
                fill: false
            },
            'Normal weight': {
                label: 'Normal weight',
                data: [],
                borderColor: 'green',
                borderWidth: 2,
                pointBackgroundColor: 'green',
                fill: false
            },
            'Overweight': {
                label: 'Overweight',
                data: [],
                borderColor: 'orange',
                borderWidth: 2,
                pointBackgroundColor: 'orange',
                fill: false
            },
            'Obese': {
                label: 'Obese',
                data: [],
                borderColor: 'red',
                borderWidth: 2,
                pointBackgroundColor: 'red',
                fill: false
            }
        };

        // Populate dataset
        dates.forEach(date => {
            Object.keys(dataset).forEach(status => {
                dataset[status].data.push({ x: date, y: bmiCounts[status][date] || 0 });
            });
        });

        // Chart configuration
        const ctx = document.getElementById('bmiLineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: Object.values(dataset)
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'yyyy-MM-dd'
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Children'
                        },
                        ticks: {
                            stepSize: 1 // Adjust the step size for better visibility of fluctuations
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
