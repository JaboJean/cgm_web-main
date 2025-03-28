<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

if (isset($_POST["signin"])) {
  $id         = TestData($_POST["id"]);
  $password   = TestData($_POST["password"]);
  $query      = mysqli_query($connection, "SELECT * FROM admins WHERE admin_phone ='$id' OR admin_email='$id' AND admin_password ='$password'  AND admin_status ='active'") or die(mysqli_error($connection));
  $count      = mysqli_num_rows($query);
  if ($count == 1) {

    $data = mysqli_fetch_assoc($query);

    $alert  = "success";
    $msg    = "You have successfully signed in.";

    setcookie("ETNGTOKEN", $data["admin_id"], time() + (86400 * 30), "/");
    // setcookie("F_ADMIN_ROLE", $data["user_role"], time() + (86400 * 30), "/");
    setcookie("F_ADMIN_NAME", $data["admin_name"], time() + (86400 * 30), "/");

    $home = "dashboard";


?>
    <script type="text/javascript">
      setTimeout(function() {
        window.location = "<?php print($home) ?>";
      }, 3000);
    </script>
<?php
  } else {
    $alert  = "danger";
    $msg    = "Invalid login information, please try again.";
  }

  require "templates/alert.php";
}

// ADD SEASON

if (isset($_POST["addSeason"])) {
  $season         = TestData($_POST["season"]);
  $from           = TestData($_POST["from"]);
  $to             = TestData($_POST["to"]);

  $query = mysqli_query($connection,"INSERT INTO `seasons` (`season_id`, `start_from`, `end_on`, `season`) VALUES (NULL, '$from', '$to', '$season')")or die(mysqli_error($connection));

  mysqli_query($connection,"UPDATE players SET player_status ='Payment Required'")or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully updated season!";
    require("templates/alert.php");
  }

}

//#####################################  USER REGISTRATION  ######################//

if (isset($_POST["addUser"])) {

  $fname                = TestData($_POST["fname"]);
  $lname                = TestData($_POST["lname"]);
  $phone                = TestData($_POST["phone"]);
  $email                = TestData($_POST["email"]);
  $role                 = TestData($_POST["role"]);

  // GENERATE PASSWORD

  $digits_needed = 6;
  $random_number = ''; // set up a blank string
  $count = 0;
  while ($count < $digits_needed) {
    $random_digit = mt_rand(0, 9);

    $random_number .= $random_digit;
    $count++;
  }

  $password             = $random_number;

  $query = mysqli_query($connection, "INSERT INTO `users` (`user_id`, `user_name`, `user_lname`, `user_fname`, `user_phone`, `user_email`, `user_password`, `user_role`, `user_status`) 
  VALUES (NULL, '$fname', '$lname', '$fname', '$phone', '$email', '$password', '$role', 'active')") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully registered new user!";
    require("templates/alert.php");
  }
}

# TOP UP


if (isset($_POST["topUp"])) {

  $userId      = TestData($_POST["userId"]);
  $units       = TestData($_POST["units"]);
  $date         = date("Y-m-d");

  $query = mysqli_query($connection, "UPDATE users SET user_balance = user_balance+'$units' WHERE user_id ='$userId'") or die(mysqli_error($connection));

  mysqli_query($connection, "INSERT INTO `invoices` (`invoice_id`, `user_id`, `invoice_date`, `invoice_due_date`, `invoice_status`) VALUES (NULL, '$userId', '$date', '$date', 'paid')") or die(mysqli_error($connection));
  $invoiceId = mysqli_insert_id($connection);
  $item = "SMS purchase";

  mysqli_query($connection, "INSERT INTO `invoice_items` (`item_id`, `invoice_id`, `item_description`, `item_qty`, `item_price`) VALUES (NULL, '$invoiceId', '$item', '$units', '10')") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully toped up user's Balance";
    require("templates/alert.php");
  }
}

# DELETE PLAYER

if (isset($_GET["deleteP"])) {

  $playerId      = TestData($_GET["deleteP"]);
  $query = mysqli_query($connection, "DELETE FROM `players` WHERE `player_id` = '$playerId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted a player!";
    require("templates/alert.php");
  }
}

# APPROVE PLAYER

if (isset($_GET["approveP"])) {

  $playerId      = TestData($_GET["approveP"]);
  $query = mysqli_query($connection, "UPDATE players SET player_status ='active' WHERE `player_id` = '$playerId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully approved a player!";
    require("templates/alert.php");
  }
}


# DELETE REF

if (isset($_GET["deleteRef"])) {

  $refId      = TestData($_GET["deleteRef"]);
  $query = mysqli_query($connection, "DELETE FROM `officials` WHERE `official_id` = '$refId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted a Referee!";
    require("templates/alert.php");
  }
}


# DELETE STAFF

if (isset($_GET["deleteStaff"])) {

  $userId      = TestData($_GET["deleteStaff"]);
  $query = mysqli_query($connection, "DELETE FROM `coaches` WHERE `coach_id` = '$userId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted staff member!";
    require("templates/alert.php");
  }
}


# DELETE STAFF

if (isset($_GET["deleteClub"])) {

  $clubId = TestData($_GET["deleteClub"]);

  $query = mysqli_query($connection, "DELETE FROM `clubs` WHERE `club_id` = '$clubId' ") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted club!";
    require("templates/alert.php");
  }
}


# DELETE CATEGORY

if (isset($_GET["deleteUser"])) {

  $userId      = TestData($_GET["deleteUser"]);
  $query = mysqli_query($connection, "DELETE FROM `users` WHERE `user_id` = '$userId'") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully deleted a user!";
    require("templates/alert.php");
  }
}

// APPROVE TRANSFER


if (isset($_GET["approveTransfer"])) {

  $transferId      = TestData($_GET["transfer"]);
  $query           = mysqli_query($connection, " SELECT * FROM transfers WHERE transfer_id ='$transferId'") or die(mysqli_error($connection));
  $data            = mysqli_fetch_assoc($query);

  $playerId = $data["player_id"];
  $clubId   = $data["club_id_to"];

  mysqli_query($connection,"UPDATE players SET club_id ='$clubId' WHERE player_id ='$playerId'");
  mysqli_query($connection,"UPDATE transfers SET transfer_status ='approved' WHERE transfer_id ='$transferId' ")or die(mysqli_error($connection));


  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully approved the transfer!";
    require("templates/alert.php");
  }
}

ob_end_flush();
?>