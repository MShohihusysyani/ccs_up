<style>
    .stars {
    font-size: 24px;
}

.star {
    cursor: pointer;
    color: #ccc;
}

.star.active {
    color: #ffdd00;
}

</style>
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
                                        <th>No Tiket</th>
                                        <th>Perihal</th>
                                        <th>Attachment</th>
                                        <th>Category</th>
                                        <th>Tags</th>
                                        <th>Priority</th>
                                        <th>Max Day</th>
                                        <th>Status CCS</th>
                                        <th>Aksi</th>
                                        <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php
                                    $no = 1;
                                    foreach ($datapelaporan as $divp) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= tanggal_indo($divp['waktu_pelaporan']); ?></td>
                                        <td><?= $divp['no_tiket'];?></td>
                                        <td><?= $divp['perihal']; ?></td>
                                        <td> <a
                                                href="<?= base_url('assets/files/' . $divp['file']); ?>"><?= $divp['file']; ?></a>
                                        </td>
                                        <td><?= $divp['kategori'];?></td>
                                        <td>
                                            <span class="label label-info"><?= $divp['tags'];?></span>
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

                                                <?php elseif ($divp['status_ccs'] == 'HANDLE 2') : ?>
                                                    <span class="label label-info">HANDLE 2</span>

                                                <?php elseif ($divp['status_ccs'] == 'ADDED') : ?>
                                                    <span class="label label-primary">ADDED</span>
                                                
                                                <?php elseif ($divp['status_ccs'] == 'ADDED 2') : ?>
                                                    <span class="label label-primary">ADDED 2</span> 

                                                <?php else : ?>
                                                <?php endif; ?>
                                            
                                            </td>
                                        
                                        <!-- <?php $this->session->set_userdata('referred_from', current_url()); ?> -->
                                        <td>
                                        <a class="btn btn-xs btn-info"
                                                href="<?= base_url() ?>klien/edit_pelaporan/<?= $divp['id_pelaporan']; ?>"><i
                                                    class="material-icons">visibility</i> <span
                                                    class="icon-name"></span>Detail</a>
                                        </td>
                                        <td>
                                                <div id="ratingForm">
                                                    <input type="hidden" id="id_pelaporan" name="id_pelaporan" value="<?= $divp['id_pelaporan'];?>">
                                                    <!-- <input type="hidden" id="user_id" name="user_id" value="<?= $user['id_user'];?>"> -->
                                                        <div class="stars" id="rating" name="rating">
                                                                <span class="star" data-value="kecewa">&#9733;</span>
                                                                <span class="star" data-value="cukup">&#9733;</span>
                                                                <span class="star" data-value="cukup">&#9733;</span>
                                                                <span class="star" data-value="bagus">&#9733;</span>
                                                                <span class="star" data-value="bagus">&#9733;</span>
                                                        </div>
                                                </div>
                                                <div id="message"></div>
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
    $('.star').on('click', function() {
        // var rating = $('#rating').val();
        var id_pelaporan = $('#id_pelaporan').val();
        var rating = $(this).attr('data-value');
        
        $.ajax({
            url: '<?= base_url('klien/insert_rating2') ?>',
            type: 'POST',
            data: {
                id_pelaporan: id_pelaporan,
                rating: rating
            },
            success: function(response) {
                $('#message').html('Rating saved successfully!');
                // Optionally, you can update the UI here to reflect the new rating
            },
            error: function(xhr, status, error) {
                $('#message').html('Error saving rating: ' + error);
            }
        });
    });

    // Highlight stars on hover
    $('.star').hover(function() {
        $(this).prevAll().addBack().addClass('active');
    }, function() {
        $(this).prevAll().addBack().removeClass('active');
    });
});
</script>

