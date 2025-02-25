<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Superadmin_model', 'superadmin_model');
    }

    public function index()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['data_bpr'] = $this->superadmin_model->getKlien();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    #CATEGORY
    public function category()
    {
        $this->load->model('Category_model', 'category_model');
        $data['nama_kategori'] = $this->db->get('category')->result_array();

        $data['category'] = $this->category_model->getCategory();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/category', $data);
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
        redirect('superadmin/category');
    }

    public function hapus_kategori($id)
    {
        $this->category_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/category'));
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
        Redirect(base_url('superadmin/category'));
    }

    // DATA CLIENT
    public function client()
    {
        $this->load->model('Client_model', 'client_model');
        $data['no_urut'] = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();

        $data['klien'] = $this->client_model->getClient();
        $data['user'] = $this->client_model->getUserClient();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/client', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_client()
    {
        $data['no_klien']    = $this->db->get('klien')->result_array();
        $data['nama_klien'] = $this->db->get('klien')->result_array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_klien', 'No Klien', 'required|is_unique[klien.no_klien]');
        $this->form_validation->set_rules('nama_klien', 'Nama Klient', 'required');
        $this->form_validation->set_rules('nama_user_klien', 'Nama User', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', 'Tambah klien gagal! Kode klien tidak boleh sama.');
            redirect('superadmin/client');
        } else {

            $data = [
                'no_klien'    => $this->input->post('no_klien'),
                'nama_klien' => $this->input->post('nama_klien'),
                'id_user_klien' => $this->input->post('nama_user_klien')
            ];
            $this->db->insert('klien', $data);
            $this->session->set_flashdata('pesan', 'Successfully Added!');
            redirect('superadmin/client');
        }
    }

    public function hapus_klien($id)
    {
        $this->client_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/client'));
    }

    public function edit_klien()
    {
        $id         = $this->input->post('id');
        $no_klien    = $this->input->post('no_klien');
        $nama_klien = $this->input->post('nama_klien');
        $ArrUpdate  = array(
            'no_klien'    => $no_klien,
            'nama_klien' => $nama_klien,
            'id_user_klien' => $this->input->post('nama_user_klien')
        );
        $this->client_model->updateKlien($id, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/client'));
    }

    # DATA USER
    public function user()
    {

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
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/user', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_user()
    {
        $username = $this->input->post('username');

        // Cek apakah username sudah ada di database
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            // Jika username sudah ada, set pesan error dan redirect
            $this->session->set_flashdata('alert', 'Username sudah digunakan oleh user lain.');
            redirect('superadmin/user');
        } else {
            // Hash password
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $data = [
                'divisi'       => $this->input->post('divisi'),
                'nama_user'    => $this->input->post('nama_user'),
                'username'     => $username,
                'password'     => $password,
                'role'         => $this->input->post('role'),
                'tgl_register' => $this->input->post('tgl_register')
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('pesan', 'Successfully Added!');
            redirect('superadmin/user');
        }
    }

    public function edit_user()
    {
        $id       = $this->input->post('id_user');
        $divisi   = $this->input->post('divisi');
        $nama     = $this->input->post('nama_user');
        $username = $this->input->post('username');
        $password = trim($this->input->post('password'));
        $role     = $this->input->post('role');
        $active   = $this->input->post('active');

        // Ambil data user lama dari database
        $user = $this->usermaster_model->getUserById($id);

        if (!$user) {
            $this->session->set_flashdata('pesan', 'User tidak ditemukan!');
            redirect(base_url('superadmin/user'));
            return;
        }

        // Buat array update tanpa password terlebih dahulu
        $ArrUpdate = array(
            'divisi'   => $divisi,
            'nama_user' => $nama,
            'username' => $username,
            'role'     => $role,
            'active'   => $active,
        );

        // Jika password diisi, baru tambahkan ke array update
        if (!empty($password)) {
            $ArrUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Lakukan update data
        $this->usermaster_model->updateUser($id, $ArrUpdate);

        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        redirect(base_url('superadmin/user'));
    }



    // public function edit_user()
    // {
    //     $id       = $this->input->post('id_user');
    //     $divisi   = $this->input->post('divisi');
    //     $nama     = $this->input->post('nama_user');
    //     $username = $this->input->post('username');
    //     $password = $this->input->post('password');
    //     $role     = $this->input->post('role');
    //     $active   = $this->input->post('active');

    //     // Check if the password field is not empty, then hash it
    //     if (!empty($password)) {
    //         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //         $ArrUpdate = array(
    //             'divisi'   => $divisi,
    //             'nama_user' => $nama,
    //             'username' => $username,
    //             'password' => $hashed_password,  // Hash the password
    //             'role'     => $role,
    //             'active'   => $active,
    //         );
    //     } else {
    //         // If password is empty, don't update the password field
    //         $ArrUpdate = array(
    //             'divisi'   => $divisi,
    //             'nama_user' => $nama,
    //             'username' => $username,
    //             'role'     => $role,
    //             'active'   => $active,
    //         );
    //     }

    //     $this->usermaster_model->updateUser($id, $ArrUpdate);

    //     $this->session->set_flashdata('pesan', 'Successfully Edited!');
    //     Redirect(base_url('superadmin/user'));
    // }


    public function hapus_user($id)
    {
        $this->usermaster_model->hapus($id);
        $this->session->set_flashdata('pesan', 'Successfully Deleted!');
        Redirect(Base_url('superadmin/user'));
    }

    //LIST TICKET
    public function AllTicket()
    {


        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/allticket');
        $this->load->view('templates/footer');
    }

    public function ajax_list()
    {
        $list = $this->superadmin_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pelaporan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pelaporan->no_tiket;
            $row[] = tanggal_indo($pelaporan->waktu_pelaporan);
            $row[] = $pelaporan->nama;
            $row[] = $pelaporan->judul;
            // $row[] = $pelaporan->impact;
            // $row[] = '<a href="' . site_url('assets/files/' . $pelaporan->file) . '">' . $pelaporan->file . '</a>';
            // $pelaporan->file;
            $row[] = $pelaporan->kategori;
            $row[] = $pelaporan->tags;
            // Proses nilai prioritas di server-side
            if ($pelaporan->priority == 'Low') {
                $priority_label = '<span class="label label-info">Low</span>';
            } elseif ($pelaporan->priority == 'Medium') {
                $priority_label = '<span class="label label-warning">Medium</span>';
            } elseif ($pelaporan->priority == 'High') {
                $priority_label = '<span class="label label-danger">High</span>';
            } else {
                $priority_label = $pelaporan->priority;
            }

            $row[] = $priority_label;
            // Proses nilai maxday di server-side
            if ($pelaporan->maxday == '90') {
                $maxday_label = '<span class="label label-info">90</span>';
            } elseif ($pelaporan->maxday == '60') {
                $maxday_label = '<span class="label label-warning">60</span>';
            } elseif ($pelaporan->maxday == '7') {
                $maxday_label = '<span class="label label-danger">7</span>';
            } else {
                $maxday_label = $pelaporan->maxday;
            }

            $row[] = $maxday_label;
            // Proses nilai maxday di server-side
            if ($pelaporan->status_ccs == 'ADDED') {
                $status_ccs_label = '<span class="label label-primary">ADDED</span>';
            } elseif ($pelaporan->status_ccs == 'ADDED 2') {
                $status_ccs_label = '<span class="label label-primary">ADDED 2</span>';
            } elseif ($pelaporan->status_ccs == 'HANDLED') {
                $status_ccs_label = '<span class="label label-info">HANDLED</span>';
            } elseif ($pelaporan->status_ccs == 'HANDLED 2') {
                $status_ccs_label = '<span class="label label-info">HANDLED 2</span>';
            } elseif ($pelaporan->status_ccs == 'CLOSED') {
                $status_ccs_label = '<span class="label label-warning">CLOSED</span>';
            } elseif ($pelaporan->status_ccs == 'FINISHED') {
                $status_ccs_label = '<span class="label label-success">FINISHED</span>';
            } else {
                $status_ccs_label = $pelaporan->status_ccs;
            }

            $row[] = $status_ccs_label;
            //Gabungkan handle_by, handle_by2, handle_by3
            $handle_combined = $pelaporan->handle_by;
            if ($pelaporan->handle_by2) {
                $handle_combined .= ', ' . $pelaporan->handle_by2;
            }
            if ($pelaporan->handle_by3) {
                $handle_combined .= ', ' . $pelaporan->handle_by3;
            }
            $row[] = $handle_combined;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->superadmin_model->count_all(),
            "recordsFiltered" => $this->superadmin_model->count_filtered(),
            "data" => $data,
        );
        // output dalam format JSON
        echo json_encode($output);
    }

    public function added()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->superadmin_model->getDataAdded();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    // public function onprogress()
    // {
    //     $this->load->model('Superadmin_model', 'superadmin_model');
    //     // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
    //     $data['category'] = $this->category_model->getNamakategori();
    //     $this->load->model('User_model', 'user_model');
    //     $data['user'] = $this->user_model->getDataUser();
    //     $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanOP();

    //     // $this->load->model('User_model', 'user_model');
    //     // $data['namahd'] = $this->user_model->getNamaUser();
    //     $this->load->model('User_model', 'user_model');
    //     $data['namateknisi'] = $this->user_model->getNamaTeknisi();

    //     $this->load->view('templates/header');
    //     $this->load->view('templates/superadmin_sidebar');
    //     $this->load->view('superadmin/pelaporan_onprogress', $data);
    //     $this->load->view('templates/footer');
    // }

    public function onprogress()
    {
        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // Set form validation rules (allow empty)
        $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
        $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
        $this->form_validation->set_rules('status_ccs', 'Status CCS', 'trim');
        $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
        $this->form_validation->set_rules('nama_user', 'User Name', 'trim');
        $this->form_validation->set_rules('rating', 'rating', 'trim');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/pelaporan_onprogress', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs    = 'FINISHED'; // For pelaporan finish, the status is always FINISHED
            $nama_klien    = $this->input->post('nama_klien');
            $nama_user     = $this->input->post('nama_user');
            $tags          = $this->input->post('tags');

            // var data for view 
            $data['tanggal_awal']  = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs']    = $status_ccs;
            $data['nama_klien']    = $nama_klien;
            $data['nama_user']     = $nama_user;
            $data['tags']          = $tags;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $nama_user, $tags);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/pelaporan_onprogress', $data);
            $this->load->view('templates/footer');
        }
    }

    public function get_data_handle()
    {
        $this->load->model('Serversidehandle_model', 'serversidehandle_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'nama_user' => $this->input->post('nama_user'),
            'tags' => $this->input->post('tags'),
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }
        $list = $this->serversidehandle_model->get_datatables($filters);
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $dp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dp->no_tiket;
            $row[] = tanggal_indo($dp->waktu_pelaporan);
            $row[] = $dp->nama;
            $row[] = $dp->judul;
            $row[] = $dp->kategori;
            $row[] = $dp->tags ? '<span class="label label-info">' . $dp->tags . '</span>' : '';

            // Proses nilai prioritas di server-side
            if ($dp->priority == 'Low') {
                $priority_label = '<span class="label label-info">Low</span>';
            } elseif ($dp->priority == 'Medium') {
                $priority_label = '<span class="label label-warning">Medium</span>';
            } elseif ($dp->priority == 'High') {
                $priority_label = '<span class="label label-danger">High</span>';
            } else {
                $priority_label = $dp->priority;
            }
            $row[] = $priority_label;

            // Proses nilai maxday di server-side
            if ($dp->maxday == '90') {
                $maxday_label = '<span class="label label-info">90</span>';
            } elseif ($dp->maxday == '60') {
                $maxday_label = '<span class="label label-warning">60</span>';
            } elseif ($dp->maxday == '7') {
                $maxday_label = '<span class="label label-danger">7</span>';
            } else {
                $maxday_label = $dp->maxday;
            }
            $row[] = $maxday_label;

            // Proses nilai status_ccs di server-side
            if ($dp->status_ccs == 'ADDED') {
                $status_ccs_label = '<span class="label label-primary">ADDED</span>';
            } elseif ($dp->status_ccs == 'ADDED 2') {
                $status_ccs_label = '<span class="label label-primary">ADDED 2</span>';
            } elseif ($dp->status_ccs == 'HANDLED') {
                $status_ccs_label = '<span class="label label-info">HANDLED</span>';
            } elseif ($dp->status_ccs == 'HANDLED 2') {
                $status_ccs_label = '<span class="label label-info">HANDLED 2</span>';
            } elseif ($dp->status_ccs == 'CLOSED') {
                $status_ccs_label = '<span class="label label-warning">CLOSED</span>';
            } elseif ($dp->status_ccs == 'FINISHED') {
                $status_ccs_label = '<span class="label label-success">FINISHED</span>';
            } else {
                $status_ccs_label = $dp->status_ccs;
            }
            $row[] = $status_ccs_label;

            // Proses handle_by
            $handle_combined = $dp->handle_by;
            if ($dp->handle_by2) {
                $handle_combined .= ', ' . $dp->handle_by2;
            }
            if ($dp->handle_by3) {
                $handle_combined .= ', ' . $dp->handle_by3;
            }
            $row[] = $handle_combined;

            // Tombol Aksi
            $row[] = '
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="btn btn-sm btn-warning edit-helpdesk" data-toggle="modal" data-target="#editModalCP" 
                    data-id_pelaporan="' . $dp->id_pelaporan . '" 
                    data-no_tiket="' . $dp->no_tiket . '" 
                    data-waktu_pelaporan="' . $dp->waktu_pelaporan . '" 
                    data-nama="' . $dp->nama . '" 
                    data-judul="' . $dp->judul . '" 
                    data-priority="' . $dp->priority . '" 
                    data-maxday="' . $dp->maxday . '" 
                    data-kategori="' . $dp->kategori . '" 
                    data-tags="' . $dp->tags . '" 
                    data-status_ccs="' . $dp->status_ccs . '">
                    <i class="material-icons">edit</i> Edit Teknisi
                </button>
                <a class="btn btn-sm btn-info" href="' . base_url('superadmin/detail_pelaporan/' . $dp->id_pelaporan) . '">
                    <i class="material-icons">visibility</i> Detail
                </a>
                <a class="btn btn-sm btn-primary" href="' . base_url('export/print_detail/' . $dp->no_tiket) . '">
                    <i class="material-icons">print</i> Print Detail
                </a>
            </div>
            ';

            $row[] = $dp->mode_fokus == 1 ? 'Fokus' : '';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->serversidehandle_model->count_all(),
            "recordsFiltered" => $this->serversidehandle_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);  // Kirim JSON ke DataTables
        die();
    }

    public function close()
    {
        $this->load->model('Superadmin_model', 'superadmin_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->superadmin_model->getDataClosed();

        $this->load->model('User_model', 'user_model');
        $data['namahd'] = $this->user_model->getNamaUser();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }

    // public function finish()
    // {
    //     $this->load->model('Superadmin_model', 'superadmin_model');
    //     // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
    //     $data['category'] = $this->category_model->getNamakategori();
    //     $this->load->model('User_model', 'user_model');
    //     $data['user'] = $this->user_model->getDataUser();
    //     $data['datapelaporan'] = $this->superadmin_model->getKlienPelaporanFinish();

    //     $this->load->view('templates/header');
    //     $this->load->view('templates/superadmin_sidebar');
    //     $this->load->view('superadmin/pelaporan_finish', $data);
    //     $this->load->view('templates/footer');
    // }
    public function finish()
    {
        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // Set form validation rules (allow empty)
        $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
        $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
        $this->form_validation->set_rules('status_ccs', 'Status CCS', 'trim');
        $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
        $this->form_validation->set_rules('nama_user', 'User Name', 'trim');
        $this->form_validation->set_rules('rating', 'rating', 'trim');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/pelaporan_finish', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs    = 'FINISHED'; // For pelaporan finish, the status is always FINISHED
            $nama_klien    = $this->input->post('nama_klien');
            $nama_user     = $this->input->post('nama_user');
            $rating        = $this->input->post('rating');
            $tags          = $this->input->post('tags');

            // var data for view 
            $data['tanggal_awal']  = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs']    = $status_ccs;
            $data['nama_klien']    = $nama_klien;
            $data['nama_user']     = $nama_user;
            $data['rating']        = $rating;
            $data['tags']          = $tags;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $nama_user, $rating, $tags);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/pelaporan_finish', $data);
            $this->load->view('templates/footer');
        }
    }

    public function get_data_finish()
    {
        $this->load->model('Datatable_model', 'datatable_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'nama_user' => $this->input->post('nama_user'),
            'rating' => $this->input->post('rating'),
            'tags' => $this->input->post('tags'),
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }
        $list = $this->datatable_model->get_datatables($filters);
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $dp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dp->no_tiket;
            $row[] = tanggal_indo($dp->waktu_pelaporan);
            $row[] = $dp->nama;
            $row[] = $dp->judul;
            $row[] = $dp->kategori;
            $row[] = $dp->tags ? '<span class="label label-info">' . $dp->tags . '</span>' : '';

            // Proses nilai prioritas di server-side
            if ($dp->priority == 'Low') {
                $priority_label = '<span class="label label-info">Low</span>';
            } elseif ($dp->priority == 'Medium') {
                $priority_label = '<span class="label label-warning">Medium</span>';
            } elseif ($dp->priority == 'High') {
                $priority_label = '<span class="label label-danger">High</span>';
            } else {
                $priority_label = $dp->priority;
            }
            $row[] = $priority_label;

            // Proses nilai maxday di server-side
            if ($dp->maxday == '90') {
                $maxday_label = '<span class="label label-info">90</span>';
            } elseif ($dp->maxday == '60') {
                $maxday_label = '<span class="label label-warning">60</span>';
            } elseif ($dp->maxday == '7') {
                $maxday_label = '<span class="label label-danger">7</span>';
            } else {
                $maxday_label = $dp->maxday;
            }
            $row[] = $maxday_label;

            // Proses nilai status_ccs di server-side
            if ($dp->status_ccs == 'ADDED') {
                $status_ccs_label = '<span class="label label-primary">ADDED</span>';
            } elseif ($dp->status_ccs == 'ADDED 2') {
                $status_ccs_label = '<span class="label label-primary">ADDED 2</span>';
            } elseif ($dp->status_ccs == 'HANDLED') {
                $status_ccs_label = '<span class="label label-info">HANDLED</span>';
            } elseif ($dp->status_ccs == 'HANDLED 2') {
                $status_ccs_label = '<span class="label label-info">HANDLED 2</span>';
            } elseif ($dp->status_ccs == 'CLOSED') {
                $status_ccs_label = '<span class="label label-warning">CLOSED</span>';
            } elseif ($dp->status_ccs == 'FINISHED') {
                $status_ccs_label = '<span class="label label-success">FINISHED</span>';
            } else {
                $status_ccs_label = $dp->status_ccs;
            }
            $row[] = $status_ccs_label;

            // Proses handle_by
            $handle_combined = $dp->handle_by;
            if ($dp->handle_by2) {
                $handle_combined .= ', ' . $dp->handle_by2;
            }
            if ($dp->handle_by3) {
                $handle_combined .= ', ' . $dp->handle_by3;
            }
            $row[] = $handle_combined;

            // Proses rating bintang
            $star_rating = '';
            if ($dp->rating !== null) {
                $rating = $dp->rating; // Get the rating value
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        $star_rating .= '<span class="star selected">&#9733;</span>'; // Full star for rating
                    } else {
                        $star_rating .= '<span class="star">&#9734;</span>'; // Empty star for remaining
                    }
                }
            }
            $row[] = '<div class="star-rating">' . $star_rating . '</div>'; // Wrap in div for styling

            // Tombol Aksi
            $row[] = '<a class="btn btn-sm btn-info" href="' . base_url('superadmin/detail_finish/' . $dp->id_pelaporan) . '"><i class="material-icons">visibility</i></a>';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->datatable_model->count_all(),
            "recordsFiltered" => $this->datatable_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);  // Kirim JSON ke DataTables
        die();
    }

    // EDIT PELAPORAN
    public function edit_pelaporan()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $status_ccs   = $this->input->post('status_ccs');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'status_ccs' => $status_ccs,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday,
            'tags'       => $tags

        );
        $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('superadmin/added'));
    }

    //DISTRIBUSI TO HELPDESK
    public function fungsi_forward()
    {
        // Set validation rules
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required', [
            'required' => 'Kolom Helpdesk wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('superadmin/added');
        } else {
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

            $priority = $this->input->post('priority');
            $maxday = $this->input->post('maxday');
            $kategori = $this->input->post('kategori');
            $ArrUpdate = array(
                'priority'   => $priority,
                'maxday'     => $maxday,
                'kategori'   => $kategori
            );
            $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
            $this->supervisor_model->updateForward($id_pelaporan, $nama_user);
            $this->session->set_flashdata('pesan', 'Successfully Forward!');
            Redirect(Base_url('superadmin/added'));
        }
    }

    // FUNGSI EDIT HELPDESK
    public function fungsi_edit()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required', [
            'required' => 'Kolom Helpdesk wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('superadmin/onprogress');
        } else {
            // Retrieve POST data
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namahd');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->update('forward', $data);

                $this->supervisor_model->updateHD($id_pelaporan, $nama_user);

                $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
            } else {
                $this->session->set_flashdata('error', 'User not found.');
            }

            redirect(base_url('superadmin/onprogress'));
        }
    }

    public function fungsi_edit_teknisi()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namateknisi', 'Teknisi', 'required', [
            'required' => 'Kolom Teknisi wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);

        // Check if the form passes validation
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('superadmin/onprogress');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namateknisi');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                // Update the forward table
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->update('t1_forward', $data);

                $this->superadmin_model->updateTeknisi($id_pelaporan, $nama_user);

                $this->session->set_flashdata('pesan', 'Teknisi berhasil dirubah!');
            } else {
                $this->session->set_flashdata('error', 'User not found.');
            }
            redirect(base_url('superadmin/onprogress'));
        }
    }

    // FUNGSI REJECT
    public function fungsi_reject()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namahd', 'Helpdesk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Form validation failed. Please fill in all required fields.');
            redirect(base_url('supervisor/onprogress'));
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namahd');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                // Update the forward table
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->update('forward', $data);

                $this->supervisor_model->updateReject($id_pelaporan, $nama_user);

                $this->session->set_flashdata('pesan', 'Helpdesk has been updated!');
            } else {
                $this->session->set_flashdata('error', 'User not found.');
            }

            redirect(base_url('superadmin/close'));
        }
    }

    //Approve Tiket
    public function finish_pelaporan($id)
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan_close($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/finish_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_approve_pelaporan()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $id_pelaporan         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        $nama       = $this->input->post('nama');
        $judul      = $this->input->post('judul');
        // $perihal    = $this->input->post('perihal');
        $status_ccs = 'FINISHED';
        $waktu      = date('Y-m-d H:i:s');
        $priority   = $this->input->post('priority');
        $maxday     = $this->input->post('maxday');
        $kategori   = $this->input->post('kategori');

        $this->db->set('judul', $judul);
        $this->db->set('no_tiket', $no_tiket);
        $this->db->set('nama', $nama);
        $this->db->set('status_ccs', $status_ccs);
        $this->db->set('waktu_approve', $waktu);
        $this->db->set('priority', $priority);
        // $this->db->set('perihal', $perihal);
        $this->db->set('maxday', $maxday);
        $this->db->set('kategori', $kategori);
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan');
        $this->session->set_flashdata('pesan', 'Succesfully Approve!');
        Redirect(base_url('superadmin/close'));
    }


    //   FILTER LAPORAN
    public function rekapPelaporan1()
    {
        $this->load->model('Client_model', 'client_model');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getAll();
        $data['klien'] = $this->client_model->getClient();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function rekapPelaporan()
    {
        // Load necessary models
        $this->load->model('Superadmin_model', 'superadmin_model');
        $this->load->model('Client_model', 'client_model');
        $this->load->model('User_model', 'user_model');

        // Initialize empty data for view
        $data = [
            'tanggal_awal' => '',
            'tanggal_akhir' => '',
            'status_ccs' => '',
            'nama_klien' => '',
            'nama_user' => '',
            'tags' => '',
        ];

        // Fetch data from models
        $data['klien'] = $this->client_model->getClient();
        $data['user'] = $this->user_model->getNamaPetugas();
        $data['pencarian_data'] = $this->superadmin_model->getAllData(); // Replace with appropriate method

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_pelaporan', $data);
        $this->load->view('templates/footer');
    }


    public function datepelaporan()
    {
        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Client_model', 'client_model');

        // Set form validation rules (allow empty)
        $this->form_validation->set_rules('tanggal_awal', 'Start Date', 'trim');
        $this->form_validation->set_rules('tanggal_akhir', 'End Date', 'trim');
        $this->form_validation->set_rules('status_ccs', 'Status CCS', 'trim');
        $this->form_validation->set_rules('nama_klien', 'Client Name', 'trim');
        $this->form_validation->set_rules('nama_user', 'User Name', 'trim');
        $this->form_validation->set_rules('rating', 'rating', 'trim');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs    = $this->input->post('status_ccs');
            $nama_klien    = $this->input->post('nama_klien');
            $nama_user     = $this->input->post('nama_user');
            $rating        = $this->input->post('rating');
            $tags          = $this->input->post('tags');

            // var data for view 
            $data['tanggal_awal']  = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs']    = $status_ccs;
            $data['nama_klien']    = $nama_klien;
            $data['nama_user']     = $nama_user;
            $data['rating']        = $rating;
            $data['tags']          = $tags;

            // Fetch data from models
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $nama_user, $rating, $tags);

            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }
    }


    public function fetch_data()
    {
        $this->load->model('Serverside_model', 'serverside_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'nama_user' => $this->input->post('nama_user'),
            'rating' => $this->input->post('rating'),
            'tags' => $this->input->post('tags'),
            'status_ccs' => $this->input->post('status_ccs')
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }

        // Panggil model untuk mendapatkan data dengan filter
        $list = $this->serverside_model->get_datatables($filters);
        $data = array();

        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1;
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['judul'] = isset($dataItem->judul) ? $dataItem->judul : '';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            // $row['tags'] = '<span class="label label-info">' . $dataItem->tags . '</span>';
            $row['priority'] = $this->get_priority_label($dataItem->priority);
            $row['maxday'] = $this->get_maxday_label($dataItem->maxday);
            $row['status_ccs'] = $this->get_status_label($dataItem->status_ccs);
            // Proses handle_by
            // Proses handle_by
            $handle_combined = isset($dataItem->handle_by) ? $dataItem->handle_by : '';
            if (isset($dataItem->handle_by2) && !empty($dataItem->handle_by2)) {
                $handle_combined .= ', ' . $dataItem->handle_by2;
            }
            if (isset($dataItem->handle_by3) && !empty($dataItem->handle_by3)) {
                $handle_combined .= ', ' . $dataItem->handle_by3;
            }

            $row['handle_combined'] = $handle_combined;

            // Proses rating bintang
            $star_rating = '';
            if ($dataItem->rating !== null) {
                $rating = $dataItem->rating; // Ambil nilai rating
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        $star_rating .= '<span class="star selected">&#9733;</span>'; // Bintang penuh untuk rating
                    } else {
                        $star_rating .= '<span class="star">&#9734;</span>'; // Bintang kosong untuk sisanya
                    }
                }
            }
            $row['rating'] = '<div class="star-rating">' . $star_rating . '</div>'; // Dibungkus dalam div untuk styling

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->serverside_model->count_all(),
            "recordsFiltered" => $this->serverside_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);
    }

    private function get_priority_label($priority)
    {
        if ($priority == 'High') {
            return '<span class="label label-danger">High</span>';
        } elseif ($priority == 'Medium') {
            return '<span class="label label-warning">Medium</span>';
        } elseif ($priority == 'Low') {
            return '<span class="label label-info">Low</span>';
        }
    }

    private function get_maxday_label($maxday)
    {
        if ($maxday == '7') {
            return '<span class="label label-danger">7</span>';
        } elseif ($maxday == '60') {
            return '<span class="label label-warning">60</span>';
        } elseif ($maxday == '90') {
            return '<span class="label label-info">90</span>';
        }
    }

    private function get_status_label($status)
    {
        if ($status == 'FINISHED') {
            return '<span class="label label-success">FINISHED</span>';
        } elseif ($status == 'CLOSED') {
            return '<span class="label label-warning">CLOSED</span>';
        } elseif ($status == 'HANDLED') {
            return '<span class="label label-info">HANDLED</span>';
        } elseif ($status == 'HANDLED 2') {
            return '<span class="label label-info">HANDLED 2</span>';
        } elseif ($status == 'ADDED 2') {
            return '<span class="label label-info">ADDED 2</span>';
        } elseif ($status == 'ADDED') {
            return '<span class="label label-primary">ADDED</span>';
        }
    }



    // REKAP KATEGORI
    public function rekapKategori()
    {
        $this->load->model('Category_model', 'category_model');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getAllCategory();
        $data['category'] = $this->category_model->getCategory();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function dateKategori()
    {

        //Load necessary libraries and models
        $this->load->library('form_validation');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $this->load->model('Category_model', 'category_model');

        // Set form validation rules
        $this->form_validation->set_rules('tgla', 'Start Date', 'required');
        $this->form_validation->set_rules('tglb', 'End Date', 'required');
        $this->form_validation->set_rules('kategori', 'Category Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['errors'] = validation_errors();
            $data['category'] = $this->category_model->getCategory();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/rekap_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $tgla = $this->input->post('tgla');
            $tglb = $this->input->post('tglb');
            $kategori = $this->input->post('kategori');

            $data['category'] = $this->category_model->getCategory();
            $data['pencarian_data'] = $this->pelaporan_model->getDateKategori($tgla, $tglb,  $kategori);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('superadmin/rekap_kategori', $data);
            $this->load->view('templates/footer');
        }
    }

    // REKAP HANDLE BY HELPDESK
    public function rekapHelpdesk()
    {
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getHelpdesk();

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }

    public function datehelpdesk()
    {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $this->load->model('Pelaporan_model', 'pelaporan_model');
        $data['pencarian_data'] = $this->pelaporan_model->getDateHelpdesk($tgla, $tglb);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/rekap_helpdesk', $data);
        $this->load->view('templates/footer');
    }



    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->superadmin_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->get_latest_comments($id);
        $data['datareply']     = $this->supervisor_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_close($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->superadmin_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_close', $data);
        $this->load->view('templates/footer');
    }
    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Superadmin_model', 'superadmin_model');
        $data['datapelaporan'] = $this->superadmin_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/detail_finish', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '25600';
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

        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('user_id', 'Helpdesk', 'required');
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
        $data = preg_replace("/^<p.*?>/", "", $data);
        $data = preg_replace("|</p>$|", "", $data);
        $this->db->insert('comment', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('superadmin/detail_pelaporan/' . $id_pelaporan));
    }

    public function upload_comment()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/comment/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/comment/' . $photo);
                $this->load->helper('url');

                $uploaded_images = $this->session->userdata('uploaded_images') ?? [];
                $uploaded_images[] = $photo;
                $this->session->set_userdata('uploaded_images', $uploaded_images);

                $data = array(
                    'fileName' => $photo,
                    'uploaded' => 1,
                    'url' => $url
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            } else {
                $data = array(
                    'message' => 'Upload failed',
                    'uploaded' => 0
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            }
        }
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $photo = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">' . $this->upload->display_errors() . '</div>');
                return;
            }
        }

        $id_pelaporan = $this->input->post('id_pelaporan');
        $id_user = $this->input->post('user_id');
        $body = $this->input->post('body');
        $create_at = date('Y-m-d H:i:s');
        $comment_id = $this->input->post('id_comment');

        $data = [
            'pelaporan_id' => $id_pelaporan,
            'user_id' => $id_user,
            'body' => $body,
            'file' => $photo,
            'created_at' => $create_at,
            'comment_id' => $comment_id
        ];
        $data = preg_replace("/^<p.*?>/", "", $data);
        $data = preg_replace("|</p>$|", "", $data);
        if ($this->db->insert('reply', $data)) {
            $this->session->set_flashdata('pesan', 'Successfully Add!');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">Failed to add reply.</div>');
        }

        redirect(base_url('superadmin/detail_pelaporan/' . $id_pelaporan));
    }

    public function upload_reply()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/reply/' . $photo);
                $this->load->helper('url');

                $uploaded_images = $this->session->userdata('uploaded_images') ?? [];
                $uploaded_images[] = $photo;
                $this->session->set_userdata('uploaded_images', $uploaded_images);

                $data = array(
                    'fileName' => $photo,
                    'uploaded' => 1,
                    'url' => $url
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            } else {
                $data = array(
                    'message' => 'Upload failed',
                    'uploaded' => 0
                );
                $this->output->set_content_type('application/json');
                echo json_encode($data);
            }
        }
    }


    // NOTIFICATION
    public function fetch_notifications()
    {
        $limit = 5;  // Tampilkan 20 notifikasi per halaman
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $this->load->model('Superadmin_model', 'superadmin_model');
        $notifications = $this->superadmin_model->get_notifications($limit, $offset);
        $unread_count = $this->superadmin_model->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
}
