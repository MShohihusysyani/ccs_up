<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['data_bpr'] = $this->superadmin_model->getKlien();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/category', $data);
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
        redirect('superadmin/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/category'));
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
        Redirect(base_url('superadmin/category'));
    }

    // DATA CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        
        $data['klien'] = $this->client_model->getClient();
        $data['user'] = $this->client_model->getUserClient();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/client', $data);
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
   
        if ($this->form_validation->run() == FALSE)
        {
            // belum menampilkan pesan error
            redirect('superadmin/client');
        }
        else
        {

            $data = [
                'no_klien'    => $this->input->post('no_klien'),
                'nama_klien' => $this->input->post('nama_klien'),
                'id_user_klien' => $this->input->post('nama_user_klien')
            ];
            $this->db->insert('klien', $data);
            $this->session->set_flashdata('pesan', 'Successfully Added!');
            redirect('superadmin/client');
        }


    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/client'));
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
        Redirect(base_url('superadmin/client'));
    }

     # DATA USER
     public function user(){

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
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/user', $data);
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
        redirect('superadmin/user');
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
        Redirect(base_url('superadmin/user'));
    }

    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/user'));
    }

    // LIST TICKET
    public function AllTicket()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/allticket', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->superadmin_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanClose();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }
    
    public function finish()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }

    
    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->superadmin_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->get_latest_comments($id);
        $data['datareply']     = $this->supervisor_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|docx|pdf|jpeg|png';
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

        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('user_id','Helpdesk', 'required');
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

        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/'.$id_pelaporan));
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|docx|pdf|jpeg|png|jpg';
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
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('user_id','Helpdesk', 'required');
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

        $this->db->insert('reply', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/'.$id_pelaporan));
    }

}