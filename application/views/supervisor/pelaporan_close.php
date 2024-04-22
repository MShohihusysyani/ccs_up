<!-- Button trigger modal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- Basic Examples -->
        <?= $this->session->flashdata('message'); ?>
        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CLOSE
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
                                            <th>Perihal </th>
                                            <th>Attachment</th>
                                            <th>Category</th>
                                            <th>Priority</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
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
                                        <th>Priority</th>
                                        <th>Status CCS</th>
                                        <th>Handle By</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                <?php
                                        $no = 1;
                                        foreach ($datapelaporan as $dp) : ?>
                                        <tr>
                                            <td><?= $no++?></td>
                                            <!-- <td><a
                                                href="<?= base_url() ?>admin/ruangan_isi/<?= $rgn['id_ruangan']; ?>"><?= $rgn['kode_bangunan']; ?>.<?= $rgn['kode_ruangan']; ?>'</a>
                                            </td> -->
                                            <!-- <td> <a
                                                href="<?= base_url('supervisor/pilih_helpdesk/' . $dp['id']); ?>"><?= $dp['no_tiket']; ?></a>
                                            </td> -->
                                            <td><?= $dp['no_tiket'];?></td>
                                            <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                            <td><?= $dp['nama'];?></td>
                                            <td><?= $dp['perihal'];?></td>
                                            <td> <a
                                                href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                            </td>
                                            <td><?= $dp['kategori'];?></td>
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
                                                <?php if ($dp['status_ccs'] == 'FINISH') : ?>
                                                    <span class="label label-success">FINISH</span>

                                                <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                    <span class="label label-warning">CLOSE</span>

                                                <?php elseif ($dp['status_ccs'] == 'HANDLE') : ?>
                                                    <span class="label label-info">HANDLE</span>

                                                <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                            <td><?= $dp['handle_by'];?></td>
                                            <td><?= $dp['status'];?></td>
                                            <td><?= $dp['keterangan'];?></td>
                                            <td>
                                            <div class="btn btn-sm btn-info">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModal<?= $dp['id_pelaporan']; ?>"> <i
                                                        class="material-icons">launch</i> <span
                                                        class="icon-name">Approve</span>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="btn btn-sm btn-danger">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModalReject<?= $dp['id_pelaporan']; ?>"> <i
                                                        class="material-icons">cancel</i> <span
                                                        class="icon-name">Reject 1</span>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="btn btn-sm btn-danger">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModalReject2<?= $dp['id_pelaporan']; ?>"> <i
                                                        class="material-icons">close</i> <span
                                                        class="icon-name">Reject 2</span>
                                                </div>
                                            </div>

                                            <br>
                                            <br>
                                            <div class="btn btn-sm btn-danger">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModalReject3<?= $dp['id_pelaporan']; ?>"> <i
                                                        class="material-icons">cancel</i> <span
                                                        class="icon-name">Reject 3</span>
                                                </div>
                                            </div>

                                            <br>
                                            <br>
                                            <div class="btn btn-sm btn-danger">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#editModalReject4<?= $dp['id_pelaporan']; ?>"> <i
                                                        class="material-icons">close</i> <span
                                                        class="icon-name">Reject 4</span>
                                                </div>
                                            </div>
                                            
                                            
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

        
<!-- MODAL APPROVE -->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModal<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Approve</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/approve') ?>
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

    <!-- MODAL REJECT HD1-->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModalReject<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Approve</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/reject') ?>
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
                            <div class="form-line">
                                <input value="<?= $dp['keterangan']; ?>" type="text" id="keterangan" name="keterangan" class="form-control">
                                <label class="form-label">Alasan Reject</label>
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

    <!-- MODAL REJECT HD2-->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModalReject2<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Approve</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/reject2') ?>
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
                            <div class="form-line">
                                <input value="<?= $dp['keterangan']; ?>" type="text" id="keterangan" name="keterangan" class="form-control">
                                <label class="form-label">Alasan Reject</label>
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

    <!-- MODAL REJECT HD3-->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModalReject3<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Approve</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/reject3') ?>
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
                            <div class="form-line">
                                <input value="<?= $dp['keterangan']; ?>" type="text" id="keterangan" name="keterangan" class="form-control">
                                <label class="form-label">Alasan Reject</label>
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

     <!-- MODAL REJECT HD4-->
     <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="editModalReject4<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Approve</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('supervisor/reject4') ?>
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
                            <div class="form-line">
                                <input value="<?= $dp['keterangan']; ?>" type="text" id="keterangan" name="keterangan" class="form-control">
                                <label class="form-label">Alasan Reject</label>
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



