<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>"></div>
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>
        <div class="eror" data-eror="<?= $this->session->flashdata('alert') ?>"></div>
        <?php if ($this->session->flashdata('pesan')) { ?>

        <?php } ?>
        <p><?= validation_errors(); ?></p>
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

                        <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal"> <i class="material-icons">add</i> <span class="icon-name"></i>Add Client</button>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Klien</th>
                                        <th>Nama Klien</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <th>No</th>
                                    <th>Kode Klien</th>
                                    <th>Nama Klien</th>
                                    <th>Aksi</th>
                                </tfoot>
                                <tbody>

                                    <?php
                                    $no = 1;
                                    foreach ($klien as $cln) : ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?= $cln['no_klien']; ?></td>
                                            <td><?= $cln['nama_klien']; ?></td>

                                            <td>
                                                <div class="btn btn-sm btn-warning">
                                                    <div class="demo-google-material-icon" data-toggle="modal" data-target="#editModal<?= $cln['id']; ?>"> <i class="material-icons">edit</i> <span class="icon-name"></span>
                                                    </div>
                                                </div>
                                                <a class="btn btn-sm btn-danger waves-effect tombol-hapus" data-type="success" href="<?= base_url() ?>superadmin/hapus_klien/<?= $cln['id']; ?>"><i class="material-icons">delete</i><span class="fa fa-trash"></span>
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
                    <?= form_open_multipart('superadmin/edit_klien') ?>
                    <input type="hidden" name="id" value="<?= $cln['id']; ?>">
                    <div class="body">
                        <form class="form-horizontal">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input value="<?= $cln['no_klien']; ?>" type="text" id="no_klien" name="no_klien" class="form-control">
                                    <label class="form-label">No Urut</label>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" value="<?= $cln['nama_klien']; ?>" id="nama_klien" name="nama_klien" class="form-control">
                                    <label class="form-label">Nama Klien</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select id="nama_user_klien" name="nama_user_klien" class="form-control show-tick" required>
                                        <option value=""><?= $cln['nama_klien'] ?></option>
                                        <?php foreach ($user as $data) :
                                        ?>
                                            <option value="<?= $data['id_user'] ?>" <?= ($data['nama_user'] === $cln['nama_klien']) ? 'selected' : '' ?>><?= $data['nama_user'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="form-label">Pilih User</label>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-link waves-effect">SAVE
                                    CHANGES</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                <?php echo form_close() ?>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<!-- MODAL ADD -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Data</h4>
            </div>
            <div class="modal-body">

                <div class="body">
                    <?php echo form_open_multipart('superadmin/tambah_client') ?>
                    <form>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= noUrutClient(); ?>" type="text" id="no_klien" name="no_klien" class="form-control">
                                <label class="form-label">No Klien</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <select id="nama_user_klien" name="nama_user_klien" class="form-control show-tick" required>
                                    <option value="">-- Please select User--</option>
                                    <?php foreach ($user as $data) :
                                    ?>
                                        <option value="<?= $data['id_user'] ?>"><?= $data['nama_user'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="nama_klien" name="nama_klien" class="form-control">
                                <label class="form-label">Nama Klien</label>
                            </div>
                        </div>

                </div>

                <div class="modal-footer js-sweetalert">
                    <button type="submit" id="tombol-tambah" class="btn btn-primary waves-effect" data-type="success">SAVE
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