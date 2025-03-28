<?php
// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "cgm";

// Initialize variables with default values
$bmi_status = "Not available";
$calories = "Not available";
$recipes = [];
$meal_plans = [];

// Attempt MySQL server connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch BMI status, nutrition information, and recipes for a specific child
if (isset($_GET['child_id'])) {
    $child_id = $_GET['child_id'];

    try {
        // Prepare SQL query to fetch data
        $sql = "SELECT h.bmi_status, n.calories, n.recipes, n.meal_plans
                FROM health_info h
                LEFT JOIN nutrition n ON h.bmi_status = n.bmi_category
                WHERE h.child_id = :child_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $bmi_status = $result['bmi_status'] ?? "Not available";
            $calories = $result['calories'] ?? "Not available";
            $recipes = json_decode($result['recipes'], true) ?: [];
            $meal_plans = json_decode($result['meal_plans'], true) ?: [];
        } else {
            die("No nutrition information found for the specified child.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage()); // Handle PDO exceptions
    }
} else {
    die("No child ID specified.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Child Nutrition Information</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .main-container {
            display: flex;
            flex: 1;
            margin-left: 250px; /* Adjust this to match the width of your sidebar */
            padding: 20px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Adjust this to match your sidebar width */
            height: 100vh;
            background: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Space between columns */
        }
        .widget {
            flex: 1;
            display: flex;
            flex-direction: column;
            border: none;
            box-shadow: none;
            border-radius: 0;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .widget-content {
            border: none;
            padding: 0;
        }
        .widget-content ul {
            list-style-type: none;
            padding-left: 0;
        }
        .widget-content ul li {
            margin-bottom: 10px;
        }
        .widget-content ul ul {
            margin-top: 5px;
            padding-left: 20px;
        }
        .widget-heading {
            color: #007bff; /* Change this to your desired color */
            border: none; /* Remove any borders */
            padding: 0; /* Remove any default padding */
            margin-top: 40px; /* Adjust the top margin */
            margin-bottom: 10px; /* Adjust the bottom margin */
            font-size: 1.25rem; /* Adjust the font size if needed */
            font-weight: 600; /* Adjust the font weight if needed */
            line-height: 1.4; /* Adjust line height if needed */
        }
    </style>
</head>

<body class="sidebar-noneoverflow">

    <!-- BEGIN SIDEBAR -->
    <?php require("templates/sideBar.php"); ?>
    <!-- END SIDEBAR -->

    <!-- BEGIN MAIN CONTAINER -->
    <div class="main-container" id="container">
        <div class="content-wrapper">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <h5 class="widget-heading">Nutrition Information</h5>
                    <p><strong>BMI Status:</strong> <?php echo htmlspecialchars($bmi_status); ?></p>
                    <p><strong>Recommended Calories:</strong> <?php echo htmlspecialchars($calories); ?></p>
                </div>
            </div>
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <h5 class="widget-heading">Recipes</h5>
                    <ul>
                        <?php if (!empty($recipes)): ?>
                            <?php foreach ($recipes as $recipe): ?>
                                <li>
                                    <?php if (isset($recipe['name'])): ?>
                                        <strong><?php echo htmlspecialchars($recipe['name']); ?></strong><br>
                                        <?php if (isset($recipe['ingredients']) && is_array($recipe['ingredients'])): ?>
                                            <strong>Ingredients:</strong> <?php echo implode(", ", $recipe['ingredients']); ?><br>
                                        <?php else: ?>
                                            <em>No ingredients available for this recipe.</em><br>
                                        <?php endif; ?>
                                        <?php if (isset($recipe['instructions'])): ?>
                                            <strong>Instructions:</strong> <?php echo htmlspecialchars($recipe['instructions']); ?><br>
                                        <?php else: ?>
                                            <em>No instructions available for this recipe.</em><br>
                                        <?php endif; ?>
                                        <?php if (isset($recipe['protein'])): ?>
                                            <strong>Protein:</strong> <?php echo htmlspecialchars($recipe['protein']); ?>g<br>
                                        <?php endif; ?>
                                        <?php if (isset($recipe['fats'])): ?>
                                            <strong>Fats:</strong> <?php echo htmlspecialchars($recipe['fats']); ?>g<br>
                                        <?php endif; ?>
                                        <?php if (isset($recipe['carbohydrates'])): ?>
                                            <strong>Carbohydrates:</strong> <?php echo htmlspecialchars($recipe['carbohydrates']); ?>g<br>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <em>No name available for this recipe.</em><br>
                                    <?php endif; ?>
                                </li>
                                <br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No recipes available.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <h5 class="widget-heading">Meal Plans</h5>
                    <ul>
                        <?php if (!empty($meal_plans)): ?>
                            <?php foreach ($meal_plans as $meal => $description): ?>
                                <li><strong><?php echo htmlspecialchars($meal); ?>:</strong> 
                                    <?php 
                                        if (is_array($description)) {
                                            echo "<pre>" . htmlspecialchars(json_encode($description, JSON_PRETTY_PRINT)) . "</pre>";
                                        } else {
                                            echo htmlspecialchars($description);
                                        }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No meal plans available.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

</html>
