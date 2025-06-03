<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .content {
            margin-top: 20px;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: small;
            margin-top: 30px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            font-size: 11pt;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .right-align {
            text-align: left;
            /* Tetap rata kiri dalam elemen */
        }

        .header-table td {
            vertical-align: top;
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

        .right-side p {
            margin: 0 0;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <table border="1" width="100%" cellspacing="0" cellpadding="5" style="border-collapse: collapse; font-size:10pt;">
        <thead>
            <tr style="background-color: #dcedc8;">
                <th>No</th>
                <th>Tanggal</th>
                <th>No Tiket</th>
                <th>Perihal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data_sla as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($row['waktu_pelaporan'])) ?></td>
                    <td><?= $row['no_tiket'] ?></td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['status_ccs'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
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