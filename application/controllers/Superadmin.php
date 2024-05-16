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
        $data['datacomment']   = $this->superadmin_model->ambil_id_comment($id);
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
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
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo
        ];

        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/'.$id_pelaporan));
    }

}