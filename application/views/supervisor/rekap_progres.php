<section class="content">
    <div class="container-fluid">
        <div class="block-header">

        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        FILTER
                    </h2>

                </div>
                <div class="body">

                    <div class="row clearfix">
                        <?= form_open('supervisor/dateprogres'); ?>
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

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="status_ccs" name="status_ccs" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="FINISH">FINISH </option>
                                            <!-- <option value="CLOSE">CLOSE </option> -->
                                            <option value="HANDLE">HANDLE </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-info" name="tampilkan"
                                    value="proses"><i class="material-icons">search</i> <span class="icon-name"></span></button>
                            </div>
                            <br>
                            <?= form_close(); ?>
                            
                            <?= form_open('supervisor/rekapProgres'); ?>
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-success" name="tampilkan"
                                    value="proses">Semua
                                    Data</button>
                            </div>
                            <?= form_close(); ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-exportable dataTable"
                            id="example">
                            <thead>
                                <tr>
                                            <th>No</th>
                                            <!-- <th>Tanggal</th> -->
                                            <th>Progress</th>
                                            <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pencarian_data as $pd) : ?>
                                <tr>
                                            <td><?= $no++?></td>
                                            <!-- <td><?= tanggal_indo($pd['waktu_approve']) ?></td> -->
                                            <td><?= $pd['status_ccs'];?></td>
                                            <td><?= $pd['totalP'];?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>




