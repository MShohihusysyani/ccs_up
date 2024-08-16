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
        <!-- <link rel="stylesheet"  type="text/css" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->
        <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <!-- <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script> -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script> -->


        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Ticket
                        </h2>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                            Import Excel
                        </button>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="table_id" class="display table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>Nama Klien</th>
                                        <th>Perihal</th>
                                        <th>Impact</th>
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
                                        <th>Impact</th>
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
                                    <!-- <?php
                                            $no = 1;
                                            foreach ($datapelaporan as $dp) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $dp['no_tiket']; ?></td>
                                            <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                            <td><?= $dp['nama']; ?></td>
                                            <td><?= $dp['perihal']; ?></td>
                                            <td><?= $dp['impact']; ?></td>
                                            <td> <a
                                                href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                            </td>
                                            <td><?= $dp['kategori']; ?></td>
                                            <td>
                                                <span class="label label-info"><?= $dp['tags']; ?></span>
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
                                            <td><?= $dp['handle_by']; ?> , <?= $dp['handle_by2']; ?> , <?= $dp['handle_by3']; ?></td>
                                        
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
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<!-- Modal for File Upload -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('export/import_excel_to_t1_forward') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Choose Excel File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#table_id').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('superadmin/ajax_list') ?>",
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

<!-- <script>
$(document).ready(function() {
    $('#table_id').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('superadmin/ajax_list') ?>",
            "type": "POST"
        },
        "order": [[2, 'desc']],
        "columnDefs": [
            { 
                "targets": [0], 
                "orderable": false
            },
            { 
                "targets": [13], // Index of "Time Left" column
                "orderable": false,
                "render": function(data, type, row) {
                    let maxDay = parseInt(row[10]); // Assuming "Max Day" is at index 10
                    let reportDateStr = row[2]; // Assuming "Tanggal" is at index 2

                    console.log("Raw Max Day:", row[10]); // Debugging log for Max Day
                    console.log("Raw date string:", reportDateStr); // Debugging log for date

                    // Check if maxDay is a valid number
                    if (isNaN(maxDay)) {
                        console.error("Invalid Max Day: ", row[10]); // Debugging log
                        return 'Invalid max day';
                    }

                    // Parse the report date
                    let reportDate = new Date(reportDateStr);

                    // If the date parsing fails, log the error and return an error message
                    if (isNaN(reportDate)) {
                        console.error("Invalid date format: ", reportDateStr); // Debugging log
                        return 'Invalid date';
                    }

                    let currentDate = new Date();
                    let maxDate = new Date(reportDate);
                    maxDate.setDate(maxDate.getDate() + maxDay);

                    let timeDifference = maxDate - currentDate;
                    
                    if (timeDifference < 0) {
                        return '<span class="label label-danger">Expired</span>';
                    } else {
                        let days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                        let hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

                        return `${days}d ${hours}h ${minutes}m left`;
                    }
                }
            }
        ]
    });
});

</script> -->