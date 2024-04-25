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

    public function finish()
    {
        // date_default_timezone_set('Asia/Jakarta');
         # add your city to set local time zone


         $id              = $this->input->post('id');
         $no_tiket        = $this->input->post('no_tiket');
         $waktu_pelaporan = $this->input->post('waktu_pelaporan');
         $nama            = $this->input->post('nama');
         $perihal         = $this->input->post('perihal');
         $status          = 'Forwad To Helpdesk 1';
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
         $this->pelaporan_model->updateImplementator($id, $ArrUpdate);
         redirect('implementator/pelaporan');
     }

     public function finish2()
     {
         // date_default_timezone_set('Asia/Jakarta');
          # add your city to set local time zone
 
 
          $id              = $this->input->post('id');
          $no_tiket        = $this->input->post('no_tiket');
          $waktu_pelaporan = $this->input->post('waktu_pelaporan');
          $nama            = $this->input->post('nama');
          $perihal         = $this->input->post('perihal');
          $status          = 'Forward To Helpdesk 2';
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
          $this->pelaporan_model->updateImplementator($id, $ArrUpdate);
          redirect('implementator/pelaporanhd2');
      }

      public function finish3()
      {
          // date_default_timezone_set('Asia/Jakarta');
           # add your city to set local time zone
  
  
           $id              = $this->input->post('id');
           $no_tiket        = $this->input->post('no_tiket');
           $waktu_pelaporan = $this->input->post('waktu_pelaporan');
           $nama            = $this->input->post('nama');
           $perihal         = $this->input->post('perihal');
           $status          = 'Forward To Helpdesk 3';
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
           $this->pelaporan_model->updateImplementator($id, $ArrUpdate);
           redirect('implementator/pelaporanhd3');
       }

       public function finish4()
      {
          // date_default_timezone_set('Asia/Jakarta');
           # add your city to set local time zone
  
  
           $id              = $this->input->post('id');
           $no_tiket        = $this->input->post('no_tiket');
           $waktu_pelaporan = $this->input->post('waktu_pelaporan');
           $nama            = $this->input->post('nama');
           $perihal         = $this->input->post('perihal');
           $status          = 'Forward To Helpdesk 4';
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
           $this->pelaporan_model->updateImplementator($id, $ArrUpdate);
           redirect('implementator/pelaporanhd4');
       }
     
     
    
}