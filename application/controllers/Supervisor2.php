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

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/allticket');
        $this->load->view('templates/footer');
    }

    public function ajax_list()
    {
        $list = $this->spv2_model->get_datatables();
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
            "recordsTotal" => $this->spv2_model->count_all(),
            "recordsFiltered" => $this->spv2_model->count_filtered(),
            "data" => $data,
        );
        // output dalam format JSON
        echo json_encode($output);
    }

    public function added()
    {
        $this->load->model('Spv2_model', 'spv2_model');
        // $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category']      = $this->category_model->getCategory();
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->spv2_model->getDataAdded();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    // public function onprogress()
    // {
    //     $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
    //     // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
    //     $data['category'] = $this->category_model->getNamakategori();
    //     $this->load->model('User_model', 'user_model');
    //     $data['user'] = $this->user_model->getDataUser();
    //     $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanOP();

    //     $this->load->model('User_model', 'user_model');
    //     $data['namateknisi'] = $this->user_model->getNamaTeknisi();

    //     $this->load->view('templates/header');
    //     $this->load->view('templates/supervisor2_sidebar');
    //     $this->load->view('supervisor2/pelaporan_onprogress', $data);
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

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = [];

            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/pelaporan_onprogress', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs    = 'FINISHED';
            $nama_klien    = $this->input->post('nama_klien');
            $nama_user     = $this->input->post('nama_user');

            // var data for view 
            $data['tanggal_awal']  = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs']    = $status_ccs;
            $data['nama_klien']    = $nama_klien;
            $data['nama_user']     = $nama_user;


            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $nama_user);

            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/pelaporan_onprogress', $data);
            $this->load->view('templates/footer');
        }
    }

    public function fetch_onprogress()
    {
        $this->load->model('Chat_model');
        $my_id = $this->session->userdata('id_user');
        $this->load->model('serversidehandlespv2_model', 'serversidehandlespv2_model');
        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'nama_user' => $this->input->post('nama_user'),
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }
        // Mengambil data pelaporan dengan metode server-side
        $list = $this->serversidehandlespv2_model->get_datatables($filters);
        $data = array();
        $no = isset($_POST['start']) ? $_POST['start'] : 0;

        foreach ($list as $pelaporan) {
            $no++;
            $row = array();

            // 🔥 Tambahkan unread_count di sini
            $unread_count = $this->Chat_model->get_unread_ccs_messages_count($pelaporan->id_pelaporan, $my_id);
            $row[] = $no;  // Menambahkan kolom no
            $row[] = $pelaporan->no_tiket;
            $row[] = tanggal_indo($pelaporan->waktu_pelaporan);
            $row[] = $pelaporan->nama;
            $row[] = $pelaporan->judul;
            $row[] = $pelaporan->kategori;
            // $row['tags'] = $pelaporan->tags;

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

            // Proses nilai status_ccs di server-side
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

            // Gabungkan handle_by, handle_by2, handle_by3
            $handle_combined = $pelaporan->handle_by;
            if ($pelaporan->handle_by2) {
                $handle_combined .= ', ' . $pelaporan->handle_by2;
            }
            if ($pelaporan->handle_by3) {
                $handle_combined .= ', ' . $pelaporan->handle_by3;
            }
            $row[] = $handle_combined;

            $row[] = $pelaporan->subtask1;

            if ($pelaporan->status1 == 'PENDING') {
                $status1_label = '<span class="label label-info">PENDING</span>';
            } elseif ($pelaporan->status1 == 'COMPLETED') {
                $status1_label = '<span class="label label-success">COMPLETED</span>';
            } else {
                $status1_label = $pelaporan->status1;
            }
            $row[] = $status1_label;

            $row[] = $pelaporan->subtask2;
            if ($pelaporan->status2 == 'PENDING') {
                $status2_label = '<span class="label label-info">PENDING</span>';
            } elseif ($pelaporan->status2 == 'COMPLETED') {
                $status2_label = '<span class="label label-success">COMPLETED</span>';
            } else {
                $status2_label = $pelaporan->status2;
            }
            $row[] = $status2_label;
            $row[] = tanggal_indo($pelaporan->tanggal);

            // tombol chat (Dropdown Menu)
            $chatBtn = '
<div class="btn-group chat-btn-wrapper" id="chat-wrapper-' . $pelaporan->id_pelaporan . '">
    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opsi Chat">
        <i class="material-icons">more_vert</i>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        <li>
            <a href="' . base_url('chat/room/' . $pelaporan->no_tiket) . '" target="_blank" class="dropdown-item">
                <i class="material-icons" style="font-size: 16px; vertical-align: middle; margin-right: 5px;">chat</i> Buka Room Chat
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="dropdown-item mark-as-unread-btn" data-id="' . $pelaporan->id_pelaporan . '">
                <i class="material-icons" style="font-size: 16px; vertical-align: middle; margin-right: 5px;">mark_chat_unread</i> Tandai Belum Dibaca
            </a>
        </li>
    </ul>';

            // Tampilkan badge notifikasi di atas tombol dropdown jika ada pesan belum dibaca
            if ($unread_count > 0) {
                $chatBtn .= '<span class="badge" style="top: -5px; right: 2px;">' . $unread_count . '</span>';
            }

            $chatBtn .= '</div>';

            // Tombol aksi dengan URL detail, print detail, edit, dan tambah teknisi
            $row[] = '
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                ' . $chatBtn . '
                    <a class="btn btn-sm btn-info" href="' . base_url('supervisor2/detail_pelaporan/' . $pelaporan->id_pelaporan) . '">
                        <i class="material-icons">visibility</i>
                    </a>
                    <a class="btn btn-sm btn-primary" href="' . base_url('export/print_detail/' . $pelaporan->no_tiket) . '">
                        <i class="material-icons">print</i>
                    </a>
                    <button class="btn btn-sm btn-warning edit-helpdesk" data-toggle="modal" data-target="#editModalCP" 
                            data-id_pelaporan="' . $pelaporan->id_pelaporan . '" 
                            data-no_tiket="' . $pelaporan->no_tiket . '" 
                            data-waktu_pelaporan="' . $pelaporan->waktu_pelaporan . '" 
                            data-nama="' . $pelaporan->nama . '" 
                            data-judul="' . $pelaporan->judul . '" 
                            data-priority="' . $pelaporan->priority . '" 
                            data-maxday="' . $pelaporan->maxday . '" 
                            data-kategori="' . $pelaporan->kategori . '" 
                            data-tags="' . $pelaporan->tags . '" 
                            data-status_ccs="' . $pelaporan->status_ccs . '">
                        <i class="material-icons">edit</i> 
                    </button>
                    <div class="btn btn-sm btn-info">
                        <a href="javascript:;" data-id_pelaporan="' . $pelaporan->id_pelaporan . '" 
                        data-no_tiket="' . $pelaporan->no_tiket . '" 
                        data-waktu_pelaporan="' . $pelaporan->waktu_pelaporan . '" 
                        data-nama="' . $pelaporan->nama . '" 
                        data-perihal="' . htmlspecialchars($pelaporan->perihal, ENT_QUOTES) . '" 
                        data-status="' . $pelaporan->status . '" 
                        data-status_ccs="' . $pelaporan->status_ccs . '" 
                        data-kategori="' . $pelaporan->kategori . '" 
                        data-judul="' . $pelaporan->judul . '" 
                        data-priority="' . $pelaporan->priority . '" 
                        data-maxday="' . $pelaporan->maxday . '" 
                        data-toggle="modal" 
                        data-target="#editModal">
                        <i class="material-icons">add</i> <span class="icon-name"></span>
                        </a>
                    </div>
                </div>
                ';

            $row[] = $pelaporan->mode_fokus == 1 ? 'Fokus' : '';


            $data[] = $row; // Tambahkan row ke data
        }
        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->serversidehandlespv2_model->count_all(),
            "recordsFiltered" => $this->serversidehandlespv2_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);
        die();
    }

    // Get unread count for specific ticket
    public function get_unread_count()
    {
        $this->load->model('Chat_model');
        $my_id = $this->session->userdata('id_user');
        $id_pelaporan = $this->input->post('id_pelaporan');

        if ($id_pelaporan) {
            $unread_count = $this->Chat_model->get_unread_ccs_messages_count($id_pelaporan, $my_id);
            echo json_encode(['unread_count' => $unread_count]);
        } else {
            echo json_encode(['unread_count' => 0]);
        }
    }

    // Get all unread counts for onprogress tickets
    public function get_all_unread_counts()
    {
        $this->load->model('Chat_model');
        $this->load->model('Serversidehandlespv2_model', 'serversidehandlespv2_model');

        $my_id = $this->session->userdata('id_user');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal'   => $this->input->post('tanggal_awal'),
            'tanggal_akhir'  => $this->input->post('tanggal_akhir'),
            'nama_klien'     => $this->input->post('nama_klien'),
            'nama_user'      => $this->input->post('nama_user'),
            'tags'           => $this->input->post('tags'),
        );

        if (isset($_POST['semua_data'])) {
            $filters = array();
        }

        // Ambil semua ticket yang sedang ditampilkan
        $list = $this->serversidehandlespv2_model->get_datatables($filters);
        $unread_counts = array();

        foreach ($list as $dp) {
            $unread_count = $this->Chat_model->get_unread_ccs_messages_count($dp->id_pelaporan, $my_id);
            $unread_counts[$dp->id_pelaporan] = $unread_count;
        }

        echo json_encode($unread_counts);
    }

    public function close()
    {
        $this->load->model('Spv2_model', 'spv2_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanClose();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
    {
        // $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        // $data['category'] = $this->category_model->getNamakategori();
        // $this->load->model('User_model', 'user_model');
        // $data['user'] = $this->user_model->getDataUser();
        // $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanFinish();
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
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/pelaporan_finish', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal  = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs    = 'FINISHED';
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

            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/pelaporan_finish');
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
                        $star_rating .= '<span class="star selected">&#9733;</span>';
                    } else {
                        $star_rating .= '<span class="star">&#9734;</span>';
                    }
                }
            }
            $row[] = '<div class="star-rating">' . $star_rating . '</div>';

            // Tombol Aksi
            $row[] = '<a class="btn btn-sm btn-info" href="' . base_url('supervisor2/detail_finish/' . $dp->id_pelaporan) . '"><i class="material-icons">visibility</i></a>';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->datatable_model->count_all(),
            "recordsFiltered" => $this->datatable_model->count_filtered($filters),
            "data" => $data,
        );

        echo json_encode($output);
        die();
    }

    public function finish_pelaporan($id)
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Spv2_model', 'spv2_model');
        $data['datapelaporan'] = $this->spv2_model->ambil_id_pelaporan_close($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/finish_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    //Approve Tiket
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
        Redirect(base_url('supervisor2/close'));
    }

    public function edit_pelaporan()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $judul        = $this->input->post('judul');
        // $perihal      = $this->input->post('perihal');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'judul'      => $judul,
            // 'perihal'    => $perihal,
            'priority'   => $priority,
            'kategori'   => $kategori,
            'maxday'     => $maxday,
            'tags'       => $tags

        );
        $this->pelaporan_model->updateCP($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('supervisor2/added'));
    }


    //DETAIL PELAPORAN
    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Supervisor_model', 'supervisor_model');
        $data['datapelaporan'] = $this->supervisor_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->supervisor_model->get_latest_comments($id);
        $data['datareply']     = $this->supervisor_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_close($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Spv2_model', 'spv2_model');
        $data['datapelaporan'] = $this->spv2_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/detail_close', $data);
        $this->load->view('templates/footer');
    }
    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Spv2_model', 'spv2_model');
        $data['datapelaporan'] = $this->spv2_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/detail_finish', $data);
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
        Redirect(Base_url('supervisor2/detail_pelaporan/' . $id_pelaporan));
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
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'txt|csv|xlsx|docx|pdf|jpeg|jpg|zip|rar|png';
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
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('user_id', 'Helpdesk', 'required');
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
        $data = preg_replace("/^<p.*?>/", "", $data);
        $data = preg_replace("|</p>$|", "", $data);
        $this->db->insert('reply', $data);
        $this->session->set_flashdata('pesan', 'Successfully Add!');
        Redirect(Base_url('supervisor2/detail_pelaporan/' . $id_pelaporan));
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

                // Store the uploaded file name in session
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

    // FORWARD KE TEKNISI
    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namateknisi', 'Teknisi', 'required', [
            'required' => 'Kolom Teknisi wajib diisi.'
        ]);
        $this->form_validation->set_rules('judul', 'Judul', 'required', [
            'required' => 'Kolom Judul wajib diisi.'
        ]);
        $this->form_validation->set_rules('subtask', 'Subtask', 'required', [
            'required' => 'Kolom Subtask wajib diisi.'
        ]);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required', [
            'required' => 'Kolom Tenggat waktu wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor2/added');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namateknisi');
            $judul   = $this->input->post('judul');
            $subtask = $this->input->post('subtask');
            $tanggal = $this->input->post('tanggal');
            $status  = 'PENDING';
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user,
                'judul'   => $judul,
                'subtask' => $subtask,
                'tanggal' => $tanggal,
                'status'  => $status
            ];

            // cari nama user berdasarkan id 
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();
            $user = $query->row();
            $nama_user = $user->nama_user;

            $this->db->insert('t1_forward', $data);
            $this->spv2_model->updateForward($id_pelaporan, $nama_user);
            $this->session->set_flashdata('pesan', 'Successfully Forward!');
            redirect(base_url('supervisor2/added'));
        }
    }

    public function forward_tiket($id = null)
    {
        if ($id === null) {
            $this->session->set_flashdata('alert', 'Forward gagal.');
            redirect('supervisor2/pelaporan');
            return;
        }

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);


        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/forward_tiket', $data);
        $this->load->view('templates/footer');
    }

    public function batal()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $this->db->delete('s_forward', ['pelaporan_id' => $id_pelaporan]);
        $this->spv2_model->pembatalanForward($id_pelaporan);
        $this->session->set_flashdata('pesan', 'Pembatalan Berhasil!');
        redirect(base_url('supervisor2/added'));
    }

    public function fungsi_edit()
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


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor2/onprogress');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namateknisi');

            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                $this->db->select('id_forward');
                $this->db->from('t1_forward');
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->order_by('id_forward', 'ASC');
                $query = $this->db->get();
                $result = $query->result();

                if (count($result) >= 2) {
                    $second_technician_id = $result[1]->id_forward;

                    // Update the second technician
                    $this->db->where('id_forward', $second_technician_id);
                    $this->db->update('t1_forward', ['user_id' => $id_user]);

                    // Update the Helpdesk in the supervisor_model
                    $this->spv2_model->updateTeknisi($id_pelaporan, $nama_user);

                    $this->session->set_flashdata('pesan', 'Teknisi kedua telah diperbarui!');
                } else {
                    $this->session->set_flashdata('alert', 'Teknisi kedua tidak ditemukan.');
                }
            } else {
                $this->session->set_flashdata('alert', 'User tidak ditemukan.');
            }

            redirect(base_url('supervisor2/onprogress'));
        }
    }


    //TAMBAH TEKNISI
    public function fungsi_tambah()
    {
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namateknisi', 'Teknisi', 'required', [
            'required' => 'Kolom Teknisi wajib diisi.'
        ]);
        $this->form_validation->set_rules('judul', 'Judul', 'required', [
            'required' => 'Kolom Judul wajib diisi.'
        ]);
        $this->form_validation->set_rules('subtask', 'Subtask', 'required', [
            'required' => 'Kolom Subtask wajib diisi.'
        ]);
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required', [
            'required' => 'Kolom Tenggat waktu wajib diisi.'
        ]);
        $this->form_validation->set_rules('priority', 'Priority', 'required', [
            'required' => 'Kolom Priority wajib diisi.'
        ]);
        $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
            'required' => 'Kolom Max Day wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor2/onprogress');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namateknisi');
            $judul   = $this->input->post('judul');
            $subtask = $this->input->post('subtask');
            $tanggal = $this->input->post('tanggal');
            $status  = 'PENDING';
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user,
                'judul'   => $judul,
                'subtask' => $subtask,
                'tanggal' => $tanggal,
                'status'  => $status
            ];

            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();
            $user = $query->row();
            $nama_user = $user->nama_user;

            $this->db->insert('t1_forward', $data);
            $this->spv2_model->tambahTeknisi($id_pelaporan, $nama_user);
            $this->session->set_flashdata('pesan', 'Teknisi has been added!');
            Redirect(Base_url('supervisor2/onprogress'));
        }
    }

    //   FILTER LAPORAN
    public function rekapPelaporan()
    {
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
        $data['pencarian_data'] = $this->supervisor_model->getAllData();

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/rekap_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function datepelaporan()
    {
        // Load necessary libraries and models
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
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');
            $tags = $this->input->post('tags');

            // var data for view 
            $data['tanggal_awal'] = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs'] = $status_ccs;
            $data['nama_klien'] = $nama_klien;
            $nama_user     = $this->input->post('nama_user');
            $rating        = $this->input->post('rating');
            $data['tags'] = $tags;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['user'] = $this->user_model->getNamaPetugas();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $nama_user, $rating, $tags);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/rekap_pelaporan', $data);
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

        // Format data sesuai kebutuhan DataTables
        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1; // Nomor urutan
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['judul'] = isset($dataItem->judul) ? $dataItem->judul : '';
            // $row['tags'] = '<span class="label label-info">' . $dataItem->tags . '</span>';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            $row['priority'] = $this->get_priority_label($dataItem->priority);
            $row['maxday'] = $this->get_maxday_label($dataItem->maxday);
            $row['status_ccs'] = $this->get_status_label($dataItem->status_ccs);
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

        // Menyiapkan output JSON untuk DataTables
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
        } elseif ($status == 'HANDLED 2') {
            return '<span class="label label-info">HANDLED 2</span>';
        } elseif ($status == 'HANDLED') {
            return '<span class="label label-info">HANDLED</span>';
        } elseif ($status == 'ADDED') {
            return '<span class="label label-info">ADDED</span>';
        } elseif ($status == 'ADDED 2') {
            return '<span class="label label-primary">ADDED 2</span>';
        }
    }

    public function get_notifications()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Spv2_model', 'spv2_model');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        // Ambil notifikasi dari database dengan paginasi
        $notifications = $this->spv2_model->get_notifications($limit, $offset);

        // Total notifikasi yang tersedia di server
        $total_count = $this->spv2_model->get_total_count();

        // Kirim response JSON
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $this->spv2_model->get_unread_count(),
            'total_count' => $total_count
        ]);
    }
    public function fetch_notifications()
    {
        // // Fetch total active data from the model
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $limit = 5;  // Tampilkan 20 notifikasi per halaman
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $this->load->model('Spv2_model', 'spv2_model');
        $notifications = $this->spv2_model->get_notifications($limit, $offset);
        $unread_count = $this->spv2_model->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
}
