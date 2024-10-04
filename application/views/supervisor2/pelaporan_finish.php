<style>
    .star-rating {
        display: inline-block;
    }

    .star {
        cursor: pointer;
        color: gray;
        font-size: 20px;
    }

    .star.selected {
        color: gold;
    }

    .star-rating .star.selected {
        font-size: 30px;
        /* Sesuaikan ukuran sesuai kebutuhan Anda */
        color: gold;
        /* Warna emas untuk bintang */
    }
</style>
<!-- Button trigger modal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            FINISH
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>Nama Klien</th>
                                        <th>Judul</th>
                                        <th>Category</th>
                                        <th>Tags</th>
                                        <th>Priority</th>
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Handle By</th>
                                        <th>Rating</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Tanggal</th>
                                        <th>Nama Klien</th>
                                        <th>Judul</th>
                                        <th>Category</th>
                                        <th>Tags</th>
                                        <th>Priority</th>
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Handle By</th>
                                        <th>Rating</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <!-- <?php
                                            $no = 1;
                                            foreach ($datapelaporan as $dp) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $dp['no_tiket']; ?></td>
                                                <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                                <td><?= $dp['nama']; ?></td>
                                                <td><?= $dp['judul']; ?></td>
                                                <td><?= $dp['kategori']; ?></td>
                                                <td>
                                                    <?php if (!empty($dp['tags'])): ?>
                                                        <span class="label label-info">
                                                            <?= $dp['tags']; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($dp['priority'] == 'Low') : ?>
                                                        <span class="label label-info">Low</span>

                                                    <?php elseif ($dp['priority'] == 'Medium') : ?>
                                                        <span class="label label-warning">Medium</span>

                                                    <?php elseif ($dp['priority'] == 'High') : ?>
                                                        <span class="label label-danger">High</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($dp['maxday'] == '90') : ?>
                                                        <span class="label label-info">90</span>

                                                    <?php elseif ($dp['maxday'] == '60') : ?>
                                                        <span class="label label-warning">60</span>

                                                    <?php elseif ($dp['maxday'] == '7') : ?>
                                                        <span class="label label-danger">7</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($dp['status_ccs'] == 'FINISHED') : ?>
                                                        <span class="label label-success">FINISHED</span>

                                                    <?php elseif ($dp['status_ccs'] == 'CLOSED') : ?>
                                                        <span class="label label-warning">CLOSED</span>

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLED') : ?>
                                                        <span class="label label-info">HANDLED</span>

                                                    <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                        <span class="label label-primary">ADDED</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    $handleByList = [
                                                        $dp['handle_by'],
                                                        $dp['handle_by2'],
                                                        $dp['handle_by3']
                                                    ];

                                                    $first = true;
                                                    foreach ($handleByList as $handleBy) :
                                                        if (!empty($handleBy)) :
                                                            if (!$first) {
                                                                echo ', ';
                                                            }
                                                            $first = false;
                                                    ?>
                                                            <div class="handle-by-item">
                                                                <?= $handleBy; ?>
                                                            </div>
                                                    <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
                                                </td>
                                                <td>
                                            
                                                    <?php if ($dp['rating'] !== null) : ?>
                                                        <div class="star-rating">
                                                            <?php
                                                            $rating = $dp['rating'];
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $rating) {
                                                                    echo '<span class="star selected">&#9733;</span>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a class="btn btn-sm btn-info" href="<?= base_url() ?>supervisor2/detail_finish/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>
                                                        Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
    <!-- Button trigger modal -->
</section>

<script>
    $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('supervisor2/get_data_finish') ?>",
            "type": "POST"
        },
        "order": [
            [2, 'desc']
        ], // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending (dari yang terbaru)
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],
    });
</script>