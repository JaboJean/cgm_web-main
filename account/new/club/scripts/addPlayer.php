<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addPlayer"])) {

  $fname                = TestData($_POST["fname"]);
  $lname                = TestData($_POST["lname"]);
  $clubId               = $_COOKIE["CLUB_ID"];
  $countryId            = TestData($_POST["countryId"]);
  $phone                = TestData($_POST["phone"]);
  $gender               = TestData($_POST["gender"]);
  $dob                  = TestData($_POST["dob"]);
  $nid                  = TestData($_POST["nid"]);
  $jerseyNo             = TestData($_POST["jerseyNo"]);

  $query = mysqli_query($connection, " SELECT * FROM players WHERE nid = '$nid'") or die($connecion);
  $count = mysqli_num_rows($query);

  if ($count > 0) {
    $alert  = "danger";
    $msg    = "This player is already registered!";
    require("templates/alert.php");
  } else {

    $query = mysqli_query($connection, "SELECT * FROM players") or die(mysqli_error($connection));
    $count = mysqli_num_rows($query);
    $no = $count + 1;

    if ($no < 10) {
      // LICENSE ID
      $no = "000" . $no;
    } elseif ($no < 100 && $no >= 10) {
      $no = "00" . $no;
    } elseif ($no < 1000 && $no >= 100) {
      $no = "0" . $no;
    }

    $licenseId = date("Y") . $no . "/P/" . $gender;

    // END LICENSE ID


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

    // TERMINATED CONTRACT

    $fileName        = $_FILES["terminatedContract"]["name"];
    $fileSize        = $_FILES["terminatedContract"]["size"] / 1024;
    $fileType        = $_FILES["terminatedContract"]["type"];
    $fileTmpName     = $_FILES["terminatedContract"]["tmp_name"];

    if (
      $fileType == "application/pdf"
    ) {

      //New file name
      $random = sha1(rand());
      $newFileName = $random . $fileName;
      $terminatedContract     =  $newFileName;

      //File upload path
      $uploadPath = "../catalog/docs/" . $newFileName;

      move_uploaded_file($fileTmpName, $uploadPath);
    } else {
      $error = 1;
      $alert  = "danger";
      $msg    = "Terminated Contract form has to be in pdf format only!";
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


    $query = mysqli_query($connection, "INSERT INTO `players` (`player_id`, `club_id`, `country_id`,`license_no`,`nid`, `player_fname`, `player_lname`, `gender`, `dob`, `phone`, `profile_picture`,`declaration`,`payment_proof`,`terminated_contract`, `jersey_number`, `player_status`) 
    VALUES (NULL, '$clubId', '$countryId', '$licenseId', '$nid', '$fname', '$lname', '$gender', '$dob', '$phone','$picture', '$declaration','$payment','$terminatedContract', '$jerseyNo', 'pending')") or die(mysqli_error($connection));

    if ($query) {

      // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
      //require("configs/deny.resubmit.php");
      // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

      $alert  = "success";
      $msg    = "You have successfully registered new player!";
      require("templates/alert.php");
    }
  }
}
