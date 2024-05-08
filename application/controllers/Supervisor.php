<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supervisor extends CI_Controller
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
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/dashboard', $data);
        $this->load->view('templates/footer');
    }
    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();


        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/category', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_category()
    {
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $this->form_validation->set_rules('nama_kategori', 'Kategory', 'required');
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori')
        ];
        $this->db->insert('category', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('supervisor/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/category'));
    }

    public function edit_kategori()
    {
        $id            = $this->input->post('id');
        $nama_kategori = $this->input->post('nama_kategori');
        $ArrUpdate     = array(
            'nama_kategori' => $nama_kategori
        );
        $this->category_model->updateKategori($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        
        Redirect(base_url('supervisor/category'));
    }

    #CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        
        $data['klien'] = $this->client_model->getClient();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/client', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_client()
    {
        $data['no_urut']    = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');
        $data = [
            'no_urut'    => $this->input->post('no_urut'),
            'nama_klien' => $this->input->post('nama_klien')
        ];
        $this->db->insert('klien', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('supervisor/client');
    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/client'));
    }

    public function edit_klien()
    {
        $id         = $this->input->post('id');
        $no_urut    = $this->input->post('no_urut');
        $nama_klien = $this->input->post('nama_klien');
        $ArrUpdate  = array(
            'no_urut'    => $no_urut,
            'nama_klien' => $nama_klien
        );
        $this->client_model->updateKlien($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor/client'));
    }

    #USER
    public function user(){

        $this->load->model('Usermaster_model', 'usermaster_model');
        $data['divisi']     = $this->db->get('user')->result_array();
        $data['nama']       = $this->db->get('user')->result_array();
        $data['username']   = $this->db->get('user')->result_array();
        $data['active']     = $this->db->get('user')->result_array();
        $this->load->model('Client_model', 'client_model');
        $data['nama_klien'] = $this->db->get('klien')->result_array();


        $data['user'] = $this->usermaster_model->getUser();
        $data['klien'] = $this->client_model->getClient();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/user', $data);
        $this->load->view('templates/footer');

    }

    public function tambah_user()
    {
        $data['divisi']   = $this->db->get('user')->result_array();
        $data['nama_user']     = $this->db->get('user')->result_array();
        $data['username'] = $this->db->get('user')->result_array();
        $data['password'] = $this->db->get('user')->result_array();
        $data['role']     = $this->db->get('user')->result_array();
        $data['active']   = $this->db->get('user')->result_array();


        $this->form_validation->set_rules('no_urut', 'No Urut', 'required');
        $this->form_validation->set_rules('nama_klien', 'Kategory', 'required');

        // $password = md5($this->input->post('password'));
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data = [
            'divisi'   => $this->input->post('divisi'),
            'nama_user'     => $this->input->post('nama_user'),
            'username' => $this->input->post('username'),
            'password' => $password,
            'role'     => $this->input->post('role'),
            'active'   => $this->input->post('active')
        ];
        $this->db->insert('user', $data);
        $this->session->set_flashdata('pesan', 'Successfully Added!');
        redirect('supervisor/user');
    }

    public function edit_user()
    {
        $id       = $this->input->post('id_user');
        $divisi   = $this->input->post('divisi');
        $nama     = $this->input->post('nama_user');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role     = $this->input->post('role');
        $active   = $this->input->post('active');
        $ArrUpdate = array(
            'divisi'   => $divisi,
            'nama_user'     => $nama,
            'username' => $username,
            'password' => $password,
            'role'     => $role,
            'active'   => $active,

        );
        $this->usermaster_model->updateUser($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor/user'));
    }

    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('supervisor/user'));
    }

    #PELAPORAN
    public function pelaporan1()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['nama'] = $this->db->get('pelaporan')->result_array();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan',$data);
        $this->load->view('templates/footer');
    }

    public function pelaporan2(){
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporan();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function AllTicket()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporan();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/allticket', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->supervisor_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();


        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanClose();


        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();


        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }
    
    public function finish()
    {
        $this->load->model('Supervisor_model', 'supervisor_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->supervisor_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/pelaporan_finish', $data);
        $this->load->view('templates/footer');
    }
    // EDIT CCS
    public function updateccs($id)
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);
        $this->load->model('Category_model', 'category_model');
        $data['category']      = $this->category_model->getCategory();
        

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();
        
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/edit_ccs', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_edit_ccs()
    {
        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getCategory();
      

        // $data['category'] = $this->db->get_where('category', ['nama_kategori' => $this->input->post('kategori')])->row_array();
        $id = $this->input->post('id_pelaporan');
        $no_tiket = $this->input->post('no_tiket');
        $perihal = $this->input->post('perihal');
        $status = $this->input->post('status');
        $status_ccs = $this->input->post('status_ccs');
        $priority = $this->input->post('priority');
        $kategori = $this->input->post('kategori');
        $maxday = $this->input->post('maxday');


        //jika ada gambar
        // $photo = $_FILES['file']['name'];

        // if ($photo) {
        //     $config['allowed_types'] = 'pdf|xlsx|docx|jpg|png';
        //     $config['max_size'] = '2048';
        //     $config['upload_path'] = './assets/files/';

        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);

        //     if ($this->upload->do_upload('file')) {
        //         $old_image = $data['pelaporan']['file'];
        //         if ($old_image != '') {
        //             unlink(FCPATH . 'assets/files/' . $old_image);
        //         }
        //         $new_image = $this->upload->data('file_name');
        //         $this->db->set('file', $new_image);
        //     } else {
        //         $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
        //         redirect('supervisor/edit_ccs');
        //     }
        // }
        $this->db->set('no_tiket', $no_tiket);
        $this->db->set('perihal', $perihal);
        $this->db->set('status', $status);
        $this->db->set('status_ccs', $status_ccs);
        $this->db->set('priority', $priority);
        $this->db->set('kategori', $kategori);
        $this->db->set('maxday', $maxday);
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan');
        $this->session->set_flashdata('pesan', 'Success!');
        Redirect(base_url('supervisor/added'));
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
        Redirect(base_url('supervisor/added'));
    }

    //   Approve supervisor
    public function approve()
    {
        // date_default_timezone_set('Asia/Jakarta');
        # add your city to set local time zone
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');


        $id         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        //$waktu_pelaporan = $this->input->post('waktu_pelaporan');
        $nama       = $this->input->post('nama');
        $perihal    = $this->input->post('perihal');
        $status_ccs ='FINISH';
        $waktu      = date('Y-m-d');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
        $kategori   = $this->input->post('kategori');
        $ArrUpdate  = array(

            'no_tiket'       => $no_tiket,
            //    'waktu_pelaporan' => $waktu_pelaporan,
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

    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->ambil_id_comment($id);
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/detail_pelaporan', $data);
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
        Redirect(Base_url('supervisor/detail_pelaporan/'.$id_pelaporan));
    }


        //   FILTER LAPORAN
        public function rekapPelaporan()
        {
            $this->load->model('Client_model', 'client_model');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getAll();
            $data['klien'] = $this->client_model->getClient();
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }

        public function datepelaporan()
        {
            $tgla       = $this->input->post('tgla');
            $tglb       = $this->input->post('tglb');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');

            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tgla, $tglb, $status_ccs, $nama_klien);
    
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }

        //LAPORAN FILTER KATEGORI
        public function rekapKategori()
        {
            $this->load->model('Category_model', 'category_model');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getAllCategory();
            $data['category'] = $this->category_model->getCategory();
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_kategori', $data);
            $this->load->view('templates/footer');
        }

        public function dateKategori()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            // $nama_kategori = $this->input->post('nama_kategori');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['category'] = $this->category_model->getCategory();
            $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb);
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_kategori', $data);
            $this->load->view('templates/footer');
        }

        // public function dateKategori()
        // {
          
        //     $tgla = $this->input->post('tgla');
        //     $tglb = $this->input->post('tglb');
        //     $nama_kategori = $this->input->post('nama_kategori');
        //     $this->load->model('Pelaporan_model', 'pelaporan_model');
    
        //     $data['category'] = $this->category_model->getCategory();
        //     $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb, $nama_kategori);
    
        //     $this->load->view('templates/header');
        //     $this->load->view('templates/supervisor_sidebar');
        //     $this->load->view('supervisor/rekap_kategori', $data);
        //     $this->load->view('templates/footer');
        // }


        // REKAP HANDLE BY HELPDESK
        public function rekapHelpdesk()
        {
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getHelpdesk();

    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_helpdesk', $data);
            $this->load->view('templates/footer');
        }

        public function datehelpdesk()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getDateHelpdesk($tgla, $tglb);
    
    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_helpdesk', $data);
            $this->load->view('templates/footer');
        }

        // REKAP PROGRESS
        public function rekapProgres()
        {
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getProgres();

    
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_progres', $data);
            $this->load->view('templates/footer');
        }

        public function dateprogres()
        {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            $status_ccs = $this->input->post('status_ccs');
            $this->load->model('Pelaporan_model', 'pelaporan_model');
            $data['pencarian_data'] = $this->pelaporan_model->getDateProgres($tgla, $tglb,$status_ccs);
            
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('supervisor/rekap_progres', $data);
            $this->load->view('templates/footer');
        }

        //DISTRIBUSI TO HELPDESK
        public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->insert('forward', $data);
        $this->supervisor_model->updateForward($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('supervisor/added'));
    }

    // EDIT HELPDESK
    public function fungsi_edit()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->update('forward', $data);
        $this->supervisor_model->updateHD($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Helpdesk has been update!');
        Redirect(Base_url('supervisor/onprogress'));
    }

    // FUNGSI REJECT
    public function fungsi_reject()
    {
        $this->form_validation->set_rules('id_pelaporan','Pelaporan', 'required');
        $this->form_validation->set_rules('namahd','Helpdesk', 'required');
        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('namahd');
        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user
        ];

        // cari nama user berdasarkan id 
        $this->db->select('id_user, nama_user');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row();
        $nama_user = $user->nama_user;

        $this->db->update('forward', $data);
        $this->supervisor_model->updateReject($id_pelaporan, $nama_user);
        $this->session->set_flashdata('pesan', 'Successfully Reject!');
        Redirect(Base_url('supervisor/close'));
    }

}