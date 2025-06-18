<!DOCTYPE html>
<html>

<head>
    <title>Rekap Kategori</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #dcedc8;
        }

        .right-side {
            text-align: right;
            page-break-inside: avoid;
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 100px;
            width: 100%;
        }
    </style>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <?php
                $start = ($periode == 1) ? 1 : 7;
                $end = ($periode == 1) ? 6 : 12;
                for ($i = $start; $i <= $end; $i++): ?>
                    <th><?= DateTime::createFromFormat('!m', $i)->format('F'); ?></th>
                <?php endfor; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data_kategori = [];
            $total_per_bulan = [];
            $grand_total = 0;

            foreach ($rekap_kategori as $row) {
                $kat = ($row['kategori'] == '' || is_null($row['kategori'])) ? '(Tanpa Kategori)' : $row['kategori'];
                $bulan = (int)$row['bulan'];
                $jumlah = $row['jumlah'];

                $data_kategori[$kat][$bulan] = $jumlah;

                if (!isset($total_per_bulan[$bulan])) $total_per_bulan[$bulan] = 0;
                $total_per_bulan[$bulan] += $jumlah;

                $grand_total += $jumlah;
            }

            $no = 1;
            foreach ($data_kategori as $kategori => $bulan_data):
                $total = 0;
                echo "<tr><td>{$no}</td><td>{$kategori}</td>";
                for ($i = $start; $i <= $end; $i++) {
                    $jml = isset($bulan_data[$i]) ? $bulan_data[$i] : 0;
                    $total += $jml;
                    echo "<td>{$jml}</td>";
                }
                echo "<td>{$total}</td></tr>";
                $no++;
            endforeach;
            ?>
            <tr style="background-color: #dcedc8; font-weight: bold;">
                <td colspan="2">Total</td>
                <?php
                for ($i = $start; $i <= $end; $i++) {
                    $tot = isset($total_per_bulan[$i]) ? $total_per_bulan[$i] : 0;
                    echo "<td>{$tot}</td>";
                }
                echo "<td>{$grand_total}</td>";
                ?>
            </tr>
        </tbody>
    </table>

    <?php
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d');
    ?>

    <div class="right-side">
        <p>Purwokerto, <?= tanggal_indo($now); ?></p>
        <p>PT. Mitranet Software Online</p>
        <p><img src="assets/images/ttd.jpg" style="height: 100px;" alt="TTD" loading="lazy"></p>
        <p>Plt Kadiv Corebanking</p>
    </div>
</body>

</html>