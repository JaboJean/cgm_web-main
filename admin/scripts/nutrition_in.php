<?php
// Database connection
$servername = "localhost";
$username = "root";  // change this to your database username
$password = "";      // change this to your database password
$dbname = "cgm";     // change this to your database name

$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $age_group = $connection->real_escape_string($_POST['age_group']);
    $bmi_category = $connection->real_escape_string($_POST['bmi_category']);
    $calories = $connection->real_escape_string($_POST['calories']);
    $protein = $connection->real_escape_string($_POST['protein']);
    
    // Encode meal plans to JSON
    $meal_plans = json_encode(["plan" => $_POST['meal_plans']]);

    // Insert the data into the nutrition table
    $sql = "INSERT INTO nutrition (age_group, bmi_category, calories, protein, meal_plans) 
            VALUES ('$age_group', '$bmi_category', '$calories', '$protein', '$meal_plans')";

    if ($connection->query($sql) === TRUE) {
        $alert = "success";
        $msg = "New nutrition added successfully!";
        require("templates/alert.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>