<section class="content">
    <div class="container-fluid">
        <div class="block-header">

        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        FILTER
                    </h2>

                </div>
            </div>

            <div class="card">
                <div class="body">
                    <form action="<?= base_url('export/rekap_pelaporan'); ?>" method="post"
                                enctype="multipart/form-data">
                            <div>
                                <button class='btn btn-primary waves-effect m-r-20' type="submit">
                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                    Export Excel
                                </button>
                            </div>
                    </form>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-exportable dataTable"
                            id="example">
                            <thead>
                                <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No Tiket</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <!-- <th>Status</th> -->
                                            <!-- <th>Category</th>
                                            <th>Priority</th> -->
                                            <th>Status</th>
                                            <!-- <th>Handle By</th> -->
                                </tr>

                            </thead>
                            <tbody>

                                <?php
                                $no = 1;
                                foreach ($pelaporan as $pd) : ?>
                                <tr>
                                            <td><?= $no++?></td>
                                            <td><?= ['waktu_pelaporan'] ?></td>
                                            <td><?= $pd['no_tiket'];?></td>
                                            <td><?= $pd['nama'];?></td>
                                            <td><?= $pd['perihal'];?></td>
                                            <!-- <td><?= $pd['status'];?></td> -->
                                            <!-- <td><?= $pd['kategori'];?></td>
                                            <td>
                                                <?php if ($pd['priority'] == 'Low') : ?>
                                                    <span class="label label-info">Low</span>

                                                <?php elseif ($pd['priority'] == 'Medium') : ?>
                                                    <span class="label label-warning">Medium</span>

                                                <?php elseif ($pd['priority'] == 'High') : ?>
                                                    <span class="label label-danger">High</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            </td> -->
                                            <td>
                                                <?php if ($pd['status_ccs'] == 'FINISH') : ?>
                                                    <span class="label label-success">FINISH</span>

                                                <?php elseif ($pd['status_ccs'] == 'CLOSE') : ?>
                                                    <span class="label label-warning">CLOSE</span>

                                                <?php elseif ($pd['status_ccs'] == 'HANDLE') : ?>
                                                    <span class="label label-info">HANDLE</span>

                                                <?php elseif ($pd['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                            <!-- <td><?= $pd['handle_by'];?></td> -->

                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- #END# Exportable Table -->
    </div>

</section>

<!-- modal cari klien -->
<div class="modal fade" id="defaultModalNamaKlien" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cari Klien</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                        width="100%">
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
                            <?php foreach ($klien  as $cln) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cln['nama_klien']; ?></td>
                                <td class="hide"><?= $cln['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3"
                                        data-nama-klien="<?= $cln['nama_klien']; ?>"
                                        data-id-namaklien="<?= $cln['id']; ?>">
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


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
    $(document).on('click', '#pilih3', function() {
        var nama_klas = $(this).data('nama-klien');
        var id = $(this).data('id');
        $('#nama_klien').val(nama_klas);
        $('#id').val(id);
        $('#defaultModalNamaKlien').modal('hide');
    })
});
</script>


