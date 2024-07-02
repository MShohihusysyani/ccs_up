<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/dashboard');
        $this->load->view('templates/footer');
    }

    public function pengajuan()
    {
        // $data['noTiket'] = $this->client_model->getkodeticket();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $this->load->model('Category_model', 'category_model');
        // $data['nama_kategori'] = $this->db->get('category')->result_array();
        $this->load->model('Temp_model', 'temp_model');
        // $data['nama_kategori'] = $this->db->get('tiket_temp')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $data['tiket_temp'] = $this->temp_model->getTiketTemp1();
        $id_user = $this->session->userdata('id_user');
        $no_klien = $this->client_model->getNoKlien($id_user);
        $no_urut = $this->client_model->getNoUrut($id_user);
        $bulan = $time = date("m");
        $tahun = $time = date("Y");

        $data['tiket'] = "TIC" . $no_klien . $tahun . $bulan . $no_urut;

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHD();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function reject()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHDReject();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/reject', $data);
        $this->load->view('templates/footer');
    }

    public function forward()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHDForward();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/forward', $data);
        $this->load->view('templates/footer');
    }

    public function data_finish()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getDataPelaporanHD();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/finish', $data);
        $this->load->view('templates/footer');
    }


    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getDataPelaporanHD();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function rekapPelaporan()
    {
        // Load necessary models
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // var data for view 
        $data['tanggal_awal'] = '';
        $data['tanggal_akhir'] = '';
        $data['status_ccs'] = '';
        $data['nama_klien'] = '';
        $data['tags'] = '';

        // Get all data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->klienpelaporan_model->getAllData(); // A method that returns all data

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
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
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }



    //FINISH HELPDESK
    public function finish1()
    {
        // date_default_timezone_set('Asia/Jakarta');
        # add your city to set local time zone

        $id              = $this->input->post('id_pelaporan');
        $no_tiket        = $this->input->post('no_tiket');
        $waktu_pelaporan = $this->input->post('waktu_pelaporan');
        $nama            = $this->input->post('nama');
        $perihal         = $this->input->post('perihal');
        $status          = 'Solved';
        $status_ccs      = 'CLOSE';
        $priority        = $this->input->post('priority');
        $maxday          = $this->input->post('maxday');
        $kategori        = $this->input->post('kategori');
        $ArrUpdate       = array(

            'no_tiket'        => $no_tiket,
            'waktu_pelaporan' => $waktu_pelaporan,
            'nama'            => $nama,
            'perihal'         => $perihal,
            'status'          => $status,
            'status_ccs'      => $status_ccs,
            'priority'        => $priority,
            'maxday'          => $maxday,
            'kategori'        => $kategori
        );
        $this->pelaporan_model->updateHD($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('helpdesk/data_pelaporan');
    }

    public function finish()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('catatan_finish', 'Catatan Finish', 'callback_validateCatatanFinish');

        // Check if the form validation passed
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, set an error message and redirect back
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            redirect('helpdesk/pelaporan');
        } else {
            $this->processFinish();
        }
    }

    // Custom validation callback
    public function validateCatatanFinish($str)
    {
        $minLength = 50;

        // Strip tags to get text content and check if length is less than min length
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
        // Handle file upload if there is a file
        $photo = $_FILES['file_finish']['name'];

        if ($photo) {
            $config['allowed_types'] = 'csv|xlsx|docx|pdf|txt|jpeg|jpg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/filefinish/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_finish')) {
                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                redirect('helpdesk/pelaporan');
            }
        }

        // Prepare the data for insertion
        $id = $this->input->post('id_pelaporan');
        $data = [
            'id_pelaporan' => $id,
            'no_tiket' => $this->input->post('no_tiket'),
            'waktu_pelaporan' => $this->input->post('waktu_pelaporan'),
            'file_finish'     => $photo,
            'nama'     => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'priority'   => $this->input->post('priority'),
            'maxday'     => $this->input->post('maxday'),
            'catatan_finish' => $this->input->post('catatan_finish'),
            'status'     => 'Solved',
            'status_ccs' => 'CLOSE'
        ];

        // Remove unwanted HTML tags from data
        $data = array_map(function ($value) {
            return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
        }, $data);

        // Insert the data into the database
        $this->pelaporan_model->updateHD($id, $data);

        // Set a success message and redirect to the submission page
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('helpdesk/pelaporan');
    }

    public function upload()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/filefinish/';

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


    public function edit_pelaporan()
    {

        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $status_ccs   = $this->input->post('status_ccs');
        $impact       = $this->input->post('impact');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'status_ccs' => $status_ccs,
            'impact'     => $impact

        );
        $this->pelaporan_model->updateImpact($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('helpdesk/pelaporan'));
    }


    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namaspv');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        $this->db->insert('s_forward', $data);
        $this->klienpelaporan_model->updateForward($id_pelaporan, $id_user);
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('helpdesk/pelaporan'));
    }

    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->klienpelaporan_model->get_latest_comments($id);
        $data['datareply']     = $this->klienpelaporan_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_pelaporann($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->klienpelaporan_model->get_latest_comments($id);
        $data['datareply']     = $this->klienpelaporan_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_pelaporann', $data);
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
        Redirect(Base_url('helpdesk/detail_pelaporan/' . $id_pelaporan));
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
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
        Redirect(Base_url('helpdesk/detail_pelaporan/' . $id_pelaporan));
    }

    // public function fungsi_forward()
    // {
    //     $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
    //     $this->form_validation->set_rules('namahd','Helpdesk', 'required');
    //     $data = [
    //         'pelaporan_id' => $this->input->post('id_pelaporan'),
    //         'user_id' => $this->input->post('namaspv')
    //     ];
    //     $this->db->insert('forward', $data);
    //     $this->session->set_flashdata('pesan', 'Success Forward!');
    //     Redirect(Base_url('helpdesk/pelaporan'));
    // }

    // public function statistik()
    // {

    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    //     $this->load->model('Pelaporan_model', 'pelaporan_model');
    //     $data['tickets_per_user'] = $this->pelaporan_model->get_tickets_count_per_user();
    //     $this->load->view('templates/header');
    //     $this->load->view('templates/helpdesk_sidebar');
    //     $this->load->view('helpdesk/statistik', $data);
    //     $this->load->view('templates/footer');
    // }




    public function statistik()
    {
        // // Fetch total active data from the model
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/statistik');
        $this->load->view('templates/footer');
    }
}
