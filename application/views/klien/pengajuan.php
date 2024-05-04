<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>
            <!-- <?= $this->session->flashdata('message'); ?> -->
        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet"
            href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Input Pelaporan </h2>
                </div>
                <div class="body">
                    <form method="post" action="<?= base_url('klien/add_temp'); ?>" enctype="multipart/form-data">
                    <div class="form-group form-float">
                            <div class="form-line">
                                <input  type="text" id="no_tiket" name="no_tiket" class="form-control" value="<?= $noTiket; ?>" readonly>
                                <label class="form-label">No tiket</label>
                            </div>
                        </div>
<!--                         
                        <input type="hidden" name="category_id" id="category_id" placeholder="id category"
                            class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly> -->
                        <br>

                        
                            <textarea id="editor" class="form-control" name="perihal" id="perihal" rows="10">
                                
                            </textarea>
                
                            <!-- <textarea id="ckeditor" name="perihal" id="perihal" class="form-control" rows="10">
                                
                            </textarea> -->
                            <br>

                        <label for="nama">File</label>
                        <div class="form-group">
                            <label for="exampleInputFile"></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file" required>
                                    <label for="file" class="custom-file-label">Choose
                                        file</label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group form-float">
                        <select name="kategori" id="kategori" class="form-control">
                            
                                    <option value="">--Pilih Category--</option>
                                    <?php
                                    foreach ($category as $cat) : ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                        <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                        </div> -->

                        
                        <label for="jenis_barang">Category</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaKategori"
                                    name="kategori" id="kategori" placeholder=""
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>

                        <label for="tags">Tags</label>
                            <div class="form-group demo-tagsinput-area">
                                <div class="form-line">
                                    <input type="text" class="form-control" data-role="tagsinput" value="" id="tags" name="tags">
                                </div>
                            </div>
                    
                        <input type="hidden" name="user_id" id="user_id" value="<?= $user['id_user']; ?>">
                        <input type="hidden" name="nama" id="nama" value="<?= $user['nama_user']?>">
                        <!-- <input type="hidden" name="no_urut" id="no_urut" value="<?= $user['no_urut']?>"> -->
                        
                    
                        <div class="js-sweetalert">
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect"
                                data-type="with-custom-icon">Proses</button>
                        </div>
                    </form>
                </div>
            </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Data Pengajuan
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                                id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Perihal</th>
                                        <th>Attachment</th>
                                        <th>kategori</th>
                                        <th>Tags</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($tiket_temp as $tmp) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $tmp['no_tiket']; ?></td>
                                        <td><?= $tmp['perihal']; ?></td>
                                        <td> <a
                                                href="<?= base_url('assets/files/' . $tmp['file']); ?>"><?= $tmp['file']; ?></a>
                                        </td>
                                        <td><?= $tmp['kategori'];?></td>
                                        <td>
                                            <span class="label label-info" data-role="tagsinput"><?= $tmp['tags'];?></span>
                                        </td>
                                        <td>

                                            <a class="btn btn-sm btn-danger tombol-hapus"
                                                href="<?= base_url() ?>klien/fungsi_delete_temp/<?= $tmp['id_temp']; ?>"><span
                                                    class="fa fa-trash tombol-hapus"></span>
                                                Hapus</a>

                                        </td>

                                    </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <form method="post" action="<?= base_url('klien/fungsi_pengajuan') ?>">
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Ajukan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- #END# Data Pengajuan -->
        </div>


        

        
    </div>
    
</section>

    <!-- modal cari kategori -->
    <div class="modal fade" id="defaultModalNamaKategori" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cari Kategori</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                        width="100%">
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
                            <?php foreach ($category  as $cat) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cat['nama_kategori']; ?></td>
                                <td class="hide"><?= $cat['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3"
                                        data-nama-kategori="<?= $cat['nama_kategori']; ?>"
                                        data-id-namakategori="<?= $cat['id']; ?>">
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
<!-- ckeditor -->
<script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    $(document).on('click', '#pilih3', function() {
        var nama_klas = $(this).data('nama-kategori');
        var id = $(this).data('id');
        $('#kategori').val(nama_klas);
        $('#id_kategori').val(id);
        $('#defaultModalNamaKategori').modal('hide');
    })
});
</script>







