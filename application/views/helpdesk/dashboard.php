<section class="content">
    <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-6">
                                <h4>SELAMAT DATANG DI CUSTOMER CARE SYSTEM</h4>
                            </div>
                            <div class="col-xs-12 col-sm-6 align-right">
                                <div class="switch panel-switch-btn">
                                    <!-- <span class="m-r-10 font-12">REAL TIME</span>
                                        <label>OFF<input type="checkbox" id="realtime" checked><span class="lever switch-col-cyan"></span>ON</label> -->

                                </div>
                            </div>

                        </div>
                        <hr>
                        <h5><b>DATA PELAPORAN</b></h5>
                        <br>
                        <?php
                            $totalp = $this->db->query("SELECT count(id_pelaporan) as totalp FROM pelaporan where status_ccs = 'HANDLE'");

                            foreach ($totalp->result() as $total) {
                            ?>

                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box bg-cyan hover-expand-effect">
                                    <div class="icon">
                                        <a href="<?php echo base_url('helpdesk/pelaporan') ?>">
                                            <i class="material-icons">playlist_add_check</i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <div class="text">HANDLE</div>
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
                                        <a href="<?php echo base_url('helpdesk/data_pelaporan') ?>">
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
        </div>

                </div>
            </div>
        </div>
    </div>
</section>