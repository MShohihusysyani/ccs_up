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
                    <?= form_open('superadmin/rekapProgres'); ?>
                    <div class="row clearfix">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="periode">Periode</label>
                            <select id="periode" name="periode" class="form-control show-tick" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="1" <?= ($periode == 1) ? 'selected' : ''; ?>>Periode 1 (Jan–Jun)</option>
                                <option value="2" <?= ($periode == 2) ? 'selected' : ''; ?>>Periode 2 (Jul–Des)</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="tahun">Tahun</label>
                            <select id="tahun" name="tahun" class="form-control show-tick" required>
                                <option value="">-- Pilih Tahun --</option>
                                <?php for ($i = date('Y'); $i >= 2019; $i--): ?>
                                    <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : ''; ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="margin-top: 25px;">
                            <button type="submit" class="btn btn-sm btn-info">
                                <i class="material-icons">search</i> Tampilkan
                            </button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>

            <!-- TABEL REKAP (Hanya tampil jika filter sudah dipilih) -->
            <?php if (!empty($periode) && !empty($tahun) && !empty($rekap)): ?>
                <div class="card">
                    <div class="header">
                        <h2>REKAP PROGRES</h2>
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
                            <table class="table table-bordered table-hover" style="text-align:center">
                                <thead style="background-color: #dcedc8;">
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Finished</th>
                                        <th>Handled</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_finished = 0;
                                    $total_handled = 0;
                                    $total_all = 0;
                                    $no = 1;
                                    foreach ($rekap as $row):
                                        $total_finished += $row['finished'];
                                        $total_handled += $row['handled'];
                                        $total_all += $row['total'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['bulan']; ?></td>
                                            <td><?= $row['finished']; ?></td>
                                            <td><?= $row['handled']; ?></td>
                                            <td><?= $row['total']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="background-color: #dcedc8;">
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th><?= $total_finished; ?></th>
                                        <th><?= $total_handled; ?></th>
                                        <th><?= $total_all; ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form POST tersembunyi untuk Export PDF -->
            <form id="exportPdfForm" method="POST" action="<?= base_url('export/rekap_progres_pdf'); ?>" target="_blank" style="display:none;">
                <input type="hidden" name="periode" id="exportPeriode">
                <input type="hidden" name="tahun" id="exportTahun">
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

        if (!periode || !tahun) {
            alert("Silakan pilih Periode dan Tahun terlebih dahulu.");
            return;
        }

        document.getElementById('exportPeriode').value = periode;
        document.getElementById('exportTahun').value = tahun;

        document.getElementById('exportPdfForm').submit();
    });
</script>