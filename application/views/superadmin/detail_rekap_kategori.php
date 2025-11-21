<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Detail Rekap Kategori</h2>
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
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Handle By</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($detail_kategori)): ?>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_kategori as $kategori): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $kategori['no_tiket'] ?></td>
                                                <td><?= tanggal_indo($kategori['waktu_pelaporan']) ?></td>
                                                <td><?= $kategori['nama_klien'] ?></td>
                                                <td><?= $kategori['judul'] ?></td>
                                                <td><?= $kategori['kategori'] ?></td>
                                                <td>
                                                    <?php if ($kategori['status_ccs'] == 'FINISHED') : ?>
                                                        <span class="label label-success">FINISHED</span>
                                                    <?php elseif ($kategori['status_ccs'] == 'CLOSED') : ?>
                                                        <span class="label label-warning">CLOSED</span>
                                                    <?php elseif ($kategori['status_ccs'] == 'HANDLED') : ?>
                                                        <span class="label label-info">HANDLED</span>
                                                    <?php elseif ($kategori['status_ccs'] == 'HANDLED 2') : ?>
                                                        <span class="label label-info">HANDLED 2</span>
                                                    <?php elseif ($kategori['status_ccs'] == 'ADDED 2') : ?>
                                                        <span class="label label-info">ADDED 2</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= $kategori['handle_by']; ?>
                                                    <?php if (!empty($kategori['handle_by2'])) : ?>
                                                        , <?= $kategori['handle_by2']; ?>
                                                    <?php endif; ?>
                                                    <?php if (!empty($kategori['handle_by3'])) : ?>
                                                        , <?= $kategori['handle_by3']; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-info" href="<?= base_url() ?>superadmin/detail/<?= $kategori['id_pelaporan']; ?>"><i class="material-icons">visibility</i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data detail.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>