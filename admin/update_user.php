<?php
require("configs/globals.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $userId = mysqli_real_escape_string($connection, $_POST['userId']);
    $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    $nationalID = mysqli_real_escape_string($connection, $_POST['nationalID']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phoneNumber = mysqli_real_escape_string($connection, $_POST['phoneNumber']);

    // Update the user record in the database
    $query = "UPDATE users SET fname='$firstName', lname='$lastName', nid='$nationalID', gender='$gender', email='$email', phone='$phoneNumber' WHERE user_id='$userId'";
    if (mysqli_query($connection, $query)) {
        echo 'Record updated successfully';
    } else {
        echo 'Error updating record: ' . mysqli_error($connection);
    }
}
?>
