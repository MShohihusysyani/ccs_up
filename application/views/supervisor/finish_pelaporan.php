<section class="content">
    <div class="container-fluid">
        <div class="block-header">


        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- #END# Basic Examples -->
        <!-- Exportable Table -->
        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Finish Pelaporan</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('', ['id' => 'form-action']) ?>
                    <?php foreach ($datapelaporan as $dp) : ?>
                        <input type="hidden" id="id_pelaporan" name="id_pelaporan" class="form-control" value="<?= $dp['id_pelaporan']; ?>">

                        <label for="waktu_pelaporan">Created At</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" value="<?= tanggal_indo($dp['waktu_pelaporan']); ?>" readonly>
                            </div>
                        </div>
                        <label for="nama_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="no_tiket" name="no_tiket" class="form-control" value="<?= $dp['no_tiket']; ?>" readonly>
                            </div>
                        </div>

                        <label for="judul">Nama Klien</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="nama" name="nama" class="form-control" value="<?= $dp['nama']; ?>" readonly>
                            </div>
                        </div>

                        <label for="judul">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="judul" name="judul" class="form-control" value="<?= $dp['judul']; ?>" readonly>
                            </div>
                        </div>

                        <label for="perihal">Perihal</label>
                        <div class="form-group">
                            <div class="form-line">
                                <div id="perihal" readonly><?= $dp['perihal']; ?></div>
                            </div>
                        </div>


                        <label for="priority">Priority</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="priority" name="priority" class="form-control" value="<?= $dp['priority']; ?>" readonly>
                            </div>
                        </div>

                        <label for="maxday">Maxday</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="maxday" name="maxday" class="form-control" value="<?= $dp['maxday']; ?>" readonly>
                            </div>
                        </div>

                        <label for="handle_by">Handle By</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="handle_by" name="handle_by" class="form-control" value="<?= $dp['handle_by']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="handle_by2" name="handle_by2" class="form-control" value="<?= $dp['handle_by2']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="handle_by3" name="handle_by3" class="form-control" value="<?= $dp['handle_by3']; ?>" readonly>
                            </div>
                        </div>

                        <label for="perihal">Catatan Finish</label>
                        <textarea id="editor" class="form-control" name="catatan_finish" id="catatan_finish" readonly>
                                <?= $dp['catatan_finish']; ?>
                            </textarea>
                        <br>
                        <label for="alasan_reject">Alasan Reject</label>
                        <textarea id="editor_tolak" class="form-control" id="alasan_tolak" name="alasan_tolak" rows="10" readonly>
                            </textarea>
                        <br>
                        <!-- <label for="nama">File (jpeg/png/pdf/xlsx/docx) max 2mb</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <img src="<?= base_url('assets/filefinish/') . $dp['file_finish']; ?>" width="500" height="500" class="img-thumbnail">
                                </div>
                            </div> -->

                        <label for="nama">File</label>
                        <div class="form-group">
                            <div class="form-line">
                                <?php
                                $file_finish = $dp['file_finish']; // File yang dilampirkan
                                if (!empty($file_finish)) {
                                    $file_path = base_url('assets/filefinish/') . $file_finish;
                                    $file_name = basename($file_finish);  // Mengambil nama file
                                    $file_ext = pathinfo($file_finish, PATHINFO_EXTENSION);

                                    // Tampilkan nama file
                                    echo '<p>' . $file_name . '</p>';

                                    // Periksa apakah file adalah gambar
                                    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        // Jika file gambar, tampilkan dengan tag <img>
                                        echo '<img src="' . $file_path . '" width="500" height="500" class="img-thumbnail">';
                                    } else {
                                        // Jika file bukan gambar, tampilkan tautan untuk mengunduh atau melihat file
                                        echo '<a href="' . $file_path . '" target="_blank" class="btn btn-primary">Download file</a>';
                                    }
                                } else {
                                    // Jika tidak ada file yang dilampirkan
                                    echo '<span class= "label label-info" style="font-size:12px;">Tidak ada file yang dilampirkan.</span/';
                                }
                                ?>
                            </div>
                        </div>

                        <label for="kategori">Category</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" data-toggle="modal" data-target="#modalPilihKategori" name="kategori" id="kategori" placeholder="" class="form-control ui-autocomplete-input" value="<?= $dp['kategori']; ?>" autocomplete="off" readonly>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>

                        <label for="tags">Tags</label>
                        <div class="form-group demo-tagsinput-area">
                            <div class="form-line">
                                <input type="text" class="form-control" data-role="tagsinput" value="<?= $dp['tags']; ?>" id="tags" name="tags" readonly>
                            </div>
                        </div>


                        <a href="<?= base_url('supervisor/close') ?>" type="button" class="btn btn-primary m-t-15 waves-effect">Kembali</a>

                        <button type="submit" id="approve" class="btn btn-success m-t-15 waves-effect">Approve</button>
                        <button type="submit" id="reject" class="btn btn-warning m-t-15 waves-effect">Reject</button></button>
                    <?php endforeach; ?>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    const form = document.getElementById('form-action');

    // Event untuk tombol Forward
    document.getElementById('approve').addEventListener('click', function() {
        form.action = "<?= base_url('supervisor/fungsi_approve_pelaporan') ?>";
        form.submit();
    });

    // Event untuk tombol Finish
    document.getElementById('reject').addEventListener('click', function() {
        form.action = "<?= base_url('supervisor/fungsi_reject') ?>";
        form.submit();
    });
</script>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- catatan finish -->
<script>
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'fontSize', 'fontFamily', 'fontColor', '|',
                'alignment', '|',
                'uploadImage', '|',
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

<!-- alasan tola -->
<script>
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor_tolak"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'fontSize', 'fontFamily', 'fontColor', '', '', '|',
                'alignment', '|',
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