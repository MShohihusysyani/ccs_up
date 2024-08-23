<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supervisor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user_model');
        $this->load->model('Supervisor_model', 'supervisor_model');
    }

    public function index()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['data_bpr'] = $this->supervisor_model->getKlien();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/dashboard', $data);
        $this->load->view('templates/footer');
    }
    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/category', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_category()
    {
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $this->form_validation->set_rules('nama_kategori', 'Kategory', 'required');
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];
        $this->db->insert('category', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('supervisor/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/category'));
    }

    public function edit_kategori()
    {
        $id            = $this->input->post('id');
        $nama_kategori = $this->input->post('nama_kategori');
        $ArrUpdate     = array(
            'nama_kategori' => $nama_kategori
        );
        $this->category_model->updateKategori($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');

        Redirect(base_url('supervisor/category'));
    }

    #CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $data['klien'] = $this->client_model->getClient();
        $data['user'] = $this->client_model->getUserClient();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/client', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_client()
    {
        $data['no_klien']    = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_klien', 'No Klien', 'required|is_unique[klien.no_klien]');
        $this->form_validation->set_rules('nama_klien', 'Nama Klient', 'required');
        $this->form_validation->set_rules('nama_user_klien', 'Nama User', 'required');

        if ($this->form_validation->run() == FALSE) {
            // belum menampilkan pesan error
            redirect('supervisor/client');
        } else {

            $data = [
                'no_klien'    => $this->input->post('no_klien'),
                'nama_klien' => $this->input->post('nama_klien'),
                'id_user_klien' => $this->input->post('nama_user_klien')
            ];
            $this->db->insert('klien', $data);
            $this->session->set_flashdata('pesan', 'Successfully Added!');
            redirect('supervisor/client');
        }
    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/client'));
    }

    public function edit_klien()
    {
        $id         = $this->input->post('id');
        $no_klien    = $this->input->post('no_klien');
        $nama_klien = $this->input->post('nama_klien');
        $ArrUpdate  = array(
            'no_klien'    => $no_klien,
            'nama_klien' => $nama_klien
        );
        $this->client_model->updateKlien($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor/client'));
    }

    #USER
    public function user()
    {

        $this->load->model('Usermaster_model', 'usermaster_model');
        $data['divisi']     = $this->db->get('user')->result_array();
        $data['nama']       = $this->db->get('user')->result_array();
        $data['username']   = $this->db->get('user')->result_array();
        $data['active']     = $this->db->get('user')->result_array();
        $this->load->model('Client_model', 'client_model');
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $data['user'] = $this->usermaster_model->getUser();
        $data['klien'] = $this->client_model->getClient();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/user', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_user()
    {
        $data['divisi']   = $this->db->get('user')->result_array();
        $data['nama_user']     = $this->db->get('user')->result_array();
        $data['username'] = $this->db->get('user')->result_array();
        $data['password'] = $this->db->get('user')->result_array();
        $data['role']     = $this->db->get('user')->result_array();
        $data['active']   = $this->db->get('user')->result_array();

        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');

        // $password = md5($this->input->post('password'));
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data = [
            'divisi'   => $this->input->post('divisi'),
            'nama_user'     => $this->input->post('nama_user'),
            'username' => $this->input->post('username'),
            'password' => $password,
            'role'     => $this->input->post('role'),
            'active'   => $this->input->post('active')
        ];
        $this->db->insert('user', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('supervisor/user');
    }

    public function edit_user()
    {
        $id       = $this->input->post('id_user');
        $divisi   = $this->input->post('divisi');
        $nama     = $this->input->post('nama_user');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role     = $this->input->post('role');
        $active   = $this->input->post('active');
        $ArrUpdate = array(
            'divisi'   => $divisi,
            'nama_user'     => $nama,
            'username' => $username,
            'password' => $password,
            'role'     => $role,
            'active'   => $active,

        );
        $this->usermaster_model->updateUser($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor/user'));
    }

    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/user'));
    }


    public function AllTicket()
    {

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/allticket');
        $this->load->view('templates/footer');
    }

    public function ajax_list()
    {
        $list = $this->supervisor_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pelaporan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pelaporan->no_tiket;
            $row[] = tanggal_indo($pelaporan->waktu_pelaporan);
            $row[] = $pelaporan->nama;
            $row[] = $pelaporan->perihal;
            $row[] = $pelaporan->impact;
            $row[] = '<a href="' . site_url('assets/files/' . $pelaporan->file) . '">' . $pelaporan->file . '</a>';
            $pelaporan->file;
            $row[] = $pelaporan->kategori;
            $row[] = $pelaporan->tags;
            // Proses nilai prioritas di server-side
            if ($pelaporan->priority == 'Low') {
                $priority_label = '<span class="label label-info">Low</span>';
            } elseif ($pelaporan->priority == 'Medium') {
                $priority_label = '<span class="label label-warning">Medium</span>';
            } elseif ($pelaporan->priority == 'High') {
                $priority_label = '<span class="label label-danger">High</span>';
            } else {
                $priority_label = $pelaporan->priority;
            }

            $row[] = $priority_label;
            // Proses nilai maxday di server-side
            if ($pelaporan->maxday == '90') {
                $maxday_label = '<span class="label label-info">90</span>';
            } elseif ($pelaporan->maxday == '60') {
                $maxday_label = '<span class="label label-warning">60</span>';
            } elseif ($pelaporan->maxday == '7') {
                $maxday_label = '<span class="label label-danger">7</span>';
            } else {
                $maxday_label = $pelaporan->maxday;
            }

            $row[] = $maxday_label;
            // Proses nilai maxday di server-side
            if ($pelaporan->status_ccs == 'ADDED') {
                $status_ccs_label = '<span class="label label-primary">ADDED</span>';
            } elseif ($pelaporan->status_ccs == 'ADDED 2') {
                $status_ccs_label = '<span class="label label-primary">ADDED 2</span>';
            } elseif ($pelaporan->status_ccs == 'HANDLE') {
                $status_ccs_label = '<span class="label label-info">HANDLE</span>';
            } elseif ($pelaporan->status_ccs == 'HANDLE 2') {
                $status_ccs_label = '<span class="label label-info">HANDLE 2</span>';
            } elseif ($pelaporan->status_ccs == 'CLOSE') {
                $status_ccs_label = '<span class="label label-warning">CLOSE</span>';
            } elseif ($pelaporan->status_ccs == 'FINISH') {
                $status_ccs_label = '<span class="label label-success">FINISH</span>';
            } else {
                $status_ccs_label = $pelaporan->status_ccs;
            }

            $row[] = $status_ccs_label;
            //Gabungkan handle_by, handle_by2, handle_by3
            $handle_combined = $pelaporan->handle_by;
            if ($pelaporan->handle_by2) {
                $handle_combined .= ', ' . $pelaporan->handle_by2;
            }
            if ($pelaporan->handle_by3) {
                $handle_combined .= ', ' . $pelaporan->handle_by3;
            }
            $row[] = $handle_combined;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supervisor_model->count_all(),
            "recordsFiltered" => $this->supervisor_model->count_filtered(),
            "data" => $data,
        );
        // output dalam format JSON
        echo json_encode($output);
    }

    public function added()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->supervisor_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();


        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanClose();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }

    public function edit_pelaporan()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $status_ccs   = $this->input->post('status_ccs');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday,
            'tags'       => $tags

        );
        $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor/added'));
    }

    //   Approve Tiket
    public function finish_pelaporan($id)
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan_close($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/finish_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_approve_pelaporan()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');

        $id_pelaporan         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        $nama       = $this->input->post('nama');
        $judul      = $this->input->post('judul');
        // $perihal    = $this->input->post('perihal');
        $status_ccs = 'FINISH';
        $waktu      = date('Y-m-d');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
        $kategori   = $this->input->post('kategori');

        $this->db->set('judul', $judul);
        $this->db->set('no_tiket', $no_tiket);
        $this->db->set('nama', $nama);
        $this->db->set('status_ccs', $status_ccs);
        $this->db->set('waktu_approve', $waktu);
        $this->db->set('priority', $priority);
        // $this->db->set('perihal', $perihal);
        $this->db->set('maxday', $maxday);
        $this->db->set('kategori', $kategori);
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan');
        $this->session->set_flashdata('pesan', 'Succesfully Approve!');
        Redirect(base_url('supervisor/close'));
    }


    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->get_latest_comments($id);
        $data['datareply']     = $this->supervisor_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/detail_finish', $data);
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
        Redirect(Base_url('supervisor/detail_pelaporan/' . $id_pelaporan));
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
        Redirect(Base_url('supervisor/detail_pelaporan/' . $id_pelaporan));
    }

    //   FILTER LAPORAN
    public function rekapPelaporan()
    {
        // Load necessary models
        $this->load->model('supervisor_model', 'supervisor_model');
        $this->load->model('Client_model', 'client_model');

        // var data for view 
        $data['tanggal_awal'] = '';
        $data['tanggal_akhir'] = '';
        $data['status_ccs'] = '';
        $data['nama_klien'] = '';
        $data['tags'] = '';

        // Get all data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->supervisor_model->getAllData(); // A method that returns all data

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_pelaporan', $data);
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

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');
            $tags = $this->input->post('tags');

            // var data for view 
            $data['tanggal_awal'] = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs'] = $status_ccs;
            $data['nama_klien'] = $nama_klien;
            $data['tags'] = $tags;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }
    }

    public function fetch_data()
    {
        $this->load->model('Server_model', 'serverside_model');

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
        $list = $this->serverside_model->get_datatables($filters);
        $data = array();

        // Format data sesuai kebutuhan DataTables
        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1; // Nomor urutan
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['perihal'] = isset($dataItem->perihal) ? $dataItem->perihal : '';
            $row['tags'] = '<span class="label label-info">' . $dataItem->tags . '</span>';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            $row['impact'] = isset($dataItem->impact) ? $dataItem->impact : '';
            $row['priority'] = $this->get_priority_label($dataItem->priority);
            $row['maxday'] = $this->get_maxday_label($dataItem->maxday);
            $row['status_ccs'] = $this->get_status_label($dataItem->status_ccs);
            $data[] = $row;
        }

        // Menyiapkan output JSON untuk DataTables
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->serverside_model->count_all(),
            "recordsFiltered" => $this->serverside_model->count_filtered($filters),
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
        if ($status == 'FINISH') {
            return '<span class="label label-success">FINISH</span>';
        } elseif ($status == 'CLOSE') {
            return '<span class="label label-warning">CLOSE</span>';
        } elseif ($status == 'HANDLE') {
            return '<span class="label label-info">HANDLE</span>';
        } elseif ($status == 'ADDED') {
            return '<span class="label label-primary">ADDED</span>';
        }
    }

    //LAPORAN FILTER KATEGORI
    public function rekapKategori()
    {
        $this->load->model('Category_model', 'category_model');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getAllCategory();
        $data['category'] = $this->category_model->getCategory();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function dateKategori()
    {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        // $nama_kategori = $this->input->post('nama_kategori');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['category'] = $this->category_model->getCategory();
        $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_kategori', $data);
        $this->load->view('templates/footer');
    }



    // REKAP HANDLE BY HELPDESK
    public function rekapHelpdesk()
    {
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getHelpdesk();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    public function datehelpdesk()
    {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getDateHelpdesk($tgla, $tglb);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    // REKAP PROGRESS
    public function rekapProgres()
    {
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getProgres();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_progres', $data);
        $this->load->view('templates/footer');
    }

    public function dateprogres()
    {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $status_ccs = $this->input->post('status_ccs');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getDateProgres($tgla, $tglb, $status_ccs);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/rekap_progres', $data);
        $this->load->view('templates/footer');
    }

    //DISTRIBUSI TO HELPDESK
    public function fungsi_forward()
    {
        // Set validation rules
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required', [
            'required' => 'Kolom Helpdesk wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back to the form with error messages
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor/added');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namahd');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // cari nama user berdasarkan id 
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();
            $user = $query->row();
            $nama_user = $user->nama_user;

            $this->db->insert('forward', $data);
            $this->supervisor_model->updateForward($id_pelaporan, $nama_user);
            $this->session->set_flashdata('pesan', 'Successfully Forward!');
            Redirect(Base_url('supervisor/added'));
        }
    }


    public function fungsi_edit()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required', [
            'required' => 'Kolom Helpdesk wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);


        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back to the form with error messages
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor/onprogress');
        } else {
            // Retrieve POST data
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namahd');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                // Update the forward table
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->update('forward', $data);

                // Update the Helpdesk in the supervisor_model
                $this->supervisor_model->updateHD($id_pelaporan, $nama_user);

                // Set success message
                $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
            } else {
                // Set error message if user not found
                $this->session->set_flashdata('error', 'User not found.');
            }

            // Redirect to the onprogress page
            redirect(base_url('supervisor/onprogress'));
        }
    }


    // FUNGSI REJECT
    public function fungsi_reject()
    {

        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required');

        // Check if the form passes validation
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form validation failed. Please fill in all required fields.');
            redirect(base_url('supervisor/onprogress'));
        } else {
            // Retrieve POST data
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namahd');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                // Update the forward table
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->update('forward', $data);

                // Update the Helpdesk in the supervisor_model
                $this->supervisor_model->updateReject($id_pelaporan, $nama_user);

                // Set success message
                $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
            } else {
                // Set error message if user not found
                $this->session->set_flashdata('error', 'User not found.');
            }

            // Redirect to the onprogress page
            redirect(base_url('supervisor/close'));
        }
    }

    public function get_notifications()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Supervisor_model', 'supervisor_model');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        // Ambil notifikasi dari database dengan paginasi
        $notifications = $this->supervisor_model->get_notifications($limit, $offset);

        // Total notifikasi yang tersedia di server
        $total_count = $this->supervisor_model->get_total_count();

        // Kirim response JSON
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $this->supervisor_model->get_unread_count(),
            'total_count' => $total_count
        ]);
    }
    public function fetch_notifications()
    {
        $limit = 5;  // Tampilkan 20 notifikasi per halaman
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $this->load->model('Supervisor_model', 'supervisor_model');
        $notifications = $this->supervisor_model->get_notifications($limit, $offset);
        $unread_count = $this->supervisor_model->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
}
