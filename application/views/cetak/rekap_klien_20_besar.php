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
        REKAP KLIEN 20 BESAR(Periode: <?= $label_bulan_ini . ' ' . $filter_tahun ?>)
    </h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="<?= $bg_color ?> vertical-align: middle;">No</th>
                <th colspan="3" style="<?= $bg_color ?>">Jumlah Request</th>
            </tr>

            <tr>
                <th style="<?= $bg_color ?> vertical-align: middle;">Kode Klien</th>
                <th style="<?= $bg_color ?> vertical-align: middle;">Nama Klien</th>
                <th style="<?= $bg_color ?>"><?= $label_bulan_ini ?></th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (empty($rekap)) {
                echo '<tr><td colspan="4" class="text-center">Data tidak ditemukan</td></tr>';
            } else {
                $no = 1;
                $i = 0;
                $count = count($rekap);

                while ($i < $count) {
                    $current_val = $rekap[$i]['klien_current'];
                    $j = $i;

                    // Hitung ada berapa baris yang nilainya sama berturut-turut
                    while ($j < $count && $rekap[$j]['klien_current'] == $current_val) {
                        $j++;
                    }

                    $rowspan = $j - $i;

                    // Loop untuk menampilkan baris-baris dalam grup yang sama
                    for ($k = $i; $k < $j; $k++) {
                        echo '<tr>';

                        // Tampilkan kolom No dan Jumlah Request hanya pada baris pertama di grupnya
                        if ($k == $i) {
                            echo '<td class="text-center" rowspan="' . $rowspan . '" style="vertical-align:middle;">' . $no++ . '</td>';
                        }

                        echo '<td class="text-center">' . $rekap[$k]['no_klien'] . '</td>';
                        echo '<td class="text-left">' . $rekap[$k]['nama_klien'] . '</td>';
                        echo '<td class="text-center">' . $rekap[$k]['klien_current'] . '</td>';

                        echo '</tr>';
                    }

                    // Loncati indeks ke grup berikutnya
                    $i = $j;
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>