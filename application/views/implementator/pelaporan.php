<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>

            </h2>
        </div>
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- Basic Examples -->
        <div class="login" data-login="<?= $this->session->flashdata('pesan') ?>">
            <?php if ($this->session->flashdata('pesan')) { ?>

            <?php } ?>
            <div class="eror" data-eror="<?= $this->session->flashdata('alert') ?>">
                <?php if ($this->session->flashdata('pesan')) { ?>

                <?php } ?>
                <?= validation_errors(); ?>
                <!-- #END# Basic Examples -->
                <!-- Exportable Table -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    PELAPORAN
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
                                                <th>Impact</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Tags</th>
                                                <th>Priority</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle By</th>
                                                <th>Subtask 1</th>
                                                <th>Status Subtask 1</th>
                                                <th>Subtask 2</th>
                                                <th>Status Subtask 2</th>
                                                <th>Tenggat waktu</th>
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
                                                <th>Impact</th>
                                                <th>Attachment</th>
                                                <th>Category</th>
                                                <th>Tags</th>
                                                <th>Priority</th>
                                                <th>Max Day</th>
                                                <th>Status CCS</th>
                                                <th>Handle By</th>
                                                <th>Subtask 1</th>
                                                <th>Status Subtask 1</th>
                                                <th>Subtask 2</th>
                                                <th>Status Subtask 2</th>
                                                <th>Tenggat waktu</th>
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
                                                    <td><?= $dp['impact']; ?></td>
                                                    <td> <a href="<?= base_url('assets/files/' . $dp['file']); ?>"><?= $dp['file']; ?></a>
                                                    </td>
                                                    <td><?= $dp['kategori']; ?></td>
                                                    <td>
                                                        <?php if (!empty($dp['tags'])): ?>
                                                            <span class="label label-info">
                                                                <?= $dp['tags']; ?>
                                                            </span>
                                                        <?php endif; ?>
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

                                                        <?php elseif ($dp['status_ccs'] == 'HANDLE 2') : ?>
                                                            <span class="label label-info">HANDLE 2</span>

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
                                                    <td><?= $dp['subtask1']; ?></td>
                                                    <td>
                                                        <?php if ($dp['status1'] == 'COMPLETED') : ?>
                                                            <span class="label label-success">COMPLETED</span>

                                                        <?php elseif ($dp['status1'] == 'PENDING') : ?>
                                                            <span class="label label-info">PENDING</span>

                                                        <?php else : ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $dp['subtask2']; ?></td>
                                                    <td>
                                                        <?php if ($dp['status2'] == 'COMPLETED') : ?>
                                                            <span class="label label-success">COMPLETED</span>

                                                        <?php elseif ($dp['status2'] == 'PENDING') : ?>
                                                            <span class="label label-info">PENDING</span>

                                                        <?php else : ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= tanggal_indo($dp['tanggal']) ?></td>

                                                    <td>

                                                        <a class="btn btn-sm btn-info" href="<?= base_url() ?>implementator/detail_pelaporan/<?= $dp['id_pelaporan']; ?>"><i class="material-icons">visibility</i> <span class="icon-name"></span>Detail</a>
                                                        <br>
                                                        <br>

                                                        <?php $this->session->set_userdata('referred_from', current_url()); ?>
                                                        <div class="btn btn-sm btn-info">
                                                            <a href="javascript:;" data-id_pelaporan="<?= $dp['id_pelaporan']; ?>" data-no_tiket="<?= $dp['no_tiket']; ?>" data-waktu_pelaporan="<?= $dp['waktu_pelaporan']; ?>" data-nama="<?= $dp['nama']; ?>" data-perihal='<?= $dp['perihal']; ?>' data-status="<?= $dp['status']; ?>" data-status_ccs="<?= $dp['status_ccs']; ?>" data-kategori="<?= $dp['kategori']; ?>" data-priority="<?= $dp['priority']; ?>" data-maxday="<?= $dp['maxday']; ?>" data-judul="<?= $dp['judul']; ?>" data-toggle="modal" data-target="#finishModal"> <i class="material-icons">done</i> <span class="icon-name">Finish</span></a>
                                                        </div>
                                                        <br>
                                                        <br>

                                                        <a class="btn btn-sm btn-primary" href="<?= base_url() ?>export/print_detail/<?= $dp['no_tiket']; ?>"><i class="material-icons">print</i> <span class="icon-name"></span>Print Detail</a>


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

<!-- FINISH TIKET-->
<div class="modal fade" id="finishModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Finish CCS</h4>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('implementator/finish') ?>
                <input type="hidden" name="id_pelaporan" id="id_pelaporan">
                <div class="body">
                    <form class="form-horizontal">

                        <label for="no_tiket">No Tiket</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="no_tiket" name="no_tiket" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="waktu_pelaporan">Tanggal</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="waktu_pelaporan" name="waktu_pelaporan" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="nama">Nama Klien</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="nama" name="nama" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="judul">Judul</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="judul" name="judul" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="perihal">Perihal</label>
                            <div class="form-line">
                                <div id="perihal_coba" readonly></div>
                            </div>
                        </div>

                        <label for="status_ccs">Status CCS</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="status_ccs" name="status_ccs" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="priority">Priority</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="priority" name="priority" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="maxday">Max Day</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="maxday" name="maxday" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="kategori">Kategori</label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="" type="text" id="kategori" name="kategori" class="form-control" readonly>
                            </div>
                        </div>

                        <label for="perihal">Catatan Finish</label>
                        <textarea id="editor" class="form-control" name="catatan_finish" id="catatan_finish" required>

                        </textarea>


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


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">FINISH</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>

                        </div>

                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- AUTO INPUT MAX DAY AFTER SELECT PRIORITY -->
<script type="text/javascript">
    //Get references to the select and input elements
    const select = document.getElementById('priority');
    const input = document.getElementById('maxday');

    // Add event listener to the select element
    select.addEventListener('change', function() {
        // Set the value of the input field to the selected option's value
        if (select.value == "Low") {
            input.value = "90";
        } else if (select.value == "Medium") {
            input.value = "60";
        } else if (select.value == "High") {
            input.value = "7";
        } else {
            input.value = "";

        }

    });
</script>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {

        // Untuk sunting
        $('#editModalCP').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_pelaporan').attr("value", div.data('id_pelaporan'));
            modal.find('#no_tiket').attr("value", div.data('no_tiket'));
            modal.find('#waktu_pelaporan').attr("value", div.data('waktu_pelaporan'));
            modal.find('#nama').attr("value", div.data('nama'));
            modal.find('#perihal').attr("value", div.data('perihal'));
            modal.find('#status').attr("value", div.data('status'));
            modal.find('#status_ccs').attr("value", div.data('status_ccs'));
            // modal.find('#priority').attr("value", div.data('priority'));
            modal.find('#priority').value = div.data('priority');
            // modal.find('#priority option:selected').text(div.data('priority'));
            modal.find('#maxday').attr("value", div.data('maxday'));
            // modal.find('#kategori').attr("value", div.data('kategori'));
            modal.find('#kategori option:selected').text(div.data('kategori'));
            modal.find('#namauser option:selected').text(div.data('nama'));
            // modal.find('#bprnama').attr("value", div.data('bprnama'));
            // modal.find('#bprsandi').attr("value", div.data('bprsandi'));
            // modal.find('#judul').attr("value", div.data('judul'));
            // modal.find('#headline').attr("value", div.data('headline'));
            // modal.find('#gbr_utama').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbr_utama'));
            // modal.find('#gbrtmbhn1').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn1'));
            // modal.find('#gbrtmbhn2').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn2'));
            // modal.find('#gbrtmbhn3').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn3'));
            // modal.find('#linkberita').val(div.data('linkberita'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));

        });

    });
</script>


<script>
    $(document).ready(function() {

        // Untuk sunting
        $('#finishModal').on('show.bs.modal', function(event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            modal.find('#id_pelaporan').attr("value", div.data('id_pelaporan'));
            modal.find('#no_tiket').attr("value", div.data('no_tiket'));
            modal.find('#waktu_pelaporan').attr("value", div.data('waktu_pelaporan'));
            modal.find('#nama').attr("value", div.data('nama'));
            modal.find('#judul').attr("value", div.data('judul'));
            modal.find('#perihal_coba').html(div.data('perihal'));
            modal.find('#status').attr("value", div.data('status'));
            modal.find('#status_ccs').attr("value", div.data('status_ccs'));
            modal.find('#priority').attr("value", div.data('priority'));
            // modal.find('#priority').value = div.data('priority');
            // modal.find('#priority option:selected').text(div.data('priority'));
            modal.find('#maxday').attr("value", div.data('maxday'));
            modal.find('#kategori').attr("value", div.data('kategori'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));
            // modal.find('#bprnama').attr("value", div.data('bprnama'));
            // modal.find('#bprsandi').attr("value", div.data('bprsandi'));
            // modal.find('#judul').attr("value", div.data('judul'));
            // modal.find('#headline').attr("value", div.data('headline'));
            // modal.find('#gbr_utama').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbr_utama'));
            // modal.find('#gbrtmbhn1').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn1'));
            // modal.find('#gbrtmbhn2').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn2'));
            // modal.find('#gbrtmbhn3').attr("src", '<?= base_url() ?>assets/images/berita/' + div.data('gbrtmbhn3'));
            // modal.find('#linkberita').val(div.data('linkberita'));
            // modal.find('#kategori option:selected').text(div.data('kategori'));

        });

    });
</script>

<script>
    // Check if tenggat waktu is empty and display message if true
    $(document).ready(function() {
        $('#example tbody tr').each(function() {
            var tenggatWaktu = $(this).find('td:eq(17)').text().trim(); // Assuming 15th column (index 14) is tenggat waktu
            if (tenggatWaktu === '') {
                $(this).find('td:eq(17)').text('Invalid date format'); // Replace with your message or any action you want
            }
        });
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
    });
    RemoveFormat: [
        'paragraph'

    ]
</script>