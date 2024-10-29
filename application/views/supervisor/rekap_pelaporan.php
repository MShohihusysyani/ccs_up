<style>
    .star-rating {
        display: inline-block;
    }

    .star {
        cursor: pointer;
        color: gray;
        font-size: 20px;
    }

    .star.selected {
        color: gold;
    }

    .star-rating .star.selected {
        font-size: 30px;
        /* Sesuaikan ukuran sesuai kebutuhan Anda */
        color: gold;
        /* Warna emas untuk bintang */
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <!-- <h2>FILTER</h2> -->
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filterForm" aria-expanded="false" aria-controls="filterForm">
                        <i class="material-icons">filter_alt</i><span>Filter</span>
                    </button>
                </div>

                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
                <script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

                <div class="body">
                    <div class="row clearfix collapse" id="filterForm">
                        <form id="filterFormContent" class="row">
                            <!-- Kolom pertama (6 grid) -->
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="filter_tanggal_awal">Dari Tanggal</label>
                                    <div class="form-line">
                                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nama_klien">Pilih Klien</label>
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien" name="nama_klien" id="nama_klien" placeholder="Pilih Klien" class="form-control" autocomplete="off">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status_ccs">Pilih Status</label>
                                    <div class="form-line">
                                        <select id="status_ccs" name="status_ccs" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="FINISHED">FINISHED</option>
                                            <option value="CLOSED">CLOSED</option>
                                            <option value="HANDLED">HANDLED</option>
                                            <option value="HANDLED 2">HANDLED 2</option>
                                            <option value="ADDED">ADDED</option>
                                            <option value="ADDED 2">ADDED 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom kedua (6 grid) -->
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="filter_tanggal_akhir">Sampai Tanggal</label>
                                    <div class="form-line">
                                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nama_user">Pilih Petugas</label>
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#defaultModalNamaUser" name="nama_user" id="nama_user" placeholder="Pilih Petugas" class="form-control" autocomplete="off">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="rating">Pilih Rating</label>
                                    <div class="form-line">
                                        <select id="rating" name="rating" class="form-control">
                                            <option value="">-- Pilih Rating --</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm waves-effect">
                                        <i class="material-icons">filter_alt</i><span>Filter</span>
                                    </button>

                                    <button type="button" id="resetFilterButton" class="btn btn-info btn-sm waves-effect">
                                        <i class="material-icons">restart_alt</i><span>Reset Filter</span>
                                    </button>

                                    <button type="button" id="semuaDataButton" class="btn btn-success btn-sm waves-effect">
                                        <i class="material-icons">sync</i><span>Semua Data</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h2>RINCIAN PELAPORAN</h2>
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
                                    <th>Tanggal</th>
                                    <th>No Tiket</th>
                                    <th>Nama</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <!-- <th>Tags</th> -->
                                    <th>Priority</th>
                                    <th>Max Day</th>
                                    <th>Status</th>
                                    <th>Handle By</th>
                                    <th>Rating</th>
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
                            <th>Kode Klien</th>
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
                                <td><?= $cln['no_klien']; ?></td>
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

<!-- Modal Cari Petugas -->
<div class="modal fade" id="defaultModalNamaUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Petugas</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($user as $usr) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row"><?= $i; ?></td>
                                <td><?= $usr['nama_user']; ?></td>
                                <td class="hide"><?= $usr['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih4" data-nama-user="<?= $usr['nama_user']; ?>" data-id-namauser="<?= $usr['id_user']; ?>">
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

<script type="text/javascript">
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
                data.nama_user = $('#nama_user').val();
                data.rating = $('#rating').val();
                data.tags = $('#tags').val();
                data.status_ccs = $('#status_ccs').val();
            }
        },
        "order": [
            [1, 'desc']
        ], // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending (dari yang terbaru)
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],
        "columns": [{
                "data": "no"
            },
            {
                "data": "waktu_pelaporan"
            },
            {
                "data": "no_tiket"
            },
            {
                "data": "nama"
            },
            {
                "data": "judul"
            },
            {
                "data": "kategori"
            },
            {
                "data": "priority"
            },
            {
                "data": "maxday"
            },
            {
                "data": "status_ccs"
            },
            {
                "data": "handle_combined"
            },
            {
                "data": "rating"
            },
        ]
    });


    // Handle form submission for filtering
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw(); // Redraw the DataTable based on new filters
    });
    // Handle "Reset Filter" button click
    $('#resetFilterButton').on('click', function() {
        $('#filterFormContent')[0].reset();
        table.draw(); // Redraw the DataTable to reflect reset filters
    });
    // Handle "Semua Data" button click
    $('#semuaDataButton').on('click', function() {
        $('#filterFormContent')[0].reset();
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
            nama_user: $('#nama_user').val(),
            rating: $('#rating').val(),
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
</script>
<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- pilih klien -->
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

<!-- pilih petugas -->
<script>
    $(document).ready(function() {
        $(document).on('click', '#pilih4', function() {
            var nama_klas = $(this).data('nama-user');
            var id = $(this).data('id');
            $('#nama_user').val(nama_klas);
            $('#id').val(id);
            $('#defaultModalNamaUser').modal('hide');
        });
    });
</script>

<!-- expandable -->
<script>
    $(document).ready(function() {
        $('#filterForm').collapse({
            toggle: false
        });
    });
</script>