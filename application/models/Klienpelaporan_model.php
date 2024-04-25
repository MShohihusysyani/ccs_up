
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klienpelaporan_model extends CI_Model
{
    public function getKlienPelaporanTemp()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT   pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.perihal, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority, pelaporan.maxday, pelaporan.kategori
        FROM pelaporan 
        where user_id = $user_id ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporan2()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT   category.nama_kategori, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.deskripsi_masalah, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority
        FROM pelaporan 
        LEFT JOIN category ON pelaporan.category_id=category.id
        LEFT JOIN user ON pelaporan.user_id = user.id
        where user_id = $user_id";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, impact, maxday, handle_by2  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanAdd()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by  FROM pelaporan WHERE status_ccs='ADDED' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanOP()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, impact, handle_by2  FROM pelaporan WHERE status_ccs='HANDLE' OR status_ccs='HANDLE 2'  ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanClose()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, keterangan  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanFinish()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //data per helpdesk
    public function getKlienPelaporanHD()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE'";
        return $this->db->query($query)->result_array();
    }

   

    //VIEW FORWARD IMPLEMENTATOR
    public function getKlienPelaporanImplementator()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status, pelaporan.handle_by2
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }

    //DATA PELAPORAN
    public function getDataPelaporanHD()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $data['handle_by'] = $this->db->get_where('user', ['handle_by' => $this->sessions->userdata['handle_by']])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, keterangan  FROM pelaporan WHERE status_ccs='CLOSE' OR status='Solved by HD1' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_pelaporan($id)
    { 
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, nama, status, status_ccs, kategori, priority, maxday  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    //FUNGSI FORWARD KE SUPERVISOR 2
    public function updateForward($id_pelaporan){

  
        $query = "UPDATE pelaporan SET status_ccs='HANDLE 2', status='Forward To Supervisor 2' WHERE id_pelaporan=$id_pelaporan" ;

        return $this->db->query($query);
    }


}




    