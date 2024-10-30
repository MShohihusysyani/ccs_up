<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
        <!-- <link rel="stylesheet"  type="text/css" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

        <!-- Basic Examples -->
        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ON PROGRESS
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
                                        <th>Judul</th>
                                        <!-- <th>Perihal</th> -->
                                        <!-- <th>Attachment</th> -->
                                        <th>Category</th>
                                        <th>Priority</th>
                                        <!-- <th>Impact</th> -->
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Handle_by</th>
                                        <th>Subtask 1</th>
                                        <th>Status Subtask 1</th>
                                        <th>Subtask 2</th>
                                        <th>Status Subtask 2</th>
                                        <th>Tenggat waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>Nama Klien</th>
                                        <th>Judul</th>
                                        <!-- <th>Perihal</th> -->
                                        <!-- <th>Attachment</th> -->
                                        <th>Category</th>
                                        <th>Priority</th>
                                        <!-- <th>Impact</th> -->
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Handle By</th>
                                        <th>Subtask 1</th>
                                        <th>Status Subtask 1</th>
                                        <th>Subtask 2</th>
                                        <th>Status Subtask 2</th>
                                        <th>Tenggat waktu</th>
                                        <th>Aksi</th>
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


<!-- MODAL EDIT -->
<div class="modal fade" id="editModalCP" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Edit Teknisi</h4>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('supervisor2/fungsi_edit') ?>
                <input type="hidden" name="id_pelaporan" id="id_pelaporan">
                <div class="body">
                    <form class="form-horizontal">

                        <label for="no_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="no_tiket" name="no_tiket" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="waktu_pelaporan">Tanggal</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="nama">Nama Klien</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="nama" name="nama" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="nama">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="judul" name="judul" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="perihal">Perihal</label>
                            <div class="form-line">
                                <div id="perihal_coba" readonly></div>
                            </div>
                        </div>

                        <label for="status">Status</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="status" name="status" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="status_ccs">Status CCS</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="status_ccs" name="status_ccs" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="priority">Priority</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="priority" name="priority" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="maxday">Max Day</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="maxday" name="maxday" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="kategori">Kategori</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="kategori" name="kategori" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="form-line">
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="<?= $dp['kategori']; ?> "><?= $dp['kategori']; ?></option>
                                    <?php
                                    foreach ($category as $cat) : ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                    <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->


                        <div class="form-group">
                            <div class="form-line">
                                <select name="namateknisi" id="namateknisi" class="form-control">
                                    <option value=""> -- Pilih Teknisi -- </option>
                                    <?php
                                    foreach ($namateknisi as $nat) : ?>
                                        <option value="<?= $nat['id_user']; ?>"><?= $nat['nama_user']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- <label for="maxday">Subtask</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="subtask" name="subtask" class="form-control">
                            </div>
                        </div> -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SAVE
                                CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>

                        </div>

                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- TAMBAH TEKNISI -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Tambah Teknisi</h4>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('supervisor2/fungsi_tambah') ?>
                <input type="hidden" name="id_pelaporan" id="id_pelaporan">
                <div class="body">
                    <form class="form-horizontal">

                        <label for="no_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="no_tiket" name="no_tiket" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="waktu_pelaporan">Tanggal</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="nama">Nama Klien</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="nama" name="nama" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="nama">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="judul" name="judul" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="perihal">Perihal</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="perihal" name="perihal" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="status_ccs">Status CCS</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="status_ccs" name="status_ccs" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="priority">Priority</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="priority" name="priority" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="form-line">
                                <select id="priority" name="priority" class="form-control">
                                    <option value="">-- Please select Priority--</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div> -->

                        <label for="maxday">Max Day</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="maxday" name="maxday" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="kategori">Kategori</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="kategori" name="kategori" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="form-line">
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="<?= $dp['kategori']; ?> "><?= $dp['kategori']; ?></option>
                                    <?php
                                    foreach ($category as $cat) : ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                    <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="form-line">
                                <select name="namateknisi" id="namateknisi" class="form-control">
                                    <option value=""> -- Pilih Teknisi -- </option>
                                    <?php
                                    foreach ($namateknisi as $nat) : ?>
                                        <option value="<?= $nat['id_user']; ?>"><?= $nat['nama_user']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <label for="judul">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="judul" name="judul" class="form-control">
                            </div>
                        </div>

                        <label for="subtask">Subtask</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="subtask" name="subtask" class="form-control">
                            </div>
                        </div>

                        <label for="tanggal">Tenggat waktu</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="date" id="tanggal" name="tanggal" class="form-control">
                            </div>
                        </div>


                        <!-- <label for="kategori">Category</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#modalPilihKategori"
                                    name="kategori" id="kategori" placeholder=""
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div> -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SAVE
                                CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>

                        </div>

                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- modal cari kategori -->
<div class="modal fade" id="modalPilihKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Kategori</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
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
                        <?php foreach ($category as $cat) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cat['nama_kategori']; ?></td>
                                <td class="hide"><?= $cat['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilihKategori" data-nama-kategori="<?= $cat['nama_kategori']; ?>" data-id-kategori="<?= $cat['id']; ?>">
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

<!-- jQuery and DataTables Scripts -->
<script type="text/javascript">
    table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('supervisor2/fetch_onprogress') ?>",
            "type": "POST",
            "data": function(data) {
                data.tanggal_awal = $('#tanggal_awal').val();
                data.tanggal_akhir = $('#tanggal_akhir').val();
                data.nama_klien = $('#nama_klien').val();
                data.nama_user = $('#nama_user').val();
            }

        },
        "order": [
            [2, 'desc']
        ], // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending (dari yang terbaru)
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],
        "columns": [{
                "data": "no"
            }, // Pastikan ini ada
            {
                "data": "no_tiket"
            },
            {
                "data": "waktu_pelaporan"
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
                "data": "handle_by"
            },
            {
                "data": "subtask1"
            },
            {
                "data": "status1"
            },
            {
                "data": "subtask2"
            },
            {
                "data": "status2"
            },
            {
                "data": "tanggal"
            },
            {
                "data": "aksi", // Ini untuk tombol aksi
                // Pastikan kolom aksi tidak dapat diurutkan
            }
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
            status_ccs: $('#status_ccs').val(),
            rating: $('#rating').val()
        };

        var actionUrl = format === 'pdf' ? '<?php echo base_url('export/rekap_pelaporan_pdf'); ?>' : '<?php echo base_url('export/rekap_pelaporan_excel_handle'); ?>';

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
<!-- AUTO INPUT MAX DAY AFTER SELECT PRIORITY -->
<script type="text/javascript">
    //Get references to the select and input elements
    const select = document.getElementById('priority');
    const input = document.getElementById('maxday');

    // Add event listener to the select element
    select.addEventListener('change', function() {
        // Set the value of the input field to the selected option's value
        if (select.value == "Low") {
            input.value = "90";
        } else if (select.value == "Medium") {
            input.value = "60";
        } else if (select.value == "High") {
            input.value = "7";
        } else {
            input.value = "";

        }

    });
</script>


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#pilihKategori', function() {
            var nama_klas = $(this).data('nama-kategori');
            var id = $(this).data('id-kategori');
            $('#kategori').val(nama_klas);
            $('#id').val(id);
            $('#modalPilihKategori').modal('hide');
        })
    });
</script>
<script>
    $(document).ready(function() {

        // Untuk sunting
        $('#editModalCP').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_pelaporan').attr("value", div.data('id_pelaporan'));
            modal.find('#no_tiket').attr("value", div.data('no_tiket'));
            modal.find('#waktu_pelaporan').attr("value", div.data('waktu_pelaporan'));
            modal.find('#nama').attr("value", div.data('nama'));
            modal.find('#judul').attr("value", div.data('judul'));
            modal.find('#perihal_coba').html(div.data('perihal'));
            modal.find('#status').attr("value", div.data('status'));
            modal.find('#status_ccs').attr("value", div.data('status_ccs'));
            modal.find('#priority').attr("value", div.data('priority'));
            // modal.find('#priority').value = div.data('priority');
            // modal.find('#priority option:selected').text(div.data('priority'));
            modal.find('#maxday').attr("value", div.data('maxday'));
            modal.find('#kategori').attr("value", div.data('kategori'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));
            modal.find('#namahd option:selected').text(div.data('nama'));
            // modal.find('#bprnama').attr("value", div.data('bprnama'));
            // modal.find('#bprsandi').attr("value", div.data('bprsandi'));
            // modal.find('#judul').attr("value", div.data('judul'));
            // modal.find('#headline').attr("value", div.data('headline'));
            // modal.find('#gbr_utama').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbr_utama'));
            // modal.find('#gbrtmbhn1').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn1'));
            // modal.find('#gbrtmbhn2').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn2'));
            // modal.find('#gbrtmbhn3').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn3'));
            // modal.find('#linkberita').val(div.data('linkberita'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));

        });

    });
</script>

<script>
    $(document).ready(function() {

        // Untuk sunting
        $('#editModal').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_pelaporan').attr("value", div.data('id_pelaporan'));
            modal.find('#no_tiket').attr("value", div.data('no_tiket'));
            modal.find('#waktu_pelaporan').attr("value", div.data('waktu_pelaporan'));
            modal.find('#nama').attr("value", div.data('nama'));
            modal.find('#judul').attr("value", div.data('judul'));
            modal.find('#perihal').attr("value", div.data('perihal'));
            modal.find('#status').attr("value", div.data('status'));
            modal.find('#status_ccs').attr("value", div.data('status_ccs'));
            modal.find('#priority').attr("value", div.data('priority'));
            // modal.find('#priority').value = div.data('priority');
            // modal.find('#priority option:selected').text(div.data('priority'));
            modal.find('#maxday').attr("value", div.data('maxday'));
            modal.find('#kategori').attr("value", div.data('kategori'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));
            modal.find('#namahd option:selected').text(div.data('nama'));
            modal.find('#judul').attr("value", div.data('judul'));
            modal.find('#tanggal').attr("value", div.data('tanggal'));
            // modal.find('#bprnama').attr("value", div.data('bprnama'));
            // modal.find('#bprsandi').attr("value", div.data('bprsandi'));
            // modal.find('#judul').attr("value", div.data('judul'));
            // modal.find('#headline').attr("value", div.data('headline'));
            // modal.find('#gbr_utama').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbr_utama'));
            // modal.find('#gbrtmbhn1').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn1'));
            // modal.find('#gbrtmbhn2').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn2'));
            // modal.find('#gbrtmbhn3').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn3'));
            // modal.find('#linkberita').val(div.data('linkberita'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));

        });

    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#pilih3', function() {
            var nama_klas = $(this).data('nama-divisi');
            var id = $(this).data('id-divisi');
            $('#namahd').val(nama_klas);
            $('#id').val(id);
            $('#defaultModalNamaDivisi').modal('hide');
        })
    });
</script>