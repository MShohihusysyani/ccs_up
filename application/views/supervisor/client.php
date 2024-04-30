<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <?= $this->session->flashdata('message'); ?>
        </div>

        <!-- <?= $this->session->flashdata('message'); ?> -->
        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Data Client
                        </h2>
                        <br>
                        
                        <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal"
                            data-target="#defaultModal"> <i class="material-icons">add</i> <span
                                class="icon-name"></i>Add Client</button>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                                id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Urut</th>
                                        <th>Nama Klien</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                        <th>No</th>
                                        <th>No Urut</th>
                                        <th>Nama Klien</th>
                                        <th>Aksi</th>
                                </tfoot>
                                <tbody>

                                <?php
                                    $no = 1;
                                    foreach ($klien as $cln) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $cln['no_urut'];?></td>
                                        <td><?= $cln['nama_klien']; ?></td>

                                        <td>
                                            <div class="btn btn-sm btn-warning">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModal<?= $cln['id']; ?>"> <i
                                                        class="material-icons">edit</i> <span
                                                        class="icon-name"></span>
                                                </div>
                                            </div>
                                            <a class="btn btn-sm btn-danger waves-effect tombol-hapus"
                                                    data-type="success"
                                                    href="<?= base_url() ?>supervisor/hapus_klien/<?= $cln['id']; ?>"><i
                                                        class="material-icons">delete</i><span
                                                        class="fa fa-trash"></span>
                                                    </a>
                                        </td>

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
    <!-- Button trigger modal -->
</section>
    <!-- Button trigger modal -->
    <!-- MODAL  edit -->
    <?php
    $no = 0;
    foreach ($klien as $cln) : $no++; ?>
    <div class="modal fade" id="editModal<?= $cln['id']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit User</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/edit_klien') ?>
                    <input type="hidden" name="id" value="<?= $cln['id']; ?>">
                    <div class="body">
                        <form class="form-horizontal">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $cln['no_urut']; ?>" type="text" id="no_urut" name="no_urut" class="form-control">
                                <label class="form-label">No Urut</label>
                            </div>
                        </div>

                        
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" value="<?= $cln['nama_klien']; ?>" id="nama_klien" name="nama_klien" class="form-control">
                                <label class="form-label">Nama Klien</label>
                            </div>
                        </div>

    
                                
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-link waves-effect">SAVE
                                    CHANGES</button>
                                <button type="button" class="btn btn-link waves-effect"
                                    data-dismiss="modal">CLOSE</button>
                                <?php echo form_close() ?>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>

    <!-- MODAL ADD -->
    <!-- MODAL ADD -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Data</h4>
            </div>
            <div class="modal-body">

                <div class="body">
                    <?php echo form_open_multipart('supervisor/tambah_client') ?>
                    <form>

                        <!-- <div class="form-group form-float">
                            <div class="form-line">
                                <input type="date" id="tanggal" name="tanggal" class="form-control">
                                <label class="form-label"></label>
                            </div>
                        </div> -->

                        <!-- <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="divisi" name="divisi" class="form-control">
                                <label class="form-label">Divisi</label>
                            </div>
                        </div> -->

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= noUrutClient(); ?>"  type="text" id="no_urut" name="no_urut" class="form-control">
                                <label class="form-label">No Urut</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="nama_klien" name="nama_klien" class="form-control">
                                <label class="form-label">Nama Klien</label>
                            </div>
                        </div>

                        <!-- <label for="nama">Foto</label>
                        <div class="form-group">
                            <label for="exampleInputFile"></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto_nota" name="foto_nota"
                                        required>
                                    <label for="file" class="custom-file-label">Choose
                                        file</label>
                                </div>
                            </div>
                        </div> -->


                </div>

                <div class="modal-footer js-sweetalert">
                    <button type="submit" id="tombol-tambah" class="btn btn-primary waves-effect"
                        data-type="success">SAVE
                        CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    <?php echo form_close() ?>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>

    
<script>
$('#tombol-tambah').on('click', function(e) {

    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        icon: 'success',
        title: 'Added',
        text: 'Data added'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        }
    })

})
</script>