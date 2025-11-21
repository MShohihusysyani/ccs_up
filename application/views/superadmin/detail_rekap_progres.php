<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!-- <h2><?= $judul; ?></h2> -->
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Detail Rekap Progres</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>BPR/Klien</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Handle By</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($detail_laporan as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['no_tiket']; ?></td>
                                            <td><?= tanggal_indo($row['waktu_pelaporan']) ?></td>
                                            <td><?= $row['nama_klien']; ?></td>
                                            <td><?= $row['judul']; ?></td>
                                            <td>
                                                <?php if ($row['status_ccs'] == 'FINISHED') : ?>
                                                    <span class="label label-success">FINISHED</span>
                                                <?php elseif ($row['status_ccs'] == 'CLOSED') : ?>
                                                    <span class="label label-warning">CLOSED</span>
                                                <?php elseif ($row['status_ccs'] == 'HANDLED') : ?>
                                                    <span class="label label-info">HANDLED</span>
                                                <?php elseif ($row['status_ccs'] == 'HANDLED 2') : ?>
                                                    <span class="label label-info">HANDLED 2</span>
                                                <?php elseif ($row['status_ccs'] == 'ADDED 2') : ?>
                                                    <span class="label label-info">ADDED 2</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $row['handle_by']; ?>
                                                <?php if (!empty($row['handle_by2'])) : ?>
                                                    , <?= $row['handle_by2']; ?>
                                                <?php endif; ?>
                                                <?php if (!empty($row['handle_by3'])) : ?>
                                                    , <?= $row['handle_by3']; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="<?= base_url() ?>superadmin/detail/<?= $row['id_pelaporan']; ?>"><i class="material-icons">visibility</i></a>
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
    </div>
</section>