<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";

###############################    SIGNIN       ################################

if (isset($_POST["signin"])) {
  $id         = TestData($_POST["id"]);
  $password   = TestData($_POST["password"]);
  $query      = mysqli_query($connection, "SELECT * FROM clubs WHERE phone ='$id' OR email='$id' AND password ='$password'  AND club_status ='active'") or die(mysqli_error($connection));
  $count      = mysqli_num_rows($query);
  if ($count == 1) {

    $data = mysqli_fetch_assoc($query);

    $alert  = "success";
    $msg    = "You have successfully signed in.";

    setcookie("CLUB_ID", $data["club_id"], time() + (86400 * 30), "/");
    setcookie("CLUB_NAME", $data["club_name"], time() + (86400 * 30), "/");

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

if (isset($_POST["sendRequest"])) {

  $playerId = $_POST["playerId"];
  $clubId = $_COOKIE["CLUB_ID"];
  $date = date("Y-m-d");

  $query = mysqli_query($connection, "SELECT * FROM players WHERE player_id ='$playerId'");
  $data = mysqli_fetch_assoc($query);

  $from = $data["club_id"];

  $error = 0;

  // RELEASE LETTER

  $fileName      = $_FILES["release"]["name"];
  $fileSize      = $_FILES["release"]["size"] / 1024;
  $fileType      = $_FILES["release"]["type"];
  $fileTmpName   = $_FILES["release"]["tmp_name"];

  if (
    $fileType == "application/pdf"
  ) {

    //New file name
    $random = sha1(rand());
    $newFileName = $random . $fileName;
    $release = $newFileName;

    //File upload path
    $uploadPath = "../catalog/docs/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {

    $error = 1;
    $alert  = "danger";
    $msg    = "Release letter has to be in pdf format only!";
    require("templates/alert.php");
  }

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



  // CONTRACT

  $fileName        = $_FILES["contract"]["name"];
  $fileSize        = $_FILES["contract"]["size"] / 1024;
  $fileType        = $_FILES["contract"]["type"];
  $fileTmpName     = $_FILES["contract"]["tmp_name"];

  if (
    $fileType == "application/pdf"
  ) {

    //New file name
    $random       = sha1(rand());
    $newFileName  = $random . $fileName;
    $contract     =  $newFileName;

    //File upload path
    $uploadPath = "../catalog/docs/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {
    $error = 1;
    $alert  = "danger";
    $msg    = "Contract  has to be in pdf format only!";
    require("templates/alert.php");
  }


  // ID

  $fileName        = $_FILES["id"]["name"];
  $fileSize        = $_FILES["id"]["size"] / 1024;
  $fileType        = $_FILES["id"]["type"];
  $fileTmpName     = $_FILES["id"]["tmp_name"];

  if (
    $fileType == "application/pdf"
  ) {

    //New file name
    $random       = sha1(rand());
    $newFileName  = $random . $fileName;
    $id     =  $newFileName;

    //File upload path
    $uploadPath = "../catalog/docs/" . $newFileName;

    move_uploaded_file($fileTmpName, $uploadPath);
  } else {
    $error = 1;
    $alert  = "danger";
    $msg    = "ID has to be in pdf format only!";
    require("templates/alert.php");
  }

  if ($error == 0) {

    mysqli_query($connection, "INSERT INTO `transfers` (`transfer_id`, `club_id_from`, `club_id_to`, `player_id`, `transfer_date`, `transfer_date_updated`,`release_letter`,`declaration`,`payment`,`contract`,`id`, `transfer_status`) 
  VALUES (NULL, '$from', '$clubId', '$playerId', '$date', NULL,'$release','$declaration','$payment','$contract','$id','pending')") or die(mysqli_error($connection));

    $alert  = "success";
    $msg    = "You have successfully submitted your request.";

    require "templates/alert.php";
  }
}

# CANCEL TRANSFER

if (isset($_GET["cancelT"])) {

  $id = TestData($_GET["cancelT"]);

  $query = mysqli_query($connection, "UPDATE transfers SET transfer_status ='Canceled' WHERE transfer_id ='$id' ") or die(mysqli_error($connection));

  if ($query) {

    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully canceled your transfer request!";
    require("templates/alert.php");
  }
}

ob_end_flush();
?>