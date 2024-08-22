<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $this->load->model('User_model', 'user_model');
        // $data['username'] = $this->db->get('user')->result_array();


        // $data['user'] = $this->user_model->getUser();
        $this->load->view('templates/header');
        $this->load->view('templates/admin_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function AktivasiUser()
    {
        $this->load->model('User_model', 'user_model');

        $data['user'] = $this->user_model->getDataUser();
        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('superadmin/activate_user', $data);
        $this->load->view('templates/footer');
    }

    public function active($id)
    {
        // $this->_sendEmail($id, 'active');
        $sql = "UPDATE user SET active='Y' WHERE id_user=$id";
        $this->db->query($sql);
        $this->session->set_flashdata('pesan', 'Success Active!');
        $referred_from = $this->session->userdata('referred_from');
        redirect($referred_from, 'refresh');
    }

    public function inactive($id)
    {
        // $this->_sendEmail($id, 'nonactive');
        $sql = "UPDATE user SET active='N' WHERE id_user=$id";
        $this->db->query($sql);
        $this->session->set_flashdata('pesan', 'Success Inactive!');
        $referred_from = $this->session->userdata('referred_from');
        redirect($referred_from, 'refresh');
    }

    #PROFILE
    public function profile_klien($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/klien_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_supervisor($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }


    public function profile_supervisor2($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/supervisor2_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }


    public function profile_hd($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/helpdesk_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_implementator($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/implementator_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_support($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/support_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_superadmin($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/superadmin_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_crd($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/crd_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    public function profile_development($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);

        $this->load->view('templates/header');
        $this->load->view('templates/development_sidebar');
        $this->load->view('profile/profile', $data);
        $this->load->view('templates/footer');
    }

    // public function getUser()
    // {
    //     $this->load->model('User_model', 'user_model');
    //     $data['nama_brg'] = $this->db->get('pengajuan')->result_array();

    //     $data['user'] = $this->user_model->getDataUser();
    //     $this->load->view('templates/header');
    //     $this->load->view('templates/admin_sidebar');
    //     $this->load->view('', $data);
    //     $this->load->view('templates/footer');
    // }

    public function getDataUser()
    {
        $this->load->model('User_model', 'user_model');

        $data['user'] = $this->user_model->getDataUser();
        $this->load->view('templates/header');
        $this->load->view('templates/supervisor_sidebar');
        $this->load->view('supervisor/activate_user', $data);
        $this->load->view('templates/footer');
    }


    #EDIT PROFILE
    // public function fungsi_edit($id)
    // {
    //     $this->load->model('User_model', 'user_model');
    //     $data['user'] = $this->user_model->getUserDetail($id);
    //     $nama         = $this->input->post('nama_user');
    //     $username     = $this->input->post('username');

    //     $this->db->set('nama_user', $nama);
    //     $this->db->set('username', $username);
    //     $this->db->where('id_user', $id);
    //     $this->db->update('user');
    //     $this->session->set_flashdata('pesan', 'Successfully Edit!');
    //     $referred_from = $this->session->userdata('referred_from');
    //     redirect($referred_from, 'refresh');
    // }
    public function fungsi_edit($id)
    {
        $this->load->model('User_model', 'user_model');
        $data['user'] = $this->user_model->getUserDetail($id);
        $nama         = $this->input->post('nama_user');
        $username     = $this->input->post('username');

        // Cek apakah username sudah ada di database selain milik user ini
        $this->db->where('username', $username);
        $this->db->where('id_user !=', $id);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            // Jika username sudah digunakan oleh user lain, set pesan error dan redirect
            $this->session->set_flashdata('alert', 'Username sudah digunakan oleh user lain.');
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        } else {
            // Lakukan update jika username belum digunakan
            $this->db->set('nama_user', $nama);
            $this->db->set('username', $username);
            $this->db->where('id_user', $id);
            $this->db->update('user');
            $this->session->set_flashdata('pesan', 'Successfully Edit!');
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        }
    }

    #EDIT PASSWORD
    public function changepassword()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor_sidebar');
            $this->load->view('profile/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword');
                // Tambahkan pengecekan jika password baru kurang dari 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword');
            }
        }
    }

    public function changepassword_spv2()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/supervisor2_sidebar');
            $this->load->view('profile/changepassword_spv2', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword_spv2');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword_spv2');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword_spv2');
                // Tambahkan pengecekan jika password baru kurang dari 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword_spv2');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword');
            }
        }
    }

    public function changepassword_superadmin()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/superadmin_sidebar');
            $this->load->view('profile/changepassword_superadmin', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword_superadmin');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword_superadmin');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword_superadmin');
                // Tambahkan pengecekan password baru minimal 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword_superadmin');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword_superadmin');
            }
        }
    }

    public function changepassword_klien()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/klien_sidebar');
            $this->load->view('profile/changepassword_klien', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword_klien');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword_klien');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword_klien');
                // Tambahkan pengecekan jika password baru kurang dari 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword_klien');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword_klien');
            }
        }
    }

    public function changepassword_hd()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/helpdesk_sidebar');
            $this->load->view('profile/changepassword_hd', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword_hd');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword_hd');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword_hd');
                // Tambahkan pengecekan password baru minimal 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword_hd');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword_hd');
            }
        }
    }

    public function changepassword_implementator()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/implementator_sidebar');
            $this->load->view('profile/changepassword_implementator', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $confirm_new_password = $this->input->post('new_password2');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password lama anda salah!');
                redirect('user/changepassword_implementator');
                // Verifikasi bahwa password baru dan konfirmasinya sama
            } elseif (!password_verify($confirm_new_password, password_hash($new_password, PASSWORD_DEFAULT))) {
                $this->session->set_flashdata('alert', 'Password baru dan konfirmasi password baru tidak sama!');
                redirect('user/changepassword_implementator');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Password baru tidak boleh sama dengan password lama!!');
                redirect('user/changepassword_implementator');
                // Tambahkan pengecekan jika password baru kurang dari 8 karakter
            } elseif (strlen($new_password) < 8) {
                $this->session->set_flashdata('alert', 'Password baru minimal 8 karakter!');
                redirect('user/changepassword');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Berhasil merubah password!');
                redirect('user/changepassword_implementator');
            }
        }
    }

    public function changepassword_support()
    {
        $data['user'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[8]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[8]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/support_sidebar');
            $this->load->view('profile/changepassword_support', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'Wrong current password!');
                redirect('user/changepassword_support');
            } elseif (password_verify($new_password, $data['user']['password'])) {
                $this->session->set_flashdata('alert', 'New password cannot be the same as current password!!');
                redirect('user/changepassword_support');
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $hashed_password);
                $this->db->where('id_user', $this->session->userdata('id_user'));
                $this->db->update('user');

                $this->session->set_flashdata('pesan', 'Password Changed!');
                redirect('user/changepassword_support');
            }
        }
    }
}
