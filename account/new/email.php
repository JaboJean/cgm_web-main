<?php 

$email ="hubertithug@gmail.com";
$password ='1234567';
$clubName ='TEST';
    // SEND NOTIFICATION EMAIL 
    $to = $email;
    $subject = "E-TUNGO ACCOUNT";

    $message ="
  <html>
  <body>
  <p>Hello " . $clubName . "!</p>
  <p>Your request has been approved!</p>
  <p>Use your email and this password " . $password . " to login to your E-TUNGO Account.</p>
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
    $headers .= 'From: E-TUNGO <info@E-TUNGO.rw>' . "\r\n";
    $headers .= 'Cc: hubertithug@gmail.com' . "\r\n";

    mail($to, $subject, $message, $headers);

    ?>