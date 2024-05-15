
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klienpelaporan_model extends CI_Model
{
    public $table = 'pelaporan';

    public function getKlienPelaporanTemp()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.id_pelaporan, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.perihal, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority, pelaporan.maxday, pelaporan.kategori, pelaporan.tags, pelaporan.no_tiket, pelaporan.rating
        FROM pelaporan 
        where user_id = $user_id ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporan2()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT category.nama_kategori, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.deskripsi_masalah, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority
        FROM pelaporan 
        LEFT JOIN category ON pelaporan.category_id=category.id
        LEFT JOIN user ON pelaporan.user_id = user.id
        where user_id = $user_id";
        return $this->db->query($query)->result_array();
    }


    //DATA PER USER HELPDESK
    public function getKlienPelaporanHD()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status, pelaporan.tags
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE'";
        return $this->db->query($query)->result_array();
    }

    //DATA HELPDESK FORWARD 
    public function getKlienPelaporanHDForward()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE 2' ";
        return $this->db->query($query)->result_array();
    }

    //DATA PELAPORAN HELPDESK FINISH
    public function getDataPelaporanHD()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND  status_ccs='FINISH'";
        return $this->db->query($query)->result_array();
    }

    //DATA HELPDESK REJECT
    public function getKlienPelaporanHDReject()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='REJECT'";
        return $this->db->query($query)->result_array();
    }

    //DATA FORWARD PER USER TEKNISI IMPLEMENTATOR
    public function getKlienPelaporanImplementator()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status, pelaporan.handle_by2, pelaporan.handle_by3, pelaporan.tags, t1_forward.subtask, t1_forward.tanggal, t1_forward.judul
        FROM t1_forward
        LEFT JOIN pelaporan ON t1_forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE t1_forward.user_id=$user_id AND status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }

     //DATA PELAPORAN TEKNISI IMPLEMENTATOR FINISH
    public function getDataPelaporanImplementator()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by2, pelaporan.status, pelaporan.tags
        FROM t1_forward
        LEFT JOIN pelaporan ON t1_forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE t1_forward.user_id=$user_id AND  status_ccs='FINISH'";
        return $this->db->query($query)->result_array();
    }

    // DATA PER USER TEKNISI SUPPORT
    public function getKlienPelaporanSupport()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.handle_by2, pelaporan.handle_by3, pelaporan.status, pelaporan.tags, t2_forward.subtask2, t2_forward.tanggal2, t2_forward.judul2
        FROM t2_forward
        LEFT JOIN pelaporan ON t2_forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE t2_forward.user_id=$user_id AND status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }

    // DATA PELAPORAN SUPPORT FINISH
    public function getDataPelaporanSupport()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by3, pelaporan.status
        FROM t2_forward
        LEFT JOIN pelaporan ON t2_forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE t2_forward.user_id=$user_id AND  status_ccs='FINISH'";
        return $this->db->query($query)->result_array();
    }


    // public function getDataPelaporanHD()
    // {
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');
    //     $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, keterangan  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
    //     return $this->db->query($query)->result_array();
    // }

    public function ambil_id_pelaporan($id)
    { 
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, nama, status_ccs, kategori, priority, maxday, impact, file  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    // AMBIL DATA KOMEN LAMA
    // public function ambil_id_comment($id){
    //     $this->db->select('*');
    //     $this->db->from('comment');
    //     $this->db->where('pelaporan_id', $id);
    //     return $this->db->get()->result();
    // }

    public function ambil_id_comment($id){

        $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id, comment.id_comment 
        FROM comment
        LEFT JOIN user ON comment.user_id=user.id_user
        WHERE comment.pelaporan_id='$id'";

        return $this->db->query($query)->result_array();
    }


    //FUNGSI FORWARD KE SUPERVISOR 2
    public function updateForward($id_pelaporan){

        $query = "UPDATE pelaporan SET status_ccs='ADDED 2', status='Forward To Supervisor 2' WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    // RATING KLIEN
    public function tambah_rating(){

        $query = "INSERT INTO pelaporan(rating)";
        $this->db->query($query);
    }

    public function updateRate($id_pelaporan, $rating){

        $query = "UPDATE pelaporan SET rating = '$rating'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    public function update_data($table,$data,$id_pelaporan)
	{
		$this->db->where('id_pelaporan', $id_pelaporan);
		return $this->db->update($table, $data);
    }

}
