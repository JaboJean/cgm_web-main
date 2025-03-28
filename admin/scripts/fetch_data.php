<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die(mysqli_error($connection));

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to count children by weight status
$query = "
SELECT 
    SUM(CASE WHEN bmi_status = 'Underweight' THEN 1 ELSE 0 END) AS underweight,
    SUM(CASE WHEN bmi_status = 'Normal' THEN 1 ELSE 0 END) AS normal,
    SUM(CASE WHEN bmi_status = 'Overweight' THEN 1 ELSE 0 END) AS overweight,
    SUM(CASE WHEN bmi_status = 'Obese' THEN 1 ELSE 0 END) AS obese
FROM 
    health_info
";

// Execute the query
$result = $connection->query($query);

// Fetch data
$data = $result->fetch_assoc();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$connection->close();
?>
