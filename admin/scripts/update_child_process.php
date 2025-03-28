<?php

$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="cgm";

$connection = mysqli_connect($db_host,$db_user,$db_password,$db_name) or die(mysqli_error($connection));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $child_id = $_POST['child_id'];
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $join_date = $_POST['join_date'];
    $gender = $_POST['gender'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];
    $parent_phone = $_POST['parent_phone'];
    $email = $_POST['email'];
    $vaccinations = isset($_POST['vaccinations']) ? implode(',', $_POST['vaccinations']) : '';

    $query = "UPDATE child SET 
                full_name = '$full_name',
                date_of_birth = '$date_of_birth',
                join_date = '$join_date',
                gender = '$gender',
                father = '$father',
                mother = '$mother',
                parent_phone = '$parent_phone',
                email = '$email',
                vaccinations = '$vaccinations'
              WHERE child_id = $child_id";

    if (mysqli_query($connection, $query)) {
        header("Location: ../childprofile.php?message=Update successful");
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
