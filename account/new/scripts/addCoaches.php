<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addCoach"])) {

    $fname                = TestData($_POST["fname"]);
    $lname                = TestData($_POST["lname"]);
    $countryId            = TestData($_POST["countryId"]);
    $gender               = TestData($_POST["gender"]);
    $dob                  = TestData($_POST["dob"]);
    $validFrom            = TestData($_POST["validFrom"]);
    $validTo              = TestData($_POST["validTo"]);
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
  
    $licenseId = date("Y") . $no . "/S/" . $gender;
  
    // END LICENSE ID

    
  
    $query = mysqli_query($connection, "INSERT INTO `coaches` (`coach_id`, `license_id`, `country_id`,  `coach_fname`, `coach_lname`, `gender`, `dob`, `validity_from`, `validity_to`, `phone`, `email`, `coach_status`) 
    VALUES (NULL, '$licenseId', '$countryId', '$fname', '$lname', '$gender', '$dob', '$validFrom', '$validTo', '$phone', '$email', 'active')") or die(mysqli_error($connection));
  
    if ($query) {
  
      // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
      require("configs/deny.resubmit.php");
      // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
  
      $alert  = "success";
      $msg    = "You have successfully registered new coach!";
      require("templates/alert.php");
    }
  }
  