<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>FILTER</h2>
                </div>

                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
                <script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

                <div class="body">
                    <div class="row clearfix">
                        <form id="filterForm">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="filter_tanggal_awal">Dari Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="filter_tanggal_akhir">Sampai Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien"
                                            name="nama_klien" id="nama_klien" placeholder="Pilih BPR"
                                            class="form-control" value="" autocomplete="off">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="tags" id="tags" class="form-control" placeholder="Pilih Tags">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="status_ccs" name="status_ccs" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="FINISH">FINISH</option>
                                            <option value="CLOSE">CLOSE</option>
                                            <option value="HANDLE">HANDLE</option>
                                            <option value="ADDED">ADDED</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="submit" class="btn btn-primary btn-lg m-l-15 waves-effect">Filter</button><br><br>
                                <button type="button" id="semuaDataButton" class="btn btn-success btn-lg m-l-15 waves-effect">Semua Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h2>LIST PELAPORAN</h2>
                </div>
                <br>
                <div class="btn-group" role="group" style="margin-left: 20px;">
                    <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">save</i> <span>Export</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><button id="exportPdfButton" class="btn btn-sm btn-white" style="width:100%;">Export PDF</button></li>
                        <li><button id="exportExcelButton" class="btn btn-sm btn-white" style="width:100%;">Export Excel</button></li>
                    </ul>
                </div>

                <div class="body">
                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped table-hover" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu Pelaporan</th>
                                    <th>No Tiket</th>
                                    <th>Nama</th>
                                    <th>Perihal</th>
                                    <th>Tags</th>
                                    <th>Kategori</th>
                                    <th>Impact</th>
                                    <th>Priority</th>
                                    <th>Max Day</th>
                                    <th>Status CCS</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Cari Klien -->
<div class="modal fade" id="defaultModalNamaKlien" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Klien</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Klien</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($klien as $cln) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row"><?= $i; ?></td>
                                <td><?= $cln['nama_klien']; ?></td>
                                <td class="hide"><?= $cln['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3" data-nama-klien="<?= $cln['nama_klien']; ?>" data-id-namaklien="<?= $cln['id']; ?>">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#pilih3', function() {
            var nama_klas = $(this).data('nama-klien');
            var id = $(this).data('id');
            $('#nama_klien').val(nama_klas);
            $('#id').val(id);
            $('#defaultModalNamaKlien').modal('hide');
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('supervisor/fetch_data'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.tanggal_awal = $('#tanggal_awal').val();
                    data.tanggal_akhir = $('#tanggal_akhir').val();
                    data.nama_klien = $('#nama_klien').val();
                    data.tags = $('#tags').val();
                    data.status_ccs = $('#status_ccs').val();
                }
            },
            "order": [[1, 'desc']], // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending (dari yang terbaru)
            "columnDefs": [
            { 
            "targets": [ 0 ], 
            "orderable": false,
            },
        ],
            "columns": [
                { "data": "no" },
                { "data": "waktu_pelaporan" },
                { "data": "no_tiket" },
                { "data": "nama" },
                { "data": "perihal" },
                { "data": "tags" },
                { "data": "kategori" },
                { "data": "impact" },
                { "data": "priority" },
                { "data": "maxday" },
                { "data": "status_ccs" }
            ]
        });
        

        // Handle form submission for filtering
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw(); // Redraw the DataTable based on new filters
        });

        // Handle "Semua Data" button click
        $('#semuaDataButton').on('click', function() {
            $('#filterForm')[0].reset();
            table.ajax.reload(); // Reload DataTables to show all data
        });

        // Handle export buttons
        $('#exportPdfButton').on('click', function() {
            exportData('pdf');
        });

        $('#exportExcelButton').on('click', function() {
            exportData('excel');
        });

        function exportData(format) {
            var filters = {
                tanggal_awal: $('#tanggal_awal').val(),
                tanggal_akhir: $('#tanggal_akhir').val(),
                nama_klien: $('#nama_klien').val(),
                tags: $('#tags').val(),
                status_ccs: $('#status_ccs').val()
            };

            var actionUrl = format === 'pdf' ? '<?php echo base_url('export/rekap_pelaporan_pdf'); ?>' : '<?php echo base_url('export/rekap_pelaporan_excel'); ?>';
            
            var form = $('<form>', {
                action: actionUrl,
                method: 'POST',
                target: '_blank'
            }).appendTo('body');

            $.each(filters, function(key, value) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: value
                }));
            });

            form.submit();

            // Remove the form after a slight delay to ensure the submission goes through
            setTimeout(function() {
                form.remove();
            }, 100);
        }
    });
</script>



