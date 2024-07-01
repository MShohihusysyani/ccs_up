<!-- Button trigger modal -->
<style>
    .star-rating {
        display: inline-block;
    }

    .star {
        cursor: pointer;
        color: gray;
        font-size: 20px;
    }

    .star.selected {
        color: gold;
    }

    .star-rating .star.selected {
        font-size: 30px;
        /* Sesuaikan ukuran sesuai kebutuhan Anda */
        color: gold;
        /* Warna emas untuk bintang */
    }
</style>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
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
                                FINISH
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
                                            <th>Perihal</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Impact</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Tiket</th>
                                            <th>Tanggal</th>
                                            <th>Nama Klien</th>
                                            <th>Judul</th>
                                            <th>Perihal</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Priority</th>
                                            <th>Impact</th>
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>
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
                                                <td><?= $dp['perihal']; ?></td>
                                                <td><?= $dp['kategori']; ?></td>
                                                <td>
                                                    <span class="label label-info">
                                                        <?= $dp['tags']; ?>
                                                    </span>
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
                                                <td><?= $dp['impact']; ?></td>
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
                                                    <?php if ($dp['status_ccs'] == 'FINISH') : ?>
                                                        <span class="label label-success">FINISH</span>

                                                    <?php elseif ($dp['status_ccs'] == 'CLOSE') : ?>
                                                        <span class="label label-warning">CLOSE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'HANDLE') : ?>
                                                        <span class="label label-info">HANDLE</span>

                                                    <?php elseif ($dp['status_ccs'] == 'ADDED') : ?>
                                                        <span class="label label-primary">ADDED</span>

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
                                                <!-- <td>
                                                    <div class="star-rating" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>">
                                                        <span class="fa fa-star-o" data-rating="1"></span>
                                                        <span class="fa fa-star-o" data-rating="2"></span>
                                                        <span class="fa fa-star-o" data-rating="3"></span>
                                                        <span class="fa fa-star-o" data-rating="4"></span>
                                                        <span class="fa fa-star-o" data-rating="5"></span>
                                                        <input type="hidden" name="rating" class="rating-value" value="<?= $dp['rating']; ?>">
                                                    </div>
                                                </td> -->
                                                <td>
                                                    <div class="star-rating" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>" data-has-rated="<?= $dp['has_rated'] ? 'true' : 'false'; ?>">
                                                        <span class="star" data-value="1">&#9733;</span>
                                                        <span class="star" data-value="2">&#9733;</span>
                                                        <span class="star" data-value="3">&#9733;</span>
                                                        <span class="star" data-value="4">&#9733;</span>
                                                        <span class="star" data-value="5">&#9733;</span>
                                                    </div>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.star-rating').each(function() {
            var hasRated = $(this).data('has-rated');

            if (hasRated) {
                $(this).find('.star').addClass('selected').css('cursor', 'default');
                $(this).off('click');
            }
        });

        $('.star').on('click', function() {
            var $star = $(this);
            var rating = $star.data('value');
            var $ratingContainer = $star.closest('.star-rating');
            var id_pelaporan = $ratingContainer.data('id_pelaporan');
            var hasRated = $ratingContainer.data('has-rated');

            if (hasRated) {
                return; // Prevent rating if already rated
            }

            // Send the rating to the server
            $.ajax({
                url: '<?= base_url("klien/rating"); ?>',
                type: 'POST',
                data: {
                    id_pelaporan: id_pelaporan,
                    rating: rating
                },
                success: function(response) {
                    // Handle the response
                    if (response.status === 'success') {
                        alert('Rating submitted successfully');

                        // Update the UI
                        $ratingContainer.find('.star').removeClass('selected');
                        $star.prevAll('.star').addBack().addClass('selected');

                        // Prevent further clicks
                        $ratingContainer.find('.star').off('click').css('cursor', 'default');
                        $ratingContainer.data('has-rated', true);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle the error
                    console.error("Failed to submit rating", textStatus, errorThrown);
                    console.error("Response:", jqXHR.responseText);
                    alert('Failed to submit rating: ' + textStatus + ' - ' + errorThrown);
                }
            });

        });
    });
</script>




<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include jQuery Star Rating Plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $(document).ready(function() {
        $('.star-rating .fa').on('click', function() {
            var rating = $(this).data('rating');
            var id_pelaporan = $(this).parent().data('id_pelaporan');
            $(this).siblings('input.rating-value').val(rating);
            $(this).siblings('.fa').removeClass('fa-star').addClass('fa-star-o');
            $(this).prevAll('.fa').addClass('fa-star').removeClass('fa-star-o');
            $(this).addClass('fa-star').removeClass('fa-star-o');

            // Log data before AJAX request
            console.log('ID:', id_pelaporan, 'Rating:', rating);

            // AJAX request to save rating
            $.ajax({
                url: '<?= base_url("klien/save_rating") ?>',
                type: 'post',
                data: {
                    id_pelaporan: id_pelaporan,
                    rating: rating
                },
                success: function(response) {
                    console.log(response);
                    alert('Rating saved!');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>