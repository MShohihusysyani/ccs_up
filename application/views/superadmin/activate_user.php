<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- Basic Examples -->


        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Aktivasi User
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                                    id="example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Tanggal Registrasi</th>
                                            <th>Last Login</th>
                                            <th>Active</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $no = 1;
                                        foreach ($user as $u) : ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?= $u['nama_user']; ?></td>
                                                <td><?= $u['username']; ?></td>
                                                <td><?= $u['divisi']; ?></td>
                                                <td><?= tanggal_indo($u['tgl_register']); ?></td>
                                                <td><?= format_indo($u['last_login']); ?></td>
                                                <td> <?php if ($u['active'] == 'N') : ?>
                                                        <i class="material-icons">clear</i>

                                                    <?php elseif ($u['active'] == 'Y') : ?>
                                                        <i class="material-icons">verified</i>
                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>

                                                    <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                    <?php if ($u['active'] == 'N') : ?>
                                                        <a class="btn btn-sm btn-success waves-effect tombol-aktif"
                                                            href="<?= base_url() ?>user/active/<?= $u['id_user']; ?>"><i class="material-icons">check</i>
                                                            Active</a>
                                                        <?php $this->session->set_userdata('referred_from', current_url()); ?>

                                                    <?php elseif ($u['active'] == 'Y') : ?>
                                                        <a class="btn btn-sm btn-danger tombol-nonaktif"
                                                            href="<?= base_url() ?>user/inactive/<?= $u['id_user']; ?>"><i class="material-icons">close</i>
                                                            Inactive</a>

                                                    <?php else : ?>
                                                    <?php endif; ?>
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

<script>
    $('#tombol-tambah').on('click', function(e) {

        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            icon: 'success',
            title: 'Added',
            text: 'Data added'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })

    })
</script>