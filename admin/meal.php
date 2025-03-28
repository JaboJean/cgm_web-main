<!DOCTYPE html>
<html>
<head>
    <title>Nutritional Guidance and Meal Planning for Kids</title>
</head>
<body>
    <form method="GET" action="index.php">
        <label for="age_group">Select Age Group:</label>
        <select id="age_group" name="age_group">
            <option value="1-3">1-3 years</option>
            <option value="4-8">4-8 years</option>
            <!-- Add more age groups as needed -->
        </select>
        <br>

        <label for="bmi_category">Select BMI Category:</label>
        <select id="bmi_category" name="bmi_category">
            <option value="Underweight">Underweight</option>
            <option value="Normal weight">Normal weight</option>
            <option value="Overweight">Overweight</option>
            <option value="Obese">Obese</option>
        </select>
        <br>

        <button type="submit" name="action" value="nutrition">Get Nutrition Info</button>
        <button type="submit" name="action" value="recipes">Get Recipes</button>
        <button type="submit" name="action" value="meal_plans">Get Meal Plans</button>
    </form>

    <?php
    if (isset($_GET['age_group']) && isset($_GET['bmi_category']) && isset($_GET['action'])) {
        $age_group = $_GET['age_group'];
        $bmi_category = $_GET['bmi_category'];
        $action = $_GET['action'];

        $api_url = "http://localhost/apitest/extended_nutrition_api.php?endpoint={$action}&age_group={$age_group}&bmi_category=" . urlencode($bmi_category);
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        if (isset($data['error'])) {
            echo "<p>Error: " . $data['error'] . "</p>";
        } else {
            echo "<h2>" . ucfirst($action) . " for Age Group {$age_group} and BMI Category {$bmi_category}</h2>";
            echo "<pre>" . print_r($data, true) . "</pre>";
        }
    }
    ?>
</body>
</html>
