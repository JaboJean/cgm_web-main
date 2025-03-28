<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="dashboard">
                    <img src="assets/img/favicon.jpeg" class="navbar-logo" alt="logo">
                </a>
            </li>

            <li class="nav-item theme-text">
                <a href="dashboard" class="nav-link"> E-TUNGO </a>
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
            <li class="menu dashboard">
                <a href="dashboard" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="trello"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>


            <!-- <li class="menu licenses">
                <a href="#licenses" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layers"></i>
                        <span>Licenses</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="licenses" data-parent="#accordionExample">

                    <li class='playersLicense'>
                        <a href="#license.players"> Players</a>
                    </li>
                </ul>
            </li> -->


            <li class="menu players">
                <a href="players" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="users"></i>
                        <span>Players</span>
                    </div>
                </a>
            </li>

            <li class="menu transfers">
                <a href="#transfers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layers"></i>
                        <span>Transfers</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="transfers" data-parent="#accordionExample">

                    <li class='inwardTransfers'>
                        <a href="inwardTransfers">Requests</a>
                    </li>

                    <li class='outwardTransfers'>
                        <a href="outwardTransfers">Outwards</a>
                    </li>
                </ul>
            </li>


        </ul>

    </nav>

</div>