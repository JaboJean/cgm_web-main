<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="path/to/your/custom.css" rel="stylesheet">
    <style>
        /* Add custom CSS here */
        .menu a {
            display: block;
            padding: 10px;
            color:#fff;
            text-decoration: none;
        }

        .menu.active a,
        .menu a:hover {
            background-color:#485a5e;
            color: white;
        }

        /* Highlight the active menu item */
        .menu:target {
            background-color: #485a5e;
            color: white;
        }

        .menu:target a {
            color: white;
        }
    </style>
</head>

<body>

<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <ul class="navbar-nav theme-brand flex-row text-center">
            <li class="nav-item theme-logo">
                <a href="#">
                    <img src="assets/img/logoo.png" class="navbar-logo" alt="logo" style="width: 170px; height: 170px;">
                </a>
            </li>

            <li class="nav-item theme-text">
                <a href="" class="nav-link"></a>
            </li>
            <li class="nav-item toggle-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-arrow-left sidebarCollapse">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </li>
        </ul>

        <div class="shadow-bottom"></div>

        <?php if ($role == "pediatrician") { ?>
            <ul class="list-unstyled menu-categories" id="accordionExample">
                <li id="appointements" class="menu appointements">
                    <a href="reappointement.php#appointements" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="calendar"></i>
                            <span>Appointments</span>
                        </div>
                    </a>
                </li>
            </ul>
        <?php } elseif ($role == "Parent") { ?>
            <ul class="list-unstyled menu-categories" id="accordionExample">
                <li id="childgrowth" class="menu childgrowth chart">
                    <a href="homepage.php#childgrowth" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="trello"></i>
                            <span>Child Growth Chart</span>
                        </div>
                    </a>
                </li>

                <li id="childprofile" class="menu child profile">
                    <a href="rechildprofile.php?type=rechildprofile#childprofile" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="smile"></i>
                            <span>Child Profile</span>
                        </div>
                    </a>
                </li>

                <li id="nutrition" class="menu nutrition">
                    <a href="renutrition.php#nutrition" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="database"></i>
                            <span>Nutritions</span>
                        </div>
                    </a>
                </li>

                <li id="requestappointements" class="menu requestappointements">
                    <a href="requestappointment.php#requestappointements" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="clock"></i>
                            <span>Request Appointment</span>
                        </div>
                    </a>
                </li>

                <li id="assessments" class="menu assessments">
                    <a href="re.assessments.php?type=assessment#assessments" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="edit"></i>
                            <span>Assessments</span>
                        </div>
                    </a>
                </li>

                <li id="vaccination" class="menu vaccination">
                    <a href="re.vaccination.php#vaccination" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="clipboard"></i>
                            <span>Vaccinations</span>
                        </div>
                    </a>
                </li>
            </ul>
        <?php } elseif ($role == "nurse") { ?>
            <ul class="list-unstyled menu-categories" id="accordionExample">
                <li id="patientrecords" class="menu patientrecords">
                    <a href="home.php#patientrecords" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="user-check"></i>
                            <span>Patient Records</span>
                        </div>
                    </a>
                </li>

                <li id="appointments" class="menu appointments">
                    <a href="nurseappointments.php#appointments" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="calendar"></i>
                            <span>Appointments</span>
                        </div>
                    </a>
                </li>

                <li id="medications" class="menu medications">
                    <a href="medications.php#medications" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="heart"></i>
                            <span>Medications</span>
                        </div>
                    </a>
                </li>
                
                <li id="healthreports" class="menu healthreports">
                    <a href="healthreports.php#healthreports" aria-expanded="false" class="dropdown-toggle">
                        <div>
                            <i data-feather="file-text"></i>
                            <span>Health Reports</span>
                        </div>
                    </a>
                </li>
            </ul>
        <?php } ?>
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
