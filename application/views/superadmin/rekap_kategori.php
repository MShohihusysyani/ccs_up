<section class="content">
    <div class="container-fluid">
        <div class="block-header">

        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- <div class="card">
                <div class="header">
                    <h2>
                        FILTER
                    </h2>

                </div>
                <div class="body">

                    <div class="row clearfix">
                        <?= form_open('supervisor/dateKategori'); ?>
                        <form method="POST" id="cari" action="">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="dari_tgl">Dari Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="tgla" id="tgla" class="form-control">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="sampai_tgl">Sampai Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="tglb" id="tglb" class="form-control">

                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-info" name="tampilkan"
                                    value="proses"><i class="material-icons">search</i> <span class="icon-name"></span></button>
                            </div>
                            <br>
                            <?= form_close(); ?>
                            
                            <?= form_open('supervisor/rekapKategori'); ?>
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-success" name="tampilkan"
                                    value="proses">Semua
                                    Data</button>
                            </div>
                            <?= form_close(); ?>
                        </form>
                    </div>
                </div>
            </div> -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Rekap Kategori
                        </h2>
                        <br>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">save</i> <span>Export</span> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url('export/rekap_kategori'); ?>">Export PDF</a></li>
                                    <li><a href="<?= base_url('export/rekap_kategori_excel')?>">Export Excel</a></li>
                                </ul>
                            </div>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                                id="example">
                                <thead>
                                    <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Total</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Total</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach ($pencarian_data as $pd) : ?>
                                        <tr>
                                            <td><?= $no++?></td>
                                            <td><?= $pd['kategori'];?></td>
                                            <td><?= $pd['total'];?></td>
                                        
                                        </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- #END# Exportable Table -->
    </div>

</section>




