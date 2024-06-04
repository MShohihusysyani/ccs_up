<section class="content">
    <div class="container-fluid">
        <div class="block-header">


        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet"
            href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Edit Tiket</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('klien/fungsi_edit_pelaporan') ?>
                    <form enctype="multipart/form-data">
                        <?php foreach ($tiket_temp as $tmp) : ?>
                        <input type="hidden" id="id_temp" name="id_temp" class="form-control"
                            value="<?= $tmp['id_temp']; ?>">

                        <label for="nama_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="no_tiket" name="no_tiket" class="form-control"
                                    value="<?= $tmp['no_tiket']; ?>" readonly>
                            </div>
                        </div>

                        <label for="judul">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="judul" name="judul" class="form-control"
                                    value="<?= $tmp['judul']; ?>">
                            </div>
                        </div>

                        <label for="perihal">Perihal </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="perihal" name="perihal" class="form-control"
                                    value="<?= $tmp['perihal']; ?>">
                            </div>
                        </div>


                        <!-- <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                        <div class="form-group">
                            <div class="form-line">
                                <img src="<?= base_url('assets/files/') . $tmp['file']; ?>" width="500"
                                    height="500" class="img-thumbnail">
                                <div class="form-group">
                                    <label for="exampleInputFile"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file"
                                                name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                        <div class="form-group">
                            <div class="form-line">
                                <img src="<?= base_url('assets/files/') . $tmp['file']; ?>" width="500"
                                    height="500" class="img-thumbnail">
                                <div class="form-group">
                                    <label for="exampleInputFile"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file"
                                                name="file">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <label for="kategori">Category</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#modalPilihKategori"
                                    name="kategori" id="kategori" placeholder=""
                                    class="form-control ui-autocomplete-input" value="<?= $tmp['kategori'];?>" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>

                        <label for="tags">Tags</label>
                            <div class="form-group demo-tagsinput-area">
                                <div class="form-line">
                                    <input type="text" class="form-control" data-role="tagsinput" value="<?= $tmp['tags'];?>" id="tags" name="tags">
                                </div>
                            </div>


                        <a href="<?= base_url('klien/pengajuan') ?>" type="button"
                            class="btn btn-primary m-t-15 waves-effect">Kembali</a>
                            
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">EDIT</button>
                        <?php endforeach; ?>
                    </form>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    
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