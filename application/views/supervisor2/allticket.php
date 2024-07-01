<!-- Button trigger modal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

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
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example">
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
                                        <th>Status</th>
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
                                        <th>Status</th>
                                        <th>Handle By</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <!-- <?php
                                            $no = 1;
                                            foreach ($datapelaporan as $dp) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $dp['no_tiket']; ?></td>
                                            <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                            <td><?= $dp['nama']; ?></td>
                                            <td><?= $dp['perihal']; ?></td>
                                            <td> <a href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                            </td>
                                            <td><?= $dp['kategori']; ?></td>
                                            <td>
                                                <span class="label label-info">
                                                    <?= $dp['tags']; ?>
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

                                                <?php elseif ($dp['status_ccs'] == 'REJECT') : ?>
                                                    <span class="label label-danger">REJECT</span>

                                                <?php else : ?>
                                                <?php endif; ?>

                                            </td>
                                            <td>
                                                <?= $dp['handle_by']; ?>
                                                <?php if (!empty($dp['handle_by2'])) : ?>
                                                    , <?= $dp['handle_by2']; ?>
                                                <?php endif; ?>
                                                <?php if (!empty($dp['handle_by3'])) : ?>
                                                    , <?= $dp['handle_by3']; ?>
                                                <?php endif; ?>
                                            </td>
        
                                        </tr>
                                    <?php endforeach; ?> -->
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
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('supervisor2/ajax_list') ?>",
            "type": "POST"
        },
        "order": [
            [2, 'desc']
        ], // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending (dari yang terbaru)
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],
    });
</script>