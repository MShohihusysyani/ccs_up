<!-- <style>
    .table .mode-fokus {
        background-color: #d1e7dd !important;
        /* Hijau muda */
    }

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
</style> -->
<style>
    .table .current-task {
        background-color: #d1e7dd !important;
        /* Hijau muda */
    }

    /* Letakkan ini di file CSS Anda atau di dalam tag <style> di view */
    .chat-btn-wrapper {
        position: relative;
        /* Wajib ada, sebagai acuan untuk badge */
        display: inline-flex;
        /* Agar wrapper pas dengan ukuran tombol */
        vertical-align: middle;
    }

    .chat-btn-wrapper .badge {
        position: absolute;
        /* Posisi 'melayang' di atas wrapper */
        top: -8px;
        /* Atur posisi vertikal (sedikit ke atas dari sudut) */
        right: -8px;
        /* Atur posisi horizontal (sedikit ke kanan dari sudut) */

        /* ===================================================================== */
        /* PENTING: Angka ini membawa badge ke lapisan paling atas */
        z-index: 10;
        /* ===================================================================== */

        /* Styling tambahan agar terlihat bagus seperti di WA */
        padding: 4px;
        font-size: 10px;
        font-weight: bold;
        line-height: 1;
        color: white;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        background-color: #F44336;
        /* Warna merah */
        border-radius: 50%;
        /* Membuatnya bulat sempurna */
        min-width: 18px;
        /* Agar tetap bulat walau 1 digit */
        height: 18px;
        /* Agar tetap bulat walau 1 digit */
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2></h2>
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
                            <h2>FORWARD</h2>
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
                                            <!-- <th>Impact</th> -->
                                            <!-- <th>Attachment</th> -->
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
                                            <!-- <th>Impact</th> -->
                                            <!-- <th>Attachment</th> -->
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
                                        foreach ($datapelaporan as $dp) :
                                            // Assuming $dp['subtasks'] is an array of subtask data

                                        ?>
                                            <tr class="<?= $dp['mode_fokus'] ? 'mode-fokus' : ''; ?>">
                                                <td><?= $no++ ?></td>
                                                <td><?= $dp['no_tiket']; ?></td>
                                                <td><?= tanggal_indo($dp['waktu_pelaporan']) ?></td>
                                                <td><?= $dp['nama']; ?></td>
                                                <td><?= $dp['judul']; ?></td>
                                                <!-- <td><?= $dp['impact']; ?></td> -->
                                                <!-- <td>
                                                    <?php if (!empty($dp['file'])) : ?>
                                                        <a href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                                    <?php endif; ?>
                                                </td> -->
                                                <td><?= $dp['kategori']; ?></td>
                                                <td>
                                                    <?php if ($dp['priority'] == 'Low') : ?>
                                                        <span class="label label-info">Low</span>
                                                    <?php elseif ($dp['priority'] == 'Medium') : ?>
                                                        <span class="label label-warning">Medium</span>
                                                    <?php elseif ($dp['priority'] == 'High') : ?>
                                                        <span class="label label-danger">High</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($dp['maxday'] == '90') : ?>
                                                        <span class="label label-info">90</span>
                                                    <?php elseif ($dp['maxday'] == '60') : ?>
                                                        <span class="label label-warning">60</span>
                                                    <?php elseif ($dp['maxday'] == '7') : ?>
                                                        <span class="label label-danger">7</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($dp['status_ccs'] == 'FINISHED') : ?>
                                                        <span class="label label-success">FINISHED</span>
                                                    <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                        <span class="label label-warning">CLOSED</span>
                                                    <?php elseif ($dp['status_ccs'] == 'HANDLED') : ?>
                                                        <span class="label label-info">HANDLED</span>
                                                    <?php elseif ($dp['status_ccs'] == 'HANDLED 2') : ?>
                                                        <span class="label label-info">HANDLED 2</span>
                                                    <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                        <span class="label label-primary">ADDED</span>
                                                    <?php elseif ($dp['status_ccs'] == 'ADDED 2') : ?>
                                                        <span class="label label-primary">ADDED 2</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $dp['handle_by']; ?>
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
                                                    <a class="btn btn-xs btn-info" href="<?= base_url() ?>helpdesk/detail_pelaporann/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span></a>
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