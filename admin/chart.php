<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cgm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get BMI statuses
$sql = "SELECT bmi_status, COUNT(*) as count FROM health_info GROUP BY bmi_status";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

// Encode data to JSON format
$data_json = json_encode($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>BMI Status Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 400px;
            max-height: 300px;
        }
    </style>
</head>
<body>
    <canvas id="bmiChart"></canvas>
    <script>
        // Get the data from PHP
        var data = <?php echo $data_json; ?>;

        // Prepare the data for Chart.js
        var labels = data.map(function(item) {
            return item.bmi_status;
        });
        var counts = data.map(function(item) {
            return item.count;
        });

        var ctx = document.getElementById('bmiChart').getContext('2d');
        var bmiChart = new Chart(ctx, {
            type: 'bar', // Bar chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Children',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
