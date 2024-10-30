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
                                $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'ADDED 2'");

                                foreach ($totalp->result() as $total) {
                                ?>

                                    <div class="row clearfix">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-blue hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('supervisor2/added') ?>">
                                                        <i class="material-icons">playlist_add_check</i>
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
                                    $user_id =  $this->session->userdata('id_user');
                                    $handle = $this->db->query("SELECT 
                                        COUNT(*) as ticket_handle2
                                        FROM s_forward
                                        LEFT JOIN pelaporan ON s_forward.pelaporan_id = pelaporan.id_pelaporan
                                        WHERE s_forward.user_id = $user_id
                                        AND pelaporan.status_ccs = 'HANDLED 2' ")->result_array();
                                    foreach ($handle as $hd) : ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-cyan hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('supervisor2/onprogress') ?>">
                                                        <i class="material-icons">assignment_turned_in</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">CLOSED</div>
                                                    <div class="number count-to" data-from="0" data-to="<?= $hd['ticket_handle2'] ?>" data-speed="1000" data-fresh-interval="20"><?= $hd['ticket_handle2'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php
                                    $user_id =  $this->session->userdata('id_user');
                                    $handle = $this->db->query("SELECT 
                                        COUNT(*) as ticket_close
                                        FROM s_forward
                                        LEFT JOIN pelaporan ON s_forward.pelaporan_id = pelaporan.id_pelaporan
                                        WHERE s_forward.user_id = $user_id
                                        AND pelaporan.status_ccs = 'CLOSED' ")->result_array();
                                    foreach ($handle as $hd) : ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-orange hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('supervisor2/close') ?>">
                                                        <i class="material-icons">report</i>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <div class="text">CLOSE</div>
                                                    <div class="number count-to" data-from="0" data-to="<?= $hd['ticket_close'] ?>" data-speed="1000" data-fresh-interval="20"><?= $hd['ticket_close'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>


                                    <?php
                                    $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'FINISHED'");

                                    foreach ($totalp->result() as $total) {
                                    ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="info-box bg-light-green hover-expand-effect">
                                                <div class="icon">
                                                    <a href="<?php echo base_url('supervisor2/finish') ?>">
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
                    <!-- DIAGRAM  -->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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

                    <!-- TICKET -->
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        LIST TICKET
                                    </h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                                    <div class="list-group">
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-pink"><b><?= total_today() ?></b>
                                                <medium>TICKETS</medium>
                                            </span> Today
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-cyan"><b><?= total_yesterday() ?></b>
                                                <medium>TICKETS</medium>
                                            </span>Yesterday
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-teal"><b><?= total_lastweek() ?></b>
                                                <medium>TICKETS</medium>
                                            </span>Last Week
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-orange"><?= total_lastmonth() ?> <medium>TICKETS</medium></span>Last Month
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-purple"><b><?= total_thismonth() ?></b>
                                                <medium>TICKETS</medium>
                                            </span>This Month
                                        </a>
                                        <a href="javascript:void(0);" class="list-group-item">
                                            <span class="badge bg-amber"><b><?= total_all() ?></b>
                                                <medium>TICKETS</medium>
                                            </span>All Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# TICKET -->

                    <!-- Jumlah BPR -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2>KLIEN INFO</h2>
                                <ul class="header-dropdown m-r--5">
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>

                                    </li>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Klien</th>
                                                <th>Total Pelaporan</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($data_bpr as $bp) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $bp['nama']; ?></td>
                                                    <td><?= $bp['jumlah']; ?></td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END KLIEN INFO -->
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