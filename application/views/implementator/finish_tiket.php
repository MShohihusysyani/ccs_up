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
                        Finish Tiket</h2>
                </div>
                <div class="body">
                    <?php echo form_open_multipart('implementator/finish') ?>
                    <form enctype="multipart/form-data">
                        <?php foreach ($datapelaporan as $dp) : ?>
                            <input type="hidden" id="id_pelaporan" name="id_pelaporan" class="form-control" value="<?= $dp['id_pelaporan']; ?>">

                            <label for="nama_tiket">No Tiket</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="no_tiket" name="no_tiket" class="form-control" value="<?= $dp['no_tiket']; ?>" readonly>
                                </div>
                            </div>

                            <label for="nama_tiket">Tanggal </label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" value="<?= $dp['waktu_pelaporan']; ?>" readonly>
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

                            <label for="kategori">Kategori</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input value="<?= $dp['kategori']; ?>" type="text" id="kategori" name="kategori" class="form-control" readonly>
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


                            <label for="perihal">Catatan Finish</label>
                            <textarea id="editor" class="form-control" name="catatan_finish" id="catatan_finish" required>

                            </textarea>
                            <br>


                            <label for="nama">File (jpg/jpeg/png/pdf/xlsx/docx) max 2mb</label>
                            <div class="form-group">
                                <label for="exampleInputFile"></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_finish" name="file_finish">
                                        <label for="file" class="custom-file-label">Choose
                                            file</label>
                                    </div>
                                </div>
                            </div>

                            <!-- <label for="nama">File</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php
                                    $file_finish = $dp['file']; // File yang dilampirkan
                                    if (!empty($file_finish)) {
                                        $file_path = base_url('assets/file/') . $file_finish;
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
                            <br> -->

                            <a href="<?= base_url('implementator/pelaporan') ?>" type="button" class="btn btn-primary m-t-15 waves-effect">Kembali</a>

                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Finish</button>
                        <?php endforeach; ?>
                    </form>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
        // uploadImage: {
        //     types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'jpg'],
        //     previewsInData: true
        // },
        ckfinder: {
            uploadUrl: "<?= base_url('implementator/upload') ?>"
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

    }).then(editor => {
        // Blokir paste gambar (termasuk clipboard dan base64)
        editor.editing.view.document.on('clipboardInput', (evt, data) => {
            const clipboardData = data.dataTransfer;

            // Jika ada file gambar yang di-paste, blokir dan hapus
            if (clipboardData && clipboardData.files.length > 0) {
                for (let file of clipboardData.files) {
                    if (file.type.startsWith('image/')) {
                        evt.stop();
                        evt.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Mohon tidak mempaste gambar secara langsung. Gunakan fitur upload!',
                        }).then(() => {
                            editor.setData(editor.getData().replace(/<img[^>]+>/g, '')); // Hapus gambar
                        });
                        return;
                    }
                }
            }

            // Cek apakah ada gambar dari clipboard dalam bentuk HTML
            const htmlData = clipboardData.getData('text/html');
            if (htmlData.includes('<img')) {
                evt.stop();
                evt.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon tidak mempaste gambar secara langsung. Gunakan fitur upload!',
                }).then(() => {
                    editor.setData(editor.getData().replace(/<img[^>]+>/g, '')); // Hapus gambar
                });
            }
        });

        // Hapus gambar base64 yang mungkin lolos dari paste
        editor.model.document.on('change:data', () => {
            let data = editor.getData();

            // Deteksi dan hapus gambar base64
            const base64Pattern = /<img[^>]+src=["']data:image\/[^;]+;base64,[^"']+["'][^>]*>/g;
            if (base64Pattern.test(data)) {
                editor.setData(data.replace(base64Pattern, '')); // Hapus gambar base64
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gambar yang di-paste telah dihapus. Gunakan fitur upload!',
                });
            }
        });

        // Blokir paste gambar menggunakan event paste langsung di editor
        editor.ui.view.editable.element.addEventListener('paste', (event) => {
            const items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (let item of items) {
                if (item.type.indexOf('image') !== -1) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon tidak mempaste gambar secara langsung. Gunakan fitur upload!',
                    }).then(() => {
                        editor.setData(editor.getData().replace(/<img[^>]+>/g, '')); // Hapus gambar
                    });
                    return;
                }
            }
        });

    }).catch(error => {
        console.error(error);
    });
    RemoveFormat: [
        'paragraph'

    ]
</script>