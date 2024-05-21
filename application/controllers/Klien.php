<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
        $this->load->model('klienpelaporan_model');
    }

    public function index()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['data_handle'] = $this->client_model->getDataKlienHandle();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function add_temp()
    {
        
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|docx|pdf|jpeg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/files/';

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
        $data          = [
            'no_tiket' => $this->input->post('no_tiket'),
            'perihal'  => $this->input->post('perihal'),
            'file'     => $photo,
            'user_id'  => $this->input->post('user_id'),
            'nama'     => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'tags'     => $this->input->post('tags'),
            'judul'    => $this->input->post('judul')
        ];
        $this->db->insert('tiket_temp', $data);
        $this->session->set_flashdata('pesan', 'Pelaporan Added!');

        redirect('klien/pengajuan');
    }

    public function fungsi_delete_temp($id)
    {
        $this->load->model('Temp_model', 'temp_model');
        $this->temp_model->hapus_temp($id);
        $this->session->set_flashdata('pesan', 'Data Deleted!');
        Redirect(Base_url('klien/pengajuan'));
    }

    public function fungsi_pengajuan()
    {
        $this->pelaporan_model->add_pelaporan();
        $this->session->set_flashdata('pesan', 'Pelaporan Success!');
        $this->pelaporan_model->delete_pelaporan();
        Redirect(Base_url('klien/datapelaporan'));
    }


    public function tiket_temp()
    {
        $this->load->model('Temp_model', 'temp_model');
        $data['nama_kateogori'] = $this->db->get('tiket_temp')->result_array();
        $data['tiket_temp'] = $this->temp_model->getTiketTemp();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    public function pengajuan()
    {
        // $data['noTiket'] = $this->client_model->getkodeticket();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();
        $this->load->model('Temp_model', 'temp_model');
        $data['nama_kategori'] = $this->db->get('tiket_temp')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $data['tiket_temp'] = $this->temp_model->getTiketTemp1();
        $id_user = $this->session->userdata('id_user');
        $no_klien = $this->client_model->getNoKlien($id_user);
        $no_urut = $this->client_model->getNoUrut($id_user);
        $bulan = $time = date("m");
        $tahun = $time = date("Y"); 

        $data['tiket'] = "TIC".$no_klien.$tahun.$bulan.$no_urut;

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    #data pelaporan
    public function datapelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanTemp();
        
        
        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function bank_knowlage()
    {
        // $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanTemp();
        
        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/bank_knowlage');
        $this->load->view('templates/footer');
    }

    public function edit_tiket()
    {

         //jika FILE
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'jpg|png|docx|pdf|xlsx';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/files/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
 
            if ($this->upload->do_upload('file')) {
                $old_image = $data['tiket_temp']['file'];
                if ($old_image != '') {
                    unlink(FCPATH . 'assets/files/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('file', $new_image);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                redirect('klien/pengajuan');
            }
        }
        $id_temp = $this->input->post('id_temp');
        $no_tiket     = $this->input->post('no_tiket');
        $judul        = $this->input->post('judul');
        $perihal      = $this->input->post('perihal');
        $kategori     = $this->input->post('kategori');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'judul'      => $judul,
            'perihal'    => $perihal,
            'kategori'   => $kategori,
            'tags'       => $tags,
            'file'       => $photo

        );
        $this->temp_model->updateTiket($id_temp, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('klien/pengajuan'));
    }
    // EDIT PELAPORAN
    public function edit_pelaporan($id){

        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->klienpelaporan_model->ambil_id_comment($id);

        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();


        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/edit_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_edit_pelaporan()
    {
        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();

        $id_pelaporan = $this->input->post('id_pelaporan');
        $waktu_pelaporan = $this->input->post('waktu_pelaporan');
        $nama = $this->input->post('nama');
        $perihal = $this->input->post('perihal');
        $perihal = $this->input->post('perihal');
        $status = $this->input->post('status');

        //jika FILE
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'jpg|png|docx|pdf|xlsx';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/files/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $old_image = $data['pelaporan']['file'];
                if ($old_image != '') {
                    unlink(FCPATH . 'assets/files/' . $old_image);
                }
                $new_image = $this->upload->data('file_name');
                $this->db->set('file', $new_image);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                redirect('klien/edit_pelaporan');
            }
        }

        $this->db->set('waktu_pelaporan', $waktu_pelaporan);
        $this->db->set('nama', $nama);
        $this->db->set('perihal', $perihal);
        $this->db->set('status', $status);
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan');
        $this->session->set_flashdata('pesan', 'Data Edited!');
        Redirect(base_url('klien/datapelaporan'));
    }

    public function detail_pelaporan($id)
        {
            $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
            $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
            $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
            $data['datacomment']   = $this->klienpelaporan_model->get_latest_comments($id);
            $data['datareply']     = $this->klienpelaporan_model->get_replies_by_pelaporan_id($id);

            $this->load->view('templates/header');
            $this->load->view('templates/klien_sidebar');
            $this->load->view('klien/detail_pelaporan', $data);
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
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('klien/detail_pelaporan/'.$id_pelaporan));
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
        Redirect(Base_url('klien/detail_pelaporan/'.$id_pelaporan));
    }


    public function rate_item() {

        $id_pelaporan = $this->input->post('id_pelaporan');
        $rating = $this->input->post('rating');
        $data = [
            'rating'    => $rating
        ];
        $this->db->update('rating', $data);
        $this->klienpelaporan_model->updateRate($id_pelaporan, $rating);
    }

    public function insert_rating() {

        $data['rating_name']    = $this->db->get('rating')->result_array();

        $this->form_validation->set_rules('rating_name', 'Rating', 'required');
        $data = [
            'rating_name'    => $this->input->post('rating_name')
        ];
        $this->db->insert('rating', $data);
    
    }

    public function insert_rating2() {

        // $data['rating']    = $this->db->get('pelaporan')->result_array();
        // $data['id_pelaporan']    = $this->db->get('pelaporan')->result_array();
        $id_pelaporan = $this->input->post('id_pelaporan');
        $rating = $this->input->post('rating');

        $this->form_validation->set_rules('rating', 'Rating', 'required');
        $data = [
            'rating'    => $rating
        ];
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan', $data);
        // $this->klienpelaporan_model->updateRate($id_pelaporan, $rating);

    
    }

    public function update()
{
    	$id_pelaporan = $this->input->post('id_pelaporan');
		$data = array(
	        'rating' => $this->input->post('rating')
		);
        $this->klienpelaporan_model->update_data('pelaporan',$data,$id_pelaporan);
    }
}