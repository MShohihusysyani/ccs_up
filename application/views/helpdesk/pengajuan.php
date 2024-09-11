<section class="content">
    <div class="container-fluid">
        <div class="alert alert-lg alert-info"> <i class="material-icons">report</i>
            <strong>Peringatan!</strong> Sebelum mengajukan tiket yang baru, <strong>Dimohon</strong> untuk mengajukan tiket yang sudah diproses terlebih dahulu. Agar tiket yang baru dapat diproses!!!
        </div>
        <div class="block-header">
            <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <div class="eror" data-eror="<?= $this->session->flashdata('alert') ?>">
                    <?php if ($this->session->flashdata('pesan')) { ?>

                    <?php } ?>
                </div>

                <!-- jQuery UI CSS -->
                <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">


                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Input Pelaporan </h2>
                        </div>
                        <div class="body">
                            <form method="post" action="<?= base_url('helpdesk/add_temp_tiket'); ?>" enctype="multipart/form-data">
                                <!-- Dropdown Pilih Klien -->

                                <!-- <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien"
                                            name="nama_klien" id="nama_klien" placeholder="Pilih BPR"
                                            class="form-control" value="" autocomplete="off">
                                        <input type="hidden" id="klien_id" name="klien_id">
                                    </div>
                                </div> -->

                                <label for="klien">Pilih Klien</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="klien" name="klien" class="form-control" required>
                                            <option value="">-- Pilih Klien --</option>
                                            <?php foreach ($klien as $u) : ?>
                                                <option value="<?= $u['id_user_klien']; ?>"><?= $u['nama_klien']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Hidden input untuk id_user KLIEN -->
                                <input type="hidden" id="klien_id" name="klien_id">
                                <!-- Hidden input untuk nama_user klien -->
                                <input type="hidden" id="nama_klien" name="nama_klien">

                                <!-- No Tiket (Akan Terisi Otomatis) -->
                                <label for="judul">No Tiket</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="no_tiket" name="no_tiket" class="form-control" placeholder="" readonly>
                                    </div>
                                </div>


                                <label for="judul">Judul</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan Judul">
                                    </div>
                                </div>
                                <br>

                                <label for="perihal">Perihal</label>
                                <textarea id="editor" class="form-control" name="perihal" id="perihal" rows="10" required>

                                </textarea>

                                <label for="nama">File (jpg/jpeg/png/pdf/xlsx/docx) max 2mb</label>
                                <div class="form-group">
                                    <label for="exampleInputFile"></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file">
                                            <label for="file" class="custom-file-label">Choose
                                                file</label>
                                        </div>
                                    </div>
                                </div>

                                <label for="kategori">Category</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#modalPilihKategori" name="kategori" id="kategori" placeholder="" class="form-control ui-autocomplete-input" value="" autocomplete="off" readonly>
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>

                                <label for="tags">Tags</label>
                                <div class="form-group demo-tagsinput-area">
                                    <div class="form-line">
                                        <input type="text" class="form-control" data-role="tagsinput" value="" id="tags" name="tags">
                                    </div>
                                </div>
                                <!-- Hidden input untuk user_id_helpdesk -->
                                <input type="hidden" name="user_id_hd" id="user_id_hd" value="<?= $user_hd['id_user']; ?>">

                                <div class="js-sweetalert">
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect" data-type="with-custom-icon">Proses</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Data Pengajuan
                                    </h2>

                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-basic-example" id="example">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>No Tiket</th>
                                                    <th>Judul</th>
                                                    <th>Nama</th>
                                                    <!-- <th>Perihal</th> -->
                                                    <th>Attachment</th>
                                                    <th>kategori</th>
                                                    <th>Tags</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($tiket_temp as $tmp) : ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?= $tmp['no_tiket']; ?></td>
                                                        <td><?= $tmp['judul']; ?></td>
                                                        <td><?= $tmp['nama']; ?></td>
                                                        <!-- <td><?= $tmp['perihal']; ?></td> -->
                                                        <td> <a href="<?= base_url('assets/files/' . $tmp['file']); ?>"><?= $tmp['file']; ?></a>
                                                        </td>
                                                        <td><?= $tmp['kategori']; ?></td>
                                                        <td>
                                                            <span class="label label-info" data-role="tagsinput"><?= $tmp['tags']; ?></span>
                                                        </td>
                                                        <td>

                                                            <a class="btn btn-sm btn-warning" href="<?= base_url() ?>helpdesk/edit_tiket_temp/<?= $tmp['id_temp']; ?>"><i class="material-icons">edit</i> <span class="icon-name"></span>Edit</a>
                                                            <br><br>
                                                            <a class="btn btn-sm btn-info" href="<?= base_url() ?>helpdesk/preview/<?= $tmp['id_temp']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>Detail</a>
                                                            <br><br>
                                                            <a class="btn btn-sm btn-danger tombol-hapus" href="<?= base_url() ?>helpdesk/fungsi_delete_temp/<?= $tmp['id_temp']; ?>"><span class="fa fa-trash tombol-hapus"></span>
                                                                Hapus</a>


                                                        </td>

                                                    </tr>

                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <form method="post" action="<?= base_url('helpdesk/fungsi_pengajuan') ?>">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Ajukan</button>
                                            <!-- <input type="hidden" id="user_id" name="user_id"> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Data Pengajuan -->
                </div>
            </div>
</section>


<!-- Modal Cari Klien -->
<div class="modal fade" id="defaultModalNamaKlien" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Klien</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Klien</th>
                            <th>Nama Klien</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($klien as $cln) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row"><?= $i; ?></td>
                                <td><?= $cln['no_klien']; ?></td>
                                <td><?= $cln['nama_klien']; ?></td>
                                <td class="hide"><?= $cln['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info pilih-klien" id="pilih3" data-nama-klien="<?= $cln['nama_klien']; ?>" data-id-namaklien="<?= $cln['id']; ?>" data-kodeklien="<?= $cln['no_klien']; ?>">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal cari kategori -->
<div class="modal fade" id="modalPilihKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Kategori</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($category as $cat) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row">
                                    <?= $i; ?>
                                </td>
                                <td><?= $cat['nama_kategori']; ?></td>
                                <td class="hide"><?= $cat['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilihKategori" data-nama-kategori="<?= $cat['nama_kategori']; ?>" data-id-kategori="<?= $cat['id']; ?>">
                                        Pilih</button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#pilih3', function() {
            var nama_klas = $(this).data('nama-klien');
            var id = $(this).data('id');
            $('#nama_klien').val(nama_klas);
            $('#id').val(id);
            $('#defaultModalNamaKlien').modal('hide');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#klien').change(function() {
            var user_id = $(this).val(); // Ambil value id_user dari klien yang dipilih
            var nama_klien = $('#klien option:selected').text(); // Ambil nama klien dari option yang dipilih

            if (user_id !== "") {
                $.ajax({
                    url: '<?= base_url("helpdesk/get_no_tiket"); ?>', // Ganti URL ini dengan URL ke controller yang benar
                    type: 'POST',
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('#no_tiket').val(response); // Tampilkan nomor tiket di input
                        $('#klien_id').val(user_id); // Isi hidden input klien_id
                        $('#nama_klien').val(nama_klien); // Isi hidden input nama_klien
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Menangani error jika terjadi
                    }
                });
            } else {
                $('#no_tiket').val(''); // Jika tidak ada klien yang dipilih, kosongkan input
                $('#klien_id').val(''); // Kosongkan hidden input klien_id
                $('#nama_klien').val(''); // Kosongkan hidden input nama_klien
            }
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        // Trigger when a client is selected from the modal
        $('.pilih-klien').on('click', function() {
            var user_id = $(this).data('id-namaklien'); // Get the user_id from the data attribute
            var nama_klien = $(this).data('nama-klien'); // Get the nama_klien from the data attribute

            // Populate the form fields with client data
            $('#klien_id').val(user_id);
            $('#nama_klien').val(nama_klien);

            if (user_id !== "") {
                // AJAX request to get the No Tiket
                $.ajax({
                    url: '<?= base_url("helpdesk/get_no_tiket"); ?>', // URL to your controller
                    type: 'POST',
                    data: {
                        user_id: user_id
                    },
                    success: function(response) {
                        $('#no_tiket').val(response); // Fill in the No Tiket field
                    },
                    error: function(xhr, status, error) {
                        console.error(error); // Handle any errors
                    }
                });
            } else {
                // Clear fields if no client is selected
                $('#no_tiket').val('');
                $('#klien_id').val('');
                $('#nama_klien').val('');
            }

            // Close the modal after selection
            $('#defaultModalNamaKlien').modal('hide');
        });
    });
</script> -->

<script>
    $(document).ready(function() {
        $(document).on('click', '#pilihKategori', function() {
            var nama_klas = $(this).data('nama-kategori');
            var id = $(this).data('id-kategori');
            $('#kategori').val(nama_klas);
            $('#id').val(id);
            $('#modalPilihKategori').modal('hide');
        })
    });
</script>

<script>
    editor.on('required', function(evt) {
        alert('Article content is required.');
        evt.cancel();
    });
</script>

<script>
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'fontSize', 'fontFamily', 'fontColor', '', '', '|',
                'alignment', '|',
                'insertTable', 'mediaEmbed', '', '', '|',
                'undo', 'redo',
            ],
            shouldNotGroupWhenFull: true
        },
        // Changing the language of the interface requires loading the language file using the <script> tag.
        // language: 'es',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
        heading: {
            options: [{
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph'
                },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1'
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2'
                },
                {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3'
                },
                {
                    model: 'heading4',
                    view: 'h4',
                    title: 'Heading 4',
                    class: 'ck-heading_heading4'
                },
                {
                    model: 'heading5',
                    view: 'h5',
                    title: 'Heading 5',
                    class: 'ck-heading_heading5'
                },
                {
                    model: 'heading6',
                    view: 'h6',
                    title: 'Heading 6',
                    class: 'ck-heading_heading6'
                }
            ]
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
        placeholder: '',
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
        },
        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
        htmlSupport: {
            allow: [{
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }]
        },
        // Be careful with enabling previews
        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        mediaEmbed: {
            previewsInData: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [{
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }]
        },
        // The "superbuild" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'MultiLevelList',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType.
            'MathType',
            // The following features are part of the Productivity Pack and require additional license.
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents',
            'PasteFromOfficeEnhanced',
            'CaseChange'
        ]
    });
    RemoveFormat: [
        'paragraph'

    ]
</script>