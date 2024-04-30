<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
      
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/support_sidebar');
        $this->load->view('support/dashboard');
        $this->load->view('templates/footer');
    }

    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanSupport();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/support_sidebar');
        $this->load->view('support/pelaporan', $data);
        $this->load->view('templates/footer');
    }

}