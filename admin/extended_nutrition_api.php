<?php
header("Content-Type: application/json");

$age_group = isset($_GET['age_group']) ? $_GET['age_group'] : null;
$bmi_category = isset($_GET['bmi_category']) ? $_GET['bmi_category'] : null;
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : null;

$nutrition_data = [
    "1-3" => [
        "Underweight" => [
            "calories" => "1400-1600",
            "protein" => "15g",
            "fat" => "35-45g",
            "carbohydrates" => "140g"
        ],
        "Normal weight" => [
            "calories" => "1000-1400",
            "protein" => "13g",
            "fat" => "30-40g",
            "carbohydrates" => "130g"
        ],
        "Overweight" => [
            "calories" => "900-1100",
            "protein" => "13g",
            "fat" => "25-35g",
            "carbohydrates" => "120g"
        ],
        "Obese" => [
            "calories" => "800-1000",
            "protein" => "13g",
            "fat" => "20-30g",
            "carbohydrates" => "110g"
        ],
    ],
    "4-8" => [
        "Underweight" => [
            "calories" => "1800-2000",
            "protein" => "20g",
            "fat" => "50-60g",
            "carbohydrates" => "160g"
        ],
        "Normal weight" => [
            "calories" => "1200-1800",
            "protein" => "19g",
            "fat" => "40-55g",
            "carbohydrates" => "130g"
        ],
        "Overweight" => [
            "calories" => "1100-1400",
            "protein" => "19g",
            "fat" => "35-50g",
            "carbohydrates" => "120g"
        ],
        "Obese" => [
            "calories" => "1000-1300",
            "protein" => "19g",
            "fat" => "30-45g",
            "carbohydrates" => "110g"
        ],
    ],
    // Add more age groups and BMI categories...
];

$recipes = [
    "1-3" => [
        "Underweight" => [
            [
                "name" => "Banana Smoothie",
                "ingredients" => ["Banana", "Whole Milk", "Honey"],
                "instructions" => "Blend banana, milk, and honey until smooth."
            ],
            [
                "name" => "Peanut Butter Oatmeal",
                "ingredients" => ["Oats", "Peanut Butter", "Milk"],
                "instructions" => "Cook oats in milk and stir in peanut butter."
            ],
            [
                "name" => "Pap (Maize Porridge)",
                "ingredients" => ["Maize Meal", "Water", "Milk", "Sugar"],
                "instructions" => "Cook maize meal in water, add milk and sugar to taste."
            ],
        ],
        "Normal weight" => [
            [
                "name" => "Apple Slices with Peanut Butter",
                "ingredients" => ["Apple", "Peanut Butter"],
                "instructions" => "Slice the apple and spread peanut butter on each slice."
            ],
            [
                "name" => "Cheese and Crackers",
                "ingredients" => ["Cheese", "Whole Grain Crackers"],
                "instructions" => "Serve cheese slices with whole grain crackers."
            ],
            [
                "name" => "Baked Sweet Potato",
                "ingredients" => ["Sweet Potato", "Butter", "Honey"],
                "instructions" => "Bake sweet potato and top with butter and honey."
            ],
        ],
        // Add more recipes for other BMI categories...
    ],
    "4-8" => [
        "Underweight" => [
            [
                "name" => "Yogurt and Fruit Parfait",
                "ingredients" => ["Greek Yogurt", "Granola", "Mixed Berries"],
                "instructions" => "Layer yogurt, granola, and berries in a cup."
            ],
            [
                "name" => "Chicken and Veggie Wrap",
                "ingredients" => ["Whole Wheat Tortilla", "Chicken Breast", "Mixed Vegetables"],
                "instructions" => "Fill the tortilla with chicken and vegetables, then wrap."
            ],
            [
                "name" => "Jollof Rice",
                "ingredients" => ["Rice", "Tomatoes", "Onions", "Peppers", "Chicken"],
                "instructions" => "Cook rice with tomatoes, onions, peppers, and chicken."
            ],
        ],
        "Normal weight" => [
            [
                "name" => "Veggie Wrap",
                "ingredients" => ["Whole Wheat Tortilla", "Hummus", "Cucumber", "Carrots", "Lettuce"],
                "instructions" => "Spread hummus on the tortilla, add veggies, and wrap."
            ],
            [
                "name" => "Yogurt Parfait",
                "ingredients" => ["Greek Yogurt", "Granola", "Mixed Berries"],
                "instructions" => "Layer yogurt, granola, and berries in a cup."
            ],
            [
                "name" => "Ugali with Sukuma Wiki",
                "ingredients" => ["Maize Flour", "Water", "Kale", "Onions", "Tomatoes"],
                "instructions" => "Cook maize flour into a stiff porridge (ugali) and serve with kale cooked with onions and tomatoes."
            ],
        ],
        // Add more recipes for other BMI categories...
    ],
    // Add more age groups and BMI categories...
];

$meal_plans = [
    "1-3" => [
        "Underweight" => [
            "Breakfast" => "Oatmeal with banana and milk",
            "Lunch" => "Peanut butter sandwich with apple slices",
            "Dinner" => "Chicken stew with vegetables",
            "Snacks" => ["Yogurt with berries", "Cheese and crackers"]
        ],
        "Normal weight" => [
            "Breakfast" => "Whole grain cereal with milk",
            "Lunch" => "Turkey and cheese sandwich with carrot sticks",
            "Dinner" => "Spaghetti with tomato sauce and a side salad",
            "Snacks" => ["Apple slices with peanut butter", "Yogurt with granola"]
        ],
        // Add more meal plans for other BMI categories...
    ],
    "4-8" => [
        "Underweight" => [
            "Breakfast" => "Scrambled eggs with toast and fruit",
            "Lunch" => "Chicken and veggie wrap",
            "Dinner" => "Grilled fish with quinoa and vegetables",
            "Snacks" => ["Smoothie with yogurt and fruit", "Trail mix"]
        ],
        "Normal weight" => [
            "Breakfast" => "Yogurt parfait with granola and berries",
            "Lunch" => "Veggie wrap with hummus",
            "Dinner" => "Stir-fried tofu with brown rice and vegetables",
            "Snacks" => ["Fruit salad", "Cheese and crackers"]
        ],
        // Add more meal plans for other BMI categories...
    ],
    // Add more age groups and BMI categories...
];

$response = [];

if ($endpoint == "nutrition" && $age_group && isset($nutrition_data[$age_group][$bmi_category])) {
    $response = $nutrition_data[$age_group][$bmi_category];
} elseif ($endpoint == "recipes" && $age_group && isset($recipes[$age_group][$bmi_category])) {
    $response = $recipes[$age_group][$bmi_category];
} elseif ($endpoint == "meal_plans" && $age_group && isset($meal_plans[$age_group][$bmi_category])) {
    $response = $meal_plans[$age_group][$bmi_category];
} else {
    $response = ["error" => "Invalid endpoint, age group, or BMI category"];
}

echo json_encode($response);
?>
