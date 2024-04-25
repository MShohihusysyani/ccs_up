<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }
    
    

    public function proses_login()
    {

        $this->form_validation->set_rules('username', 'username', 'required', ['required' => 'Username Wajib Diisi!']);
        $this->form_validation->set_rules('password', 'password', 'required', ['required' => 'Password Wajib Diisi!']);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header');
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $username;
            $pass = MD5($password);

            $cek = $this->login_model->cek_login($user, $pass);

            if ($cek->num_rows() > 0) {

                foreach ($cek->result() as $ck) {
                    $sess_data['username'] = $ck->username;
                    $sess_data['nama_user']     = $ck->nama_user;
                    $sess_data['divisi']   = $ck->divisi;
                    $sess_data['role']     = $ck->role;
                    $sess_data['id_user']       = $ck->id_user;
                    $sess_data['active']   = $ck->active;
                   

                    $this->session->set_userdata($sess_data);
                }
                if ($sess_data['active'] == 'Y') {
                    if ($sess_data['role'] == '1') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('klien');

                    } elseif ($sess_data['role'] == '2') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('helpdesk');

                    } elseif ($sess_data['role'] == '3') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('supervisor');

                    } elseif ($sess_data['role'] == '4') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('implementator');
                    
                    } elseif ($sess_data['role'] == '5') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('support');

                    } elseif ($sess_data['role'] == '6') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('dbs');
                    
                    } elseif ($sess_data['role'] == '7') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('crd');
                        
                    } elseif ($sess_data['role'] == '8') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('development');

                    } elseif ($sess_data['role'] == '9') {
                        $this->session->set_flashdata('pesan', 'Success Login!');
                        redirect('supervisor2');
                        
                    } else {
                        $this->session->set_flashdata('alert', 'Incorrect Roles!');
                        redirect('auth');
                    }
                } else {
                    
                    $this->session->set_flashdata('alert', 'Inactive User, Please Contact Supervisor!');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('alert', 'Incorrect Username or Password!');
                redirect('auth');
            }
          

        }
    }


    public function blocked()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/blocked');
        $this->load->view('templates/auth_footer');
    }


    public function logout()
    {
        
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->set_flashdata('pesan', 'Success Logout!');
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logout!</div>');
        redirect('auth');
    }

    public function logout2(){

    date_default_timezone_set("ASIA/JAKARTA");
    $date = array('last_login' => date('Y-m-d H:i:s'));
    $id = $this->session->userdata('id');
    $this ->auth_model->logout($date, $id);
    $this->session->sess_destroy();
    $this->session->set_flashdata('pesan', 'Success Logout!');
    redirect('auth');
    }

    public function forgot_password()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header');
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'active' => 'Y'])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Please Check Email or Spam!</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email Not Registered!</div>');
                redirect('auth/forgot_password');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();


        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('pesan', '<div class=" swal-log" data-swal-log="<?= session()->get("pesan");"></div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class=" swal-log" data-swal-log="<?= session()->get("pesan");"></div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password', 'password', 'required', ['required' => 'New Password Wajib Diisi!']);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header');
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = $this->input->post('password');
            $email = $this->session->userdata('reset_email');

            $pass = MD5($password);

            $this->db->set('password', $pass);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('pesan', '<div class=" swal-log" data-swal-log="<?= session()->get("pesan");"></div>');
            redirect('auth');
        }
    }
}