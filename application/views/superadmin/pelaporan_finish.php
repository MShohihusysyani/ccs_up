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
</style>
<!-- Button trigger modal -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
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
                                    <!-- class="table table-bordered table-striped table-hover dataTable js-basic-example" -->
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Tiket</th>
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Impact</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>
                                            <!-- <th>Tanggal Approve</th> -->

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Tiket</th>
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Perihal</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Impact</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>
                                            <!-- <th>Tanggal Approve</th> -->
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php
                                        $no = 1;
                                        foreach ($datapelaporan as $dp) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $dp['no_tiket']; ?></td>
                                                <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                                <td><?= $dp['nama']; ?></td>
                                                <td><?= $dp['perihal']; ?></td>
                                                <td><?= $dp['kategori']; ?></td>
                                                <td>
                                                    <span class="label label-info">
                                                        <?= $dp['tags']; ?>
                                                    </span>
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
                                                <td><?= $dp['impact']; ?></td>
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
                                                    <?php if ($dp['status_ccs'] == 'FINISH') : ?>
                                                        <span class="label label-success">FINISH</span>

                                                    <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                        <span class="label label-warning">CLOSE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLE') : ?>
                                                        <span class="label label-info">HANDLE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                        <span class="label label-primary">ADDED</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    // Contoh penanganan multiple handle by
                                                    $handleByList = [
                                                        $dp['handle_by'],
                                                        $dp['handle_by2'],
                                                        $dp['handle_by3']
                                                    ];

                                                    // Loop untuk setiap user yang menghandle tiket
                                                    $first = true;
                                                    foreach ($handleByList as $handleBy) :
                                                        if (!empty($handleBy)) :
                                                            // Tampilkan koma di antara nama-nama pengguna jika bukan pengguna pertama
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
                                                    <!-- Tampilkan rating dalam bentuk bintang di kolom Rating -->
                                                    <?php if ($dp['rating'] !== null) : ?>
                                                        <div class="star-rating">
                                                            <?php
                                                            // Tampilkan bintang sesuai dengan rating yang diberikan
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
                                                <!-- <td>
                                                    <?= $dp['handle_by']; ?>
                                                    <?php if (!empty($dp['handle_by2'])) : ?>
                                                        , <?= $dp['handle_by2']; ?>
                                                    <?php endif; ?>
                                                    <?php if (!empty($dp['handle_by3'])) : ?>
                                                        , <?= $dp['handle_by3']; ?>
                                                    <?php endif; ?>
                                                </td> -->

                                                <!-- <td><?= tanggal_indo($dp['waktu_approve']); ?></td> -->
                                            </tr>
                                        <?php endforeach; ?>
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