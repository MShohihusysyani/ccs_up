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
            $row[] = $pelaporan->perihal;
            $row[] = $pelaporan->impact;
            $row[] = '<a href="' . site_url('assets/files/' . $pelaporan->file) . '">' . $pelaporan->file . '</a>';
            $pelaporan->file;
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
            } elseif ($pelaporan->status_ccs == 'HANDLE') {
                $status_ccs_label = '<span class="label label-info">HANDLE</span>';
            } elseif ($pelaporan->status_ccs == 'HANDLE 2') {
                $status_ccs_label = '<span class="label label-info">HANDLE 2</span>';
            } elseif ($pelaporan->status_ccs == 'CLOSE') {
                $status_ccs_label = '<span class="label label-warning">CLOSE</span>';
            } elseif ($pelaporan->status_ccs == 'FINISH') {
                $status_ccs_label = '<span class="label label-success">FINISH</span>';
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
        $data['dataAdded'] = $this->spv2_model->getKlienPelaporanAdd();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_added', $data);
        $this->load->view('templates/footer');
    }

    public function onprogress()
    {
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanOP();

        $this->load->model('User_model', 'user_model');
        $data['namateknisi'] = $this->user_model->getNamaTeknisi();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_onprogress', $data);
        $this->load->view('templates/footer');
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
        $this->load->model('Klienpelaporan_model', 'klienpelaporan_model');
        // $data['nama_kategori'] = $this->db->get('pelaporan')->result_array();
        $data['category'] = $this->category_model->getNamakategori();
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getDataUser();
        $data['datapelaporan'] = $this->spv2_model->getKlienPelaporanFinish();

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('supervisor2/pelaporan_finish', $data);
        $this->load->view('templates/footer');
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
        $now = date('Y-m-d');

        $id_pelaporan         = $this->input->post('id_pelaporan');
        $no_tiket   = $this->input->post('no_tiket');
        $nama       = $this->input->post('nama');
        $judul      = $this->input->post('judul');
        // $perihal    = $this->input->post('perihal');
        $status_ccs = 'FINISH';
        $waktu      = date('Y-m-d');
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
        // $perihal      = $this->input->post('perihal');
        $kategori     = $this->input->post('kategori');
        $priority     = $this->input->post('priority');
        $maxday       = $this->input->post('maxday');
        $tags         = $this->input->post('tags');
        $ArrUpdate = array(
            'no_tiket'   => $no_tiket,
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

    // FORWARD KE TEKNISI
    public function fungsi_forward()
    {
        // Set validation rules
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

        // Check if validation is successful
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back to the form with error messages
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


    //EDIT TEKNISI
    // public function fungsi_edit()
    // {
    //     // Load the form validation library
    //     $this->load->library('form_validation');

    //     // Set validation rules
    //     $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
    //     $this->form_validation->set_rules('namateknisi', 'Teknisi', 'required');

    //     // Check if the form passes validation
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('error', 'Form validation failed. Please fill in all required fields.');
    //         redirect(base_url('supervisor2/onprogress'));
    //     } else {
    //         // Retrieve POST data
    //         $id_pelaporan = $this->input->post('id_pelaporan');
    //         $id_user = $this->input->post('namateknisi');
    //         $data = [
    //             'pelaporan_id' => $id_pelaporan,
    //             'user_id' => $id_user
    //         ];

    //         // Fetch the user name based on the user ID
    //         $this->db->select('id_user, nama_user');
    //         $this->db->from('user');
    //         $this->db->where('id_user', $id_user);
    //         $query = $this->db->get();

    //         // Check if user exists
    //         if ($query->num_rows() > 0) {
    //             $user = $query->row();
    //             $nama_user = $user->nama_user;

    //             // Update the forward table
    //             $this->db->where('pelaporan_id', $id_pelaporan);
    //             $this->db->update('t1_forward', $data);

    //             // Update the Helpdesk in the supervisor_model
    //             $this->spv2_model->updateTeknisi($id_pelaporan, $nama_user);

    //             // Set success message
    //             $this->session->set_flashdata('pesan', 'Teknisi has been updated!');
    //         } else {
    //             // Set error message if user not found
    //             $this->session->set_flashdata('error', 'User not found.');
    //         }

    //         // Redirect to the onprogress page
    //         redirect(base_url('supervisor2/onprogress'));
    //     }
    // }
    public function fungsi_edit()
    {
        // Load the form validation library
        $this->load->library('form_validation');

        // Set validation rules
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
            // If validation fails, redirect back to the form with error messages
            $this->session->set_flashdata('alert', validation_errors());
            redirect('supervisor2/onprogress');
        } else {
            // Retrieve POST data
            $id_pelaporan = $this->input->post('id_pelaporan');
            $id_user = $this->input->post('namateknisi');

            // Fetch the user name based on the user ID
            $this->db->select('id_user, nama_user');
            $this->db->from('user');
            $this->db->where('id_user', $id_user);
            $query = $this->db->get();

            // Check if user exists
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $nama_user = $user->nama_user;

                // Find the second entry for the pelaporan_id
                $this->db->select('id_forward');
                $this->db->from('t1_forward');
                $this->db->where('pelaporan_id', $id_pelaporan);
                $this->db->order_by('id_forward', 'ASC'); // Order by id to get the entries in order
                $query = $this->db->get();
                $result = $query->result();

                if (count($result) >= 2) { // Ensure there are at least two entries
                    $second_technician_id = $result[1]->id_forward; // Get the ID of the second technician entry

                    // Update the second technician
                    $this->db->where('id_forward', $second_technician_id);
                    $this->db->update('t1_forward', ['user_id' => $id_user]);

                    // Update the Helpdesk in the supervisor_model
                    $this->spv2_model->updateTeknisi($id_pelaporan, $nama_user);

                    // Set success message
                    $this->session->set_flashdata('pesan', 'Teknisi kedua telah diperbarui!');
                } else {
                    // Set error message if there are less than two entries
                    $this->session->set_flashdata('error', 'Teknisi kedua tidak ditemukan.');
                }
            } else {
                // Set error message if user not found
                $this->session->set_flashdata('error', 'User tidak ditemukan.');
            }

            // Redirect to the onprogress page
            redirect(base_url('supervisor2/onprogress'));
        }
    }





    //TAMBAH TEKNISI
    public function fungsi_tambah()
    {
        // Set validation rules
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
            // If validation fails, redirect back to the form with error messages
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

            // cari nama user berdasarkan id 
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

    // public function fungsi_tambah()
    // {
    //     // Set validation rules
    //     $this->form_validation->set_rules('id_pelaporan', 'Pelaporan', 'required');
    //     $this->form_validation->set_rules('namateknisi', 'Teknisi', 'required', [
    //         'required' => 'Kolom Teknisi wajib diisi.'
    //     ]);
    //     $this->form_validation->set_rules('judul', 'Judul', 'required', [
    //         'required' => 'Kolom Judul wajib diisi.'
    //     ]);
    //     $this->form_validation->set_rules('subtask2', 'Subtask', 'required', [
    //         'required' => 'Kolom Subtask wajib diisi.'
    //     ]);
    //     $this->form_validation->set_rules('tanggal2', 'Tanggal', 'required', [
    //         'required' => 'Kolom Tenggat waktu wajib diisi.'
    //     ]);
    //     $this->form_validation->set_rules('priority', 'Priority', 'required', [
    //         'required' => 'Kolom Priority wajib diisi.'
    //     ]);
    //     $this->form_validation->set_rules('maxday', 'Max Day', 'required', [
    //         'required' => 'Kolom Max Day wajib diisi.'
    //     ]);

    //     if ($this->form_validation->run() == FALSE) {
    //         // If validation fails, redirect back to the form with error messages
    //         $this->session->set_flashdata('alert', validation_errors());
    //         redirect('supervisor2/onprogress');
    //     } else {
    //         $id_pelaporan = $this->input->post('id_pelaporan');
    //         $id_user = $this->input->post('namateknisi');
    //         $judul   = $this->input->post('judul');
    //         $subtask = $this->input->post('subtask2');
    //         $tanggal = $this->input->post('tanggal2');
    //         $data = [
    //             'pelaporan_id' => $id_pelaporan,
    //             'user_id' => $id_user,
    //             'judul'   => $judul,
    //             'subtask2' => $subtask,
    //             'tanggal2' => $tanggal
    //         ];

    //         // cari nama user berdasarkan id 
    //         $this->db->select('id_user, nama_user');
    //         $this->db->from('user');
    //         $this->db->where('id_user', $id_user);
    //         $query = $this->db->get();
    //         $user = $query->row();
    //         $nama_user = $user->nama_user;

    //         $this->db->insert('t2_forward', $data);
    //         $this->spv2_model->tambahTeknisi($id_pelaporan, $nama_user);
    //         $this->session->set_flashdata('pesan', 'Teknisi has been added!');
    //         Redirect(Base_url('supervisor2/onprogress'));
    //     }
    // }

    //   FILTER LAPORAN
    public function rekapPelaporan()
    {
        // Load necessary models
        $this->load->model('supervisor_model', 'supervisor_model');
        $this->load->model('Client_model', 'client_model');

        // var data for view 
        $data['tanggal_awal'] = '';
        $data['tanggal_akhir'] = '';
        $data['status_ccs'] = '';
        $data['nama_klien'] = '';
        $data['tags'] = '';

        // Get all data from the models
        $data['klien'] = $this->client_model->getClient();
        $data['pencarian_data'] = $this->supervisor_model->getAllData(); // A method that returns all data

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
        $this->form_validation->set_rules('tags', 'Tags', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, prepare data for the view with error messages
            $data['errors'] = validation_errors();
            $data['klien'] = $this->client_model->getClient();
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
            $data['tags'] = $tags;

            // Get data from the models
            $data['klien'] = $this->client_model->getClient();
            $data['pencarian_data'] = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);

            // Load views with data
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('supervisor2/rekap_pelaporan', $data);
            $this->load->view('templates/footer');
        }
    }

    public function fetch_data()
    {
        $this->load->model('Server_model', 'serverside_model');

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
        $list = $this->serverside_model->get_datatables($filters);
        $data = array();

        // Format data sesuai kebutuhan DataTables
        foreach ($list as $key => $dataItem) {
            $row = array();
            $row['no'] = $key + 1; // Nomor urutan
            $row['waktu_pelaporan'] = isset($dataItem->waktu_pelaporan) ? tanggal_indo($dataItem->waktu_pelaporan) : '';
            $row['no_tiket'] = isset($dataItem->no_tiket) ? $dataItem->no_tiket : '';
            $row['nama'] = isset($dataItem->nama) ? $dataItem->nama : '';
            $row['perihal'] = isset($dataItem->perihal) ? $dataItem->perihal : '';
            $row['tags'] = '<span class="label label-info">' . $dataItem->tags . '</span>';
            $row['kategori'] = isset($dataItem->kategori) ? $dataItem->kategori : '';
            $row['impact'] = isset($dataItem->impact) ? $dataItem->impact : '';
            $row['priority'] = $this->get_priority_label($dataItem->priority);
            $row['maxday'] = $this->get_maxday_label($dataItem->maxday);
            $row['status_ccs'] = $this->get_status_label($dataItem->status_ccs);
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
        if ($status == 'FINISH') {
            return '<span class="label label-success">FINISH</span>';
        } elseif ($status == 'CLOSE') {
            return '<span class="label label-warning">CLOSE</span>';
        } elseif ($status == 'HANDLE') {
            return '<span class="label label-info">HANDLE</span>';
        } elseif ($status == 'ADDED') {
            return '<span class="label label-primary">ADDED</span>';
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
