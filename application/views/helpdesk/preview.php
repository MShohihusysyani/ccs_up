<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2> Preview</h2>
                </div>
                <div class="body">
                    <form>
                        <?php foreach ($tiket_temp as $tmp) : ?>
                            <label for="no_tiket">No Tiket</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_tiket" name="no_tiket" class="form-control" value="<?= $tmp['no_tiket']; ?>" readonly>
                                </div>
                            </div>

                            <label for="nama">Nama Klien</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $tmp['nama']; ?>" readonly>
                                </div>
                            </div>

                            <label for="judul">Judul</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="judul" name="judul" class="form-control" value="<?= $tmp['judul']; ?>" readonly>
                                </div>
                            </div>

                            <label for="perihal">Perihal</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <div id="perihal"><?= $tmp['perihal']; ?></div>
                                </div>
                            </div>

                            <label for="kategori">Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="kategori" name="kategori" class="form-control" value="<?= $tmp['kategori']; ?>" readonly>
                                </div>
                            </div>

                            <label for="tags">Tags</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="tags" id="tags" value="<?= $tmp['tags']; ?>" class="form-control ui-autocomplete-input" readonly>
                                </div>
                            </div>

                            <label for="nama">File</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <img src="<?= base_url('assets/files/') . $tmp['file']; ?>" width="500" height="500" class="img-thumbnail">
                                </div>
                            </div>

                            <a href="<?= base_url('helpdesk/pengajuan') ?>" type="button" class="btn btn-primary m-t-15 waves-effect">kembali</a>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>