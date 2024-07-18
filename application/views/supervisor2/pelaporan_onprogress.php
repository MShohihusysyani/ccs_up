<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- Basic Examples -->
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <div class="eror" data-eror="<?= strip_tags($this->session->flashdata('alert')) ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <?= validation_errors(); ?>
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
                                                <th>Perihal</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Priority</th>
                                                <th>Impact</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle_by</th>
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
                                                <th>Perihal</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Priority</th>
                                                <th>Impact</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle By</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $no = 1;
                                            foreach ($datapelaporan as $dp) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $dp['no_tiket']; ?></td>
                                                    <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                                    <td><?= $dp['nama']; ?></td>
                                                    <td><?= $dp['judul']; ?></td>
                                                    <td><?= $dp['perihal']; ?></td>
                                                    <td> <a href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                                    </td>
                                                    <td><?= $dp['kategori']; ?></td>
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
                                                    <td><?= $dp['impact']; ?></td>
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
                                                    <td>
                                                        <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                        <div class="btn btn-sm btn-warning">
                                                            <a href="javascript:;" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>" data-no_tiket="<?= $dp['no_tiket']; ?>" data-waktu_pelaporan="<?= $dp['waktu_pelaporan']; ?>" data-nama="<?= $dp['nama']; ?>" data-perihal='<?= $dp['perihal']; ?>' data-status="<?= $dp['status']; ?>" data-status_ccs="<?= $dp['status_ccs']; ?>" data-kategori="<?= $dp['kategori']; ?>" data-judul="<?= $dp['judul']; ?>" data-priority="<?= $dp['priority']; ?>" data-maxday="<?= $dp['maxday']; ?>" data-toggle="modal" data-target="#editModalCP"> <i class="material-icons">forward</i> <span class="icon-name">Edit</span></a>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                        <div class="btn btn-sm btn-info">
                                                            <a href="javascript:;" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>" data-no_tiket="<?= $dp['no_tiket']; ?>" data-waktu_pelaporan="<?= $dp['waktu_pelaporan']; ?>" data-nama="<?= $dp['nama']; ?>" data-perihal='<?= $dp['perihal']; ?>' data-status="<?= $dp['status']; ?>" data-status_ccs="<?= $dp['status_ccs']; ?>" data-kategori="<?= $dp['kategori']; ?>" data-judul="<?= $dp['judul']; ?>" data-priority="<?= $dp['priority']; ?>" data-maxday="<?= $dp['maxday']; ?>" data-toggle="modal" data-target="#editModal"> <i class="material-icons">add</i> <span class="icon-name">Tambah Teknisi</span></a>
                                                        </div>

                                                        <br>
                                                        <br>

                                                        <a class="btn btn-sm btn-primary" href="<?= base_url() ?>export/print_detail/<?= $dp['no_tiket']; ?>"><i class="material-icons">print</i> <span class="icon-name"></span>Print Detail</a>

                                                        <br>
                                                        <br>

                                                        <a class="btn btn-sm btn-info" href="<?= base_url() ?>supervisor2/detail_pelaporan/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>Detail</a>


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