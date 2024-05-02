
<body class="theme-red">
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
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <section class="content">
    <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>

        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>SELAMAT DATANG DI CUSTOMER CARE SYSTEM</h2>
                                </div>
                                
                            </div>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                        <?php
                            $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'HANDLE '");

                            foreach ($totalp->result() as $total) {
                            ?>

                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-blue hover-expand-effect">
                                        <div class="icon">
                                            <a href="<?php echo base_url('helpdesk/pelaporan') ?>">
                                                <i class="material-icons">assignment_turned_in</i>
                                            </a>
                                        </div>
                                            <div class="content">
                                        <div class="text">NEW TIKET</div>
                                        <div class="number"><?php echo $total->totalp ?></div>
                                    </div>
                                    </div>
                            </div>
                        <?php } ?>

                            <?php
                                    $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'FINISH'");

                                foreach ($totalp->result() as $total) {
                                ?>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-light-green hover-expand-effect">
                                    <div class="icon">
                                        <a href="<?php echo base_url('helpdesk/finish') ?>">
                                            <i class="material-icons">done_all</i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="text">FINISH</div>
                                        <div class="number"><?php echo $total->totalp ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
            </div>

        </div>
    </section>

