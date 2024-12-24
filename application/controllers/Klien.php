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

    public function add_temp_tiket()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required|min_length[50]');
        $this->form_validation->set_rules('judul', 'Judul', 'required');

        // Cek validasi form
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, buat pesan error yang sesuai dengan kesalahan field
            $errors = validation_errors('<p>', '</p>');
            $error_message = 'Proses tiket baru gagal! ';

            if (form_error('perihal')) {
                $error_message .= 'Perihal harus diisi minimal 50 karakter. ';
            }

            if (form_error('judul')) {
                $error_message .= 'Judul harus diisi.';
            }

            $this->session->set_flashdata('alert', $error_message);
            redirect('klien/pengajuan');
        } else {
            $no_tiket = trim($this->input->post('no_tiket'));

            // Check jika no tiket sudah ada ditable temporary
            $this->db->where('no_tiket', $no_tiket);
            $existing_ticket = $this->db->get('tiket_temp')->row();

            if ($existing_ticket) {
                $this->session->set_flashdata('alert', 'Proses tiket baru gagal! Tiket sudah ada.');
                redirect('klien/pengajuan');
            } else {
                $photo = $_FILES['file']['name'];

                if ($photo) {
                    $config['allowed_types'] = 'pdf|docx|jpeg|jpg|png|csv|xlsx||txt|zip|rar';
                    $config['max_size'] = '25600';
                    $config['upload_path'] = './assets/files/';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $photo = $this->upload->data('file_name');
                    } else {
                        log_message('error', 'File upload error: ' . $this->upload->display_errors());
                        $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                        redirect('klien/pengajuan');
                    }
                }

                $perihal = $this->input->post('perihal');
                if ($this->contains_only_images($perihal) || strlen(strip_tags($perihal)) < 50) {
                    if ($photo) {
                        unlink('./assets/files/' . $photo);
                    }
                    $this->session->set_flashdata('alert', 'Proses tiket baru gagal! Perihal harus diisi minimal 50 karakter dan tidak boleh hanya berisi gambar.');
                    redirect('klien/pengajuan');
                    return;
                }

                $id = $this->input->post('id_temp');
                $data = [
                    'id_temp'  => $id,
                    'no_tiket' => $no_tiket,
                    'perihal'  => $perihal,
                    'file'     => $photo,
                    'user_id'  => $this->input->post('user_id'),
                    'nama'     => $this->input->post('nama'),
                    'kategori' => $this->input->post('kategori'),
                    'tags'     => $this->input->post('tags'),
                    'judul'    => $this->input->post('judul')
                ];

                // Remove tag
                $data = array_map(function ($value) {
                    return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
                }, $data);

                // Remove link
                $pattern = '/<a\s+href="([^"]+)"/i';
                $data['perihal'] = preg_replace($pattern, '', $data['perihal']);

                if ($this->db->insert('tiket_temp', $data)) {
                    $this->session->set_flashdata('pesan', 'Pelaporan berhasil ditambahkan!');
                    redirect('klien/pengajuan');
                } else {
                    $this->session->set_flashdata('alert', 'Gagal menyimpan data, silakan coba lagi.');
                    redirect('klien/pengajuan');
                }
            }
        }
    }

    public function upload()
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
        redirect(base_url('klien/pengajuan'));
    }

    public function fungsi_pengajuan()
    {
        $has_unrated_finished_tickets = $this->pelaporan_model->has_unrated_finished_tickets($this->session->userdata('user_id'));

        if ($has_unrated_finished_tickets) {
            // Jika ada tiket selesai yang belum diberi rating, berikan pesan dan hentikan proses
            $this->session->set_flashdata('alert', 'Sebelum mengajukan tiket baru, mohon berikan rating pada tiket yang telah finish. Terima kasih!');
            redirect(Base_url('klien/pengajuan'));
        } else {
            // Tambahkan tiket baru
            $this->pelaporan_model->add_pelaporan();
            $this->pelaporan_model->delete_pelaporan();
            $this->session->set_flashdata('pesan', 'Pelaporan Berhasil!');
            redirect(Base_url('klien/added'));
        }
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
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Temp_model', 'temp_model');
        $data['category'] = $this->category_model->getCategory();
        $data['tiket_temp'] = $this->temp_model->getTiketTempKlien();

        $id_user = $this->session->userdata('id_user');

        // Ambil nomor tiket lengkap dari model (sudah termasuk no_klien, tahun, bulan, dan nomor urut)
        $data['tiket'] = $this->client_model->getNoUrut($id_user);

        // Load views
        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pengajuan', $data);
        $this->load->view('templates/footer');
    }


    // public function pengajuan()
    // {
    //     // $data['noTiket'] = $this->client_model->getkodeticket();
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $this->load->model('Temp_model', 'temp_model');
    //     $data['category']      = $this->category_model->getCategory();
    //     $data['tiket_temp'] = $this->temp_model->getTiketTempKlien();
    //     $id_user = $this->session->userdata('id_user');
    //     $no_klien = $this->client_model->getNoKlien($id_user);
    //     $no_urut = $this->client_model->getNoUrut($id_user);
    //     $bulan = $time = date("m");
    //     $tahun = $time = date("Y");

    //     $data['tiket'] = "TIC" . $no_klien . $tahun . $bulan . $no_urut;

    //     $this->load->view('templates/header');
    //     $this->load->view('templates/klien_sidebar');
    //     $this->load->view('klien/pengajuan', $data);
    //     $this->load->view('templates/footer');
    // }

    #data pelaporan
    public function datapelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->getKlienPelaporanTemp();


        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/data_pelaporan', $data);
        $this->load->view('templates/footer');
    }

    public function added()
    {
        $this->load->model('M_Klien', 'M_Klien');
        $this->load->model('User_model', 'user_model');
        $data['user']          = $this->user_model->getDataUser();
        $data['dataAdded'] = $this->M_Klien->getDataAdded();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('M_Klien', 'M_Klien');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->M_Klien->getDataHandled();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
    }

    public function close()
    {
        $this->load->model('M_Klien', 'M_Klien');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->M_Klien->getDataClosed();


        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
    {
        // $this->load->model('M_Klien', 'M_Klien');
        // $this->load->model('User_model', 'user_model');
        // $data['user'] = $this->user_model->getDataUser();
        // $data['datapelaporan'] = $this->M_Klien->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_finish');
        $this->load->view('templates/footer');
    }

    public function get_data_finish()
    {
        $this->load->model('Serversideklien_model', 'serversideklien_model');

        $list = $this->serversideklien_model->get_datatables();
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
            // $row[] = $dp->tags ? '<span class="label label-info">' . $dp->tags . '</span>' : '';

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
            $row[] = '<div class="star-rating" data-id_pelaporan="' . $dp->id_pelaporan . '" data-has-rated="' . ($dp->has_rated ? 'true' : 'false') . '" data-rating="' . $dp->rating . '">
            <span class="star" data-value="1">&#9733;</span>
            <span class="star" data-value="2">&#9733;</span>
            <span class="star" data-value="3">&#9733;</span>
            <span class="star" data-value="4">&#9733;</span>
            <span class="star" data-value="5">&#9733;</span>
            </div>';


            // Tombol Aksi
            $row[] = '<a class="btn btn-sm btn-info" href="' . base_url('klien/detail_finish/' . $dp->id_pelaporan) . '"><i class="material-icons">visibility</i></a>';

            // Tambahkan row ke data
            $data[] = $row;
        }

        $output = array(
            "draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
            "recordsTotal" => $this->serversideklien_model->count_all(),
            "recordsFiltered" => $this->serversideklien_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);  // Kirim JSON ke DataTables
        die();
    }

    public function save_rating()
    {
        $id = $this->input->post('id_pelaporan');
        $rating = $this->input->post('rating');

        log_message('info', 'ID: ' . $id . ', Rating: ' . $rating);

        // Check if data received is not empty
        if (empty($id) || empty($rating)) {
            log_message('error', 'ID or Rating is empty.');
            echo json_encode(['status' => 'error', 'message' => 'ID or Rating is empty.']);
            return;
        }

        $this->load->model('M_Klien');
        $this->M_Klien->update_rating($id, $rating);

        echo json_encode(['status' => 'success']);
    }

    public function rating1()
    {
        header('Content-Type: application/json');

        $this->load->model('M_Klien');
        try {
            // Validasi input
            $id = $this->input->post('id_pelaporan');
            $rating = $this->input->post('rating');

            if (empty($id) || empty($rating)) {
                throw new Exception('ID Pelaporan dan Rating harus diisi.');
            }

            // Perform validation and update the rating in the database
            if (!$this->M_Klien->update_rating($id, $rating)) {
                throw new Exception('Failed to update rating.');
            }

            // Update the rating status
            $this->db->where('id_pelaporan', $id);
            if (!$this->db->update('pelaporan', ['has_rated' => TRUE])) {
                throw new Exception('Failed to update rating status.');
            }

            echo json_encode(['status' => 'success']);
            exit;
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Internal Server Error: ' . $e->getMessage()]);
            exit;
        }
    }

    public function rating()
    {
        header('Content-Type: application/json');
        $this->load->model('M_Klien');
        try {
            $id = $this->input->post('id_pelaporan');
            $rating = $this->input->post('rating');

            // Log input data
            log_message('debug', 'Received rating data: ID = ' . $id . ', Rating = ' . $rating);

            // Check if the user has already rated
            $this->db->where('id_pelaporan', $id);
            $query = $this->db->get('pelaporan');
            if ($query === FALSE) {
                log_message('error', 'Database query failed: ' . $this->db->last_query());
                throw new Exception('Database query failed');
            }

            $row = $query->row();

            if ($row->has_rated) {
                // User has already rated
                echo json_encode(['status' => 'error', 'message' => 'You have already rated this item.']);
                return;
            }

            // Perform validation and update the rating in the database
            if (!$this->M_Klien->update_rating($id, $rating)) {
                log_message('error', 'Failed to update rating');
                throw new Exception('Failed to update rating');
            }

            // Update the rating status
            $this->db->where('id_pelaporan', $id);
            if (!$this->db->update('pelaporan', ['has_rated' => TRUE])) {
                log_message('error', 'Failed to update rating status: ' . $this->db->last_query());
                throw new Exception('Failed to update rating status');
            }

            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            log_message('error', 'Error in method_to_handle_rating: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Internal Server Error: ' . $e->getMessage()]);
        }
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

    // EDIT PELAPORAN
    public function edit_pelaporan($id)
    {

        $this->load->model('Temp_model', 'temp_model');
        $data['tiket_temp'] = $this->temp_model->ambil_id_temp($id);

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

        $id_temp = $this->input->post('id_temp');
        $judul = $this->input->post('judul');
        $perihal = $this->input->post('perihal');
        $kategori = $this->input->post('kategori');
        $tags  = $this->input->post('tags');

        //jika FILE
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'jpeg|jpg|png|docx|pdf|xlsx|csv|txt|zip|rar';
            $config['max_size'] = '25600';
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
                // Log the error and set a flash message for failed upload
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('klien/edit_pelaporan');
            }
        }

        $this->db->set('judul', $judul);
        $this->db->set('perihal', $perihal);
        $this->db->set('kategori', $kategori);
        $this->db->set('tags', $tags);
        $this->db->where('id_temp', $id_temp);
        $this->db->update('tiket_temp');
        $this->session->set_flashdata('pesan', 'Data Edited!');
        Redirect(base_url('klien/pengajuan'));
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

    public function detail_finish($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/detail_finish', $data);
        $this->load->view('templates/footer');
    }

    public function detail_close($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('klienpelaporan_model', 'klienpelaporan_model');
        $data['datapelaporan'] = $this->klienpelaporan_model->ambil_id_pelaporan($id);

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/detail_close', $data);
        $this->load->view('templates/footer');
    }

    public function preview($id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        $data['tiket_temp'] = $this->klienpelaporan_model->ambil_id_temp($id);

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/preview', $data);
        $this->load->view('templates/footer');
    }

    public function add_comment()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        //jika ada gambar
        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|csv|docx|pdf|txt|jpeg|jpg|png|zip|rar';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/comment/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                // Log the error and set a flash message for failed upload
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('klien/detail_pelaporan');
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
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('klien/detail_pelaporan/' . $id_pelaporan));
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

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|csv|docx|pdf|txt|jpeg|png|jpg|zip|rar';
            $config['max_size'] = '25600';
            $config['upload_path'] = './assets/reply/';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {

                $photo = $this->upload->data('file_name');
            } else {
                log_message('error', 'File upload error: ' . $this->upload->display_errors());
                $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                redirect('klien/detail_pelaporan');
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
        Redirect(Base_url('klien/detail_pelaporan/' . $id_pelaporan));
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

    public function update()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $data = array(
            'rating' => $this->input->post('rating')
        );
        $this->klienpelaporan_model->update_data('pelaporan', $data, $id_pelaporan);
    }

    public function fetch_notifications()
    {
        // // Fetch total active data from the model
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('user_id');

        $limit = 5;  // Tampilkan 20 notifikasi per halaman
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $this->load->model('M_Klien', 'M_Klien');
        $notifications = $this->M_Klien->get_notifications($limit, $offset, $user_id);
        $unread_count = $this->M_Klien->count_unread_notifications();
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unread_count
        ]);
    }
}
