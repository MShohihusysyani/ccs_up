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

    public function add_temp_tiket()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('perihal', 'Perihal', 'required|min_length[50]');

        // Check if the form validation passed
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, set an error message and redirect back
            $this->session->set_flashdata('alert', 'Proses tiket baru gagal! Perihal harus diisi minimal 50 karakter.');
            redirect('klien/pengajuan');
        } else {
            // Retrieve the ticket number from the form input
            $no_tiket = $this->input->post('no_tiket');

            // Check if the ticket number already exists in the database
            $this->db->where('no_tiket', $no_tiket);
            $existing_ticket = $this->db->get('tiket_temp')->row();

            if ($existing_ticket) {
                // If the ticket number already exists, set an error message and redirect back
                $this->session->set_flashdata('alert', 'Proses tiket baru gagal! Tiket sudah ada.');
                redirect('klien/pengajuan');
            } else {
                // Handle file upload if there is a file
                $photo = $_FILES['file']['name'];

                if ($photo) {
                    $config['allowed_types'] = 'pdf|docx|jpeg|jpg|png|csv|xlsx|';
                    $config['max_size'] = '2048';
                    $config['upload_path'] = './assets/files/';

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $photo = $this->upload->data('file_name');
                    } else {
                        // Log the error and set a flash message for failed upload
                        log_message('error', 'File upload error: ' . $this->upload->display_errors());
                        $this->session->set_flashdata('alert', 'Upload file gagal! ' . $this->upload->display_errors());
                        redirect('klien/pengajuan');
                    }
                }

                // Prepare the data for insertion
                $data = [
                    'no_tiket' => $no_tiket,
                    'perihal'  => $this->input->post('perihal'),
                    'file'     => $photo,
                    'user_id'  => $this->input->post('user_id'),
                    'nama'     => $this->input->post('nama'),
                    'kategori' => $this->input->post('kategori'),
                    'tags'     => $this->input->post('tags'),
                    'judul'    => $this->input->post('judul')
                ];

                // Remove unwanted HTML tags from data
                $data = array_map(function ($value) {
                    return preg_replace("/^<p.*?>/", "", preg_replace("|</p>$|", "", $value));
                }, $data);

                // Prevent certain HTML tags such as <a> from being inserted in 'perihal'
                $pattern = '/<a\s+href="([^"]+)"/i';
                $data['perihal'] = preg_replace($pattern, '', $data['perihal']);

                // Insert the data into the database
                if ($this->db->insert('tiket_temp', $data)) {
                    // Set a success message and redirect to the submission page
                    $this->session->set_flashdata('pesan', 'Pelaporan berhasil ditambahkan!');
                    redirect('klien/pengajuan');
                } else {
                    // Set a flash message if the data insertion fails
                    $this->session->set_flashdata('alert', 'Gagal menyimpan data, silakan coba lagi.');
                    redirect('klien/pengajuan');
                }
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
        // Cek apakah ada tiket yang selesai tetapi belum diberi rating
        $has_unrated_finished_tickets = $this->pelaporan_model->has_unrated_finished_tickets($this->session->userdata('user_id'));

        if ($has_unrated_finished_tickets) {
            // Jika ada tiket selesai yang belum diberi rating, berikan pesan dan hentikan proses
            $this->session->set_flashdata('alert', 'Sebelum mengajukan tiket baru, mohon berikan rating pada tiket yang telah finish. Terima kasih!');
            redirect(Base_url('klien/pengajuan')); // Alihkan ke halaman untuk memberi rating
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
        // $data['noTiket'] = $this->client_model->getkodeticket();
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Temp_model', 'temp_model');
        $data['category']      = $this->category_model->getCategory();
        $data['tiket_temp'] = $this->temp_model->getTiketTempKlien();
        $id_user = $this->session->userdata('id_user');
        $no_klien = $this->client_model->getNoKlien($id_user);
        $no_urut = $this->client_model->getNoUrut($id_user);
        $bulan = $time = date("m");
        $tahun = $time = date("Y");

        $data['tiket'] = "TIC" . $no_klien . $tahun . $bulan . $no_urut;

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
        $data['dataAdded'] = $this->M_Klien->getKlienPelaporanAdd();

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
        $data['datapelaporan'] = $this->M_Klien->getKlienPelaporanOP();

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
        $data['datapelaporan'] = $this->M_Klien->getKlienPelaporanClose();


        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_close', $data);
        $this->load->view('templates/footer');
    }

    public function finish()
    {
        $this->load->model('M_Klien', 'M_Klien');
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->M_Klien->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('klien/pelaporan_finish', $data);
        $this->load->view('templates/footer');
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
            $config['allowed_types'] = 'xlsx|csv|docx|pdf|txt|jpeg|jpg|png';
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
        $this->session->set_flashdata('pesan', 'Successfully Forward!');
        Redirect(Base_url('klien/detail_pelaporan/' . $id_pelaporan));
    }

    public function add_reply()
    {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $photo = $_FILES['file']['name'];

        if ($photo) {
            $config['allowed_types'] = 'xlsx|csv|docx|pdf|txt|jpeg|png|jpg';
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
        Redirect(Base_url('klien/detail_pelaporan/' . $id_pelaporan));
    }

    public function update()
    {
        $id_pelaporan = $this->input->post('id_pelaporan');
        $data = array(
            'rating' => $this->input->post('rating')
        );
        $this->klienpelaporan_model->update_data('pelaporan', $data, $id_pelaporan);
    }
}
