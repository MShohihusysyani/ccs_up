
    <!-- Button trigger modal -->
    <section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- Basic Examples -->
        
        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Ticket
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
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Attachment</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                            <th>No</th>
                                            <th>No Tiket</th>
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Attachment</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                <?php
                                        $no = 1;
                                        foreach ($datapelaporan as $dp) : ?>
                                        <tr>
                                            <td><?= $no++?></td>
                                            <td><?= $dp['no_tiket'];?></td>
                                            <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                            <td><?= $dp['nama'];?></td>
                                            <td><?= $dp['perihal'];?></td>
                                            <td> <a
                                                href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                            </td>
                                            <td><?= $dp['kategori'];?></td>
                                            <td>
                                                <span class="label label-info">
                                                    <?= $dp['tags'];?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($dp['priority'] == 'Low') : ?>
                                                    <span class="label label-info">Low</span>

                                                <?php elseif ($dp['priority'] == 'Medium') : ?>
                                                    <span class="label label-warning">Medium</span>

                                                <?php elseif ($dp['priority'] == 'High') : ?>
                                                    <span class="label label-danger">High</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($dp['maxday'] == '90') : ?>
                                                    <span class="label label-info">90</span>

                                                <?php elseif ($dp['maxday'] == '60') : ?>
                                                    <span class="label label-warning">60</span>

                                                <?php elseif ($dp['maxday'] == '7') : ?>
                                                    <span class="label label-danger">7</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($dp['status_ccs'] == 'FINISH') : ?>
                                                    <span class="label label-success">FINISH</span>

                                                <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                    <span class="label label-warning">CLOSE</span>

                                                <?php elseif ($dp['status_ccs'] == 'HANDLE') : ?>
                                                    <span class="label label-info">HANDLE</span>

                                                <?php elseif ($dp['status_ccs'] == 'HANDLE 2') : ?>
                                                    <span class="label label-info">HANDLE 2</span>

                                                <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>
                                                
                                                <?php elseif ($dp['status_ccs'] == 'ADDED 2') : ?>
                                                    <span class="label label-primary">ADDED 2</span>   

                                                <?php else : ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                            <td><?= $dp['handle_by'];?> , <?= $dp['handle_by2'];?></td>
<!--                                            
                                            <td>
                                            <div class="btn btn-sm btn-warning">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModal<?= $dp['id']; ?>"><i
                                                        class="material-icons">edit</i> <span
                                                        class="icon-name">Edit</span>
                                                </div>
                                            </div>
                                            
                                            <br>
                                            <br>
                                            
                                            <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                <a class="btn btn-sm btn-info tombol-usulkan"
                                                    href="<?= base_url() ?>supervisor/forwardtoHD/<?= $dp['id']; ?>"><i
                                                        class="material-icons">forward</i> <span
                                                        class="icon-name"></span>
                                                    Forward 1</a>
                                                    <br>
                                                    <br>

                                                <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                <a class="btn btn-sm btn-info tombol-usulkan"
                                                    href="<?= base_url() ?>supervisor/forwardtoHD2/<?= $dp['id']; ?>"><i
                                                        class="material-icons">forward</i> <span
                                                        class="icon-name"></span>
                                                    Forward 2</a>
                                                    <br>
                                                    <br>
                                                    <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                <a class="btn btn-sm btn-info tombol-usulkan"
                                                    href="<?= base_url() ?>supervisor/forwardtoHD3/<?= $dp['id']; ?>"><i
                                                        class="material-icons">forward</i> <span
                                                        class="icon-name"></span>
                                                    Forward 3</a>

                                                    <br>
                                                    <br>
                                                    <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                <a class="btn btn-sm btn-info tombol-usulkan"
                                                    href="<?= base_url() ?>supervisor/forwardtoHD4/<?= $dp['id']; ?>"><i
                                                        class="material-icons">forward</i> <span
                                                        class="icon-name"></span>
                                                    Forward 4</a>
                        
                                            </td> -->
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

        
<!-- MODAL EDIT -->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModal<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Priority and Category</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/edit_pelaporan') ?>
                    <input type="hidden" name="id_pelaporan" value="<?= $dp['id_pelaporan']; ?>">
                    <div class="body">
                        <form class="form-horizontal">
                        
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['no_tiket']; ?>" type="text" id="no_tiket" name="no_tiket" class="form-control" readonly>
                                <label class="form-label">No tiket</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['waktu_pelaporan']; ?>" type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" readonly>
                                <label class="form-label">Waktu Pelaporan</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['nama']; ?>" type="text" id="nama" name="nama" class="form-control" readonly>
                                <label class="form-label">Nama Klien</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['perihal']; ?>" type="text" id="perihal" name="perihal" class="form-control" readonly>
                                <label class="form-label">Perihal</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['status']; ?>" type="text" id="status" name="status" class="form-control" readonly>
                                <label class="form-label">Status</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['status_ccs']; ?>" type="text" id="status_ccs" name="status_ccs" class="form-control" readonly>
                                <label class="form-label">Status CCS</label>
                            </div>
                        </div>

                       

                        <div class="form-group form-float">
                                <select id="priority" name="priority" class="form-control">
                                        <option value="">-- Please select Priority--</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                               </select> 
                        </div>

                        <!-- <div class="form-group form-float">
                        <select name="kategori" id="kategori" class="form-control">
                            
                                    <option value=""><?= $dp['kategori']; ?></option>
                                    <?php
                                    foreach ($category as $cat) : ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                        <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                        </div> -->
<!-- 
                        <div class="form-group form-float">
                                
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaKategori"
                                    name="kategori" id="kategori" placeholder="category"
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            
                        </div> -->

                        <!-- <label for="jenis_barang">Category</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaKategori"
                                    name="kategori" id="kategori" placeholder="Pilih Kategori" 
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div> -->

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaKategori" name="kategori" id="kategori" placeholder="" 
                                    class="form-control ui-autocomplete-input" value="" autocomplete="on" readonly>
                                <input type="hidden" id="id" name="id">
                                <label class="form-label">Category</label>
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
                                    <button class="btn btn-sm btn-info" id="pilih3" data-nama-kategori="<?= $cat['nama_kategori']; ?>" data-id-namakategori="<?= $cat['id']; ?>">
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
    $(document).ready(function() {
    $(document).on('click', '#pilih3', function() {
        var nama_klas = $(this).data('nama-kategori');
        var id = $(this).data('id-namakategori');
        $('#kategori').val(nama_klas);
        $('#id').val(id);
        $('#defaultModalNamaKategori').modal('hide');
    })
});
</script>