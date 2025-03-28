<?php
require("configs/connection.php");
require("secure.php");
ini_set('display_errors', 0);
error_reporting(E_ALL);

$token = $_COOKIE["CGMTOKEN"];

$query = mysqli_query($connection, "SELECT * FROM users where token ='$token'") or die(mysqli_error($connection));
$data = mysqli_fetch_assoc($query);

$userId = $data["user_id"];
$role = $data["role"];
$fname = $data["fname"];
$phone = $data["phone"];
$email = $data["email"];

?>

