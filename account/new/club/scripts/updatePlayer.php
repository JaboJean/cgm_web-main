<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["updatePlayer"])) {

  $fname                = TestData($_POST["fname"]);
  $lname                = TestData($_POST["lname"]);
  $playerId             = TestData($_POST["playerId"]);
  $countryId            = TestData($_POST["countryId"]);
  $phone                = TestData($_POST["phone"]);
  $gender               = TestData($_POST["gender"]);
  $dob                  = TestData($_POST["dob"]);
  $jerseyNo             = TestData($_POST["jerseyNo"]);


  // DECLARATION FORM

  $fileName        = $_FILES["declaration"]["name"];
  $fileSize        = $_FILES["declaration"]["size"] / 1024;
  $fileType        = $_FILES["declaration"]["type"];
  $fileTmpName     = $_FILES["declaration"]["tmp_name"];

  if (
    $fileType == "application/pdf"
  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;
    $declaration =  $newFileName;

    //File upload path
    $uploadPath = "../catalog/docs/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {
    $error = 1;
    $alert  = "danger";
    $msg    = "Declartion form has to be in pdf format only!";
    require("templates/alert.php");
  }

  // PAYMENT PROOF

  $fileName        = $_FILES["payment"]["name"];
  $fileSize        = $_FILES["payment"]["size"] / 1024;
  $fileType        = $_FILES["payment"]["type"];
  $fileTmpName     = $_FILES["payment"]["tmp_name"];

  if (
    $fileType == "application/pdf"
  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;
    $payment     =  $newFileName;

    //File upload path
    $uploadPath = "../catalog/docs/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {
    $error = 1;
    $alert  = "danger";
    $msg    = "payment form has to be in pdf format only!";
    require("templates/alert.php");
  }



  // PICTURE

  $fileName        = $_FILES["picture"]["name"];
  $fileSize        = $_FILES["picture"]["size"] / 1024;
  $fileType        = $_FILES["picture"]["type"];
  $fileTmpName     = $_FILES["picture"]["tmp_name"];

  if (
    $fileType == "image/png"
    || $fileType == "image/PNG"
    || $fileType == "image/JPG"
    || $fileType == "image/jpg"
    || $fileType == "image/jpeg"
    || $fileType == "image/JPEG"
    || $fileType == "image/gif"
  ) {

    //New file name
    $random       = sha1(rand());
    $newFileName  = $random . $fileName;
    $picture     =  $newFileName;

    //File upload path
    $uploadPath = "../catalog/pictures/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {
    $error = 1;
    $alert  = "danger";
    $msg    = "Profile Picture has to be an image format only!";
    require("templates/alert.php");
  }


  $query = mysqli_query($connection, "UPDATE `players` SET `country_id` = '$countryId', `player_fname` = '$fname', `player_lname` = '$lname', `gender` = '$gender', `dob` = '$dob', `phone` = '$phone', `profile_picture` = '$picture', `declaration` = '$declaration', `payment_proof` = '$payment', `jersey_number` = '$jerseyNo' WHERE `players`.`player_id` = '$playerId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    //require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully updated player's info!";
    require("templates/alert.php");
  }
}
