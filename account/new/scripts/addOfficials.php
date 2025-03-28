<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addOfficial"])) {

    $fname                = TestData($_POST["fname"]);
    $lname                = TestData($_POST["lname"]);
    $gender               = TestData($_POST["gender"]);
    $countryId            = TestData($_POST["countryId"]);
    $phone                = TestData($_POST["phone"]);
    $email                = TestData($_POST["email"]);

    if ($no < 10) {
      // LICENSE ID
      $no = "00" . $no;
    } elseif ($no < 100 && $no >= 10) {
      $no = "0" . $no;
    }elseif($no < 1000 && $no >= 100)
    {
      $no = "0" . $no;
    }
  
    $licenseId = date("Y") . $no . "/R/" . $gender;
  
    // END LICENSE ID

  
    $query = mysqli_query($connection, "INSERT INTO `officials` (`official_id`, `country_id`,`license_id`, `official_fname`, `official_lname`, `phone`, `email`, `official_status`) 
    VALUES (NULL, '$countryId', '$licenseId', '$fname', '$lname', '$phone', '$email', 'active')") or die(mysqli_error($connection));
  
    if ($query) {
  
      // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
      require("configs/deny.resubmit.php");
      // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
  
      $alert  = "success";
      $msg    = "You have successfully registered new Referee!";
      require("templates/alert.php");
    }
  }
  