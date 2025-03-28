<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "mysql";
$db_name = "cgm";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $child_name = "Not available";
    $bmi_status = "Not available";
    $height = "Not available";
    $weight = "Not available";
    $condition = "Not available";
    $weights = [];
    $months = [];
    $weightsComparison = [];
    $normalGrowth = [];
    $numberOfMonths = 0;
    $childAgeInMonths = 0;
    $dobInMonths = 0; // Variable to store the date of birth in months

    if (isset($_GET['child_id'])) {
        $child_id = $_GET['child_id'];

        // Fetch child info
        $sql = "SELECT c.full_name AS child_name, 
                       c.date_of_birth, 
                       h.bmi_status, 
                       h.height, 
                       h.weight, 
                       h.Condition
                FROM child c
                LEFT JOIN health_info h ON c.child_id = h.child_id
                WHERE c.child_id = :child_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $stmt->execute();
        $childInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($childInfo) {
            $child_name = $childInfo['child_name'];
            $bmi_status = $childInfo['bmi_status'];
            $height = $childInfo['height'];
            $weight = $childInfo['weight'];
            $condition = $childInfo['Condition'];

            // Calculate child's age in months
            $birthDate = new DateTime($childInfo['date_of_birth']);
            $currentDate = new DateTime();
            $interval = $birthDate->diff($currentDate);
            $childAgeInMonths = $interval->y * 12 + $interval->m;

            // Calculate date of birth in months
            $dobInMonths = $birthDate->diff($currentDate)->y * 12 + $birthDate->diff($currentDate)->m;
        } else {
            $child_name = "No information found for the specified child.";
        }

        // Fetch health data
        $sql = "SELECT weight, MONTH(record_date) AS month 
                FROM health_info_archive 
                WHERE child_id = :child_id 
                UNION 
                SELECT weight, MONTH(record_date) AS month 
                FROM health_info 
                WHERE child_id = :child_id 
                ORDER BY month";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $stmt->execute();
        $archiveData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($archiveData as $data) {
            $weights[] = $data['weight'];
            $months[] = date('F', mktime(0, 0, 0, $data['month'], 10));
        }

        // Calculate number of unique months
        $numberOfMonths = count(array_unique($months));

        // Calculate normal growth comparison
        if (!empty($weights)) {
            $initialWeight = $weights[0];
            foreach ($weights as $index => $weight) {
                $weightsComparison[] = $weight;
                $normalGrowth[] = $initialWeight + (2 * $index); // Example increment
            }
        }
    } else {
        $child_name = "No child ID specified.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// calculate kid's age in months
$birthDate = new DateTime($childInfo['date_of_birth']);
$currentDate = new DateTime();
$interval = $birthDate->diff($currentDate);
$childAgeInMonths = $interval->y * 12 + $interval->m;

// calculate date of birth in months
$dobInMonths = $birthDate->diff($currentDate)->y * 12 + $birthDate->diff($currentDate)->m;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $dobInMonths; ?>Child Growth Information</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex-direction: column;
        }

        .child-info {
            margin-bottom: 20px;
            text-align: center;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .chart-item {
            width: 100%;
            max-width: 600px;
            margin: 10px;
        }

        .info-line p {
            margin: 5px 0;
        }

        .info-line .info {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body class="sidebar-noneoverflow">
    <?php require("templates/navBar.php"); ?>
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <?php require("templates/sideBar.php"); ?>

        <div class="content-wrapper">
            <div class="content-body">

                <div class="child-info">
                    <div class="container mt-5">
                        <p><?php echo htmlspecialchars($child_name); ?></p>
                    </div>
                    <?php if ($child_name !== "No information found for the specified child.") : ?>
                        <div class="info-line">
                            <p><strong>BMI Status:</strong> <span class="info"><?php echo $bmi_status; ?></span></p>
                            <p><strong>Height:</strong> <span class="info"><?php echo $height; ?> cm</span></p>
                            <p><strong>Weight:</strong> <span class="info"><?php echo $weight; ?> kg</span></p>
                            <p><strong>Child Age in Months:</strong> <?php echo htmlspecialchars($childAgeInMonths); ?></p>
    <p><strong>Date of Birth in Months:</strong> <?php echo htmlspecialchars($dobInMonths); ?></p>
    <p><strong>Number of Unique Months:</strong> <?php echo htmlspecialchars($numberOfMonths); ?></p>
                            <p><strong>Condition:</strong> <span class="info"><?php echo $condition; ?></span></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="chart-container">
                    <div class="chart-item">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="chart-item" style="">
                        <canvas id="comparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("configs/connection.php");?>

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const weights = <?php echo json_encode($weights); ?>;
            const months = <?php echo json_encode($months); ?>;
          

            new Chart("myChart", {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: weights
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false,
                                min: Math.min.apply(null, weights) - 2,
                                max: Math.max.apply(null, weights) + 2
                            }
                        }]
                    }
                }
            });

            const weightsComparison = [<?php
                for($age = 24; $age <= $childAgeInMonths; $age++) {
                    $query = mysqli_query($connection, "SELECT * FROM health_info_archive WHERE months='$age' AND child_id='$child_id'");
                    $row = mysqli_fetch_assoc($query);

                    if ($row) {
                        echo $row['weight'] . ",";
                    } else {
                        echo "0,";      
                    }
                }
                ?>];
            const normalGrowth = [<?php

                for($age = 24; $age <= $childAgeInMonths; $age++){
                    $query = mysqli_query($connection,"SELECT * FROM comparison WHERE child_age='$age'");
                    $row = mysqli_fetch_assoc($query);
                    echo $row['weight'] . ",";
                }

                ?>];

            new Chart("comparisonChart", {
                type: "bar",
                data: {
                    labels: [<?php for($age = 24; $age <= $childAgeInMonths; $age++){
                            echo $age . ",";
                        }
                        ?>],
                    datasets: [
                        {
                            label: 'Historical Weight (kg)',
                            data: weightsComparison,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Normal Growth (kg)',
                            data: normalGrowth,
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
</body>
</html>
