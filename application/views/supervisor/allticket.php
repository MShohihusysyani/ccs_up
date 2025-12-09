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

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>BRP/Klien</th>
                                        <th>Judul</th>
                                        <th>Category</th>
                                        <th>Tags</th>
                                        <th>Priority</th>
                                        <th>Max Day</th>
                                        <th>Status</th>
                                        <th>Handle By</th>
                                    </tr>
                                </thead>
                                <tbody>

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
            "url": "<?php echo site_url('supervisor/ajax_list') ?>",
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