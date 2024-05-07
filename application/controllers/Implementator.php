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

}