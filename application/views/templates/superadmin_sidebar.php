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
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">CCS | Superadmin</a>

            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy</b> changed name</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> commented your post</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> updated status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
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
                            <li><a href="<?= base_url() ?>user/profile_superadmin/<?= $this->session->userdata('id_user'); ?>"><i
                                        class="material-icons">person</i>Profile</a>
                            </li>

                            <li>
                            <!-- <?= $this->uri->segment(2) == 'changepassword_superadmin' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?> -->
                                <a href="<?= base_url('user/changepassword_superadmin') ?>"><i
                                        class="material-icons">lock</i>Change Password</a>
                            </li>

                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('auth/logout') ?>" class="tombol-logout"><i
                                        class="material-icons">logout</i>Sign Out</a>
                            </li>
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
                    <li class="active">
                        <a href="<?php echo base_url('superadmin') ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li
                        <?= $this->uri->segment(2) == 'category' || $this->uri->segment(2) == 'client' || $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'AktivasiUser'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">storage</i>
                            <span>Kelola Data</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'category' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/category') ?>">Data Kategori</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'client' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/client') ?>">Data BPR</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'detail_pelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/user') ?>">Data User</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'AktivasiUser' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('user/AktivasiUser') ?>">Aktivasi User</a>
                            </li>

                        </ul>
                    </li>


                    <li
                        <?= $this->uri->segment(2) == 'AllTicket' || $this->uri->segment(2) == 'added' || $this->uri->segment(2) == 'onprogress' || $this->uri->segment(2) == 'detail_pelaporan' || $this->uri->segment(2) == 'close' || $this->uri->segment(2) == 'finish'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">confirmation_number</i>
                            <span>List Ticket</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'AllTicket' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/AllTicket') ?>">All Ticket</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'added' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/added') ?>">Added</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'onprogress' || $this->uri->segment(2) == 'detail_pelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/onprogress') ?>">On Progress</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'close' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/close') ?>">Close</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'finish' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/finish') ?>">Finish</a>
                            </li>

                        </ul>
                    </li>


                    <li
                        <?= $this->uri->segment(2) == 'rekapPelaporan' || $this->uri->segment(2) == 'datepelaporan' || $this->uri->segment(2) == 'rekapKategori' || $this->uri->segment(2) == 'rekapHelpdesk' || $this->uri->segment(2) == 'rekapProgres'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">archive</i>
                            <span>Laporan</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'rekapPelaporan' || $this->uri->segment(2) == 'datepelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapPelaporan') ?>">Rekap Pelaporan</a>
                            </li>
<!-- 
                            <li
                                <?= $this->uri->segment(2) == 'rekapKategori' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapKategori') ?>">Rekap Kategori</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'rekapHelpdesk' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapHelpdesk') ?>">Rekap Helpdesk</a>
                            </li> -->

                            <!-- <li
                                <?= $this->uri->segment(2) == 'rekapProgres' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapProgres') ?>">Rekap Progres</a>
                            </li> -->

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
                    &copy; <span id="year"></span> <a href="javascript:void(0);">Customer Care System | PT MSO</a>.
                </div>
                <div class="version">

                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

        <script>
            document.getElementById("year").innerHTML = new Date().getFullYear();
        </script>