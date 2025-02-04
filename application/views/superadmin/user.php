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
            <div class="eror" data-eror="<?= strip_tags($this->session->flashdata('alert')) ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <?= validation_errors(); ?>
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Data User
                                </h2>
                                <br>

                                <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal"> <i class="material-icons">add</i> <span class="icon-name"></i>Add User</button>

                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Divisi</th>
                                                <th>Nama</th>
                                                <!-- <th>ID User</th> -->
                                                <th>Active</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <th>No</th>
                                            <th>Divisi</th>
                                            <th>Nama</th>
                                            <!-- <th>ID User</th> -->
                                            <th>Active</th>
                                            <th>Aksi</th>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $no = 1;
                                            foreach ($user as $u) : ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?= $u['divisi']; ?></td>
                                                    <td><?= $u['nama_user']; ?></td>
                                                    <!-- <td><?= $u['id_user']; ?></td> -->
                                                    <td>
                                                        <?php if ($u['active'] == 'Y') : ?>
                                                            <span><i class="material-icons">verified</i></span>

                                                        <?php elseif ($u['active'] == 'N') : ?>
                                                            <span><i class="material-icons">close</i></span>

                                                        <?php else : ?>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td>
                                                        <div class="btn btn-sm btn-warning">
                                                            <div class="demo-google-material-icon" data-toggle="modal" data-target="#editModal<?= $u['id_user']; ?>"> <i class="material-icons">edit</i> <span class="icon-name"></span>
                                                            </div>
                                                        </div>

                                                        <a class="btn btn-sm btn-danger waves-effect tombol-hapus" data-type="success" href="<?= base_url() ?>superadmin/hapus_user/<?= $u['id_user']; ?>"><i class="material-icons">delete</i><span class="fa fa-trash"></span>
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

<!-- <script>
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
</script> -->

<!-- MODAL  EDIT -->
<?php
$no = 0;
foreach ($user as $u) : $no++; ?>
    <div class="modal fade" id="editModal<?= $u['id_user']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit User</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('superadmin/edit_user') ?>
                    <input type="hidden" name="id_user" value="<?= $u['id_user']; ?>">
                    <div class="body">
                        <form class="form-horizontal">
                            <div class="form-group form-float">
                                <select id="divisi" name="divisi" class="form-control show-tick">
                                    <option><?= $u['divisi']; ?></option>
                                    <option value="Klien">Klien</option>
                                    <option value="Helpdesk">Helpdesk</option>
                                    <option value="Supervisor 1">Supervisor 1</option>
                                    <option value="Implementator">Implementator</option>
                                    <option value="Support">Support</option>
                                    <option value="Superadmin">Superadmin</option>
                                    <option value="CRD">CRD</option>
                                    <option value="Development">Development</option>
                                    <option value="Supervisor 2">Supervisor 2</option>
                                </select>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input value="<?= $u['nama_user']; ?>" type="text" id="nama_user" name="nama_user" class="form-control">
                                    <label class="form-label">Nama</label>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input value="<?= $u['username']; ?>" type="text" id="username" name="username" class="form-control">
                                    <label class="form-label">Username</label>
                                </div>
                            </div>

                            <label for="password">Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <select id="role" name="role" class="form-control show-tick">
                                    <option><?= $u['role']; ?></option>
                                    <option value="1">1-Klien</option>
                                    <option value="2">2-Helpdesk</option>
                                    <option value="3">3-Supervisor</option>
                                    <option value="4">4-Implementator</option>
                                    <option value="5">5-Support</option>
                                    <option value="6">6-Superadmin</option>
                                    <option value="7">7-Crd</option>
                                    <option value="8">8-Development</option>
                                    <option value="9">9-Supervisor 2</option>
                                </select>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input value="<?= $u['active']; ?>" type="text" id="active" name="active" class="form-control" readonly>
                                    <label class="form-label">Active</label>
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
                    <?php echo form_open_multipart('superadmin/tambah_user') ?>
                    <form>

                        <div class="form-group form-float">
                            <select id="divisi" name="divisi" class="form-control show-tick">
                                <option value="">-- Please select Divisi--</option>
                                <option value="Superadmin">Superadmin</option>
                                <option value="Supervisor 1">Supervisor 1</option>
                                <option value="Supervisor 2">Supervisor 2</option>
                                <option value="Klien">Klien</option>
                                <option value="Helpdesk">Helpdesk</option>
                                <option value="Implementator">Implementator</option>
                                <option value="Support">Support</option>
                                <option value="CRD">CRD</option>
                                <option value="Development">Development</option>
                            </select>
                        </div>


                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="nama_user" name="nama_user" class="form-control">
                                <label class="form-label">Nama</label>
                            </div>
                        </div>

                        <!-- <div class="form-group form-float">
                        <select name="nama" id="nama" class="form-control">
                            
                                    <option value="">--Pilih BPR--</option>
                                    <?php
                                    foreach ($klien as $cln) : ?>
                                    <option value="<?php echo $cln['nama_klien']; ?>">
                                        <?php echo $cln['nama_klien']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                        </div> -->

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="username" name="username" class="form-control">
                                <label class="form-label">Username</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" id="password" name="password" class="form-control">
                                <label class="form-label">password</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <select id="role" name="role" class="form-control show-tick">
                                <option value="">-- Please select Role--</option>
                                <option value="6">6-Superadmin</option>
                                <option value="3">3-Supervisor 1</option>
                                <option value="9">9-Supervisor 2</option>
                                <option value="1">1-Klien</option>
                                <option value="2">2-Helpdesk</option>
                                <option value="4">4-Implementator</option>
                                <option value="5">5-Support</option>
                                <option value="7">7-Crd</option>
                                <option value="8">8-Development</option>
                            </select>
                        </div>

                        <label for="">Tanggal Register</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" class="form-control" id="tgl_register" name="tgl_register" placeholder="tanggal registrasi" />
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