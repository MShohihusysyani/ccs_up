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
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');

        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanImplementator();

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getDataPelaporanImplementator();


        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
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
        $this->pelaporan_model->updateImplementator($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('implementator/pelaporan');
    }

    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->klienpelaporan_model->ambil_id_comment($id);
        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('implementator/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('user_id','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = htmlspecialchars($this->input->post('body'));
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body
        ];

        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('implementator/detail_pelaporan/'.$id_pelaporan));
    }


}