<?php

ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["sendRequest"])) {

  $playerId             = TestData($_POST["playerId"]);
  $fromClubId           = $CLUBID;
  $toClubId             = TestData($_POST["toClubId"]);
  $today                = date("Y-m-d");


  $query = mysqli_query($connection, "INSERT INTO `transfers` (`transfer_id`, `club_id_from`, `club_id_to`, `player_id`, `transfer_date`, `transfer_date_updated`, `transfer_status`) 
    VALUES (NULL, '$fromClubId', '$toClubId', '$playerId', '$today', NULL, 'pending')") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully sent your request!";
    require("templates/alert.php");
  }
}
