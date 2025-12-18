<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="card">
                <div class="header">
                    <h2>FILTER REKAP KLIEN</h2>
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
                        <h2>DATA REKAP KLIEN 20 BESAR (<?= $label_bulan_ini . ' ' . $filter_tahun ?>)</h2>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" style="text-align:left">

                                <thead style="background-color: #d6e3bc; text-align:center; vertical-align: middle;">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; text-align:center;">No</th>
                                        <th colspan="3" class="text-center">Jumalah Request</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle; text-align:center;">Kode Klien</th>
                                        <th style="vertical-align: middle; text-align:center;">Nama Klien</th>
                                        <th class="text-center" style="font-size: 12px;font-weight:bold;"><?= $label_bulan_ini ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($rekap)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center font-bold col-pink">Data tidak ditemukan untuk periode ini.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php
                                        $no = 1;
                                        foreach ($rekap as $r):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= $r['no_klien']; ?></td>
                                                <td class="text-left"><?= $r['nama_klien']; ?></td>
                                                <td class="text-center">
                                                    <?= $r['klien_current']; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('.js-basic-example')) {
            $('.js-basic-example').DataTable().destroy();
        }

        $('.js-basic-example').DataTable({
            "ordering": false, // Disarankan false agar urutan grouping tidak rusak saat di-sort
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                var startIdx = 0;

                api.column(3, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last === group) {
                        // 1. Tambahkan Rowspan pada baris pertama di grup ini
                        var firstRowInGroup = $(rows).eq(startIdx).find('td:nth-child(1)');
                        var currentRs = parseInt(firstRowInGroup.attr('rowspan')) || 1;
                        firstRowInGroup.attr('rowspan', currentRs + 1).css('vertical-align', 'middle');

                        // 2. Hapus TD No pada baris saat ini (baris duplikat)
                        // Gunakan .hide() atau .remove(). 
                        // Jika menggunakan .remove(), pastikan urutan kolom tetap terjaga.
                        $(rows).eq(i).find('td:first-child').remove();

                    } else {
                        // Ganti grup baru
                        last = group;
                        startIdx = i;
                    }
                });
            }
        });
    });
</script>