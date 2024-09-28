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

                            <?php
                            $file = $tmp['file'] ?? null;
                            $file_path = $file ? base_url('assets/files/') . $file : null;
                            $file_extension = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : null;
                            $image_extensions = ['jpeg', 'jpg', 'png'];
                            ?>

                            <label for="nama">File</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php if ($file): ?>
                                        <?php if (in_array($file_extension, $image_extensions)): ?>
                                            <!-- Display the image if it's a jpeg or png -->
                                            <img src="<?= $file_path; ?>" width="500" height="500" class="img-thumbnail">
                                        <?php else: ?>
                                            <!-- Provide a download link if it's not an image -->
                                            <a href="<?= $file_path; ?>" download>Download File (<?= strtoupper($file_extension); ?>)</a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <!-- Display message if no file is attached -->
                                        <p><strong>Tidak ada file yang dilampirkan.</strong></p>
                                    <?php endif; ?>

                                    <div class="form-group mt-3">
                                        <label for="exampleInputFile">Upload New File</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file" name="file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <a href="<?= base_url('klien/pengajuan') ?>" type="button" class="btn btn-primary m-t-15 waves-effect">kembali</a>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>