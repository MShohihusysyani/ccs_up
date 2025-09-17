<style>
    /* .table .current-task {
        background-color: #d1e7dd !important;
        Hijau muda

    } */

    /* CSS BARU UNTUK BADGE */
    .chat-btn-wrapper {
        position: relative;
        display: inline-block;
    }

    .chat-btn-wrapper .badge {
        position: absolute;
        top: -8px;
        right: -8px;
        padding: 4px 7px;
        border-radius: 50%;
        background-color: #F44336;
        /* Warna merah */
        color: white;
        font-size: 10px;
        font-weight: bold;
    }
</style>
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
                                ON PROGRESS
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
                                            <!-- <th>Perihal</th> -->
                                            <!-- <th>Attachment</th> -->
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <!-- <th>Impact</th> -->
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Subtask 1</th>
                                            <th>Status Subtask 1</th>
                                            <th>Subtask 2</th>
                                            <th>Status Subtask 2</th>
                                            <th>Tenggat waktu</th>
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
                                            <!-- <th>Perihal</th> -->
                                            <!-- <th>Attachment</th> -->
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <!-- <th>Impact</th> -->
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Subtask 1</th>
                                            <th>Status Subtask 1</th>
                                            <th>Subtask 2</th>
                                            <th>Status Subtask 2</th>
                                            <th>Tenggat waktu</th>
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
                                                <!-- <td><?= $dp['perihal']; ?></td> -->
                                                <!-- <td>
                                                    <?php
                                                    $file_path = base_url('assets/files/' . $dp['file']);
                                                    $file_ext = pathinfo($dp['file'], PATHINFO_EXTENSION);

                                                    if (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                        <a href="#" data-toggle="modal" data-target="#imageModal<?= $dp['id_pelaporan']; ?>">
                                                            <img src="<?= $file_path; ?>" alt="<?= $dp['file']; ?>" style="max-width: 150px;">
                                                        </a>

                                                        Modal Bootstrap 
                                                        <div class="modal fade" id="imageModal<?= $dp['id_pelaporan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?= $dp['file']; ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="<?= $file_path; ?>" alt="<?= $dp['file']; ?>" style="max-width: 100%;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <a href="<?= $file_path; ?>"><?= $dp['file']; ?></a>
                                                    <?php endif; ?>
                                                </td> -->
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
                                                <!-- <td><?= $dp['impact']; ?></td> -->
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

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLED 2') : ?>
                                                        <span class="label label-info">HANDLED 2</span>

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
                                                <td><?= $dp['subtask2']; ?></td>
                                                <td>
                                                    <?php if ($dp['status2'] == 'COMPLETED') : ?>
                                                        <span class="label label-success">COMPLETED</span>

                                                    <?php elseif ($dp['status2'] == 'PENDING') : ?>
                                                        <span class="label label-info">PENDING</span>

                                                    <?php else : ?>
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

                                                <td><?= tanggal_indo($dp['tanggal']) ?></td>

                                                <td style="display: flex; gap: 10px; justify-content: flex-end;">
                                                    <div class="btn-group chat-btn-wrapper" id="chat-wrapper-<?= $dp['id_pelaporan']; ?>">
                                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opsi Chat">
                                                            <i class="material-icons">more_vert</i>
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li>
                                                                <a href="<?= base_url('chat/room/' . $dp['no_tiket']); ?>" target="_blank" class="dropdown-item">
                                                                    <i class="material-icons" style="font-size: 16px; vertical-align: middle; margin-right: 5px;">chat</i>
                                                                    Buka Room Chat
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="dropdown-item mark-as-unread-btn" data-id="<?= $dp['id_pelaporan']; ?>">
                                                                    <i class="material-icons" style="font-size: 16px; vertical-align: middle; margin-right: 5px;">mark_chat_unread</i>
                                                                    Tandai Belum Dibaca
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <?php if (!empty($dp['unread_count']) && $dp['unread_count'] > 0) : ?>
                                                            <span class="badge" style="top: -5px; right: 2px; position:absolute;">
                                                                <?= $dp['unread_count']; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!-- <div class="chat-btn-wrapper" id="chat-wrapper-<?= $dp['id_pelaporan']; ?>">
                                                        <a class="btn btn-sm btn-info" href="<?= base_url() ?>chat/room/<?= $dp['no_tiket']; ?>" target="_blank" title="Buka Room Chat">
                                                            <i class="material-icons">chat</i>
                                                        </a>
                                                        <?php if (isset($dp['unread_count']) && $dp['unread_count'] > 0) : ?>
                                                            <span class="badge"><?= $dp['unread_count'] ?></span>
                                                        <?php endif; ?>
                                                    </div> -->
                                                    <!-- <a class="btn btn-sm btn-info" href="<?= base_url() ?>chat/room/<?= $dp['no_tiket']; ?>" target="_blank" title="Buka Room Chat">
                                                        <i class="material-icons">chat</i>
                                                    </a> -->
                                                    <a class="btn btn-sm btn-info" href="<?= base_url() ?>klien/detail_pelaporan/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span></a>
                                                    <a class="btn btn-sm btn-primary" href="<?= base_url() ?>export/print_detail/<?= $dp['no_tiket']; ?>"><i class="material-icons">print</i> <span class="icon-name"></span></a>
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
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil ID user yang sedang login dari session PHP
        const myId = <?= $this->session->userdata('id_user'); ?>;

        // Inisialisasi Pusher
        const pusher = new Pusher('<?= PUSHER_APP_KEY ?>', {
            cluster: '<?= PUSHER_APP_CLUSTER ?>',
            encrypted: true
        });

        // Subscribe ke channel notifikasi personal
        const channelName = `user-notifications-${myId}`;
        const channel = pusher.subscribe(channelName);

        // Bind ke event 'update-badge'
        channel.bind('update-badge', function(data) {
            const tiketId = data.tiket_id;
            const unreadCount = data.unread_count;

            // Cari wrapper tombol chat yang sesuai
            const chatWrapper = document.getElementById(`chat-wrapper-${tiketId}`);
            if (!chatWrapper) {
                return; // Jika baris tiket tidak ada di halaman ini, abaikan
            }

            // Hapus badge yang sudah ada
            const existingBadge = chatWrapper.querySelector('.badge');
            if (existingBadge) {
                existingBadge.remove();
            }

            // Jika count > 0, buat dan tambahkan badge baru
            if (unreadCount > 0) {
                const newBadge = document.createElement('span');
                newBadge.className = 'badge';
                newBadge.textContent = unreadCount;
                chatWrapper.appendChild(newBadge);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol 'Tandai Belum Dibaca'
        // Menggunakan event delegation karena tombol dibuat secara dinamis oleh DataTables
        $('#example').on('click', '.mark-as-unread-btn', function(e) {
            e.preventDefault(); // Mencegah aksi default link

            const tiketId = $(this).data('id');

            // Konfirmasi (opsional, tapi disarankan)
            if (!confirm('Anda yakin ingin menandai chat ini sebagai belum dibaca?')) {
                return;
            }

            $.ajax({
                url: "<?= site_url('chat/mark_as_unread') ?>", // URL ke controller baru
                type: 'POST',
                data: {
                    id_pelaporan: tiketId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // atau gunakan notifikasi yang lebih baik seperti SweetAlert

                        // Muat ulang data tabel untuk memperbarui badge notifikasi
                        // Parameter 'null, false' akan me-reload data tanpa kembali ke halaman pertama
                        table.ajax.reload(null, false);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses permintaan.');
                }
            });
        });

        // Kode DataTables dan skrip lain Anda tetap di sini...

    });
</script>