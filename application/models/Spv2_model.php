<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spv2_model extends CI_Model {
   
    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id');
        $query = "SELECT distinct(nama), id,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanAdd()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id');
        $query = "SELECT distinct(nama), id,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by  FROM pelaporan WHERE status_ccs='HANDLE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function add_forward()
    {
        $user_id = $this->session->userdata('id');
        $query = "INSERT INTO forward(user_id, pelaporan_id) select user_id, id from pelaporan where user_id = $user_id ";

        $this->db->query($query);

    }


}




