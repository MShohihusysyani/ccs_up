<style>
    ul#notifications-list {
        list-style-type: none;
        /* Menghilangkan bullet */
        padding: 0;
        /* Menghilangkan padding default */
        margin: 0;
        /* Menghilangkan margin default */
    }

    ul#notifications-list li {
        border-bottom: 1px solid #f1f1f1;
        /* Optional: Tambahkan garis bawah antar item */
        padding: 10px 0;
        /* Optional: Atur padding antar item */
    }

    .label-count {
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 3px 6px;
        font-size: 12px;
        position: absolute;
        top: 10px;
        right: 5px;
    }

    #notifications-list {
        max-height: 300px;
        /* Sesuaikan tinggi area notifikasi */
        overflow-y: auto;
        /* Aktifkan scroll jika konten melebihi tinggi */
    }
</style>

<body class="theme-blue">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">CCS | Superadmin</a>

            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span id="notification-count" class="label-count"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu" id="notifications-list">
                                    <!-- Notifikasi akan dimasukkan secara dinamis di sini -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);" id="load-more-btn">Load More</a>
                                <!-- <a href="javascript:void(0);">View All Notifications</a> -->
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        </div>
    </nav>

    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?= base_url('assets/'); ?>images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $this->session->userdata('nama_user'); ?></div>
                    <div class="email"><?= $this->session->userdata('divisi'); ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= base_url() ?>user/profile_superadmin/<?= $this->session->userdata('id_user'); ?>"><i
                                        class="material-icons">person</i>Profile</a>
                            </li>

                            <li>
                                <!-- <?= $this->uri->segment(2) == 'changepassword_superadmin' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?> -->
                                <a href="<?= base_url('user/changepassword_superadmin') ?>"><i
                                        class="material-icons">lock</i>Change Password</a>
                            </li>

                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo site_url('auth/logout') ?>" class="tombol-logout"><i
                                        class="material-icons">logout</i>Sign Out</a>
                            </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN MENU</li>
                    <li class="active">
                        <a href="<?php echo base_url('superadmin') ?>">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li
                        <?= $this->uri->segment(2) == 'category' || $this->uri->segment(2) == 'client' || $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'AktivasiUser'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">storage</i>
                            <span>Kelola Data</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'category' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/category') ?>">Data Kategori</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'client' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/client') ?>">Data BPR</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'user' || $this->uri->segment(2) == 'detail_pelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/user') ?>">Data User</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'AktivasiUser' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('user/AktivasiUser') ?>">Aktivasi User</a>
                            </li>

                        </ul>
                    </li>


                    <li
                        <?= $this->uri->segment(2) == 'AllTicket' || $this->uri->segment(2) == 'added' || $this->uri->segment(2) == 'onprogress' || $this->uri->segment(2) == 'detail_pelaporan' || $this->uri->segment(2) == 'close' || $this->uri->segment(2) == 'finish'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">confirmation_number</i>
                            <span>List Ticket</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'AllTicket' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/AllTicket') ?>">All Ticket</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'added' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/added') ?>">Added</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'onprogress' || $this->uri->segment(2) == 'detail_pelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/onprogress') ?>">On Progress</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'close' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/close') ?>">Close</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'finish' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/finish') ?>">Finish</a>
                            </li>

                        </ul>
                    </li>


                    <li
                        <?= $this->uri->segment(2) == 'rekapPelaporan' || $this->uri->segment(2) == 'datepelaporan' || $this->uri->segment(2) == 'sla' ||  $this->uri->segment(2) == 'rekapProgres' || $this->uri->segment(2) == 'rekapKategori' || $this->uri->segment(2) == 'rekapHelpdesk' || $this->uri->segment(2) == 'rekapProgres'  ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">archive</i>
                            <span>Laporan</span>
                        </a>
                        <ul class="ml-menu">
                            <li
                                <?= $this->uri->segment(2) == 'rekapPelaporan' || $this->uri->segment(2) == 'datepelaporan' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapPelaporan') ?>">Rincian Pelaporan</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'sla' || $this->uri->segment(2) == 'sla' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/sla') ?>">SLA</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'rekaProgres' || $this->uri->segment(2) == 'rekapProgres' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapProgres') ?>">Rekap Progres</a>
                            </li>
                            <li
                                <?= $this->uri->segment(2) == 'rekapKategori' || $this->uri->segment(2) == 'rekapKategori' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapKategori') ?>">Rekap Kategori</a>
                            </li>
                            <!-- 
                            <li
                                <?= $this->uri->segment(2) == 'rekapKategori' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapKategori') ?>">Rekap Kategori</a>
                            </li>

                            <li
                                <?= $this->uri->segment(2) == 'rekapHelpdesk' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapHelpdesk') ?>">Rekap Helpdesk</a>
                            </li> -->

                            <!-- <li
                                <?= $this->uri->segment(2) == 'rekapProgres' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
                                <a href="<?php echo base_url('superadmin/rekapProgres') ?>">Rekap Progres</a>
                            </li> -->

                        </ul>
                    </li>


                    <li class="header">LABELS</li>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-red">donut_large</i>
                            <span>Important</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <span id="year"></span> <a href="javascript:void(0);">Customer Care System | PT MSO</a>.
                </div>
                <div class="version">

                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

        <script>
            document.getElementById("year").innerHTML = new Date().getFullYear();
        </script>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                var limit = 10; // Batas notifikasi yang akan ditampilkan setiap kali load
                var offset = 0; // Offset awal untuk load data
                var totalCount = 0; // Total notifikasi yang ada di server

                function loadNotifications(isLoadMore = false) {
                    $.ajax({
                        url: '<?= base_url("superadmin/fetch_notifications") ?>',
                        method: 'GET',
                        data: {
                            limit: limit,
                            offset: offset
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            var notifications = data.notifications;
                            var unreadCount = data.unread_count;
                            totalCount = data.total_count; // Update total count dari server
                            var notificationsList = '';

                            // Menampilkan jumlah notifikasi di ikon lonceng
                            if (unreadCount > 0) {
                                $('#notification-count').text(unreadCount); // Update jumlah notifikasi
                            } else {
                                $('#notification-count').text(''); // Kosongkan jika tidak ada notifikasi
                            }

                            // Jika ini adalah load awal, hapus semua notifikasi sebelumnya
                            if (!isLoadMore) {
                                $('#notifications-list').html(''); // Kosongkan list notifikasi
                            }

                            // Menampilkan notifikasi baru
                            if (notifications.length > 0) {
                                $.each(notifications, function(index, notification) {
                                    notificationsList += `
                            <li>
                                <a href="<?= base_url('superadmin/added') ?>">
                                    <div class="icon-circle bg-light-green">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <div class="menu-info">
                                        <h4>${notification.no_tiket}</h4>
                                        <p>
                                            <i class="material-icons">access_time</i> ${notification.waktu_pelaporan}
                                        </p>
                                        <p>Status: ${notification.status_ccs}</p>
                                    </div>
                                </a>
                            </li>`;
                                });

                                // Tambahkan notifikasi ke dalam list
                                $('#notifications-list').append(notificationsList);

                                // Mengecek apakah masih ada notifikasi yang belum ditampilkan
                                if ($('#notifications-list li').length < totalCount) {
                                    $('#load-more').show(); // Tampilkan tombol "Load More" jika masih ada notifikasi
                                } else {
                                    $('#load-more').hide(); // Sembunyikan tombol jika semua notifikasi sudah ditampilkan
                                }
                            } else {
                                notificationsList = '<li><p>No new notifications.</p></li>';
                                $('#notifications-list').html(notificationsList);
                            }
                        }
                    });
                }

                // Load notifications saat page load
                loadNotifications();

                // Event listener untuk tombol "Load More"
                $('#load-more').on('click', function() {
                    offset += limit; // Update offset untuk mengambil data berikutnya
                    loadNotifications(true); // Load more notifikasi
                });

                // Bisa juga menambahkan interval untuk auto-refresh notifikasi
                setInterval(function() {
                    offset = 0; // Reset offset saat refresh otomatis
                    loadNotifications(); // Muat ulang notifikasi
                }, 60000); // Setiap 60 detik
            });
        </script>