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
        $data['namahd'] = $this->user_model->getNamaUser();

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
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanOP();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanClose();

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
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }

    public function edit_pelaporan()
    {
        $id         = $this->input->post('id');
        $no_tiket   = $this->input->post('no_tiket');
        $perihal    = $this->input->post('perihal');
        $status     = $this->input->post('status');
        $status_ccs = $this->input->post('status_ccs');
        $kategori   = $this->input->post('kategori');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday'); 
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'perihal'    => $perihal,
            'status'     => $status,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday

        );
        $this->pelaporan_model->updateCP($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Success Edited!');
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

    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $data = [
            'pelaporan_id' => $this->input->post('id_pelaporan'),
            'user_id' => $this->input->post('namahd')
        ];
        $this->db->insert('forward', $data);
        Redirect(Base_url('supervisor2/added'));
    }
}