<body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <!-- <div class="overlay"></div> -->
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <!-- <div class="search-bar"> -->
    <!-- <div class="search-icon"> -->
    <!-- <i class="material-icons">search</i> -->
    <!-- </div> -->
    <!-- <input type="text" placeholder="START TYPING..."> -->
    <!-- <div class="close-search"> -->
    <!-- <i class="material-icons">close</i> -->
    <!-- </div> -->
    <!-- </div> -->
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url('klien') ?>">CCS | IMPLEMENTATOR</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> -->
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <!-- <li class="dropdown"> -->
                    <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"> -->
                    <!-- <i class="material-icons">notifications</i> -->
                    <!-- <span class="label-count">7</span> -->
                    <!-- </a> -->

                    <!-- Tasks -->
                    <!-- <li class="dropdown"> -->
                    <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"> -->
                    <!-- <i class="material-icons">flag</i> -->
                    <!-- <span class="label-count">9</span> -->
                    <!-- </a> -->

                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?= base_url('assets/'); ?>images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $this->session->userdata('nama_user'); ?></div>
                    <div class="email"><?= $this->session->userdata('divisi'); ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a
                                    href="<?= base_url() ?>user/profile_implementator/<?= $this->session->userdata('id'); ?>"><i
                                        class="material-icons">person</i>Profile</a>
                            </li>
                            <li class="<?= $this->uri->segment(2) == 'changepassword2' ? 'active' : ' ' ?>"><a
                                    href="<?= base_url('user/changepassword_implementator') ?>"><i
                                        class="material-icons">lock</i>Change Password</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('auth/logout') ?>" class="tombol-logout"><i
                                        class="material-icons">input</i>Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN MENU</li>
                    <li
                        class="active">
                        <a href="<?php echo base_url('implementator') ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">storage</i>
                            <span>Kelola Pelaporan</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url('implementator/pelaporan') ?>">Helpdesk 1</a>
                            </li>  

                            <li>
                                <a href="<?php echo base_url('implementator/pelaporanhd2') ?>">Helpdesk 2</a>
                            </li>

                            <li>
                                <a href="<?php echo base_url('implementator/pelaporanhd3') ?>">Helpdesk 3</a>
                            </li>

                            <li>
                                <a href="<?php echo base_url('implementator/pelaporanhd4') ?>">Helpdesk 4</a>
                            </li>
                             
                        </ul>

                    </li>



                    <li class="header">LABELS</li>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-red">donut_large</i>
                            <span>Important</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2024 <a href="javascript:void(0);">Customer Care System | PT MSO</a>.
                </div>
                <div class="version">

                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->