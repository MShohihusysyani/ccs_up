<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supervisor2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user_model');
    }

    public function index()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['data_bpr'] = $this->supervisor_model->getKlien();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function AllTicket()
    {
        $this->load->model('Spv2_model', 'spv2_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/allticket', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('Spv2_model', 'spv2_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->spv2_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Spv2_model', 'spv2_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanClose();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }
    
    public function finish()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }

    //FUNGSI APPROVE
    public function approve()
    {
        // date_default_timezone_set('Asia/Jakarta');
        # add your city to set local time zone
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');

        $id         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        $nama       = $this->input->post('nama');
        $perihal    = $this->input->post('perihal');
        $status_ccs ='FINISH';
        $waktu      = date('Y-m-d');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
        $kategori   = $this->input->post('kategori');
        $ArrUpdate  = array(
            'no_tiket'       => $no_tiket,
            'nama'           => $nama,
            'perihal'        => $perihal,
            'status_ccs'     => $status_ccs,
            'waktu_approve'  => $waktu,
            'priority'       => $priority,
            'maxday'         => $maxday,
            'kategori'       => $kategori
        );
        $this->pelaporan_model->approveSPV($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Approve!');
        redirect('supervisor/finish');

    }

    public function edit_pelaporan()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $perihal      = $this->input->post('perihal');
        $status_ccs   = $this->input->post('status_ccs');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'perihal'    => $perihal,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday,
            'tags'       => $tags

        );
        $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor2/added'));
    }

    public function pilih_helpdesk($id){

        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);

        // $this->load->model('Divisi_model', 'divisi_model');
        // $data['divisi'] = $this->divisi_model->getDivisi();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pilih_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_edit_helpedesk()
    {
        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();

        $this->db->where('id_pelaporan');
        $this->db->update('pelaporan');
        Redirect(base_url('supervisor2/added'));
    }

    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->ambil_id_comment($id);
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/detail_pelaporan', $data);
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
        Redirect(Base_url('supervisor2/detail_pelaporan/'.$id_pelaporan));
    }

    // FORWARD KE TEKNISI
    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namateknisi');
        $judul   = $this->input->post('judul');
        $subtask = $this->input->post('subtask');
        $tanggal = $this->input->post('tanggal');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'judul'   => $judul,
            'subtask' => $subtask,
            'tanggal' => $tanggal
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->insert('t1_forward', $data);
        $this->spv2_model->updateForward($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('supervisor2/added'));
    }

    //EDIT TEKNISI
    public function fungsi_edit()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namateknisi');
        $subtask = $this->input->post('subtask');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'subtask' => $subtask
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->update('t1_forward', $data);
        $this->spv2_model->updateTeknisi($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Teknisi has been update!');
        Redirect(Base_url('supervisor2/onprogress'));
    }

    //TAMBAH TEKNISI
    public function fungsi_tambah()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namateknisi');
        $judul   = $this->input->post('judul2');
        $subtask = $this->input->post('subtask2');
        $tanggal = $this->input->post('tanggal2');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'judul2'   => $judul,
            'subtask2' => $subtask,
            'tanggal2' => $tanggal
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->insert('t2_forward', $data);
        $this->spv2_model->tambahTeknisi($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Teknisi has been update!');
        Redirect(Base_url('supervisor2/onprogress'));
    }
}