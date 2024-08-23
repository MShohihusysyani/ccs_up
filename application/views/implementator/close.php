<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

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
                                CLOSE
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
                                            <th>Impact</th>
                                            <th>Attachment</th>
                                            <th>Category</th>
                                            <th>Priority</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Subtask 1</th>
                                            <th>Status Subtask 1</th>
                                            <th>Subtask 2</th>
                                            <th>Status Subtask 2</th>
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
                                            <th>Impact</th>
                                            <th>Attachment</th>
                                            <th>Category</th>
                                            <th>Priority</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Subtask 1</th>
                                            <th>Status Subtask 1</th>
                                            <th>Subtask 2</th>
                                            <th>Status Subtask 2</th>
                                            <th>Aksi</th>
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
                                                <td><?= $dp['judul']; ?></td>
                                                <td><?= $dp['impact']; ?></td>
                                                <td> <a href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                                </td>
                                                <td><?= $dp['kategori']; ?></td>
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
                                                    <?php if ($dp['status_ccs'] == 'FINISH') : ?>
                                                        <span class="label label-success">FINISH</span>

                                                    <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                        <span class="label label-warning">CLOSE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLE') : ?>
                                                        <span class="label label-info">HANDLE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLE 2') : ?>
                                                        <span class="label label-info">HANDLE 2</span>

                                                    <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                        <span class="label label-primary">ADDED</span>

                                                    <?php elseif ($dp['status_ccs'] == 'ADDED 2') : ?>
                                                        <span class="label label-primary">ADDED 2</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>

                                                </td>
                                                <td>
                                                    <?= $dp['handle_by']; ?>
                                                    <?php if (!empty($dp['handle_by2'])) : ?>
                                                        , <?= $dp['handle_by2']; ?>
                                                    <?php endif; ?>
                                                    <?php if (!empty($dp['handle_by3'])) : ?>
                                                        , <?= $dp['handle_by3']; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $dp['subtask1']; ?></td>
                                                <td>
                                                    <?php if ($dp['status1'] == 'COMPLETED') : ?>
                                                        <span class="label label-success">COMPLETED</span>

                                                    <?php elseif ($dp['status1'] == 'PENDING') : ?>
                                                        <span class="label label-info">PENDING</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $dp['subtask2']; ?></td>
                                                <td>
                                                    <?php if ($dp['status2'] == 'COMPLETED') : ?>
                                                        <span class="label label-success">COMPLETED</span>

                                                    <?php elseif ($dp['status2'] == 'PENDING') : ?>
                                                        <span class="label label-info">PENDING</span>

                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a class="btn btn-sm btn-info" href="<?= base_url() ?>implementator/detail_close/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>
                                                        Detail</a>
                                                </td>

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