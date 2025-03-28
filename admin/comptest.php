<?php
// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

// Create a new MySQLi connection
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check for connection errors
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Fetch the child's birth year
$child_id = 92; // ID of the child to compare
$birth_year_query = "SELECT YEAR(date_of_birth) AS birth_year FROM child WHERE child_id = ?";
$stmt = $mysqli->prepare($birth_year_query);
$stmt->bind_param('i', $child_id);
$stmt->execute();
$birth_year_result = $stmt->get_result();
$birth_year = $birth_year_result->fetch_assoc()['birth_year'];

// Fetch health info for the child
$health_query = "SELECT * FROM health_info_archive WHERE child_id = ?";
$stmt = $mysqli->prepare($health_query);
$stmt->bind_param('i', $child_id);
$stmt->execute();
$health_result = $stmt->get_result();
$health_data = $health_result->fetch_all(MYSQLI_ASSOC);

// Fetch comparison data for the child's age
$current_year = date('Y');
$child_age = $current_year - $birth_year;
$comparison_query = "SELECT month, weight FROM comparison WHERE child_age = 5";
$stmt = $mysqli->prepare($comparison_query);
$stmt->execute();
$comparison_result = $stmt->get_result();
$comparison_data = $comparison_result->fetch_all(MYSQLI_ASSOC);

// Process data for charts
$labels = [];
$health_weights = [];
$comparison_weights = [];

// Collect health data for the chart
foreach ($health_data as $data) {
    $month_year = date('M Y', strtotime($data['record_date']));
    $labels[] = $month_year;
    $health_weights[$month_year] = $data['weight'];
}

// Collect comparison data for the chart
foreach ($comparison_data as $data) {
    $month_year = $data['month'] . ' ' . $current_year;
    if (!in_array($month_year, $labels)) {
        $labels[] = $month_year;
    }
    $comparison_weights[$month_year] = $data['weight'];
}

// Sort labels to match health and comparison data order
sort($labels);

// Align weights with sorted labels
$aligned_health_weights = array_map(function($label) use ($health_weights) {
    return isset($health_weights[$label]) ? $health_weights[$label] : 0;
}, $labels);

$aligned_comparison_weights = array_map(function($label) use ($comparison_weights) {
    return isset($comparison_weights[$label]) ? $comparison_weights[$label] : 0;
}, $labels);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Comparison Chart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Weight Comparison Chart</h1>
        <canvas id="weightChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('weightChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [
                        {
                            label: 'Health Info Archive',
                            data: <?php echo json_encode($aligned_health_weights); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            barThickness: 10
                        },
                        {
                            label: 'Comparison Table (5 Years Old)',
                            data: <?php echo json_encode($aligned_comparison_weights); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            barThickness: 10
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Weight (kg)'
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
