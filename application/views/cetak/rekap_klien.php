<?php

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
    <title>Rekap Klien</title>
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
        REKAP KLIEN(Periode: <?= $label_bulan_ini . ' ' . $filter_tahun ?>)
    </h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">NO</th>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">Kode Klien</th>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">Nama Klien</th>

                <th colspan="3" style="<?= $bg_color ?>">Jumlah Request</th>
            </tr>

            <tr>
                <th style="<?= $bg_color ?>">Akumulasi</th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_lalu ?></th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_ini ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            if (empty($rekap)) {
                echo '<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>';
            } else {
                foreach ($rekap as $r):
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $r['no_klien'] ?></td>
                        <td class="text-left"><?= $r['nama_klien'] ?></td>
                        <td class="text-center"><?= $r['klien_akumulasi'] ?></td>
                        <td class="text-center"><?= $r['klien_prev'] ?></td>
                        <td class="text-center"><?= $r['klien_current'] ?></td>
                    </tr>
            <?php
                endforeach;
            }
            ?>
        </tbody>
        <tfoot style="font-size: 11px; color: #777;">
            <tr id="row-total">
                <th colspan="3">TOTAL</th>
                <th style="text-align: center"><?= $total_akumulasi_klien ?></th>
                <th style="text-align: center"><?= $total_klien_prev ?></th>
                <th style="text-align: center"><?= $total_klien_current ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>