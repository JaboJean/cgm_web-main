<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addPlayer"])) {

  $fname                = TestData($_POST["fname"]);
  $lname                = TestData($_POST["lname"]);
  $clubId               = TestData($_POST["clubId"]);
  $licenseId            = TestData($_POST["licenseId"]);
  $licenseCategory      = TestData($_POST["licenseCategory"]);
  $countryId            = TestData($_POST["countryId"]);
  $phone                = TestData($_POST["phone"]);
  $gender               = TestData($_POST["gender"]);
  $dob                  = TestData($_POST["dob"]);
  $jerseyNo             = TestData($_POST["jerseyNo"]);

  $query = mysqli_query($connection, "SELECT * FROM players") or die(mysqli_error($connection));
  $count = mysqli_num_rows($query);
  $no = $count + 1;

  if ($no < 10) {
    // LICENSE ID
    $no = "000" . $no;
  } elseif ($no < 100 && $no >= 10) {
    $no = "00" . $no;
  }elseif($no < 1000 && $no >= 100)
  {
    $no = "0" . $no;
  }

  $licenseId = date("Y") . $no . "/P/" . $gender;

  // END LICENSE ID

  $query = mysqli_query($connection, "INSERT INTO `players` (`player_id`, `club_id`, `country_id`,`license_no`, `player_fname`, `player_lname`, `gender`, `dob`, `phone`, `email`, `profile_picture`, `jersey_number`, `player_status`) 
    VALUES (NULL, '$clubId', '$countryId', '$licenseId', '$fname', '$lname', '$gender', '$dob', '$phone', '$email','profile',  '$jerseyNo', 'pending')") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    //require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully registered new player!";
    require("templates/alert.php");
  }
}
