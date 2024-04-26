<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
         <?php if ($this->session->flashdata('pesan')) { ?>

         <?php } ?>
           
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Data Pelaporan
                        </h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-basic-example"
                                id="example">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pelaporan</th>
                                        <th>Perihal</th>
                                        <th>Attachment</th>
                                        <th>Priority</th>
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    <?php
                                    $no = 1;
                                    foreach ($datapelaporan as $divp) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= tanggal_indo($divp['waktu_pelaporan']); ?></td>
                                        <!-- <td><?= $divp['status']; ?></td> -->
                                        <td><?= $divp['perihal']; ?></td>
                                        <td> <a
                                                href="<?= base_url('assets/files/' . $divp['file']); ?>"><?= $divp['file']; ?></a>
                                        </td>
                                        <td>
                                                <?php if ($divp['priority'] == 'Low') : ?>
                                                    <span class="label label-info">Low</span>

                                                <?php elseif ($divp['priority'] == 'Medium') : ?>
                                                    <span class="label label-warning">Medium</span>

                                                <?php elseif ($divp['priority'] == 'High') : ?>
                                                    <span class="label label-danger">High</span>
                                               

                                                <?php else : ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($divp['maxday'] == '90') : ?>
                                                    <span class="label label-info">90</span>

                                                <?php elseif ($divp['maxday'] == '60') : ?>
                                                    <span class="label label-warning">60</span>

                                                <?php elseif ($divp['maxday'] == '7') : ?>
                                                    <span class="label label-danger">7</span>
                                               

                                                <?php else : ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($divp['status_ccs'] == 'FINISH') : ?>
                                                    <span class="label label-success">FINISH</span>

                                                <?php elseif ($divp['status_ccs'] == 'CLOSE') : ?>
                                                    <span class="label label-warning">CLOSE</span>

                                                <?php elseif ($divp['status_ccs'] == 'HANDLE') : ?>
                                                    <span class="label label-info">HANDLE</span>

                                                <?php elseif ($divp['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>

                                                <?php else : ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                        
                                        <!-- <?php $this->session->set_userdata('referred_from', current_url()); ?> -->
                                        <td>

                                            
                                        <a class="btn btn-xs btn-info"
                                                href="<?= base_url() ?>klien/edit_pelaporan/<?= $divp['id_pelaporan']; ?>"><i
                                                    class="material-icons">visibility</i> <span
                                                    class="icon-name"></span>
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
</section>


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#nama_brg').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '<?= base_url() ?>admin/barangList',
                type: 'post',
                dataType: 'json',
                data: {
                    search: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $('#nama_brg').val(ui.item.label);
            $('#id').val(ui.item.value);

            return false;
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on('click', '#pilih', function() {
        var nama_barang = $(this).data('barang');
        var id = $(this).data('id');
        $('#nama_brg').val(nama_barang);
        $('#barang_id').val(id);
        $('#defaultModal').modal('hide');
    })
});
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#jumlah, #harga").keyup(function() {
        var harga = $("#harga").val();
        var jumlah = $("#jumlah").val();

        var total = parseInt(harga) * parseInt(jumlah);
        $("#total").val(total);
    });
});
</script>