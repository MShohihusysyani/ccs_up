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
                        <?= form_open('supervisor/datepelaporan'); ?>
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
                        
                            <!-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="nama_klien" id="nama_klien" class="form-control">
                                            <option value="">--Pilih BPR--</option>
                                                <?php
                                                foreach ($klien as $cln) : ?>
                                            <option value="<?php echo $cln['nama_klien']; ?>">
                                                <?php echo $cln['nama_klien']; ?>
                                            </option>
                                    <?php endforeach; ?>
                                </select>
                                    </div>
                                </div>
                            </div> -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien"
                                    name="nama_klien" id="nama_klien" placeholder="Pilih BPR" 
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                            </div>
                        </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="status_ccs" name="status_ccs" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="FINISH">FINISH </option>
                                            <option value="CLOSE">CLOSE </option>
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
                            
                            <?= form_open('supervisor/rekapPelaporan'); ?>
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
                    <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?= base_url('export/rekap_pelaporan'); ?>">Export PDF</a></li>
                            <li><a href="<?= base_url('export/rekap_pelaporann')?>">Export Excel</a></li>
                        </ul>
                    </div>
                    <br><br>
            
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-exportable dataTable"
                            id="example">
                            <thead>
                                <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No Tiket</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Status</th>
                                </tr>

                            </thead>
                            <tbody>

                                <?php
                                $no = 1;
                                foreach ($pencarian_data as $pd) : ?>
                                <tr>
                                            <td><?= $no++?></td>
                                            <td><?= tanggal_indo($pd['waktu_pelaporan']) ?></td>
                                            <td><?= $pd['no_tiket'];?></td>
                                            <td><?= $pd['nama'];?></td>
                                            <td><?= $pd['perihal'];?></td>
                                            <td>
                                                <?php if ($pd['status_ccs'] == 'FINISH') : ?>
                                                    <span class="label label-success">FINISH</span>

                                                <?php elseif ($pd['status_ccs'] == 'CLOSE') : ?>
                                                    <span class="label label-warning">CLOSE</span>

                                                <?php elseif ($pd['status_ccs'] == 'HANDLE') : ?>
                                                    <span class="label label-info">HANDLE</span>

                                                <?php elseif ($pd['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                            <!-- <td><?= $pd['handle_by'];?></td> -->

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

<!-- modal cari klien -->
<div class="modal fade" id="defaultModalNamaKlien" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cari Klien</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Klien</th>
                                <th class="hide">ID</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($klien  as $cln) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cln['nama_klien']; ?></td>
                                <td class="hide"><?= $cln['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3"
                                        data-nama-klien="<?= $cln['nama_klien']; ?>"
                                        data-id-namaklien="<?= $cln['id']; ?>">
                                        Pilih</button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    $(document).on('click', '#pilih3', function() {
        var nama_klas = $(this).data('nama-klien');
        var id = $(this).data('id');
        $('#nama_klien').val(nama_klas);
        $('#id').val(id);
        $('#defaultModalNamaKlien').modal('hide');
    })
});
</script>


