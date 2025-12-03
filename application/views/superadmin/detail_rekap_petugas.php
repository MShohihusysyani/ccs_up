<?php
// Helper sederhana untuk formatting judul periode
$judul_periode = "";
if ($info['periode'] == 'bulan') {
    $judul_periode = "Bulan: " . $info['bulan'] . " " . $info['tahun'];
} elseif ($info['periode'] == 'akumulasi') {
    // akumulasi adalah data sebelum bulan ini
    $judul_periode = "Akumulasi (Data < Bulan " . $info['bulan'] . " " . $info['tahun'] . ")";
} else {
    $judul_periode = "Total Keseluruhan";
}

// Warna label status header
$label_color = ($info['status'] == 'HANDLE') ? 'col-info' : (($info['status'] == 'FINISH') ? 'col-green' : 'col-blue');
?>

<section class="content">
    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Petugas: <span><?= $info['nama_petugas']; ?></span>
                        </h2>
                        <small style="font-size: 14px; margin-top:5px; display:block;">
                            Status: <b class="<?= $label_color ?>"><?= $info['status']; ?></b> |
                            Periode: <b><?= $judul_periode; ?></b>
                        </small>
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
                                    <?php if (empty($detail)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data detail untuk kategori ini.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1;
                                        foreach ($detail as $row): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $row['no_tiket']; ?></td>
                                                <td><?= tanggal_indo($row['waktu_pelaporan']) ?></td>
                                                <td><?= $row['nama_klien']; ?></td>
                                                <td><?= $row['judul']; ?></td>

                                                <td>
                                                    <?php
                                                    $st = $row['status_ccs'];
                                                    $lbl = 'label-default';
                                                    if ($st == 'FINISHED') $lbl = 'label-success';
                                                    elseif ($st == 'CLOSED') $lbl = 'label-warning';
                                                    elseif (in_array($st, ['HANDLED', 'HANDLED 2', 'ADDED 2'])) $lbl = 'label-info';
                                                    ?>
                                                    <span class="label <?= $lbl ?>"><?= $st ?></span>
                                                </td>

                                                <td>
                                                    <?= $row['handle_by']; ?>
                                                    <?= !empty($row['handle_by2']) ? ', ' . $row['handle_by2'] : ''; ?>
                                                    <?= !empty($row['handle_by3']) ? ', ' . $row['handle_by3'] : ''; ?>
                                                </td>

                                                <td>
                                                    <a class="btn btn-sm btn-info waves-effect" target="_blank" href="<?= base_url() ?>superadmin/detail/<?= $row['id_pelaporan']; ?>" title="Lihat Detail">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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