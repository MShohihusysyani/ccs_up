<section class="content">
    <div class="container-fluid">
        <div class="block-header">


        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet"
            href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="header">
                    <h2>
                        Edit CCS </h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('supervisor2/fungsi_edit_helpdesk') ?>
                    <form>
                        <?php foreach ($datapelaporan as $dp) : ?>
                        <input type="hidden" id="id" name="id" class="form-control"
                            value="<?= $dp['id']; ?>">

                            <label for="nama_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="no_tiket" name="no_tiket" class="form-control"
                                    value="<?= $dp['no_tiket']; ?>">
                            </div>
                        </div>

                        <label for="waktu_pelaporan">Tanggal </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control"
                                    value="<?= $dp['waktu_pelaporan']; ?>">
                            </div>
                        </div>

                        <label for="nama">Nama </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="nama" name="nama" class="form-control"
                                    value="<?= $dp['nama']; ?>">
                            </div>
                        </div>
                        <label for="perihal">Perihal </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="perihal" name="perihal" class="form-control"
                                    value="<?= $dp['perihal']; ?>">
                            </div>
                        </div>
                        


                        <label for="status">Status </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="status" name="status" class="form-control"
                                    value="<?= $dp['status']; ?>">
                            </div>
                        </div>

                        <label for="status_ccs ">Status CCS </label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="status_ccs" name="status_ccs" class="form-control"
                                    value="<?= $dp['status_ccs']; ?>">
                            </div>
                        </div>

                        <!-- <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                        <div class="form-group">
                            <div class="form-line">
                                <img src="<?= base_url('assets/files/') . $dp['file']; ?>" width="500"
                                    height="500" class="img-thumbnail">
                                <div class="form-group">
                                    <label for="exampleInputFile"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file"
                                                name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group form-float">
                                <select id="priority" name="priority" class="form-control">
                                        <option value=""><?= $dp['priority'];?></option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                               </select> 
                        </div>

                        <label for="maxday">Max Day</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="maxday" name="maxday" class="form-control"
                                    value="<?= $dp['maxday']; ?>" readonly>
                            </div>
                        </div>

                         <label for="kategori">Helpdesk</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#defaultModalNamaDivisi"
                                    name="namahd" id="namahd" placeholder="Pilih Helpdesk"
                                    class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="<?= $dp['kategori']; ?> "><?= $dp['kategori']; ?></option>
                                    <?php
                                    foreach ($category as $cat): ?>
                                    <option value="<?php echo $cat['nama_kategori']; ?>">
                                    <?php echo $cat['nama_kategori']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">EDIT</button>
                        <?php endforeach; ?>
                    </form>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

    
    <!-- MODAL ADD JENIS BARANG -->
    <div class="modal fade" id="defaultModalNamaDivisi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cari Helpdesk</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Helpdesk</th>
                                <th class="hide">ID</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($namahd  as $nah) : ?>

                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $nah['nama']; ?></td>
                                <td class="hide"><?= $div['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3"
                                        data-nama-divisi="<?= $nah['nama']; ?>"
                                        data-id-divisi="<?= $nah['id']; ?>">
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

</section>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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

<!-- AUTO INPUT MAX DAY AFTER SELECT PRIORITY -->

<script type="text/javascript">
    //Get references to the select and input elements
    const select = document.getElementById('priority');
    const input = document.getElementById('maxday');

    // Add event listener to the select element
    select.addEventListener('change', function () {
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