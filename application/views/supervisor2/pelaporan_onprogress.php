<style>
    /* Letakkan ini di file CSS Anda atau di dalam tag <style> di view */
    .chat-btn-wrapper {
        position: relative;
        /* Wajib ada, sebagai acuan untuk badge */
        display: inline-flex;
        /* Agar wrapper pas dengan ukuran tombol */
        vertical-align: middle;
    }

    .chat-btn-wrapper .badge {
        position: absolute;
        /* Posisi 'melayang' di atas wrapper */
        top: -8px;
        /* Atur posisi vertikal (sedikit ke atas dari sudut) */
        right: -8px;
        /* Atur posisi horizontal (sedikit ke kanan dari sudut) */

        /* ===================================================================== */
        /* PENTING: Angka ini membawa badge ke lapisan paling atas */
        z-index: 10;
        /* ===================================================================== */

        /* Styling tambahan agar terlihat bagus seperti di WA */
        padding: 4px;
        font-size: 10px;
        font-weight: bold;
        line-height: 1;
        color: white;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        background-color: #F44336;
        /* Warna merah */
        border-radius: 50%;
        /* Membuatnya bulat sempurna */
        min-width: 18px;
        /* Agar tetap bulat walau 1 digit */
        height: 18px;
        /* Agar tetap bulat walau 1 digit */
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
        <!-- <link rel="stylesheet"  type="text/css" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>

        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <div class="eror" data-eror="<?= strip_tags($this->session->flashdata('alert') ?? '') ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <?= validation_errors(); ?>

                <!-- Basic Examples -->
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

                                            <!-- <div class="form-group">
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
                                    </div> -->

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
                                    ON PROGRESS
                                </h2>

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
                                    <table class="table table-bordered table-striped table-hover display" id="example">
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
        // "responsive": true,
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

        "createdRow": function(row, data, dataIndex) {
            // console.log(data); // Debug data untuk melihat isinya
            if (data[16] === 'Fokus') {
                $(row).css("background-color", "#d4edda"); // Warna hijau lembut
            }
        },

        // "columns": [{
        //         "data": "no"
        //     }, // Pastikan ini ada
        //     {
        //         "data": "no_tiket"
        //     },
        //     {
        //         "data": "waktu_pelaporan"
        //     },
        //     {
        //         "data": "nama"
        //     },
        //     {
        //         "data": "judul"
        //     },
        //     {
        //         "data": "kategori"
        //     },
        //     {
        //         "data": "priority"
        //     },
        //     {
        //         "data": "maxday"
        //     },
        //     {
        //         "data": "status_ccs"
        //     },
        //     {
        //         "data": "handle_by"
        //     },
        //     {
        //         "data": "subtask1"
        //     },
        //     {
        //         "data": "status1"
        //     },
        //     {
        //         "data": "subtask2"
        //     },
        //     {
        //         "data": "status2"
        //     },
        //     {
        //         "data": "tanggal"
        //     },
        //     {
        //         "data": "aksi", // Ini untuk tombol aksi
        //         // Pastikan kolom aksi tidak dapat diurutkan
        //     },

        // ]


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

        var actionUrl = format === 'pdf' ? '<?php echo base_url('export/export_pdf_handle'); ?>' : '<?php echo base_url('export/rekap_pelaporan_excel_handle'); ?>';

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

<!-- script pusher -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil ID user yang sedang login dari session PHP
        const myId = <?= $this->session->userdata('id_user'); ?>;

        // Inisialisasi Pusher
        const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', {
            cluster: '<?= PUSHER_APP_CLUSTER ?>',
            encrypted: true
        });

        // Subscribe ke channel notifikasi personal
        const channelName = `user-notifications-${myId}`;
        const channel = pusher.subscribe(channelName);

        // Bind ke event 'update-badge'
        channel.bind('update-badge', function(data) {
            const tiketId = data.tiket_id;
            const unreadCount = data.unread_count;

            // Cari wrapper tombol chat yang sesuai
            const chatWrapper = document.getElementById(`chat-wrapper-${tiketId}`);
            if (!chatWrapper) {
                return; // Jika baris tiket tidak ada di halaman ini, abaikan
            }

            // Hapus badge yang sudah ada
            const existingBadge = chatWrapper.querySelector('.badge');
            if (existingBadge) {
                existingBadge.remove();
            }

            // Jika count > 0, buat dan tambahkan badge baru
            if (unreadCount > 0) {
                const newBadge = document.createElement('span');
                newBadge.className = 'badge';
                newBadge.textContent = unreadCount;
                chatWrapper.appendChild(newBadge);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol 'Tandai Belum Dibaca'
        // Menggunakan event delegation karena tombol dibuat secara dinamis oleh DataTables
        $('#example').on('click', '.mark-as-unread-btn', function(e) {
            e.preventDefault(); // Mencegah aksi default link

            const tiketId = $(this).data('id');

            // Konfirmasi (opsional, tapi disarankan)
            if (!confirm('Anda yakin ingin menandai chat ini sebagai belum dibaca?')) {
                return;
            }

            $.ajax({
                url: "<?= site_url('chat/mark_as_unread') ?>", // URL ke controller baru
                type: 'POST',
                data: {
                    id_pelaporan: tiketId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // atau gunakan notifikasi yang lebih baik seperti SweetAlert

                        // Muat ulang data tabel untuk memperbarui badge notifikasi
                        // Parameter 'null, false' akan me-reload data tanpa kembali ke halaman pertama
                        table.ajax.reload(null, false);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses permintaan.');
                }
            });
        });

        // Kode DataTables dan skrip lain Anda tetap di sini...

    });
</script>

<!-- Script untuk auto-refresh unread_count secara real-time -->
<script>
    $(document).ready(function() {
        // Fungsi untuk memperbarui unread_count
        function updateUnreadCounts() {
            // Ambil data filter yang sedang aktif
            var filters = {
                tanggal_awal: $('#tanggal_awal').val(),
                tanggal_akhir: $('#tanggal_akhir').val(),
                nama_klien: $('#nama_klien').val(),
                nama_user: $('#nama_user').val(),
                tags: $('#tags').val()
            };

            // Kirim request ke endpoint get_all_unread_counts
            $.ajax({
                url: "<?= site_url('supervisor2/get_all_unread_counts') ?>",
                type: 'POST',
                data: filters,
                dataType: 'json',
                success: function(response) {
                    // Update badge untuk setiap ticket yang ada di halaman
                    $.each(response, function(tiketId, unreadCount) {
                        const chatWrapper = document.getElementById(`chat-wrapper-${tiketId}`);
                        if (chatWrapper) {
                            // Hapus badge yang sudah ada
                            const existingBadge = chatWrapper.querySelector('.badge');
                            if (existingBadge) {
                                existingBadge.remove();
                            }

                            // Jika count > 0, buat dan tambahkan badge baru
                            if (unreadCount > 0) {
                                const newBadge = document.createElement('span');
                                newBadge.className = 'badge';
                                newBadge.textContent = unreadCount;
                                chatWrapper.appendChild(newBadge);
                            }
                        }
                    });
                },
                error: function() {
                    console.log('Error updating unread counts');
                }
            });
        }

        // Jalankan update setiap 5 detik
        setInterval(updateUnreadCounts, 5000);

        // Jalankan update saat DataTable selesai loading
        $('#example').on('draw.dt', function() {
            // Delay sedikit untuk memastikan DOM sudah ter-render
            setTimeout(updateUnreadCounts, 100);
        });

        // Jalankan update saat filter berubah
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw();
            // Update unread counts setelah filter diterapkan
            setTimeout(updateUnreadCounts, 1000);
        });

        $('#resetFilterButton').on('click', function() {
            $('#filterFormContent')[0].reset();
            table.draw();
            // Update unread counts setelah reset
            setTimeout(updateUnreadCounts, 1000);
        });

        $('#semuaDataButton').on('click', function() {
            $('#filterFormContent')[0].reset();
            table.ajax.reload();
            // Update unread counts setelah reload
            setTimeout(updateUnreadCounts, 1000);
        });
    });
</script>