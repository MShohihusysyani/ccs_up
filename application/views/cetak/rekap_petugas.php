<?php
// --- 1. LOGIKA PENENTUAN NAMA BULAN DINAMIS ---
// Sama persis dengan logika di View Rekap Petugas

$list_bulan_nama = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

// Nama Bulan Ini (Bulan Berjalan)
$label_bulan_ini = isset($list_bulan_nama[$filter_bulan]) ? $list_bulan_nama[$filter_bulan] : '-';

// Nama Bulan Lalu (Mundur 1 bulan)
$angka_bulan_lalu = (int)$filter_bulan - 1;
if ($angka_bulan_lalu == 0) {
    $angka_bulan_lalu = 12; // Jika Januari, balik ke Desember
}
$key_bulan_lalu = str_pad($angka_bulan_lalu, 2, '0', STR_PAD_LEFT);
$label_bulan_lalu = isset($list_bulan_nama[$key_bulan_lalu]) ? $list_bulan_nama[$key_bulan_lalu] : '-';

// Definisikan warna background untuk header agar terbaca di Excel
$bg_color = 'background-color: #c4d79b;';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Rekap Petugas</title>
</head>

<body>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }
    </style>

    <h3 style="text-align: center; font-family: Arial, sans-serif;">
        PROGRES REQUEST CCS (Periode: <?= $label_bulan_ini . ' ' . $filter_tahun ?>)
    </h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">NO</th>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">NAMA</th>

                <th colspan="3" style="<?= $bg_color ?>">HANDLE</th>
                <th colspan="3" style="<?= $bg_color ?>">FINISH</th>
                <th colspan="2" style="<?= $bg_color ?>">TOTAL REQUEST</th>

                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">TOTAL AKUMULASI</th>
            </tr>

            <tr>
                <th style="<?= $bg_color ?>">Akumulasi</th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_lalu ?></th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_ini ?></th>

                <th style="<?= $bg_color ?>">Akumulasi</th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_lalu ?></th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_ini ?></th>

                <th style="<?= $bg_color ?>"><?= $label_bulan_lalu ?></th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_ini ?></th>
            </tr>

            <tr style="background-color: #c4d79b;">
                <th style="<?= $bg_color ?>">A</th>
                <th style="<?= $bg_color ?>">B</th>

                <th style="<?= $bg_color ?>">C</th>
                <th style="<?= $bg_color ?>">D</th>
                <th style="<?= $bg_color ?>">E</th>

                <th style="<?= $bg_color ?>">F</th>
                <th style="<?= $bg_color ?>">G</th>
                <th style="<?= $bg_color ?>">H</th>

                <th style="<?= $bg_color ?>">I = D + G</th>
                <th style="<?= $bg_color ?>">J = E + H</th>

                <th style="<?= $bg_color ?>">K = C+F+I+J</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            if (empty($rekap)) {
                echo '<tr><td colspan="11" class="text-center">Data tidak ditemukan</td></tr>';
            } else {
                foreach ($rekap as $r):
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $r['nama_petugas'] ?></td>

                        <td class="text-center"><?= $r['handle_akumulasi'] ?></td>
                        <td class="text-center"><?= $r['handle_prev'] ?></td>
                        <td class="text-center"><?= $r['handle_current'] ?></td>

                        <td class="text-center"><?= $r['finish_akumulasi'] ?></td>
                        <td class="text-center"><?= $r['finish_prev'] ?></td>
                        <td class="text-center"><?= $r['finish_current'] ?></td>

                        <td class="text-center"><?= $r['total_req_prev'] ?></td>
                        <td class="text-center"><?= $r['total_req_current'] ?></td>

                        <td class="text-center"><strong><?= $r['total_grand_akumulasi'] ?></strong></td>
                    </tr>
            <?php
                endforeach;
            }
            ?>
        </tbody>
        <tfoot style="font-size: 11px; color: #777;">
            <tr id="row-total">
                <th colspan="2">TOTAL</th>
                <th style="text-align: center"><?= $total_akumulasi_handle ?></th>
                <th style="text-align: center"><?= $total_handle_prev ?></th>
                <th style="text-align: center"><?= $total_handle_current ?></th>
                <th style="text-align: center"><?= $total_akumulasi_finish ?></th>
                <th style="text-align: center"><?= $total_finish_prev ?></th>
                <th style="text-align: center"><?= $total_finish_current ?></th>
                <th style="text-align: center"><?= $total_request_prev ?></th>
                <th style="text-align: center"><?= $total_request_current ?></th>
                <th style="text-align: center"><?= $grand_total ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>