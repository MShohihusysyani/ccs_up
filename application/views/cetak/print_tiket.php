<!DOCTYPE html>
<html>

<head>
    <title>Ticket Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style type="text/css">
        @media print {
            .container {
                width: 100%;
            }

            .form-group {
                display: flex;
                margin-bottom: 10px;
            }

            .form-control-static {
                font-size: 12px;
                margin-left: 10px;
            }

            textarea.form-control {
                width: 90%;
                font-size: 12px;
                margin-left: 10px;
            }

            @page {
                size: A4;
                margin: 20mm;
            }

            img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Detail #<?= $ticket->no_tiket ?></h3>
                <h4><?= $ticket->judul ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><b>Added By:</b></div>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->nama ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><b>BPR/Client:</b></div>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->nama ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><b>Perihal:</b></div>
            <div class="col-sm-10">
                <!-- Rendering CKEditor content directly -->
                <?= $ticket->perihal ?>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-sm-2"><b>Perihal:</b></div>
            <div class="col-sm-10"><textarea class="form-control" rows="10"><?= $ticket->perihal ?></textarea></div>
        </div> -->
        <div class="row">
            <div class="col-sm-2"><b>Category:</b></div>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->kategori ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><b>Priority:</b></div>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->priority ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><b>Status:</b></div>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->status_ccs ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><b>Status:</b></div>
            <div class="col-sm-10">
                <?php
                // Ambil semua handler
                $handlers = array_filter([$ticket->handle_by, $ticket->handle_by2, $ticket->handle_by3]);
                foreach ($handlers as $handler) : ?>
                    <p class="form-control-static"><?= $handler ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Add more rows for other fields -->
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>

<!-- <!DOCTYPE html>
<html>

<head>
    <title>Ticket Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic-icons.css">
    <style type="text/css">
        table.page_header {
            width: 1020px;
            border: none;
            background-color: #DDDDFF;
            border-bottom: solid 1mm #AAAADD;
            padding: 2mm;
        }

        table.page_footer {
            width: 1020px;
            border: none;
            background-color: #DDDDFF;
            border-top: solid 1mm #AAAADD;
            padding: 2mm;
        }

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

        .container {
            margin: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control-static {
            padding-top: 7px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td align="left" style="width: 520px;">
                <font style="font-size: 18px"><b>Detail #<?= $ticket->no_tiket ?></b></font>
            </td>
        </tr>
    </table>
    <h3 style="text-align:left"><b><?= $ticket->judul ?></b></h3>
    <div class="container">
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Added By:</b></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->nama ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>BPR/Client:</b></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->nama ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Perihal:</b></label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="10"><?= $ticket->perihal ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Category:</b></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->kategori ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Priority:</b></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->priority ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Status:</b></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?= $ticket->status_ccs ?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><b>Handle By:</b></label>
            <div class="col-sm-10">
                <?php
                // Ambil semua handler
                $handlers = array_filter([$ticket->handle_by, $ticket->handle_by2, $ticket->handle_by3]);
                foreach ($handlers as $handler) : ?>
                    <p class="form-control-static"><?= $handler ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html> -->