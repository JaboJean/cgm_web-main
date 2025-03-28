<?php
// view_child_info.php

// Function to fetch data from API using cURL
function fetchApiData($childId) {
    // Replace with your API endpoint URL
    $apiUrl = "http://localhost/CGM-main/admin/childinfo?id=" . urlencode($childId);
    
    // Initialize cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for local testing
    
    // Execute cURL session
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Decode JSON response
    return json_decode($response, true);
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

    // Prepare SQL statement to fetch child information
    $sql_child = "SELECT * FROM `child` WHERE `child_id` = ?";
    
    // Prepare and bind parameters for child query
    $stmt_child = $conn->prepare($sql_child);
    $stmt_child->bind_param("i", $child_id);
    
    // Execute child query
    $stmt_child->execute();
    
    // Get result of child query
    $result_child = $stmt_child->get_result();
    
    // Check if child exists
    if ($result_child->num_rows > 0) {
        // Fetch data from database
        $row_child = $result_child->fetch_assoc();
        
        // Display child information
        echo "<h2>Child Information</h2>";
        echo "<p>Child ID: " . htmlspecialchars($row_child['child_id']) . "</p>";
        echo "<p>Full Name: " . htmlspecialchars($row_child['full_name']) . "</p>";
        echo "<p>Date of Birth: " . htmlspecialchars($row_child['date_of_birth']) . "</p>";
        echo "<p>Join Date: " . htmlspecialchars($row_child['join_date']) . "</p>";
        echo "<p>Gender: " . htmlspecialchars($row_child['gender']) . "</p>";
        echo "<p>Father: " . htmlspecialchars($row_child['father']) . "</p>";
        echo "<p>Mother: " . htmlspecialchars($row_child['mother']) . "</p>";
        echo "<p>Weight: " . htmlspecialchars($row_child['weight']) . "</p>";
        echo "<p>Birth Certificate: " . htmlspecialchars($row_child['birth_certificate']) . "</p>";
        echo "<p>Parent Phone: " . htmlspecialchars($row_child['parent_phone']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($row_child['email']) . "</p>";
        
        // Prepare SQL statement to fetch health information
        $sql_health = "SELECT `bmi_status` FROM `health_info` WHERE `child_id` = ? ORDER BY `record_date` DESC LIMIT 1";
        
        // Prepare and bind parameters for health query
        $stmt_health = $conn->prepare($sql_health);
        $stmt_health->bind_param("i", $child_id);
        
        // Execute health query
        $stmt_health->execute();
        
        // Get result of health query
        $result_health = $stmt_health->get_result();
        
        // Check if health information exists
        if ($result_health->num_rows > 0) {
            // Fetch health information
            $row_health = $result_health->fetch_assoc();
            
            // Display health information
            echo "<h2>Health Information</h2>";
            echo "<p>BMI Status: " . htmlspecialchars($row_health['bmi_status']) . "</p>";
            // Add more fields as needed from health info table
            
        } else {
            echo "<p>No health information found for this child.</p>";
        }
        
        // Fetch additional data from API using cURL
        $apiData = fetchApiData($child_id);
        
        // Display API data if available
        if (!empty($apiData)) {
            echo "<h2>Additional Information from API</h2>";
            echo "<p>Health Information:</p>";
            echo "<ul>";
            echo "<li>Height: " . htmlspecialchars($apiData['height']) . "</li>";
            echo "<li>BMI: " . htmlspecialchars($apiData['bmi']) . "</li>";
            // Add more fields as needed from your API response
            echo "</ul>";
        }
        
    } else {
        echo "No child found with ID: " . htmlspecialchars($child_id);
    }
    
    // Close statements and connection
    $stmt_child->close();
    $stmt_health->close();
    $conn->close();
} else {
    echo "Child ID not provided.";
}
?>
