<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk3 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
      
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk3_sidebar');
        $this->load->view('helpdesk3/dashboard');
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
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHD3();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk3_sidebar');
        $this->load->view('helpdesk3/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');

        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getDataPelaporanHD3();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk3_sidebar');
        $this->load->view('helpdesk3/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

       //FINISH HELPDESK
       public function finish()
       {
           // date_default_timezone_set('Asia/Jakarta');
            # add your city to set local time zone
   
   
            $id              = $this->input->post('id');
            $no_tiket        = $this->input->post('no_tiket');
            $waktu_pelaporan = $this->input->post('waktu_pelaporan');
            $nama            = $this->input->post('nama');
            $perihal         = $this->input->post('perihal');
            $status          = 'Solved by HD3';
            $status_ccs      = 'CLOSE';
            $keterangan      = $this->input->post('keterangan');
            $handle_by       = $this->input->post('handle_by');
            $ArrUpdate       = array(
    
                'no_tiket'        => $no_tiket,
                'waktu_pelaporan' => $waktu_pelaporan,
                'nama'            => $nama,
                'perihal'         => $perihal,
                'status'          => $status,
                'status_ccs'      => $status_ccs,
                'handle_by'       => $handle_by,
                'keterangan'      => $keterangan
    
            );
            $this->pelaporan_model->updateHD1($id, $ArrUpdate);
            $this->session->set_flashdata('pesan', 'Successfully Finish!');
            redirect('helpdesk3/pelaporan');
        }

        public function forwardtoImplementator()
        {
            // date_default_timezone_set('Asia/Jakarta');
             # add your city to set local time zone
    
    
   
             $id              = $this->input->post('id');
             $no_tiket        = $this->input->post('no_tiket');
             $waktu_pelaporan = $this->input->post('waktu_pelaporan');
             $nama            = $this->input->post('nama');
             $perihal         = $this->input->post('perihal');
             $status          = 'Forward From Helpdesk 3';
             $status_ccs      = 'HANDLE';
             $handle_by       = $this->input->post('handle_by');
             $keterangan      = $this->input->post('keterangan');
             $ArrUpdate       = array(
     
                 'no_tiket'        => $no_tiket,
                 'waktu_pelaporan' => $waktu_pelaporan,
                 'nama'            => $nama,
                 'perihal'         => $perihal,
                 'status'          => $status,
                 'status_ccs'      => $status_ccs,
                 'handle_by'       => $handle_by,
                 'keterangan'      => $keterangan
     
             );
             $this->pelaporan_model->updateForward($id, $ArrUpdate);
             $this->session->set_flashdata('pesan', 'Successfully Finish!');
        
             $referred_from = $this->session->userdata('referred_from');
             redirect($referred_from, 'refresh');
 
            
         }
 

}