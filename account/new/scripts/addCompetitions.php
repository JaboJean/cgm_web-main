<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addCompetition"])) {

    $season              = TestData($_POST["season"]);
    $name                = TestData($_POST["name"]);
    $abreviation         = TestData($_POST["abreviation"]);
    $category            = TestData($_POST["category"]);
    $begin               = TestData($_POST["begin"]);
    $end                 = TestData($_POST["end"]);
  
    $query = mysqli_query($connection, "INSERT INTO `competitions` (`competition_id`, `season`, `name`, `abreviation`, `category`, `begin_date`, `end_date`) 
    VALUES (NULL, '$season', '$name', '$abreviation', '$category', '$begin', '$end')") or die(mysqli_error($connection));
  
    if ($query) {
  
      // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
      require("configs/deny.resubmit.php");
      // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
  
      $alert  = "success";
      $msg    = "You have successfully registered new competition!";
      require("templates/alert.php");
    }
  }
  