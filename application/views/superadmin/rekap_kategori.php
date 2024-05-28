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
                        <?= form_open('superadmin/dateKategori'); ?>
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

                            <!-- <label for="kategori">Category</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" data-toggle="modal" data-target="#modalPilihKategori"
                                    name="kategori" id="kategori" placeholder=""
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                    <input type="hidden" id="id" name="id">
                                </div>
                            </div> -->

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#modalPilihKategori"
                                            name="kategori" id="kategori" placeholder="Pilih Kategori"
                                            class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-info" name="tampilkan"
                                    value="proses"><i class="material-icons">search</i> <span class="icon-name"></span></button>
                            </div>
                            <br>
                            <?= form_close(); ?>
                            
                            <?= form_open('superadmin/rekapKategori'); ?>
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
                            <table class="table table-bordered table-striped table-hover js-exportable dataTable"
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

<!-- modal cari kategori -->
<div class="modal fade" id="modalPilihKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Kategori</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($category as $cat): ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cat['nama_kategori']; ?></td>
                                <td class="hide"><?= $cat['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilihKategori"
                                        data-nama-kategori="<?= $cat['nama_kategori']; ?>"
                                        data-id-kategori="<?= $cat['id']; ?>">
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
    $(document).ready(function () {
        $(document).on('click', '#pilihKategori', function () {
            var nama_klas = $(this).data('nama-kategori');
            var id = $(this).data('id-kategori');
            $('#kategori').val(nama_klas);
            $('#id').val(id);
            $('#modalPilihKategori').modal('hide');
        })
    });
</script>




