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
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url('implementator') ?>">CCS | IMPLEMENTATOR</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

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
                                    href="<?= base_url() ?>user/profile_implementator/<?= $this->session->userdata('id_user'); ?>"><i
                                        class="material-icons">person</i>Profile</a>
                            </li>
                            <li class="<?= $this->uri->segment(2) == 'changepassword_hd' ? 'active' : ' ' ?>"><a
                                    href="<?= base_url('user/changepassword_implementator') ?>"><i
                                        class="material-icons">lock</i>Change Password</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('auth/logout') ?>" class="tombol-logout"><i
                                        class="material-icons">logout</i>Sign Out</a>
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
                        <!-- <?= $this->uri->segment(2) == 'jabatan' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?> -->
                        <a href="<?php echo base_url('implementator/pelaporan') ?>">
                            <i class="material-icons">confirmation_number</i>
                            <span>List Ticket</span>
                        </a>
                    </li>

                    <li>
                        <!-- <?= $this->uri->segment(2) == 'jabatan' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?> -->
                        <a href="<?php echo base_url('implementator/data_pelaporan') ?>">
                            <i class="material-icons">view_list</i>
                            <span>Data Pelaporan</span>
                        </a>
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