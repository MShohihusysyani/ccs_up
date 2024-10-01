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
                                            <!-- <th>Perihal</th> -->
                                            <!-- <th>Attachment</th> -->
                                            <th>Category</th>
                                            <!-- <th>Tags</th> -->
                                            <th>Priority</th>
                                            <!-- <th>Impact</th> -->
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>
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
                                            <!-- <th>Tags</th> -->
                                            <th>Priority</th>
                                            <!-- <th>Impact</th> -->
                                            <th>Max Day</th>
                                            <th>Status CCS</th>
                                            <th>Handle By</th>
                                            <th>Rating</th>
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
                                                <!-- <td>
                                                    <?php
                                                    $file_path = base_url('assets/files/' . $dp['file']);
                                                    $file_ext = pathinfo($dp['file'], PATHINFO_EXTENSION);

                                                    if (in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                        <a href="#" data-toggle="modal" data-target="#imageModal<?= $dp['id_pelaporan']; ?>">
                                                            <img src="<?= $file_path; ?>" alt="<?= $dp['file']; ?>" style="max-width: 150px;">
                                                        </a>

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
                                                <!-- <td><?= $dp['perihal']; ?></td> -->
                                                <td><?= $dp['kategori']; ?></td>
                                                <!-- <td>
                                                    <?php if (!empty($dp['tags'])): ?>
                                                        <span class="label label-info">
                                                            <?= $dp['tags']; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </td> -->
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
                                                    <div class="star-rating" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>" data-has-rated="<?= $dp['has_rated'] ? 'true' : 'false'; ?>" data-rating="<?= $dp['rating']; ?>">
                                                        <span class="star" data-value="1">&#9733;</span>
                                                        <span class="star" data-value="2">&#9733;</span>
                                                        <span class="star" data-value="3">&#9733;</span>
                                                        <span class="star" data-value="4">&#9733;</span>
                                                        <span class="star" data-value="5">&#9733;</span>
                                                    </div>
                                                </td>
                                                <td><a class="btn btn-sm btn-info" href="<?= base_url() ?>klien/detail_finish/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>
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
        <!-- Button trigger modal -->
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var initStarRating = function() {
            $('.star-rating').each(function() {
                var $ratingContainer = $(this);
                var rating = $ratingContainer.data('rating'); // Get current rating
                var hasRated = $ratingContainer.data('has-rated'); // Check if already rated

                // Highlight the stars based on the current rating
                if (rating) {
                    $ratingContainer.find('.star').each(function() {
                        var starValue = $(this).data('value');
                        if (starValue <= rating) {
                            $(this).addClass('selected');
                        } else {
                            $(this).removeClass('selected');
                        }
                    });
                }

                // Enable or disable star clicks based on whether it has been rated
                if (hasRated) {
                    $ratingContainer.find('.star').css('cursor', 'default').off('click');
                } else {
                    $ratingContainer.find('.star').css('cursor', 'pointer').off('click').on('click', function() {
                        var $star = $(this);
                        var selectedRating = $star.data('value');
                        var id_pelaporan = $ratingContainer.data('id_pelaporan');

                        // Send the selected rating to the server via AJAX
                        $.ajax({
                            url: '<?= base_url("klien/rating"); ?>',
                            type: 'POST',
                            data: {
                                id_pelaporan: id_pelaporan,
                                rating: selectedRating
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert('Rating submitted successfully');

                                    // Update the UI to reflect the rating
                                    $ratingContainer.find('.star').removeClass('selected');
                                    $star.prevAll('.star').addBack().addClass('selected');

                                    // Disable further rating for this ticket
                                    $ratingContainer.find('.star').off('click').css('cursor', 'default');
                                    $ratingContainer.data('has-rated', true);
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error("Failed to submit rating:", textStatus, errorThrown);
                                alert('Failed to submit rating: ' + textStatus + ' - ' + errorThrown);
                            }
                        });
                    });
                }
            });
        };

        // Initialize star ratings on page load
        initStarRating();

        // Reinitialize star rating after each DataTable redraw (if using DataTables)
        $('#example').on('draw.dt', function() {
            initStarRating();
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        var initStarRating = function() {
            $('.star-rating').each(function() {
                var hasRated = $(this).data('has-rated');

                if (hasRated) {
                    $(this).find('.star').addClass('selected').css('cursor', 'default');
                    $(this).off('click');
                } else {
                    $(this).find('.star').css('cursor', 'pointer');
                }
            });

            $('.star').off('click').on('click', function() {
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
        };

        // Initialize star rating on page load
        initStarRating();

        // Reinitialize star rating after each DataTable redraw
        $('#example').on('draw.dt', function() {
            initStarRating();
        });
    });
</script> -->