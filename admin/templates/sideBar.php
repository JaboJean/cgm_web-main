<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (if any) -->
    <link href="path/to/your/custom.css" rel="stylesheet">
    <style>
        /* Custom active link styling */
        .active-menu {
            background-color: #485a5e;
            color: #fff;
        }
        .active-menu a {
            color: #fff;
        }
    </style>
</head>

<body>

<?php
// Get the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <ul class="navbar-nav theme-brand flex-row text-center">
            <li class="nav-item theme-logo">
                <a href="dashboard.php">
                    <img src="assets/img/logoo.png" class="navbar-logo" alt="logo" style="width: 170px; height: 170px;">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="dashboard.php" class="nav-link">  </a>
            </li>
            <li class="nav-item toggle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left sidebarCollapse">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </li>
        </ul>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu dashboard <?php echo ($current_page == 'dashboard.php') ? 'active-menu' : ''; ?>">
                <a href="dashboard.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="trello"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu Child Profile <?php echo ($current_page == 'childprofile.php') ? 'active-menu' : ''; ?>">
                <a href="childprofile.php?type=childprofile" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layers"></i>
                        <span>Child Profile</span>
                    </div>
                </a>
            </li>
            <li class="menu Child Profile Registration <?php echo ($current_page == 'profileregistration.php') ? 'active-menu' : ''; ?>">
                <a href="profileregistration.php?type=profileregistration" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="file-plus"></i>
                        <span>Child Registration</span>
                    </div>
                </a>
            </li>
             
            <li class="menu Assessment <?php echo ($current_page == 'assessment.php') ? 'active-menu' : ''; ?>">
                <a href="assessment.php?type=assessment" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="users"></i>
                        <span>Assessment</span>
                    </div>
                </a>
            </li>
            <li class="menu Nutritions <?php echo ($current_page == 'nutritions.php') ? 'active-menu' : ''; ?>">
                <a href="nutritions.php?type=nutritions" aria-expanded="false" class="dropdown-toggle">
                    <div>
                        <i data-feather="smile"></i>
                        <span>Nutritions</span>
                    </div>
                </a>
            </li>
            <li class="menu health information <?php echo ($current_page == 'healthinfo.php') ? 'active-menu' : ''; ?>">
                <a href="healthinfo.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="shield"></i>
                        <span>Health Information</span>
                    </div>
                </a>
            </li>
            <li class="menu Paediatrician <?php echo ($current_page == 'pediatrician.php') ? 'active-menu' : ''; ?>">
                <a href="pediatrician.php?type=pediatrician" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="heart"></i>
                        <span>Paediatricians</span>
                    </div>
                </a>
            </li>
            <li class="menu Nurses <?php echo ($current_page == 'nurses.php') ? 'active-menu' : ''; ?>">
                <a href="nurses.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="user-plus"></i>
                        <span>Nurses</span>
                    </div>
                </a>
            </li>
            <li class="menu reports <?php echo ($current_page == 'admins.php') ? 'active-menu' : ''; ?>">
                <a href="myreports.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="file-text"></i>
                        <span>Reports</span>
                    </div>
                </a>
            </li>
            <li class="menu underweight <?php echo ($current_page == 'underweight.php') ? 'active-menu' : ''; ?>">
                <a href="underweight.php" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="frown"></i>
                        <span>Critical Conditions Kids</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS for dropdown functionality -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Feather Icons initialization -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        feather.replace();
    });
</script>

</body>

</html>
