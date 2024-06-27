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

                                <div class="row clearfix">

                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="info-box bg-blue hover-expand-effect">
                                            <div class="icon">
                                                <a>
                                                    <i class="material-icons">playlist_add_check</i>
                                                </a>
                                            </div>
                                            <div class="content">
                                                <div class="text">Active Progress</div>
                                                <div class="number count-to" data-from="0" data-to="<?= $handle_count ?>" data-speed="1000" data-fresh-interval="20"><?= $handle_count ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'HANDLE'");

                                    foreach ($totalp->result() as $total) {
                                    ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-cyan hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('superadmin/onprogress') ?>">
                                                        <i class="material-icons">assignment_turned_in</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">HANDLE</div>
                                                    <!-- <div class="number"><?php echo $total->totalp ?></div> -->
                                                    <div class="number count-to" data-from="0" data-to="<?php echo $total->totalp ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total->totalp ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'CLOSE'");

                                    foreach ($totalp->result() as $total) {
                                    ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-orange hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('superadmin/close') ?>">
                                                        <i class="material-icons">report</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">CLOSE</div>
                                                    <!-- <div class="number"><?php echo $total->totalp ?></div> -->
                                                    <div class="number count-to" data-from="0" data-to="<?php echo $total->totalp ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total->totalp ?></div>
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
                                                    <a href="<?php echo base_url('superadmin/finish') ?>">
                                                        <i class="material-icons">done_all</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">FINISH</div>
                                                    <!-- <div class="number"><?php echo $total->totalp ?></div> -->
                                                    <div class="number count-to" data-from="0" data-to="<?php echo $total->totalp ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total->totalp ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    $totalp = $this->db->query("SELECT count(no_tiket) as totalt FROM pelaporan");

                                    foreach ($totalp->result() as $total) {
                                    ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-cyan hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('superadmin/allticket') ?>">
                                                        <i class="material-icons">confirmation_number</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">ALL TICKETS</div>
                                                    <!-- <div class="number"><?php echo $total->totalp ?></div> -->
                                                    <div class="number count-to" data-from="0" data-to="<?php echo $total->totalt ?>" data-speed="1000" data-fresh-interval="20"><?php echo $total->totalp ?></div>
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
                    <!-- DIAGRAM  -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="card">
                            <div class="header">
                                <h2>Priority</h2>
                                <ul class="header-dropdown m-r--5">
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <canvas id="bar_chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--END DIAGRAM -->



                </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        const ctx = document.getElementById('bar_chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    label: '#Priority',
                    data: [<?= total_high() ?>, <?= total_medium() ?>, <?= total_low() ?>],
                    // backgroundColor: ['rgba(233, 30, 99, 0.8)', '#FFC107', 'rgba(0, 188, 212, 0.8)'],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(255, 205, 86)', 'rgb(54, 162, 235)', ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>