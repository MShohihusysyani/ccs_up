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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="header">
                    <h2>
                        Comment</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('klien/fungsi_edit_pelaporan') ?>
                    <form enctype="multipart/form-data">
                        <?php foreach ($datapelaporan as $dp) : ?>
                        <input type="hidden" id="id_pelaporan" name="id_pelaporan" class="form-control"
                            value="<?= $dp['id_pelaporan']; ?>">

                        <label for="nama_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="no_tiket" name="no_tiket" class="form-control"
                                    value="<?= $dp['no_tiket']; ?>" readonly>
                            </div>
                        </div>

                        <label for="waktu_pelaporan">Tanggal </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control"
                                    value="<?= $dp['waktu_pelaporan']; ?>" readonly>
                            </div>
                        </div>

                        <label for="nama">Nama </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="<?= $dp['nama']; ?>" readonly>
                            </div>
                        </div>
                        <label for="perihal">Perihal </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="perihal" name="perihal" class="form-control"
                                    value="<?= $dp['perihal']; ?>" readonly>
                            </div>
                        </div>
                        
                        <label for="status">Status </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="status" name="status" class="form-control"
                                    value="<?= $dp['status']; ?>" readonly>
                            </div>
                        </div>

                        <label for="status_ccs ">Status CCS </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="status_ccs" name="status_ccs" class="form-control"
                                    value="<?= $dp['status_ccs']; ?>" readonly>
                            </div>
                        </div>

                        <!-- <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                        <div class="form-group">
                            <div class="form-line">
                                <img src="<?= base_url('assets/files/') . $dp['file']; ?>" width="500"
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
                                <img src="<?= base_url('assets/files/') . $dp['file']; ?>" width="500"
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

                        <!-- <div class="form-group">
                            <div class="form-line">
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="<?= $dp['kategori']; ?> "><?= $dp['kategori']; ?></option>
                                    <?php
                                    foreach ($category as $cat): ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                    <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->
                        
                        <a href="<?= base_url('helpdesk/forward') ?>" type="button"
                            class="btn btn-primary m-t-15 waves-effect">Kembali</a>
                            
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">EDIT</button>
                        <?php endforeach; ?>
                    </form>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <!-- comment -->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="header">
                    <h2>
                        Input Komentar</h2>
                </div>
                <div class="body">
                    <textarea id="editor" class="form-control" name="body" id="body">
                                
                    </textarea>
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user['id_user']; ?>">
                    <input type="hidden" name="nama" id="nama" value="<?= $user['nama_user']?>">
                    
                   <button type="submit" class="btn btn-primary m-t-15 waves-effect">Input</button>
                 
                </div>
            </div>
        </div>

        <!-- end comment -->
    </div>
</section>



<script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

