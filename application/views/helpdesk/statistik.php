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
                    <h2>STATISTIK</h2>
                </div>

                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="header">
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-6">
                                        <h2>Statistik</h2>
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
                                $user_id =  $this->session->userdata('id_user');
                                $handle = $this->db->query("SELECT 
                                        COUNT(*) as ticket_finish
                                        FROM forward
                                        LEFT JOIN pelaporan ON forward.pelaporan_id = pelaporan.id_pelaporan
                                        WHERE forward.user_id = $user_id
                                        AND pelaporan.status_ccs IN ('HANDLE', 'HANDLE 2', 'ADDED 2')")->result_array();
                                foreach ($handle as $hd) : ?>
                                    <div class="row clearfix">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-blue hover-expand-effect">
                                                <div class="icon">
                                                    <i class="material-icons">playlist_add_check</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text">Active Progress</div>
                                                    <div class="number count-to" data-from="0" data-to="<?= $hd['ticket_finish'] ?>" data-speed="1000" data-fresh-interval="20">
                                                        <?= $hd['ticket_finish'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php
                                    $user_id =  $this->session->userdata('id_user');
                                    $handle = $this->db->query("SELECT 
                                        COUNT(*) as ticket_close
                                        FROM forward
                                        LEFT JOIN pelaporan ON forward.pelaporan_id = pelaporan.id_pelaporan
                                        WHERE forward.user_id = $user_id
                                        AND pelaporan.status_ccs = 'CLOSE' ")->result_array();
                                    foreach ($handle as $hd) : ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-orange hover-expand-effect">
                                                <div class="icon">
                                                    <i class="material-icons">report</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text">CLOSE</div>
                                                    <div class="number count-to" data-from="0" data-to="<?= $hd['ticket_close'] ?>" data-speed="1000" data-fresh-interval="20"><?= $hd['ticket_close'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php
                                    $user_id =  $this->session->userdata('id_user');
                                    $handle = $this->db->query("SELECT 
                                        COUNT(*) as ticket_finish
                                        FROM forward
                                        LEFT JOIN pelaporan ON forward.pelaporan_id = pelaporan.id_pelaporan
                                        WHERE forward.user_id = $user_id
                                        AND pelaporan.status_ccs = 'FINISH' ")->result_array();
                                    foreach ($handle as $hd) : ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-light-green hover-expand-effect">
                                                <div class="icon">
                                                    <i class="material-icons">done_all</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text">FINISH</div>
                                                    <div class="number count-to" data-from="0" data-to="<?= $hd['ticket_finish'] ?>" data-speed="1000" data-fresh-interval="20"><?= $hd['ticket_finish'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <!-- end -->

                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="row clearfix">

                    </div>



                </div>
    </section>