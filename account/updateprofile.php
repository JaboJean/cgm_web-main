 
 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CGM  - Update Profile</title>
    <link rel="icon" type="image/x-icon" href="" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                    <img src="assets/img/logoo.png" alt="" style="position: absolute; top: 0; left: 200px; padding: 0px; width: 250px; max-width: 100%; height: auto;" class="mb-1">

                    <br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
 
                        


                        <h4 class="">Update Password   <a href="#"><span class="brand-name"></span></a></h4>
                        <br/>
 


                         <?php
                        require("scripts/profile_handle.php");
                        ?>

<form class="text-left" method="POST" action="scripts/profile_handle.php">
    <div class="form">
        <div id="username-field" class="field-wrapper input">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <input id="email" name="user_id" type="text" class="form-control" placeholder="User ID" required>
        </div>

        <div id="password-field" class="field-wrapper input mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
        </div>

        <div id="re-password-field" class="field-wrapper input mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input id="re_password" name="re_password" type="password" class="form-control" placeholder="Re-Enter Password" required>
        </div>

        <div class="d-sm-flex justify-content-between">
            <div class="field-wrapper toggle-pass">
                <p class="d-inline-block">Show Password</p>
                <label class="switch s-primary">
                    <input type="checkbox" id="toggle-password" class="d-none">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="field-wrapper">
                <button type="submit" class="btn btn-primary" value="" name="signin">Change</button>
            </div>
        </div>
    </div>
</form>

                        <p class="terms-conditions">© <?php print(date("Y")); ?> All Rights Reserved. <a href="#">CGM</a>. <a href="javascript:void(0);">Cookie Preferences</a>, <a href="javascript:void(0);">Privacy</a>, and <a href="javascript:void(0);">Terms</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>

</body>

</html>