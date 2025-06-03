<!DOCTYPE html>
<html>

<head>
    <title>Rekap Progress</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            /* border: 1px solid #000; */
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #dcedc8;
            /* background-color: #c8e6c9; */
        }

        /* Pengaturan agar teks "Hormat Kami" sampai dengan "Direktur Utama" berada di kanan */
        .right-side {
            text-align: right;
            page-break-inside: avoid;
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 100px;
            /* Tambahkan jarak ke bawah */
            width: 100%;
        }
    </style>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Finished</th>
                <th>Handled</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_f = 0;
            $total_h = 0;
            $total_all = 0;
            $no = 1;
            foreach ($rekap as $row):
                $total_f += $row['finished'];
                $total_h += $row['handled'];
                $total_all += $row['total'];
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['bulan']; ?></td>
                    <td><?= $row['finished']; ?></td>
                    <td><?= $row['handled']; ?></td>
                    <td><?= $row['total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th><?= $total_f; ?></th>
                <th><?= $total_h; ?></th>
                <th><?= $total_all; ?></th>
            </tr>
        </tfoot>
    </table>

    <!-- Bagian "Hormat Kami" dan seterusnya di sebelah kanan -->
    <?php
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d');

    ?>
    <div class="right-side">
        <p>Purwokerto, <?= tanggal_indo($now) ?></p>
        <p>PT. Mitranet Software Online</p>
        <p><img src="assets/images/ttd.png" style="height: 100px;" alt="QR Code" loading="lazy">
        <p>Plt Kadiv Corebanking</p>
    </div>
</body>

</html>