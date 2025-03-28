<?php
// meal_recommendation_api.php

// Function to get meal recommendations based on BMI status
function getMealRecommendations($bmi_status) {
    $recommendations = [
        "Underweight" => [
            "Breakfast" => "Oatmeal with fruits and nuts",
            "Lunch" => "Grilled chicken with quinoa and vegetables",
            "Dinner" => "Salmon with brown rice and broccoli",
            "Snacks" => "Greek yogurt with honey, nuts, and a banana"
        ],
        "Normal weight" => [
            "Breakfast" => "Whole-grain toast with avocado and egg",
            "Lunch" => "Turkey and avocado wrap with a side salad",
            "Dinner" => "Stir-fried tofu with mixed vegetables",
            "Snacks" => "Apple slices with peanut butter"
        ],
        "Overweight" => [
            "Breakfast" => "Smoothie with spinach, banana, and almond milk",
            "Lunch" => "Grilled vegetable salad with chickpeas",
            "Dinner" => "Baked chicken breast with sweet potatoes and green beans",
            "Snacks" => "Carrot sticks with hummus"
        ],
        "Obese" => [
            "Breakfast" => "Egg white omelette with spinach and tomatoes",
            "Lunch" => "Quinoa salad with black beans and veggies",
            "Dinner" => "Baked fish with a side of roasted vegetables",
            "Snacks" => "Celery sticks with almond butter"
        ]
    ];

    return $recommendations[$bmi_status] ?? [];
}

// Database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "cgm"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch child information based on child_id from GET parameter
if (isset($_GET['child_id'])) {
    $child_id = $_GET['child_id'];

    // Prepare SQL statement to fetch the latest BMI status
    $sql_health = "SELECT `bmi_status` FROM `health_info` WHERE `child_id` = ? ORDER BY `record_date` DESC LIMIT 1";
    
    // Prepare and bind parameters
    $stmt_health = $conn->prepare($sql_health);
    $stmt_health->bind_param("i", $child_id);
    
    // Execute query
    $stmt_health->execute();
    
    // Get result
    $result_health = $stmt_health->get_result();
    
    // Check if health information exists
    if ($result_health->num_rows > 0) {
        // Fetch BMI status
        $row_health = $result_health->fetch_assoc();
        $bmi_status = $row_health['bmi_status'];
        
        // Get meal recommendations
        $meal_recommendations = getMealRecommendations($bmi_status);
        
        // Return meal recommendations in JSON format
        header('Content-Type: application/json');
        echo json_encode($meal_recommendations);
        
    } else {
        // Return error if no health information is found
        header('Content-Type: application/json');
        echo json_encode(["error" => "No health information found for this child."]);
    }
    
    // Close statement and connection
    $stmt_health->close();
    $conn->close();
} else {
    // Return error if child_id is not provided
    header('Content-Type: application/json');
    echo json_encode(["error" => "Child ID not provided."]);
}
?>
