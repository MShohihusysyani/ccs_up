<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spv2_model extends CI_Model {
   
    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    // public function getKlienPelaporanAdd()
    // {
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');
    //     $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by  FROM pelaporan WHERE status='Forward To SPV 2' ORDER BY waktu_pelaporan DESC";
    //     return $this->db->query($query)->result_array();
    // }

    public function getKlienPelaporanAdd(){

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.status, pelaporan.handle_by
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id";
        return $this->db->query($query)->result_array();
    }

}




