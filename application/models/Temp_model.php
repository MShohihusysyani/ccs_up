<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Temp_model extends CI_Model
{
    public function getTiketTemp()
    {
        $query = "SELECT 	id_temp,  user_id, perihal, no_tiket, file, nama_klien

                    FROM tiket_temp
                    ";
        return $this->db->query($query)->result_array();
    }

    public function getTiketTemp1()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id');
        $query = "SELECT user.nama,tiket_temp.id_temp,  tiket_temp.no_tiket, tiket_temp.perihal, tiket_temp.file, user.id
                    FROM tiket_temp JOIN user
                    ON tiket_temp.user_id = user.id
                    WHERE user_id = $user_id";
        return $this->db->query($query)->result_array();
    }

    public function hapus_temp($id)
    {
        $this->db->where('id_temp', $id);
        $this->db->delete('tiket_temp');
    }

}