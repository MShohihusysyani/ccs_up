<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- FILTER -->
            <div class="card">
                <div class="header">
                    <h2>FILTER PERIODE</h2>
                </div>
                <div class="body">
                    <?= form_open('superadmin/rekapKategori'); ?>
                    <div class="row clearfix">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <select id="periode" name="periode" class="form-control show-tick" required>
                                    <option value="">-- Pilih Periode --</option>
                                    <option value="1" <?= ($periode == 1) ? 'selected' : ''; ?>>Periode 1 (Jan–Jun)</option>
                                    <option value="2" <?= ($periode == 2) ? 'selected' : ''; ?>>Periode 2 (Jul–Des)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nama_klien">Pilih Klien</label>
                                <select id="nama_klien" name="nama_klien" class="form-control show-tick" data-live-search="true">
                                    <option value="">-- Pilih Klien --</option>
                                    <?php foreach ($klien as $row): ?>
                                        <option value="<?= $row['id_user_klien']; ?>" <?= ($nama_klien == $row['id_user_klien']) ? 'selected' : ''; ?>><?= $row['no_klien'] . ' - ' . $row['nama_klien']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select id="tahun" name="tahun" class="form-control show-tick" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php for ($i = date('Y'); $i >= 2019; $i--): ?>
                                        <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : ''; ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-info">
                                <i class="material-icons">search</i> Tampilkan
                            </button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>

            <?php if (!empty($rekap_kategori)): ?>
                <!-- TABEL REKAP KATEGORI -->
                <div class="card">
                    <div class="header">
                        <h2>REKAP REQUEST BERDASARKAN KATEGORI</h2>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">save</i> <span>Export</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="exportPdfBtn">Export PDF</a></li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example" style="text-align:center;">
                                <thead style="background-color: #c8e6c9;">
                                    <tr>
                                        <th>No</th>
                                        <th style="text-align:center;">Kategori</th>
                                        <?php
                                        $bulan_map = ($periode == 1) ?
                                            ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'] :
                                            ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                        foreach ($bulan_map as $b) echo "<th>{$b}</th>";
                                        ?>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data_kategori = [];
                                    $total_per_bulan = [];
                                    $grand_total = 0;

                                    foreach ($rekap_kategori as $row) {
                                        $kat = ($row['kategori'] == '' || is_null($row['kategori'])) ? '(Tanpa Kategori)' : $row['kategori'];
                                        $bulan = (int)$row['bulan'];
                                        $jumlah = $row['jumlah'];

                                        $data_kategori[$kat][$bulan] = $jumlah;
                                        if (!isset($total_per_bulan[$bulan])) $total_per_bulan[$bulan] = 0;
                                        $total_per_bulan[$bulan] += $jumlah;
                                        $grand_total += $jumlah;
                                    }

                                    // parameter URL
                                    $base_link_params = http_build_query([
                                        'tahun' => $tahun,
                                        'klien' => $nama_klien
                                    ]);

                                    $no = 1;
                                    foreach ($data_kategori as $kategori => $bulan_data) {
                                        $total = 0;
                                        echo "<tr><td>{$no}</td><td style=\"text-align:left;\">{$kategori}</td>";

                                        // URL Encode kategori
                                        $kat_encoded = urlencode($kategori);

                                        for ($i = ($periode == 1 ? 1 : 7); $i <= ($periode == 1 ? 6 : 12); $i++) {
                                            $jml = isset($bulan_data[$i]) ? $bulan_data[$i] : 0;
                                            $total += $jml;

                                            // Buat link jika jumlah > 0
                                            if ($jml > 0) {
                                                // Tambahkan 'kategori' ke link bulan
                                                $link = base_url("superadmin/detailKategori?kategori={$kat_encoded}&bulan={$i}&{$base_link_params}");
                                                echo "<td><a href='{$link}' target='_blank'>{$jml}</a></td>";
                                            } else {
                                                echo "<td>{$jml}</td>";
                                            }
                                        }

                                        // Buat link untuk Total per Kategori
                                        if ($total > 0) {
                                            //Tambahkan 'kategori' ke link total baris
                                            $link = base_url("superadmin/detailKategori?kategori={$kat_encoded}&periode={$periode}&{$base_link_params}");
                                            echo "<td><a href='{$link}' target='_blank'>{$total}</a></td></tr>";
                                        } else {
                                            echo "<td>{$total}</td></tr>";
                                        }

                                        $no++;
                                    }
                                    ?>

                                    <tr style="background-color: #c8e6c9; font-weight: bold;">
                                        <td colspan="2">Total</td>
                                        <?php
                                        for ($i = ($periode == 1 ? 1 : 7); $i <= ($periode == 1 ? 6 : 12); $i++) {
                                            $tot = isset($total_per_bulan[$i]) ? $total_per_bulan[$i] : 0;

                                            //link tanpa ketegori
                                            if ($tot > 0) {
                                                $link = base_url("superadmin/detailKategori?bulan={$i}&{$base_link_params}");
                                                echo "<td><a href='{$link}' target='_blank'>{$tot}</a></td>";
                                            } else {
                                                echo "<td>{$tot}</td>";
                                            }
                                        }

                                        if ($grand_total > 0) {
                                            $link = base_url("superadmin/detailKategori?periode={$periode}&{$base_link_params}");
                                            echo "<td><a href='{$link}' target='_blank'>{$grand_total}</a></td>";
                                        } else {
                                            echo "<td>{$grand_total}</td>";
                                        }
                                        ?>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Form POST tersembunyi untuk Export PDF -->
            <form id="exportPdfForm" method="POST" action="<?= base_url('export/rekap_kategori_pdf'); ?>" target="_blank" style="display:none;">
                <input type="hidden" name="periode" id="exportPeriode">
                <input type="hidden" name="tahun" id="exportTahun">
                <input type="hidden" name="nama_klien" id="exportNama">
            </form>
        </div>
    </div>
</section>

<!-- JavaScript untuk handle export -->
<script>
    document.getElementById('exportPdfBtn')?.addEventListener('click', function(e) {
        e.preventDefault();

        const periode = document.getElementById('periode').value;
        const tahun = document.getElementById('tahun').value;
        const nama_klien = document.getElementById('nama_klien').value;

        if (!periode || !tahun) {
            alert("Silakan pilih Periode dan Tahun terlebih dahulu.");
            return;
        }

        document.getElementById('exportPeriode').value = periode;
        document.getElementById('exportTahun').value = tahun;
        document.getElementById('exportNama').value = nama_klien;

        document.getElementById('exportPdfForm').submit();
    });
</script>