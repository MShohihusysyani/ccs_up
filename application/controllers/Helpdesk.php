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

    public function pengajuan()
    {
        $data['user_hd'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $id_user = $this->session->userdata('id_user');

        $this->load->model('Category_model', 'category_model');
        $this->load->model('Temp_model', 'temp_model');
        $this->load->model('User_model', 'user_model');
        $this->load->model('Client_model', 'client_model');

        $data['category']      = $this->category_model->getCategory();
        $data['tiket_temp'] = $this->temp_model->getTiketTempHd();
        $data['user'] = $this->user_model->getDataKlien();
        $data['klien'] = $this->client_model->getClient();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/pengajuan', $data);
        $this->load->view('templates/footer');
    }

    public function get_no_tiket()
    {
        $this->load->model('Temp_model', 'temp_model');
        $user_id = $this->input->post('user_id'); // user_id klien

        if ($user_id) {
            // Panggil fungsi model untuk mengambil no klien
            $no_klien = $this->temp_model->getNoKlien($user_id);

            // Dapatkan no urut tiket terakhir berdasarkan klien yang dipilih
            $no_urut = $this->temp_model->getNoUrut($user_id);

            // Buat format no tiket (misalnya: TICno_klienTahunBulanNoUrut)
            $tahun = date('Y');
            $bulan = date('m');
            $no_tiket = "TIC" . $no_klien . $tahun . $bulan . $no_urut;

            // Kembalikan no tiket ke AJAX
            echo $no_tiket;
        } else {
            echo "";  // Jika tidak ada klien yang dipilih, kembalikan kosong
        }
    }


    // public function get_no_tiket()
    // {
    //     $this->load->model('Temp_model', 'temp_model');
    //     $user_id = $this->input->post('user_id');

    //     if ($user_id) {
    //         // Panggil fungsi model untuk mengambil no klien
    //         $no_klien = $this->temp_model->getNoKlien($user_id);

    //         // Dapatkan no urut tiket terakhir berdasarkan klien yang dipilih
    //         $no_urut = $this->temp_model->getNoUrut($user_id);

    //         // Buat format no tiket (misalnya: TICno_klientahunbulannourut)
    //         $tahun = date('Y');
    //         $bulan = date('m');
    //         $no_tiket = "TIC" . $no_klien . $tahun . $bulan . $no_urut;

    //         // Kembalikan no tiket ke AJAX
    //         echo $no_tiket;
    //     } else {
    //         echo "";  // Jika tidak ada klien yang dipilih, kembalikan kosong
    //     }
    // }


    public function add_temp_tiket()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('perihal', 'Perihal', 'required|min_length[50]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('alert', 'Proses tiket baru gagal! Perihal harus diisi minimal 50 karakter.');
            redirect('helpdesk/pengajuan');
        } else {
            $user_id_hd = $this->input->post('user_id_hd');

            $this->db->where('user_id_hd', $user_id_hd);
            $existing_ticket = $this->db->get('tiket_temp')->row();

            if ($existing_ticket) {
                $this->session->set_flashdata('alert', 'Proses tiket baru gagal!, Silahkan ajukan terlebih dahulu tiket yang sudah diproses!!!');
                redirect('helpdesk/pengajuan');
            } else {
                $photo = $_FILES['file']['name'];

                if ($photo) {
                    $config['allowed_types'] = 'csv|xlsx|docx|pdf|txt|jpeg|jpg|png';
                    $config['max_size'] = '25600';
                    $config['upload_path'] = './assets/files/';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $photo = $this->upload->data('file_name');
                    } else {
                        log_message('error', 'File upload error: ' . $this->upload->display_errors());
                        $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                        redirect('helpdesk/pengajuan');
                    }
                }

                $data = [
                    'no_tiket' => trim($this->input->post('no_tiket')),
                    'perihal'  => $this->input->post('perihal'),
                    'file'     => $photo,
                    'user_id'  => $this->input->post('klien_id'),
                    'nama'     => $this->input->post('nama_klien'),
                    'kategori' => $this->input->post('kategori'),
                    'tags'     => $this->input->post('tags'),
                    'judul'    => $this->input->post('judul'),
                    'user_id_hd' => $this->input->post('user_id_hd')
                ];

                // Remove unwanted HTML tags from data
                $data = array_map(function ($value) {
                    return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
                }, $data);

                $pattern = '/<a\s+href="([^"]+)"/i';
                $data['perihal'] = preg_replace($pattern, '', $data['perihal']);

                $this->db->insert('tiket_temp', $data);
                $this->session->set_flashdata('pesan', 'Pelaporan Added!');
                redirect('helpdesk/pengajuan');
            }
        }
    }

    public function upload_tiket()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/files/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/files/' . $photo);
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

    public function fungsi_delete_temp($id)
    {
        $result = $this->temp_model->hapus_temp($id);
        if ($result) {
            $this->session->set_flashdata('pesan', 'Data Deleted!');
        } else {
            $this->session->set_flashdata('alert', 'Failed to delete!');
        }
        // var_dump($result);
        // die();
        redirect(base_url('helpdesk/pengajuan'));
    }

    public function fungsi_pengajuan()
    {
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $klien_id = $this->input->post('user_id');
        $has_unrated_finished_tickets = $this->helpdesk_model->has_unrated_finished_tickets($klien_id);

        if ($has_unrated_finished_tickets) {
            $this->session->set_flashdata('alert', 'Mohon hubungi BPR terkait untuk memberikan rating, agar tiket dapat diproses. Terima kasih!');
            redirect(Base_url('helpdesk/pengajuan'));
        } else {
            // Tambahkan tiket baru
            $this->helpdesk_model->add_pelaporan($klien_id);
            $this->helpdesk_model->delete_pelaporan($klien_id);
            $this->session->set_flashdata('pesan', 'Pelaporan Berhasil!');
            redirect(Base_url('helpdesk/pengajuan'));
        }
    }


    public function pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->helpdesk_model->getKlienPelaporanHD();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->helpdesk_model->getKlienPelaporanHDClose();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/close', $data);
        $this->load->view('templates/footer');
    }

    public function reject()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->helpdesk_model->getKlienPelaporanHDReject();

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/reject', $data);
        $this->load->view('templates/footer');
    }

    public function forward()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->helpdesk_model->getKlienPelaporanHDForward();


        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/forward', $data);
        $this->load->view('templates/footer');
    }

    public function data_finish()
    {

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/finish');
        $this->load->view('templates/footer');
    }

    public function get_data_finish()
    {
        $this->load->model('Serversidehd_model', 'serversidehd_model');

        $list = $this->serversidehd_model->get_datatables();
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
            $row[] = '<a class="btn btn-sm btn-info" href="' . base_url('helpdesk/detail_finish/' . $dp->id_pelaporan) . '"><i class="material-icons">visibility</i></a>';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->serversidehd_model->count_all(),
            "recordsFiltered" => $this->serversidehd_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);  // Kirim JSON ke DataTables
        die();
    }


    public function data_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['category'] = $this->category_model->getNamakategori();

        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->helpdesk_model->getDataPelaporanHD();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function rekapPelaporan()
    {
        // Load necessary models
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $this->load->model('Client_model', 'client_model');

        // var data for view 
        $data['tanggal_awal'] = '';
        $data['tanggal_akhir'] = '';
        $data['status_ccs'] = '';
        $data['nama_klien'] = '';
        $data['tags'] = '';

        // Get all data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->helpdesk_model->getAllData(); // A method that returns all data

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
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
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        // Load data for the view
        $data = array(
            'errors' => '',
            'klien' => $this->client_model->getClient(),
            'pencarian_data' => array(),
            'tanggal_awal' => '',
            'tanggal_akhir' => '',
            'status_ccs' => '',
            'nama_klien' => '',
            'tags' => ''
        );

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare error messages
            $data['errors'] = validation_errors();
        } else {
            // Validation passed, retrieve POST data
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');
            $status_ccs = $this->input->post('status_ccs');
            $nama_klien = $this->input->post('nama_klien');
            $tags = $this->input->post('tags');

            // Retrieve user division (assuming it's stored in session or from authentication)
            $user_id = $this->session->userdata('id_user'); // Adjust this based on your actual session logic

            // Get data from the models based on division
            $data['pencarian_data'] = $this->pelaporan_model->getDateH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags, $user_id);

            // Set the retrieved input data to be passed to the view
            $data['tanggal_awal'] = $tanggal_awal;
            $data['tanggal_akhir'] = $tanggal_akhir;
            $data['status_ccs'] = $status_ccs;
            $data['nama_klien'] = $nama_klien;
            $data['tags'] = $tags;
        }

        // Load views with data
        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function fetch_data()
    {
        $this->load->model('Helpdesk_model', 'helpdesk_model');

        // Ambil data filter dari POST request
        $filters = array(
            'tanggal_awal' => $this->input->post('tanggal_awal'),
            'tanggal_akhir' => $this->input->post('tanggal_akhir'),
            'nama_klien' => $this->input->post('nama_klien'),
            'tags' => $this->input->post('tags'),
            'status_ccs' => $this->input->post('status_ccs')
        );

        // Periksa apakah tombol "Semua Data" diklik
        if (isset($_POST['semua_data'])) {
            // Kosongkan filter
            $filters = array();
        }

        // Panggil model untuk mendapatkan data dengan filter
        $list = $this->helpdesk_model->get_datatables($filters);
        $data = array();

        // Format data sesuai kebutuhan DataTables
        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1; // Nomor urutan
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['judul'] = isset($dataItem->judul) ? $dataItem->judul : '';
            $row['tags'] = '<span class="label label-info">' . $dataItem->tags . '</span>';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            $row['impact'] = isset($dataItem->impact) ? $dataItem->impact : '';
            $row['priority'] = $this->get_priority_label($dataItem->priority);
            $row['maxday'] = $this->get_maxday_label($dataItem->maxday);
            $row['status_ccs'] = $this->get_status_label($dataItem->status_ccs);
            $row['handle_by'] = isset($dataItem->handle_by) ? $dataItem->handle_by : '';
            $data[] = $row;
        }

        // Menyiapkan output JSON untuk DataTables
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->helpdesk_model->count_all(),
            "recordsFiltered" => $this->helpdesk_model->count_filtered($filters),
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
        } elseif ($status == 'ADDED') {
            return '<span class="label label-primary">ADDED</span>';
        } elseif ($status == 'ADDED 2') {
            return '<span class="label label-primary">ADDED 2</span>';
        }
    }

    public function edit_pelaporan()
    {

        $id_pelaporan = $this->input->post('id_pelaporan');
        $no_tiket     = $this->input->post('no_tiket');
        $status_ccs   = $this->input->post('status_ccs');
        $impact       = $this->input->post('impact');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
            'status_ccs' => $status_ccs,
            'impact'     => $impact

        );
        $this->pelaporan_model->updateImpact($id_pelaporan, $ArrUpdate);
        $this->session->set_flashdata('pesan', 'Successfully Edited!');
        Redirect(base_url('helpdesk/pelaporan'));
    }

    // EDIT TIKET TEMP
    public function edit_tiket_temp($id)
    {

        $this->load->model('Temp_model', 'temp_model');
        $data['tiket_temp'] = $this->temp_model->ambil_id_temp($id);

        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();


        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/edit_tiket_temp', $data);
        $this->load->view('templates/footer');
    }

    public function fungsi_edit_pelaporan()
    {
        $this->load->model('Category_model', 'category_model');
        $data['category'] = $this->category_model->getNamaKategori();

        $id_temp = $this->input->post('id_temp');
        $judul = $this->input->post('judul');
        $perihal = $this->input->post('perihal');
        $kategori = $this->input->post('kategori');
        $tags  = $this->input->post('tags');

        //jika FILE
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'jpeg|jpg|png|docx|pdf|xlsx|csv|txt|zip|rar';
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
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('helpdesk/edit_pelaporan');
            }
        }

        $this->db->set('judul', $judul);
        $this->db->set('perihal', $perihal);
        $this->db->set('kategori', $kategori);
        $this->db->set('tags', $tags);
        $this->db->where('id_temp', $id_temp);
        $this->db->update('tiket_temp');
        $this->session->set_flashdata('pesan', 'Data Edited!');
        Redirect(base_url('helpdesk/pengajuan'));
    }


    public function fungsi_forward()
    {
        $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
        $this->form_validation->set_rules('namaspv', 'Supervisor 2', 'required', [
            'required' => 'Kolom Supervisor 2 wajib diisi.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back to the form with error messages
            $errors = strip_tags(validation_errors());
            $this->session->set_flashdata('alert', $errors);
            redirect('helpdesk/forward_tiket');
        } else {
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namaspv');
            $data = [
                'pelaporan_id' => $id_pelaporan,
                'user_id' => $id_user
            ];

            $this->db->insert('s_forward', $data);
            $this->klienpelaporan_model->updateForward($id_pelaporan, $id_user);
            $this->session->set_flashdata('pesan', 'Successfully Forward!');
            Redirect(Base_url('helpdesk/pelaporan'));
        }
    }

    public function forward_tiket($id = null)
    {
        // Cek apakah ID pelaporan tidak ada
        if ($id === null) {
            // Set pesan error dan redirect ke halaman yang sesuai
            $this->session->set_flashdata('alert', 'Forward gagal.');
            redirect('helpdesk/pelaporan'); // Redirect ke halaman yang diinginkan
            return;
        }

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);

        $this->load->model('User_model', 'user_model');
        $data['namaspv'] = $this->user_model->getNamaSpv();

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/forward_tiket', $data);
        $this->load->view('templates/footer');
    }

    public function finish_tiket($id = null)
    {
        // Cek apakah ID pelaporan tidak ada
        if ($id === null) {
            // Set pesan error dan redirect ke halaman yang sesuai
            $this->session->set_flashdata('alert', 'Finish gagal.');
            redirect('helpdesk/pelaporan'); // Redirect ke halaman yang diinginkan
            return;
        }

        // Jika ID ada, lanjutkan proses
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/finish_tiket', $data);
        $this->load->view('templates/footer');
    }



    private function contains_only_images($content)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $body = $doc->getElementsByTagName('body')->item(0);

        foreach ($body->childNodes as $node) {
            if ($node->nodeType === XML_TEXT_NODE && trim($node->textContent) !== '') {
                return false;
            }
            if ($node->nodeType === XML_ELEMENT_NODE && $node->nodeName !== 'img') {
                return false;
            }
        }
        return true;
    }

    public function finish()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('catatan_finish', 'Catatan Finish', 'callback_validateCatatanFinish');

        // Get catatan finish content from the request
        $catatan_finish = $this->input->post('catatan_finish');

        // Check if catatan finish only contains images
        if ($this->contains_only_images($catatan_finish)) {
            // If only images, set an error message and redirect back
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish tidak boleh hanya berisi gambar.');

            // Remove uploaded images
            $this->remove_uploaded_images();
            redirect('helpdesk/finish_tiket');
            return;
        }

        // Check if the form validation passed
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, set an error message and redirect back
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');

            // Remove uploaded images
            $this->remove_uploaded_images();
            redirect('helpdesk/finish_tiket');
        } else {
            $this->processFinish();
        }
    }

    // Custom validation callback
    public function validateCatatanFinish($str)
    {
        $minLength = 50;

        // Strip tags to get text content and check if length is less than min length
        $textContent = strip_tags($str);
        if (strlen($textContent) < $minLength) {
            $this->form_validation->set_message('validateCatatanFinish', 'Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            return FALSE;
        }

        return TRUE;
    }

    private function processFinish()
    {
        // Handle file upload if there is a file
        $photo = $_FILES['file_finish']['name'];

        if ($photo) {
            $config['allowed_types'] = 'csv|xlsx|docx|pdf|txt|jpeg|jpg|png|rar|zip';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/filefinish/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_finish')) {
                $photo = $this->upload->data('file_name');
            } else {

                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('helpdesk/finish_tiket');
                return;
            }
        }

        // Validate the note content
        $catatan_finish = $this->input->post('catatan_finish');
        if ($this->contains_only_images($catatan_finish) || strlen(strip_tags($catatan_finish)) < 50) {
            if ($photo) {
                unlink('./assets/filefinish/' . $photo);
            }
            $this->session->set_flashdata('alert', 'Finish gagal! Catatan Finish harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
            redirect('helpdesk/finish_tiket');
            return;
        }

        // Prepare the data for insertion
        $id = $this->input->post('id_pelaporan');
        $data = [
            'id_pelaporan' => $id,
            'no_tiket' => $this->input->post('no_tiket'),
            'waktu_pelaporan' => $this->input->post('waktu_pelaporan'),
            'file_finish'     => $photo,
            'nama'     => $this->input->post('nama'),
            'kategori' => $this->input->post('kategori'),
            'priority'   => $this->input->post('priority'),
            'maxday'     => $this->input->post('maxday'),
            'catatan_finish' => $catatan_finish,
            'status'     => 'Solved',
            'status_ccs' => 'CLOSED'
        ];

        // Remove unwanted HTML tags from data
        $data = array_map(function ($value) {
            return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
        }, $data);

        // Insert the data into the database
        $this->pelaporan_model->updateHD($id, $data);

        // Clear session images after successful finish
        $this->session->unset_userdata('uploaded_images');

        // Set a success message and redirect to the submission page
        $this->session->set_flashdata('pesan', 'Successfully Finish!');
        redirect('helpdesk/pelaporan');
    }

    private function remove_uploaded_images()
    {
        $uploaded_images = $this->session->userdata('uploaded_images');
        if ($uploaded_images) {
            foreach ($uploaded_images as $image) {
                if (file_exists('./assets/filefinish/' . $image)) {
                    unlink('./assets/filefinish/' . $image);
                }
            }
            $this->session->unset_userdata('uploaded_images');
        }
    }


    public function upload()
    {
        if ($_FILES['upload']['name']) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/filefinish/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('upload')) {
                $photo = $this->upload->data('file_name');
                $url = base_url('assets/filefinish/' . $photo);
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

    public function detail_pelaporan($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->helpdesk_model->get_latest_comments($id);
        $data['datareply']     = $this->helpdesk_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_finish', $data);
        $this->load->view('templates/footer');
    }

    public function detail_close($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_close', $data);
        $this->load->view('templates/footer');
    }

    public function detail_pelaporann($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $data['datapelaporan'] = $this->helpdesk_model->ambil_id_pelaporan($id);
        $data['datacomment']   = $this->helpdesk_model->get_latest_comments($id);
        $data['datareply']     = $this->helpdesk_model->get_replies_by_pelaporan_id($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/detail_pelaporann', $data);
        $this->load->view('templates/footer');
    }

    public function preview($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['tiket_temp'] = $this->klienpelaporan_model->ambil_id_temp($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/preview', $data);
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
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('helpdesk/detail_pelaporan');
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
        Redirect(Base_url('helpdesk/detail_pelaporan/' . $id_pelaporan));
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
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
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('helpdesk/detail_pelaporan');
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
        Redirect(Base_url('helpdesk/detail_pelaporan/' . $id_pelaporan));
    }


    public function statistik()
    {
        // // Fetch total active data from the model
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('helpdesk/statistik');
        $this->load->view('templates/footer');
    }

    public function get_notifications()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        // Ambil notifikasi dari database dengan paginasi
        $notifications = $this->helpdesk_model->get_notifications($limit, $offset);

        // Total notifikasi yang tersedia di server
        $total_count = $this->helpdesk_model->get_total_count();

        // Kirim response JSON
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $this->helpdesk_model->get_unread_count(),
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
        $this->load->model('Helpdesk_model', 'helpdesk_model');
        $notifications = $this->helpdesk_model->get_notifications($limit, $offset);
        $unread_count = $this->helpdesk_model->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
}
