<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }
    
    

    public function proses_login()
{

    $this->form_validation->set_rules('username', 'Username', 'required', ['required' => 'Username Wajib Diisi!']);
    $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password Wajib Diisi!']);

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('templates/auth_header');
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    } else {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Retrieve user by username
        $user = $this->login_model->cek_login($username);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user->password)) {
            // Update last login time
            $this->User_model->update_last_login($user->id_user);

            // Set session data
            $sess_data = [
                'username' => $user->username,
                'nama_user' => $user->nama_user,
                'divisi' => $user->divisi,
                'role' => $user->role,
                'id_user' => $user->id_user,
                'active' => $user->active,
            ];
            $this->session->set_userdata($sess_data);

            // Redirect based on user role
            if ($sess_data['active'] == 'Y') {
                $this->session->set_flashdata('pesan', 'Successfully Login!');
                switch ($sess_data['role']) {
                    case '1': redirect('klien'); break;
                    case '2': redirect('helpdesk'); break;
                    case '3': redirect('supervisor'); break;
                    case '4': redirect('implementator'); break;
                    case '5': redirect('support'); break;
                    case '6': redirect('superadmin'); break;
                    case '7': redirect('crd'); break;
                    case '8': redirect('development'); break;
                    case '9': redirect('supervisor2'); break;
                    default:
                        $this->session->set_flashdata('alert', 'Incorrect Roles!');
                        redirect('auth');
                        break;
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
        $this->session->set_flashdata('pesan', 'Successfully Logout!');
        redirect('auth');
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