<section class="content">
    <div class="container-fluid">
        <div class="block-header">


        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet"
            href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="header">
                    <h2>
                        Comment</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('klien/add_comment') ?>
                    <form>
                        <?php foreach ($datapelaporan as $dp) : ?>
                        <input type="hidden" id="id_pelaporan" name="id_pelaporan" class="form-control" value="<?= $dp['id_pelaporan']; ?>">
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

                        <label for="status_ccs ">Status CCS </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="status_ccs" name="status_ccs" class="form-control"
                                    value="<?= $dp['status_ccs']; ?>" readonly>
                            </div>
                        </div>

                        <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                        <div class="form-group">
                            <div class="form-line">
                                <img src="<?= base_url('assets/files/') . $dp['file']; ?>" width="700"
                                    height="700" class="img-thumbnail">
                                <!-- <div class="form-group">
                                    <label for="exampleInputFile"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file"
                                                name="file">

                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <label for="comment">Comment</label>
                        <textarea id="editor" class="form-control" name="body" id="body">
                                
                        </textarea>
                        <input type="hidden" name="user_id" id="user_id" value="<?= $user['id_user']; ?>">
                        
                        <a href="<?= base_url('helpdesk/forward') ?>" type="button"
                            class="btn btn-primary m-t-15 waves-effect">Kembali</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">ADD</button>
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
                        Komentar</h2>
                </div>
                <?php if(empty($datacomment)) { } else { foreach($datacomment as $dc) { ?> 
                <div class="body">
                    <form>
                        <textarea  class="form-control" >
                            <?= $dc['nama_user'];?> <br>
                            <?= $dc['body'];?>
                        </textarea>
                        <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect">Input</button> -->
                        
                    </form>
                </div>
                <?php } } ?>
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
<script>
        ClassicEditor
            .create( document.querySelector( '#editor2' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
<!--<script>
    ClassicEditor
    .create( document.querySelector( '#editor' ), {
        simpleUpload: {
            // The URL that the images are uploaded to.
            
        }
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.error( err.stack );
    } );
</script> -->


