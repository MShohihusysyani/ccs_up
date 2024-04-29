<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login_model extends CI_Model
{
    public function cek_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        
        return $this->db->get('user');
    }
    public function getLoginData($user, $pass)
    {
        $u  = $user;
        $p = MD5($pass);
        $query_cekLogin = $this->db->get_where('user', array('username' => $u, 'password' => $p));

        if (count($query_cekLogin->result()) > 0) {
            foreach ($query_cekLogin->result() as $qck) {

                foreach ($query_cekLogin->result() as $ck) {
                    $sess_data['logged_in'] = TRUE;
                    $sess_data['username']   = $ck->username;
                    $sess_data['password']   = $ck->password;
                    $sess_data['role']      = $ck->role;
                    
                    $this->session->set_userdata($sess_data);
                    
                    
                }
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="swal-log" data-swal-log="<?= session()->get("pesan");?>
</div>');

redirect('auth');
}
}

public function login(){
    $this->db->where('username',$this->input->post('username'));
    $this->db->where('password',md5($this->input->post('password')));
    $result = $this->db->get('user');
    if($result->num_rows() > 0){
        $result = $result->row();
        $data = array(
            'id'        => $result->id,
            'username'  => $result->username,
            'last_login'=>date('Y-m-d H:i:s')
        );
        $this->session->set_userdata($data);
        $this->db->where('id',$result->id);
        $this->db->update('user', array('last_login'=> date('Y-m-d H:i:s')));
        return true;
    }else{
        return false;
    }
}
}