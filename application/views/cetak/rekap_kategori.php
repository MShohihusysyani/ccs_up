<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic-icons.css">
    <!-- Setting CSS bagian header/ kop -->
    <style type="text/css">
    table.page_header {
        width: 1020px;
        border: none;
        background-color: #DDDDFF;
        border-bottom: solid 1mm #AAAADD;
        padding: 2mm
    }

    table.page_footer {
        width: 1020px;
        border: none;
        background-color: #DDDDFF;
        border-top: solid 1mm #AAAADD;
        padding: 2mm
    }
    </style>
    <!-- Setting Margin header/ kop -->
    <!-- Setting CSS Tabel data yang akan ditampilkan -->
    <style type="text/css">
    .tabel2 {
        border-collapse: collapse;
        margin: 0 auto;
        width: 90%;
        margin-left: 30px;
        margin-right: 30px;
    }

    .tabel2 th,
    .tabel2 td {
        padding: 5px 5px;
        border: 1px solid #000000;

    }

    p {
        margin-left: 30px;
    }



    div.kanan {
        position: absolute;

        right: 50px;

    }

    div.tengah {
        position: absolute;

        right: 330px;

    }

    div.kiri {
        position: absolute;

        left: 10px;
    }
    </style>

    <table>
        <tr>
            <th rowspan="3"><img src="<?= base_url('assets/'); ?>images/mso.png" style="width:100px;height:80px" />
            </th>
            <td align="center" style="width: 520px;">
                <font style="font-size: 18px"><b>PT Mitranet Software Online Purwokerto</b></font>
                <br>Jl. Gerilya Tengah, Komp.Ruko Perum Griya Karangindah Blok B4-5 Purwokerto
            </td>

        </tr>
    </table>
    <hr>
    <p align="center" style="font-weight: bold; font-size: 18px;"><u>CCS | Rekap Kategori</u></p>
     <?php
            date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
            $current_date = date('Y-m-d H:i:s');
            ?>


    <div class="isi" style="margin: 0 auto;">
        <p>Rekap Pelaporan ini dicetak oleh <b><?= $user['nama_user']?></b> pada Hari <?= format_indo($current_date)?></p>
        <!-- <p style="color: black; text-align: left;"><br>Rekap Pelaporan:</p> -->

        <table class="tabel2">
            <thead>
                <tr>
                    <th style="text-align: center;  "><b>No</b></th>
                    <th style="text-align: center;  "><b>kategori</b></th>
                    <th style="text-align: center;  "><b>Total</b></th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                foreach ($rekapCategory as $rc) : ?>
                <tr>
                    <td style="text-align: center; font-size: 12px;"><?php echo $no++; ?></td>
                    <td style="text-align: left; font-size: 12px;"><?php echo $rc['kategori']; ?></td>
                    <td style="text-align: left; font-size: 12px;"><?php echo $rc['total']; ?></td>
                </tr>
                <?php endforeach;
                ?>
            </tbody>
        </table>
    </div>




</body>

<script type="text/javascript">
window.print();
</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>