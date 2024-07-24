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
            <div class="eror" data-eror="<?= $this->session->flashdata('alert') ?>">
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
                                    SUBTASK
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
                                                <th>Impact</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Tags</th>
                                                <th>Priority</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle By</th>
                                                <th>Subtask</th>
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
                                                <th>Perihal</th>
                                                <th>Impact</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Tags</th>
                                                <th>Priority</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle By</th>
                                                <th>Subtask</th>
                                                <th>Tenggat waktu</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                            $no = 1;
                                            foreach ($subtask as $st) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $st['no_tiket']; ?></td>
                                                    <td><?= tanggal_indo($st['waktu_pelaporan']) ?></td>
                                                    <td><?= $st['nama']; ?></td>
                                                    <td><?= $st['perihal']; ?></td>
                                                    <td><?= $st['impact']; ?></td>
                                                    <td> <a href="<?= base_url('assets/files/' . $st['file']); ?>"><?= $st['file']; ?></a>
                                                    </td>
                                                    <td><?= $st['kategori']; ?></td>
                                                    <td>
                                                        <span class="label label-info"><?= $st['tags']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($st['priority'] == 'Low') : ?>
                                                            <span class="label label-info">Low</span>

                                                        <?php elseif ($st['priority'] == 'Medium') : ?>
                                                            <span class="label label-warning">Medium</span>

                                                        <?php elseif ($st['priority'] == 'High') : ?>
                                                            <span class="label label-danger">High</span>

                                                        <?php else : ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($st['maxday'] == '90') : ?>
                                                            <span class="label label-info">90</span>

                                                        <?php elseif ($st['maxday'] == '60') : ?>
                                                            <span class="label label-warning">60</span>

                                                        <?php elseif ($st['maxday'] == '7') : ?>
                                                            <span class="label label-danger">7</span>

                                                        <?php else : ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($st['status_ccs'] == 'FINISH') : ?>
                                                            <span class="label label-success">FINISH</span>

                                                        <?php elseif ($st['status_ccs'] == 'CLOSE') : ?>
                                                            <span class="label label-warning">CLOSE</span>

                                                        <?php elseif ($st['status_ccs'] == 'HANDLE') : ?>
                                                            <span class="label label-info">HANDLE</span>

                                                        <?php elseif ($st['status_ccs'] == 'HANDLE 2') : ?>
                                                            <span class="label label-info">HANDLE 2</span>

                                                        <?php elseif ($st['status_ccs'] == 'ADDED') : ?>
                                                            <span class="label label-primary">ADDED</span>

                                                        <?php else : ?>
                                                        <?php endif; ?>

                                                    </td>
                                                    <td>
                                                        <?= $st['handle_by']; ?>
                                                        <?php if (!empty($st['handle_by2'])) : ?>
                                                            , <?= $st['handle_by2']; ?>
                                                        <?php endif; ?>
                                                        <?php if (!empty($st['handle_by3'])) : ?>
                                                            , <?= $st['handle_by3']; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $st['subtask']; ?></td>
                                                    <td><?= tanggal_indo($st['tanggal']) ?></td>

                                                    <td>

                                                        <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                        <div class="btn btn-sm btn-info">
                                                            <a href="javascript:;" data-id_forward="<?= $st['id_forward']; ?>" data-no_tiket="<?= $st['no_tiket']; ?>" data-waktu_pelaporan="<?= $st['waktu_pelaporan']; ?>" data-nama="<?= $st['nama']; ?>" data-perihal='<?= $st['perihal']; ?>' data-status="<?= $st['status']; ?>" data-status_ccs="<?= $st['status_ccs']; ?>" data-kategori="<?= $st['kategori']; ?>" data-priority="<?= $st['priority']; ?>" data-maxday="<?= $st['maxday']; ?>" data-judul="<?= $st['judul']; ?>" data-subtask="<?= $st['subtask']; ?>" data-tanggal="<?= $st['tanggal']; ?>" data-toggle="modal" data-target="#finishModal"> <i class="material-icons">done</i> <span class="icon-name">Finish</span></a>
                                                        </div>

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

<!-- FINISH TIKET-->
<div class="modal fade" id="finishModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Finish Subtask</h4>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('implementator/finish_subtask') ?>
                <input type="hidden" name="id_forward" id="id_forward"> <!-- Perbarui dengan id_forward -->
                <div class="body">

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

                    <label for="judul">Judul</label>
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


                    <label for="subtask">Subtask</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input value="" type="text" id="subtask" name="subtask" class="form-control" readonly>
                        </div>
                    </div>

                    <label for="tanggal">Tenggat waktu</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input value="" type="date" id="tanggal" name="tanggal" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect">FINISH</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>

                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {

        // Untuk sunting
        $('#finishModal').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_forward').val(div.data('id_forward')); // Sesuaikan dengan data-id_forward
            modal.find('#no_tiket').val(div.data('no_tiket'));
            modal.find('#waktu_pelaporan').val(div.data('waktu_pelaporan'));
            modal.find('#nama').val(div.data('nama'));
            modal.find('#judul').val(div.data('judul'));
            modal.find('#perihal_coba').html(div.data('perihal'));
            modal.find('#status').val(div.data('status'));
            modal.find('#status_ccs').val(div.data('status_ccs'));
            modal.find('#priority').val(div.data('priority'));
            modal.find('#subtask').val(div.data('subtask'));
            modal.find('#tanggal').val(div.data('tanggal'));
            modal.find('#maxday').val(div.data('maxday'));
            modal.find('#kategori').val(div.data('kategori'));
        });

    });
</script>


<script>
    // Check if tenggat waktu is empty and display message if true
    $(document).ready(function() {
        $('#example tbody tr').each(function() {
            var tenggatWaktu = $(this).find('td:eq(14)').text().trim(); // Assuming 15th column (index 14) is tenggat waktu
            if (tenggatWaktu === '') {
                $(this).find('td:eq(14)').text('Invalid date format'); // Replace with your message or any action you want
            }
        });
    });
</script>