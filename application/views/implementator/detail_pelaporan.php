<section class="content">
    <div class="container-fluid">
        <div class="block-header">


        </div>

        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- CSS KOMENTAR -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <?= $this->session->flashdata('message'); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Comment</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('implementator/add_comment') ?>
                    <form>
                        <?php foreach ($datapelaporan as $dp) : ?>
                            <input type="hidden" id="id_pelaporan" name="id_pelaporan" class="form-control" value="<?= $dp['id_pelaporan']; ?>">
                            <label for="nama_tiket">No Tiket</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_tiket" name="no_tiket" class="form-control" value="<?= $dp['no_tiket']; ?>" readonly>
                                </div>
                            </div>

                            <label for="waktu_pelaporan">Tanggal </label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" value="<?= tanggal_indo($dp['waktu_pelaporan']); ?>" readonly>
                                </div>
                            </div>

                            <label for="nama">Nama </label>
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

                            <!-- <label for="perihal">Perihal</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <div id="perihal"><?= $dp['perihal']; ?></div>
                                </div>
                            </div> -->

                            <label for="perihal">Perihal</label>
                            <textarea id="editor3" class="form-control" name="perihal" id="perihal" readonly>
                                <?= $dp['perihal']; ?>
                            </textarea>

                            <label for="kategori">Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="kategori" name="kategori" class="form-control" value="<?= $dp['kategori']; ?>" readonly>
                                </div>
                            </div>

                            <label for="priority">Priority</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="priority" name="priority" class="form-control" value="<?= $dp['priority']; ?>" readonly>
                                </div>
                            </div>

                            <label for="impact">Impact</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="impact" name="impact" class="form-control" value="<?= $dp['impact']; ?>" readonly>
                                </div>
                            </div>

                            <label for="status_ccs ">Status CCS </label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="status_ccs" name="status_ccs" class="form-control" value="<?= $dp['status_ccs']; ?>" readonly>
                                </div>
                            </div>

                            <label for="nama">File</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $file_finish = $dp['file']; // File yang dilampirkan
                                    if (!empty($file_finish)) {
                                        $file_path = base_url('assets/files/') . $file_finish;
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

                            <label for="comment">Comment</label>
                            <textarea id="editor" class="form-control" name="body" id="body">

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
                            <input type="hidden" name="user_id" id="user_id" value="<?= $user['id_user']; ?>">

                            <a href="<?= base_url('implementator/pelaporan') ?>" type="button" class="btn btn-primary m-t-15 waves-effect">Kembali</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">ADD</button>
                        <?php endforeach; ?>
                    </form>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

        <!-- comment -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Komentar</h2>
                </div>
                <?php if (empty($datacomment)) {
                } else {
                    foreach ($datacomment as $dc) { ?>
                        <div class="body">
                            <div class="panel panel-default">
                                <div class="panel-heading"> <b><?= $dc['nama_user']; ?></b>
                                    <?= format_indo($dc['created_at']) ?>
                                </div>
                                <div class="panel-body"><?= $dc['comment_body']; ?></div>
                                <div class="panel-body"><a href="<?= base_url('assets/comment/' . $dc['file']); ?>"><?= $dc['file']; ?></a></div>
                                <div class="panel-footer" align="right"><button class="btn btn-sm btn-primary" id="<?= $dc['id_comment']; ?>showFormInputButton" onclick=""><i class="material-icons">reply</i></button></div>
                            </div>

                            <div id="<?= $dc['id_comment']; ?>hiddenFormInput" style="display: none;">
                                <?php echo form_open_multipart('implementator/add_reply') ?>
                                <label for="comment">Reply Comment</label>
                                <textarea id="<?= $dc['id_comment']; ?>editor2" class="form-control" name="body" id="body">

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

                                <input type="hidden" name="user_id" id="user_id" value="<?= $user['id_user']; ?>">
                                <input type="hidden" name="id_pelaporan" id="id_pelaporan" value="<?= $dp['id_pelaporan']; ?>">
                                <input type="hidden" name="id_comment" id="id_comment" value="<?= $dc['id_comment']; ?>">

                                <button type="submit" class="btn btn-primary m-t-15 waves-effect"> <i class="material-icons">send</i></button>
                                <?php echo form_close() ?>
                            </div>

                            <?php
                            $id_comment = $dc['id_comment'];
                            $reply = $this->db->query("SELECT 
                            user.nama_user, 
                            user.id_user, 
                            reply.body, 
                            reply.comment_id,
                            reply.created_at,
                            reply.file
                        FROM reply
                        LEFT JOIN user ON reply.user_id = user.id_user
                        WHERE reply.comment_id = $id_comment
                        ORDER BY reply.created_at DESC")->result_array();
                            foreach ($reply as $dr) : ?>
                                <div class="panel panel-default" style="margin-left: 48px;">
                                    <div class="panel-heading">
                                        <b><?= $dr['nama_user']; ?></b>
                                        <?= format_indo($dr['created_at']) ?>
                                    </div>
                                    <div class="panel-body">
                                        <?= $dr['body']; ?>
                                    </div>
                                    <div class="panel-body">
                                        <a href="<?= base_url('assets/reply/' . $dr['file']); ?>"><?= $dr['file']; ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
        <!-- end comment -->
    </div>
</section>
<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php if (empty($datacomment)) {
} else {
    foreach ($datacomment as $dc) { ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Find the button and input elements

                const showFormInputButton = document.getElementById("<?= $dc['id_comment']; ?>showFormInputButton");
                const hiddenFormInput = document.getElementById("<?= $dc['id_comment']; ?>hiddenFormInput");

                // Add click event listener to the button
                showFormInputButton.addEventListener("click", function() {
                    // Toggle the display of the input form
                    if (hiddenFormInput.style.display === "none") {
                        hiddenFormInput.style.display = "block";
                    } else {
                        hiddenFormInput.style.display = "none";
                    }
                });
            });
        </script>
<?php }
} ?>

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
                'uploadImage', 'ckfinder', '|',
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
        ckfinder: {
            uploadUrl: "<?= base_url('implementator/upload_comment') ?>"
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

<?php if (empty($datacomment)) {
} else {
    foreach ($datacomment as $dc) { ?>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("<?= $dc['id_comment']; ?>editor2"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'fontSize', 'fontFamily', 'fontColor', '|',
                        'alignment', '|',
                        'uploadImage', 'ckfinder', '|',
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
                ckfinder: {
                    uploadUrl: "<?= base_url('implementator/upload_reply') ?>"
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
<?php }
} ?>

<script>
    // This sample still does not showcase all CKEditor&nbsp;5 features (!)
    // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
    CKEDITOR.ClassicEditor.create(document.getElementById("editor3"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'fontSize', 'fontFamily', 'fontColor', '', '', '|',
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