<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">
                <div class="header">
                    <h2>FILTER REKAP PETUGAS</h2>
                </div>
                <div class="body">
                    <form method="get" action="">
                        <div class="row clearfix">

                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select id="bulan" name="bulan" class="form-control show-tick">
                                        <?php
                                        $months = [
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember'
                                        ];
                                        foreach ($months as $k => $v) {
                                            $selected = ($k == $filter_bulan) ? 'selected' : '';
                                            echo "<option value='$k' $selected>$v</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select id="tahun" name="tahun" class="form-control show-tick">
                                        <?php
                                        $year_now = date('Y');
                                        // Tampilkan dari tahun sekarang mundur 4 tahun
                                        for ($y = $year_now; $y >= 2019; $y--) {
                                            $selected = ($y == $filter_tahun) ? 'selected' : '';
                                            echo "<option value='$y' $selected>$y</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="user_id">Pilih Petugas</label>
                                    <select id="user_id" name="user_id" class="form-control show-tick" data-live-search="true">
                                        <option value="all">Semua Petugas</option>
                                        <?php foreach ($list_petugas as $p): ?>
                                            <option value="<?= $p->id_user ?>" <?= ($filter_user == $p->id_user) ? 'selected' : ''; ?>>
                                                <?= $p->nama_user ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-sm btn-info waves-effect">
                                    <i class="material-icons">search</i> Tampilkan
                                </button>

                                <button type="submit" name="action" value="excel" class="btn btn-sm btn-success waves-effect">
                                    <i class="material-icons">grid_on</i> Export Excel
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <?php if (isset($rekap)): ?>

                <?php
                // Mengubah header "Bulan Lalu" jadi "Oktober" (misalnya)
                $list_bulan_nama = [
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                ];

                //Tentukan Nama Bulan Ini (Bulan Berjalan)
                $label_bulan_ini = isset($list_bulan_nama[$filter_bulan]) ? $list_bulan_nama[$filter_bulan] : '-';

                //Tentukan Nama Bulan Lalu (Mundur 1 bulan)
                $angka_bulan_lalu = (int)$filter_bulan - 1;

                // Jika hasil 0 (Bulan Januari dikurang 1), maka balik ke 12 (Desember)
                if ($angka_bulan_lalu == 0) {
                    $angka_bulan_lalu = 12;
                }

                // Format angka agar jadi 2 digit string (misal 9 jadi '09') untuk mencocokkan key array
                $key_bulan_lalu = str_pad($angka_bulan_lalu, 2, '0', STR_PAD_LEFT);
                $label_bulan_lalu = isset($list_bulan_nama[$key_bulan_lalu]) ? $list_bulan_nama[$key_bulan_lalu] : '-';
                ?>

                <div class="card">
                    <div class="header">
                        <h2>DATA REKAP PETUGAS (<?= $label_bulan_ini . ' ' . $filter_tahun ?>)</h2>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" style="text-align:left">

                                <thead style="background-color: #d6e3bc; text-align:center; vertical-align: middle;">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">Nama Petugas</th>

                                        <th colspan="3" class="text-center">HANDLE</th>

                                        <th colspan="3" class="text-center">FINISH</th>

                                        <th colspan="2" class="text-center">TOTAL REQUEST</th>

                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">TOTAL AKUMULASI</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="font-size: 12px;">Akumulasi</th>
                                        <th class="text-center" style="font-size: 12px; color: #d32f2f; font-weight:bold;"><?= $label_bulan_lalu ?></th>
                                        <th class="text-center" style="font-size: 12px; color: #1976D2; font-weight:bold;"><?= $label_bulan_ini ?></th>

                                        <th class="text-center" style="font-size: 12px;">Akumulasi</th>
                                        <th class="text-center" style="font-size: 12px; color: #d32f2f; font-weight:bold;"><?= $label_bulan_lalu ?></th>
                                        <th class="text-center" style="font-size: 12px; color: #1976D2; font-weight:bold;"><?= $label_bulan_ini ?></th>

                                        <th class="text-center" style="font-size: 12px; color: #d32f2f; font-weight:bold;"><?= $label_bulan_lalu ?></th>
                                        <th class="text-center" style="font-size: 12px; color: #1976D2; font-weight:bold;"><?= $label_bulan_ini ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($rekap)): ?>
                                        <tr>
                                            <td colspan="11" class="text-center font-bold col-pink">Data tidak ditemukan untuk periode ini.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php
                                        $no = 1;
                                        foreach ($rekap as $r):
                                            $url_detail = site_url('superadmin/detailPetugas');
                                            $id_user    = $r['user_id'];
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td style="font-weight:bold;"><?= $r['nama_petugas']; ?></td>

                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=handle&periode=akumulasi&bulan_batas=<?= $key_bulan_lalu ?>&tahun_batas=<?= $tahun_bulan_lalu ?>" target="_blank" style="font-weight:bold; color:#555;">
                                                        <?= $r['handle_akumulasi']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=handle&periode=bulan&bulan=<?= $key_bulan_lalu ?>&tahun=<?= $tahun_bulan_lalu ?>" target="_blank" class="col-red font-bold">
                                                        <?= $r['handle_prev']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=handle&periode=bulan&bulan=<?= $filter_bulan ?>&tahun=<?= $filter_tahun ?>" target="_blank" class="col-blue font-bold">
                                                        <?= $r['handle_current']; ?>
                                                    </a>
                                                </td>

                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=finish&periode=akumulasi&bulan_batas=<?= $key_bulan_lalu ?>&tahun_batas=<?= $tahun_bulan_lalu ?>" target="_blank" style="font-weight:bold; color:#555;">
                                                        <?= $r['finish_akumulasi']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=finish&periode=bulan&bulan=<?= $key_bulan_lalu ?>&tahun=<?= $tahun_bulan_lalu ?>" target="_blank" class="col-red font-bold">
                                                        <?= $r['finish_prev']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=finish&periode=bulan&bulan=<?= $filter_bulan ?>&tahun=<?= $filter_tahun ?>" target="_blank" class="col-blue font-bold">
                                                        <?= $r['finish_current']; ?>
                                                    </a>
                                                </td>

                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=all&periode=bulan&bulan=<?= $key_bulan_lalu ?>&tahun=<?= $tahun_bulan_lalu ?>" target="_blank" class="col-red font-bold">
                                                        <?= $r['total_req_prev']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=all&periode=bulan&bulan=<?= $filter_bulan ?>&tahun=<?= $filter_tahun ?>" target="_blank" class="col-blue font-bold">
                                                        <?= $r['total_req_current']; ?>
                                                    </a>
                                                </td>

                                                <td class="text-left font-bold">
                                                    <a href="<?= $url_detail ?>?user=<?= $id_user ?>&status=all&periode=total_semua" target="_blank" style="color:#000;">
                                                        <?= $r['total_grand_akumulasi']; ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>

                                <tfoot style="font-size: 11px; color: #777;">
                                    <tr id="row-total">
                                        <th colspan="2">TOTAL</th>
                                        <th style="text-align: center"><?= $total_akumulasi_handle ?></th>
                                        <th style="text-align: center"><?= $total_handle_prev ?></th>
                                        <th style="text-align: center"><?= $total_handle_current ?></th>
                                        <th style="text-align: center"><?= $total_akumulasi_finish ?></th>
                                        <th style="text-align: center"><?= $total_finish_prev ?></th>
                                        <th style="text-align: center"><?= $total_finish_current ?></th>
                                        <th style="text-align: center"><?= $total_request_prev ?></th>
                                        <th style="text-align: center"><?= $total_request_current ?></th>
                                        <th style="text-align: center"><?= $grand_total ?></th>
                                    </tr>
                                    <tr>
                                        <td colspan="11">
                                            * <b>Akumulasi</b>: Total data dari awal waktu sampai sebelum bulan <?= $label_bulan_lalu ?>.<br>
                                            * <b><?= $label_bulan_lalu ?></b>: Data 1 bulan sebelum periode terpilih.<br>
                                            * <b><?= $label_bulan_ini ?></b>: Data pada bulan berjalan yang dipilih.
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
<script>
    $(function() {
        // Cek apakah tabel sudah ada, jika iya hancurkan dan buat ulang dengan config baru
        if ($.fn.DataTable.isDataTable('.js-basic-example')) {
            $('.js-basic-example').DataTable().destroy();
        }

        $('.js-basic-example').DataTable({
            responsive: true,
            destroy: true, // Izinkan inisialisasi ulang
            "drawCallback": function(settings) {
                var api = this.api();
                var pageInfo = api.page.info();

                // Logic menampilkan baris total hanya di halaman terakhir
                if (pageInfo.pages > 0 && pageInfo.page === (pageInfo.pages - 1)) {
                    $('#row-total').show();
                } else {
                    $('#row-total').hide();
                }
            }
        });
    });
</script>