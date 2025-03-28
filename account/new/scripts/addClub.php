
<?php
ob_start();
require "configs/connection.php";
require "configs/test.data.php";


if (isset($_POST["addClub"])) {

  $clubName             = TestData($_POST["clubName"]);
  $abreviation          = TestData($_POST["abreviation"]);
  //$category             = TestData($_POST["category"]);
  //$competion            = TestData($_POST["competition"]);
  $begin                = TestData($_POST["begin"]);
  $aboutClub            = TestData($_POST["aboutClub"]);
  $phone                = TestData($_POST["phone"]);
  $email                = TestData($_POST["email"]);


  // GENERATE PASSWORD

  $digits_needed = 6;

  $random_number = ''; // set up a blank string

  $count = 0;

  while ($count < $digits_needed) {
    $random_digit = mt_rand(0, 9);

    $random_number .= $random_digit;
    $count++;
  }
  $password = $random_number;

  $query = mysqli_query($connection, "INSERT INTO `clubs` (`club_id`, `club_name`, `club_abreviation`, `club_begin_date`,`about_club`,  `phone`, `email`,`password`, `club_status`) 
    VALUES (NULL, '$clubName', '$abreviation',  '$begin',  '$aboutClub',  '$phone', '$email','$password', 'active')") or die(mysqli_error($connection));

  if ($query) {

    // SEND NOTIFICATION EMAIL 
    $to = $email;
    $subject = "E-TUNGO PORTAL";

    $message ="
  <html>
  <body>
  <p>Hello " . $clubName . "!</p>
  <p>You are welcome to E-TUNGO Portal!</p>
  <p>Use your phone/email and this password " . $password . " to login to your E-TUNGO Account.</p>
  <br>
  <p><a href='https://rwanda.basketball/account/'>Click here to login into your account</a></p>
  <p>Thank you!</p>
  </body>
  </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: E-TUNGO <info@itdevs.rw>' . "\r\n";
    //$headers .= 'Cc: hubertithug@gmail.com' . "\r\n";

    mail($to, $subject, $message, $headers);

// $sms = "Hey";

// $sender = "BASKET";
// $receiver = "25".$phone;
// $message = $sms;


// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://menya.app/api/v1/sms/send',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => array('sender' => "$sender",'receivers' => "$receiver",'message' => "$message",'API_KEY' => '00001'),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;



    // >>>>>>>>>>>>>>>>>>>>>>>>>      prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//
    //require("configs/deny.resubmit.php");
    // >>>>>>>>>>>>>>>>>>>>>>>>>   end prevent form resubmit on refresh   <<<<<<<<<<<<<<<<<<<<<<<<<//

    $alert  = "success";
    $msg    = "You have successfully registered new club!";
    require("templates/alert.php");

  }
}
