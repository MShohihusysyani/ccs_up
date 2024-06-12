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
        bottom: 0.5rem;
        font-size: 11px;
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
            <td align="left" style="width: 520px;">
                <font style="font-size: 18px"><b> Detail #<?= $no_tiket?></b></font>
            </td>

        </tr>
    </table>
    <h3 style="text-align:left"><b><?= $dp['judul']?></b></h3>
    <p style="text-align: left;"><b>Addedy By  : <?= $nama?></b></p>
    <p style="text-align: left;"><b>BPR/Client : <?= $nama?></b></p>

    <div class="isi" style="margin: 0 auto;">
        <p><?= $dp['perihal']?></p>
    </div>


    <div class="kiri" style="margin: 0 auto;">
        <p style="text-align: left;"><b>Category  : <?= $kategori?></b></p>
        <p style="text-align: left;"><b>Priority  : <?= $priority?></b></p>
        <p style="text-align: left;"><b>Status    : <?= $status_ccs?></b></p>
        <p style="text-align: left;"><b>Handle By : <?= $handle_by?></b></p>
    </div>


</body>

<script type="text/javascript">
window.print();
</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>