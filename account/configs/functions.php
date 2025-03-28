<?php
// functions.php (or test.data.php)
if (!function_exists('TestData')) {
    function TestData($data, $connection) {
        // Implement your sanitization logic here
        return mysqli_real_escape_string($connection, htmlspecialchars(trim($data)));
    }
}


?>