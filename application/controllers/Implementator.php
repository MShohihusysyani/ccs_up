<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Implementator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/dashboard');
        $this->load->view('templates/footer');
    }

    // DATA TIKET HANDLED
    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'Implementator_model');
        $this->load->model('User_model', 'user_model');

        // --- TAMBAHAN BARU ---
        $this->load->model('Chat_model'); // Load Chat_model
        $my_id = $this->session->userdata('id_user');
        // --- AKHIR TAMBAHAN ---

        $data['user'] = $this->user_model->getDataUser();


        // Ambil data pelaporan seperti biasa
        $datapelaporan = $this->implementator_model->getDataHandled();
        // $data['datapelaporan'] = $this->Implementator_model->getDataHandled();

        // --- MODIFIKASI: Loop untuk menambahkan unread_count ---
        if (!empty($datapelaporan)) {
            foreach ($datapelaporan as &$dp) { // Gunakan reference (&) agar array asli termodifikasi
                // Panggil model untuk menghitung pesan belum dibaca untuk setiap tiket
                $dp['unread_count'] = $this->Chat_model->get_unread_ccs_messages_count($dp['id_pelaporan'], $my_id);
            }
        }
        // --- AKHIR MODIFIKASI ---

        $data['datapelaporan'] = $datapelaporan;

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    // DATA TIKET CLOSED
    public function close()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->implementator_model->getDataClosed();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/close', $data);
        $this->load->view('templates/footer');
    }

    public function reject()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->implementator_model->getPelaporanReject();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/reject', $data);
        $this->load->view('templates/footer');
    }

    // DATA TIKET FINISHED
    public function pelaporan_finish()
    {
        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // Set form validation rules (allow empty)
        $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
        $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
        $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
        $this->form_validation->set_rules('rating', 'rating', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/implementator_sidebar');
            $this->load->view('implementator/pelaporan_finish', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $nama_klien    = $this->input->post('nama_klien');
            $rating        = $this->input->post('rating');
            $status_ccs    = 'FINISHED';

            // var data for view 
            $data['tanggal_awal']  = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['nama_klien']    = $nama_klien;
            $data['rating']        = $rating;
            $data['status_ccs']    = $status_ccs;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = $this->pelaporan_model->getDateFilteredH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $rating);

            $this->load->view('templates/header');
            $this->load->view('templates/implementator_sidebar');
            $this->load->view('implementator/pelaporan_finish');
            $this->load->view('templates/footer');
        }
    }

    public function get_data_finish()
    {
        $this->load->model('Serversideteknisi_model', 'serversideteknisi_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'rating' => $this->input->post('rating'),
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }

        $list = $this->serversideteknisi_model->get_datatables($filters);
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $dp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dp->no_tiket;
            $row[] = tanggal_indo($dp->waktu_pelaporan);
            $row[] = $dp->nama;
            $row[] = $dp->judul;
            $row[] = $dp->kategori;
            // $row[] = $dp->tags ? '<span class="label label-info">' . $dp->tags . '</span>' : '';

            // Proses nilai prioritas di server-side
            if ($dp->priority == 'Low') {
                $priority_label = '<span class="label label-info">Low</span>';
            } elseif ($dp->priority == 'Medium') {
                $priority_label = '<span class="label label-warning">Medium</span>';
            } elseif ($dp->priority == 'High') {
                $priority_label = '<span class="label label-danger">High</span>';
            } else {
                $priority_label = $dp->priority;
            }
            $row[] = $priority_label;

            // Proses nilai maxday di server-side
            if ($dp->maxday == '90') {
                $maxday_label = '<span class="label label-info">90</span>';
            } elseif ($dp->maxday == '60') {
                $maxday_label = '<span class="label label-warning">60</span>';
            } elseif ($dp->maxday == '7') {
                $maxday_label = '<span class="label label-danger">7</span>';
            } else {
                $maxday_label = $dp->maxday;
            }
            $row[] = $maxday_label;

            // Proses nilai status_ccs di server-side
            if ($dp->status_ccs == 'ADDED') {
                $status_ccs_label = '<span class="label label-primary">ADDED</span>';
            } elseif ($dp->status_ccs == 'ADDED 2') {
                $status_ccs_label = '<span class="label label-primary">ADDED 2</span>';
            } elseif ($dp->status_ccs == 'HANDLED') {
                $status_ccs_label = '<span class="label label-info">HANDLED</span>';
            } elseif ($dp->status_ccs == 'HANDLED 2') {
                $status_ccs_label = '<span class="label label-info">HANDLED 2</span>';
            } elseif ($dp->status_ccs == 'CLOSED') {
                $status_ccs_label = '<span class="label label-warning">CLOSED</span>';
            } elseif ($dp->status_ccs == 'FINISHED') {
                $status_ccs_label = '<span class="label label-success">FINISHED</span>';
            } else {
                $status_ccs_label = $dp->status_ccs;
            }
            $row[] = $status_ccs_label;

            // Proses handle_by
            $handle_combined = $dp->handle_by;
            if ($dp->handle_by2) {
                $handle_combined .= ', ' . $dp->handle_by2;
            }
            if ($dp->handle_by3) {
                $handle_combined .= ', ' . $dp->handle_by3;
            }
            $row[] = $handle_combined;

            // Proses rating bintang
            $star_rating = '';
            if ($dp->rating !== null) {
                $rating = $dp->rating; // Get the rating value
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        $star_rating .= '<span class="star selected">&#9733;</span>'; // Full star for rating
                    } else {
                        $star_rating .= '<span class="star">&#9734;</span>'; // Empty star for remaining
                    }
                }
            }
            $row[] = '<div class="star-rating">' . $star_rating . '</div>'; // Wrap in div for styling

            // Tombol Aksi
            $row[] = '<a class="btn btn-sm btn-info" href="' . base_url('implementator/detail_finish/' . $dp->id_pelaporan) . '"><i class="material-icons">visibility</i></a>';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->serversideteknisi_model->count_all(),
            "recordsFiltered" => $this->serversideteknisi_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);  // Kirim JSON ke DataTables
        die();
    }

    // FINISH TIKET
    public function finish_tiket($id = null)
    {
        // Cek apakah ID pelaporan tidak ada
        if ($id === null) {
            // Set pesan error dan redirect ke halaman yang sesuai
            $this->session->set_flashdata('alert', 'Finish gagal.');
            redirect('implementator/pelaporan'); // Redirect ke halaman yang diinginkan
            return;
        }

        // Jika ID ada, lanjutkan proses
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('implementator_model', 'implementator_model');
        $data['datapelaporan'] = $this->implementator_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/finish_tiket', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catatan_finish', 'Catatan Finish', 'callback_validateCatatanFinish');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            redirect('implementator/pelaporan');
        } else {
            // Cek jika ada subtas yang masih pending
            $id = $this->input->post('id_pelaporan');
            $this->load->model('Implementator_model', 'implementator_model');
            $pendingSubtasks = $this->implementator_model->countPendingSubtasks($id);

            if ($pendingSubtasks > 0) {
                $this->session->set_flashdata('alert', 'Finish gagal! Masih ada subtask yang berstatus Pending.');
                redirect('implementator/pelaporan');
            } else {
                $this->processFinish();
            }
        }
    }

    // Custom validation callback
    public function validateCatatanFinish($str)
    {
        $minLength = 50;

        $textContent = strip_tags($str);
        if (strlen($textContent) < $minLength) {
            $this->form_validation->set_message('validateCatatanFinish', 'Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function processFinish()
    {
        $photo = $_FILES['file_finish']['name'];

        if ($photo) {
            $config['allowed_types'] = 'csv|xlsx|docx|pdf|txt|jpeg|jpg|png|rar|zip';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/filefinish/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_finish')) {
                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                redirect('implementator/pelaporan');
            }
        }

        $id = $this->input->post('id_pelaporan');
        $data = [
            'id_pelaporan' => $id,
            'no_tiket' => $this->input->post('no_tiket'),
            'waktu_pelaporan' => $this->input->post('waktu_pelaporan'),
            // 'perihal'  => $this->input->post('perihal'),
            'file_finish'     => $photo,
            'nama'     => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'priority'   => $this->input->post('priority'),
            'maxday'     => $this->input->post('maxday'),
            'catatan_finish' => $this->input->post('catatan_finish'),
            'status'     => 'Solved',
            'status_ccs' => 'CLOSED'
        ];

        // Remove tag
        $data = array_map(function ($value) {
            return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
        }, $data);

        $this->pelaporan_model->updateImplementator($id, $data);
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('implementator/pelaporan');
    }

    public function upload()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/filefinish/';
            $config['file_name'] = uniqid();

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/filefinish/' . $photo);
                $this->load->helper('url');

                $data = array(
                    'fileName' => $photo,
                    'uploaded' => 1,
                    'url' => $url
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            } else {
                $data = array(
                    'message' => 'Upload failed',
                    'uploaded' => 0
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            }
        }
    }

    // LAPORAN
    public function data_pelaporan()
    {
        // Load necessary models
        $this->load->model('Implementator_model', 'implementator_model');
        $this->load->model('Client_model', 'client_model');

        // var data for view 
        $data['tanggal_awal'] = '';
        $data['tanggal_akhir'] = '';
        $data['status_ccs'] = '';
        $data['nama_klien'] = '';
        $data['tags'] = '';

        // Get all data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->implementator_model->getAllData(); // A method that returns all data

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function datepelaporan()
    {
        // Load necessary libraries and models
        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // Set form validation rules (allow empty)
        $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
        $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
        $this->form_validation->set_rules('status_ccs', 'Status CCS', 'trim');
        $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        // Load data for the view
        $data = array(
            'errors' => '',
            'klien' => $this->client_model->getClient(),
            'pencarian_data' => array(),
            'tanggal_awal' => '',
            'tanggal_akhir' => '',
            'status_ccs' => '',
            'nama_klien' => '',
            'tags' => ''
        );

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare error messages
            $data['errors'] = validation_errors();
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');
            $tags = $this->input->post('tags');

            // Retrieve user division (assuming it's stored in session or from authentication)
            $user_id = $this->session->userdata('id_user'); // Adjust this based on your actual session logic

            // Get data from the models based on division
            $data['pencarian_data'] = $this->pelaporan_model->getDateH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags, $user_id);

            // Set the retrieved input data to be passed to the view
            $data['tanggal_awal'] = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs'] = $status_ccs;
            $data['nama_klien'] = $nama_klien;
            $data['tags'] = $tags;
        }

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function fetch_data()
    {
        $this->load->model('Implementator_model', 'implementator_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'tags' => $this->input->post('tags'),
            'status_ccs' => $this->input->post('status_ccs')
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }

        // Panggil model untuk mendapatkan data dengan filter
        $list = $this->implementator_model->get_datatables($filters);
        $data = array();

        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1; // Nomor urutan
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['judul'] = isset($dataItem->judul) ? $dataItem->judul : '';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            $row['priority'] = $this->get_priority_label(isset($dataItem->priority) ? $dataItem->priority : null);
            $row['maxday'] = $this->get_maxday_label(isset($dataItem->maxday) ? $dataItem->maxday : null);
            $row['status_ccs'] = $this->get_status_label(isset($dataItem->status_ccs) ? $dataItem->status_ccs : null);

            // Proses handle_by dan handle_by tambahan dengan pemeriksaan isset
            $handle_combined = isset($dataItem->handle_by) ? $dataItem->handle_by : '';
            $handle_combined .= isset($dataItem->handle_by2) ? ', ' . $dataItem->handle_by2 : '';
            $handle_combined .= isset($dataItem->handle_by3) ? ', ' . $dataItem->handle_by3 : '';
            $row['handle_by'] = trim($handle_combined, ', '); // Menghapus koma di akhir jika ada

            $data[] = $row;
        }

        // Menyiapkan output JSON untuk DataTables
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->implementator_model->count_all(),
            "recordsFiltered" => $this->implementator_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);
    }

    private function get_priority_label($priority)
    {
        if ($priority == 'High') {
            return '<span class="label label-danger">High</span>';
        } elseif ($priority == 'Medium') {
            return '<span class="label label-warning">Medium</span>';
        } elseif ($priority == 'Low') {
            return '<span class="label label-info">Low</span>';
        }
    }

    private function get_maxday_label($maxday)
    {
        if ($maxday == '7') {
            return '<span class="label label-danger">7</span>';
        } elseif ($maxday == '60') {
            return '<span class="label label-warning">60</span>';
        } elseif ($maxday == '90') {
            return '<span class="label label-info">90</span>';
        }
    }

    private function get_status_label($status)
    {
        if ($status == 'FINISHED') {
            return '<span class="label label-success">FINISHED</span>';
        } elseif ($status == 'CLOSED') {
            return '<span class="label label-warning">CLOSED</span>';
        } elseif ($status == 'HANDLED') {
            return '<span class="label label-info">HANDLED</span>';
        } elseif ($status == 'HANDLED 2') {
            return '<span class="label label-info">HANDLED 2</span>';
        } elseif ($status == 'ADDED') {
            return '<span class="label label-primary">ADDED</span>';
        } elseif ($status == 'ADDED 2') {
            return '<span class="label label-primary">ADDED 2</span>';
        }
    }

    // DETAIL
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $data['datapelaporan'] = $this->implementator_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->implementator_model->get_latest_comments($id);
        $data['datareply']     = $this->implementator_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_close($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $data['datapelaporan'] = $this->implementator_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/detail_close', $data);
        $this->load->view('templates/footer');
    }

    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $data['datapelaporan'] = $this->implementator_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/detail_finish', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/comment/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                $referred_from = $this->session->userdata('referred_from');
                redirect($referred_from, 'refresh');
            }
        }

        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('user_id', 'Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = $this->input->post('body');
        $create_at = date('Y-m-d H:i:s');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo,
            'created_at' => $create_at
        ];
        $data = preg_replace("/^<p.*?>/", "", $data);
        $data = preg_replace("|</p>$|", "", $data);
        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('implementator/detail_pelaporan/' . $id_pelaporan));
    }

    public function upload_comment()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/comment/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/comment/' . $photo);
                $this->load->helper('url');

                // Store the uploaded file name in session
                $uploaded_images = $this->session->userdata('uploaded_images') ?? [];
                $uploaded_images[] = $photo;
                $this->session->set_userdata('uploaded_images', $uploaded_images);

                $data = array(
                    'fileName' => $photo,
                    'uploaded' => 1,
                    'url' => $url
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            } else {
                $data = array(
                    'message' => 'Upload failed',
                    'uploaded' => 0
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            }
        }
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                $referred_from = $this->session->userdata('referred_from');
                redirect($referred_from, 'refresh');
            }
        }
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('user_id', 'Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = $this->input->post('body');
        $create_at  = date('Y-m-d H:i:s');
        $comment_id = $this->input->post('id_comment');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo,
            'created_at' => $create_at,
            'comment_id' => $comment_id
        ];
        $data = preg_replace("/^<p.*?>/", "", $data);
        $data = preg_replace("|</p>$|", "", $data);
        $this->db->insert('reply', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('implementator/detail_pelaporan/' . $id_pelaporan));
    }

    public function upload_reply()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/reply/' . $photo);
                $this->load->helper('url');

                // Store the uploaded file name in session
                $uploaded_images = $this->session->userdata('uploaded_images') ?? [];
                $uploaded_images[] = $photo;
                $this->session->set_userdata('uploaded_images', $uploaded_images);

                $data = array(
                    'fileName' => $photo,
                    'uploaded' => 1,
                    'url' => $url
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            } else {
                $data = array(
                    'message' => 'Upload failed',
                    'uploaded' => 0
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            }
        }
    }

    public function statistik()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/statistik');
        $this->load->view('templates/footer');
    }

    public function subtask()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'Implementator_model');

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['subtask'] = $this->Implementator_model->getSubtask();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/subtask', $data);
        $this->load->view('templates/footer');
    }


    public function finish_subtask()
    {
        $this->load->model('Implementator_model', 'implementator_model');
        date_default_timezone_set('Asia/Jakarta');

        $id_forward = $this->input->post('id_forward');
        $judul = $this->input->post('judul');
        $subtask = $this->input->post('subtask');
        $tanggal_finish = date('Y-m-d');
        $status = 'COMPLETED';

        $data = [
            'judul' => $judul,
            'subtask' => $subtask,
            'tanggal_finish' => $tanggal_finish,
            'status' => $status
        ];
        // var_dump($id_forward);
        // die;

        if ($this->implementator_model->updateSubtask($id_forward, $data)) {
            $this->session->set_flashdata('pesan', 'Berhasil Finish Subtask!');
        } else {
            $this->session->set_flashdata('alert', 'Gagal Finish Subtask!');
        }

        redirect(base_url('implementator/subtask'));
    }

    public function get_notifications()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        // Ambil notifikasi dari database dengan paginasi
        $notifications = $this->helpdesk_model->get_notifications($limit, $offset);

        // Total notifikasi yang tersedia di server
        $total_count = $this->helpdesk_model->get_total_count();

        // Kirim response JSON
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $this->helpdesk_model->get_unread_count(),
            'total_count' => $total_count
        ]);
    }
    public function fetch_notifications()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $limit = 5;  // Tampilkan 20 notifikasi per halaman
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $this->load->model('Implementator_model', 'implementator_model');
        $notifications = $this->implementator_model->get_notifications($limit, $offset);
        $unread_count = $this->implementator_model->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }

    // MODE FOKUS
    public function mode_fokus($id_pelaporan)
    {
        $this->load->model('Implementator_model', 'implementator_model');
        $status = $this->implementator_model->set_mode_fokus($id_pelaporan, 1);

        if ($status) {
            $this->session->set_flashdata('pesan', 'Berhasil menambahkan mode fokus!');
            redirect('implementator/pelaporan');
        } else {
            $this->session->set_flashdata('alert', 'Gagal menambahkan mode fokus!');
            redirect('implementator/pelaporan');
        }
    }
}
