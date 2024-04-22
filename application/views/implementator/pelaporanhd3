  
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
                            Pelaporan
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
                                            <th>Waktu Pelaporan</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Status</th>
                                            <th>Status CCS</th>
                                            <th>Category</th>
                                            <th>Priority</th>
                                            <th>Attachment</th>
                                            <th>Keterangan</th>
                                            <th>Handle By</th>
                                            <th>Aksi</th>
                                    </tr>
                                </thead>
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
                                            <td><?= $dp['status'];?></td>
                                            <td><?= $dp['status_ccs'];?></td>
                                            <td><?= $dp['kategori'];?></td>
                                            <td><?= $dp['priority'];?></td>
                                            <td> <a
                                                href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                            </td>
                                            <td><?= $dp['keterangan'];?></td>
                                            <td><?= $dp['handle_by'];?></td>
                                            <td>
                                            <div class="btn btn-sm btn-info">
                                                <div class="demo-google-material-icon" data-toggle="modal"
                                                    data-target="#FinishModal<?= $dp['id']; ?>"> <i
                                                        class="material-icons">edit</i> <span
                                                        class="icon-name">finish</span>
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
            
            <!-- MODAL EDIT -->
    <?php
    $no = 0;
    foreach ($datapelaporan as $dp) : $no++; ?>
    <div class="modal fade" id="FinishModal<?= $dp['id']; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Finish CCS</h4>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('implementator/finish3') ?>
                    <input type="hidden" name="id" value="<?= $dp['id']; ?>">
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

                        <!-- <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['status_ccs']; ?>" type="text" id="status_ccs" name="status_ccs" class="form-control" readonly>
                                <label class="form-label">Status CCS</label>
                            </div>
                        </div> -->

                        
                        <div class="form-group form-float">
                                <select id="status_ccs" name="status_ccs" class="form-control show-tick" >
                                        <option value=""><?= $dp['status_ccs']; ?></option>
                                        <option value="HANDLE">Handle</option>
                                        <option value="CLOSE">Close</option>
                                        <option value="FINISH">Finish</option>
                               </select> 
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['handle_by']; ?>" type="text" id="handle_by" name="handle_by" class="form-control" >
                                <label class="form-label">Handle By</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input value="<?= $dp['keterangan']; ?>" type="text" id="keterangan" name="keterangan" class="form-control" >
                                <label class="form-label">Keterangan</label>
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
    


