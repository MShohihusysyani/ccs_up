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

    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'Implementator_model');

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->Implementator_model->getKlienPelaporanImplementator();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->implementator_model->getKlienPelaporanClose();

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

    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Implementator_model', 'implementator_model');
        $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->implementator_model->getDataPelaporanImplementator();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

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
        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('catatan_finish', 'Catatan Finish', 'callback_validateCatatanFinish');

        // Check if the form validation passed
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, set an error message and redirect back
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            redirect('implementator/pelaporan');
        } else {
            // Check if there are any pending subtasks
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
            $config['allowed_types'] = 'csv|xlsx|docx|pdf|txt|jpeg|jpg|png|rar|zip';
            $config['max_size'] = '2048';
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

        // Prepare the data for insertion
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
            'status_ccs' => 'CLOSE'
        ];

        // Remove unwanted HTML tags from data
        $data = array_map(function ($value) {
            return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
        }, $data);

        // Insert the data into the database
        $this->pelaporan_model->updateImplementator($id, $data);

        // Set a success message and redirect to the submission page
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('implementator/pelaporan');
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

    public function statistik()
    {
        // // Fetch total active data from the model
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/statistik');
        $this->load->view('templates/footer');
    }

    public function subtask()
    {
        // // Fetch total active data from the model

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
        date_default_timezone_set('Asia/Jakarta'); // Set local time zone

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
        // // Fetch total active data from the model
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
}
