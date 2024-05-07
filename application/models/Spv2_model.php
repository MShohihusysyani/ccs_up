<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spv2_model extends CI_Model {
   
    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, handle_by2, handle_by3, tags, maxday  FROM pelaporan ORDER BY waktu_pelaporan DESC";
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
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.status, pelaporan.handle_by, pelaporan.impact, pelaporan.tags
        FROM s_forward
        LEFT JOIN pelaporan ON s_forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE s_forward.user_id=$user_id AND status_ccs='ADDED 2'";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanOP()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, handle_by2, handle_by3, impact  FROM pelaporan WHERE status_ccs='HANDLE 2'  ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanClose()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, keterangan, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    // public function getKlienPelaporanOP(){

    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');
    //     $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.status, pelaporan.handle_by, pelaporan.handle_by2, pelaporan.handle_by3, pelaporan.impact, pelaporan.tags, forward.subtask
    //     FROM forward
    //     LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
    //     WHERE forward.user_id = $user_id AND status_ccs='HANDLE 2'";
    //     return $this->db->query($query)->result_array();
    // }

    
    public function updateForward($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='HANDLE 2',  handle_by2 = '$nama_user',  status='Forward To Teknisi' WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    public function updateTeknisi($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='HANDLE 2', handle_by2 = '$nama_user'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    public function tambahTeknisi($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='HANDLE 2', handle_by3 = '$nama_user'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }


}




