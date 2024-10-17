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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Basic Examples -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
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
                            <table class="table table-bordered table-striped table-hover" id="example">
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
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('klien/get_data_finish') ?>",
                "type": "POST"
            },
            "order": [
                [2, 'desc'] // Urutkan berdasarkan kolom ke-3 (indeks 2) secara descending
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }]
        });

        // Function to initialize star ratings
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

        // Reinitialize star rating after each DataTable redraw
        $('#example').on('draw.dt', function() {
            initStarRating();
        });
    });
</script>

<!-- <script>
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
</script> -->