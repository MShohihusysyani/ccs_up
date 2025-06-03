<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <div class="eror" data-eror="<?= strip_tags($this->session->flashdata('alert')) ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <?= validation_errors(); ?>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Basic Examples -->
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
                <script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filterForm" aria-expanded="false" aria-controls="filterForm">
                                    <i class="material-icons">filter_alt</i><span>Filter</span>
                                </button>
                            </div>

                            <div class="body">
                                <div class="row clearfix collapse" id="filterForm">
                                    <form id="filterFormContent" class="row">
                                        <!-- Kolom pertama (6 grid) -->
                                        <div class="col-lg-6 col-md-6">

                                            <div class="form-group">
                                                <label for="bulan">Pilih Bulan</label>
                                                <div class="form-line">
                                                    <select id="bulan" name="bulan" class="form-control">
                                                        <option value="">-- Pilih Bulan --</option>
                                                        <option value="1">Januari</option>
                                                        <option value="2">Februari</option>
                                                        <option value="3">Maret</option>
                                                        <option value="4">April</option>
                                                        <option value="5">Mei</option>
                                                        <option value="6">Juni</option>
                                                        <option value="7">Juli</option>
                                                        <option value="8">Agustus</option>
                                                        <option value="9">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="nama_klien">Pilih Klien</label>
                                                <div class="form-line">
                                                    <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien" name="nama_klien" id="nama_klien" placeholder="Pilih Klien" class="form-control" autocomplete="off">
                                                    <input type="hidden" id="id" name="id">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kolom kedua (6 grid) -->
                                        <div class="col-lg-6 col-md-6">
                                            <label for="bulan">Pilih Tahun</label>
                                            <div class="form-line">
                                                <select id="tahun" name="tahun" class="form-control">
                                                    <option value="">-- Pilih Tahun --</option>
                                                    <?php for ($y = 2018; $y <= date('Y'); $y++): ?>
                                                        <option value="<?= $y ?>"><?= $y ?></option>
                                                    <?php endfor; ?>
                                                </select>
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
                                <h2>
                                    SLA
                                </h2>
                                <div class="progress mt-2" style="display: none;">
                                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                </div>
                                <br>
                                <div class="btn-group" role="group" style="margin-left: 20px;">
                                    <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">save</i> <span>Export</span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button id="exportPdfButton" class="btn btn-sm btn-white" style="width:100%;">Export PDF</button></li>
                                        <!-- <li><button id="exportExcelButton" class="btn btn-sm btn-white" style="width:100%;">Excel</button></li> -->
                                    </ul>
                                </div>

                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="display table-bordered" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Tiket</th>
                                                <th>Tanggal</th>
                                                <th>BPR/Klien</th>
                                                <th>Judul</th>
                                                <th>Category</th>
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
                                                <th>BPR/Klien</th>
                                                <th>Judul</th>
                                                <th>Category</th>
                                                <th>Priority</th>
                                                <th>Max Day</th>
                                                <th>Status</th>
                                                <th>Handle By</th>
                                            </tr>
                                        </tfoot>
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

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "<?php echo site_url('superadmin/get_sla') ?>",
                "type": "POST",
                data: function(d) {
                    d.bulan = $('#bulan').val();
                    d.tahun = $('#tahun').val();
                    d.nama_klien = $('#nama_klien').val();
                }
            },
            "order": [
                [2, 'desc'] // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }]
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



    });

    // Handle export buttons
    $('#exportPdfButton').on('click', function() {
        exportData('pdf', this);
    });

    $('#exportExcelButton').on('click', function() {
        exportData('excel', this);
    });

    function exportData(format, button) {
        var filters = new FormData();
        filters.append('bulan', $('#bulan').val());
        filters.append('tahun', $('#tahun').val());
        filters.append('nama_klien', $('#nama_klien').val());

        var actionUrl = format === 'pdf' ? '<?= base_url('export/sla_pdf'); ?>' :
            '<?= base_url('export/sla_excel'); ?>';

        var progressBar = $('#progressBar');
        var progressContainer = $('.progress');
        progressContainer.show();
        progressBar.css('width', '0%').text('0%');
        $(button).prop('disabled', true);

        let progress = 0;
        let interval = setInterval(() => {
            if (progress < 90) {
                progress += 10;
                progressBar.css('width', progress + '%').text(progress + '%');
            }
        }, 500);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', actionUrl, true);
        xhr.responseType = 'blob';

        xhr.onload = function() {
            clearInterval(interval);
            progressBar.css('width', '100%').text('100%');

            if (xhr.status === 200) {
                var disposition = xhr.getResponseHeader('Content-Disposition');
                var filename = "export." + format;
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var matches = /filename="([^"]*)"/.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1];
                }

                var blob = new Blob([xhr.response], {
                    type: xhr.getResponseHeader('Content-Type')
                });
                var blobUrl = window.URL.createObjectURL(blob);
                var link = document.createElement('a');
                link.href = blobUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(blobUrl);
            } else {
                alert("Gagal mendownload file. Silakan coba lagi.");
            }

            setTimeout(() => {
                progressContainer.hide();
                progressBar.css('width', '0%').text('0%');
                $(button).prop('disabled', false);
            }, 1000);
        };

        xhr.onerror = function() {
            clearInterval(interval);
            progressBar.css('width', '100%').text('Gagal');
            alert('Gagal mendownload file. Silakan coba lagi.');
            setTimeout(() => {
                progressContainer.hide();
                progressBar.css('width', '0%').text('0%');
                $(button).prop('disabled', false);
            }, 2000);
        };

        xhr.send(filters);



        // form.submit();
        // // Remove the form after a slight delay to ensure the submission goes through
        // setTimeout(function() {
        //     form.remove();
        // }, 100);
    }
</script>