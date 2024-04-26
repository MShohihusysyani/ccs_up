<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
      
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/dashboard');
        $this->load->view('templates/footer');
    }

    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['handle_by'] = $this->db->get_where('user', ['handle_by' => $this->session->userdata('handle_by')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHD();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function reject()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['handle_by'] = $this->db->get_where('user', ['handle_by' => $this->session->userdata('handle_by')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanHDReject();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/reject', $data);
        $this->load->view('templates/footer');
    }


    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->klienpelaporan_model->getDataPelaporanHD();


        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }


      //FINISH HELPDESK
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
           $ArrUpdate       = array(
   
               'no_tiket'        => $no_tiket,
               'waktu_pelaporan' => $waktu_pelaporan,
               'nama'            => $nama,
               'perihal'         => $perihal,
               'status'          => $status,
               'status_ccs'      => $status_ccs
           );
           $this->pelaporan_model->updateHD($id, $ArrUpdate);
           $this->session->set_flashdata('pesan', 'Successfully Finish!');
           redirect('helpdesk/data_pelaporan');
       }

        public function edit_pelaporan()
        {
            
    
            $id_pelaporan = $this->input->post('id_pelaporan');
            $no_tiket     = $this->input->post('no_tiket');
            $perihal      = $this->input->post('perihal');
            $status       = $this->input->post('status');
            $status_ccs   = $this->input->post('status_ccs');
            $impact       = $this->input->post('impact');

          
            $ArrUpdate = array(
                'no_tiket'   => $no_tiket,
                'perihal'    => $perihal,
                'status'     => $status,
                'status_ccs' => $status_ccs,
                'impact'     => $impact
    
            );
            $this->pelaporan_model->updateImpact($id_pelaporan, $ArrUpdate);
            $this->session->set_flashdata('pesan', 'Successfully Edited!');
            Redirect(base_url('helpdesk/pelaporan'));
        }

        // public function fungsi_forward()
        // {
        //     $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        //     $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        //     $data = [
        //         'pelaporan_id' => $this->input->post('id_pelaporan'),
        //         'user_id' => $this->input->post('namaspv')
        //     ];
       
        //     $this->db->insert('forward', $data);
        //     $this->session->set_flashdata('pesan', 'Success Forward!');
        //     Redirect(Base_url('helpdesk/pelaporan'));
        // }

        public function fungsi_forward()
        {
            $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
            $this->form_validation->set_rules('namahd','Helpdesk', 'required');
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namaspv');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            $this->db->update('forward', $data);
            $this->klienpelaporan_model->updateForward($id_pelaporan, $id_user);
            $this->session->set_flashdata('pesan', 'Successfully Forward!');
            Redirect(Base_url('helpdesk/pelaporan'));
        }

}