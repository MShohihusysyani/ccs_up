
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klienpelaporan_model extends CI_Model
{
    public $table = 'pelaporan';

    public function getKlienPelaporanTemp()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT   pelaporan.id_pelaporan, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.perihal, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority, pelaporan.maxday, pelaporan.kategori, pelaporan.tags, pelaporan.no_tiket, pelaporan.rating
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

    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, impact, maxday, handle_by2, handle_by3, tags  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanAdd()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, tags  FROM pelaporan WHERE status_ccs='ADDED' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanOP()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, impact, handle_by2, tags  FROM pelaporan WHERE status_ccs='HANDLE' OR status_ccs='HANDLE 2'  ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanClose()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, keterangan, maxday, handle_by2, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function getKlienPelaporanFinish()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve, handle_by2, impact, tags  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //data per helpdesk
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

    // SUPPORT
    public function getKlienPelaporanSupport()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.handle_by2, pelaporan.handle_by3, pelaporan.status, pelaporan.tags, forward.subtask
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }

    // VIEW HD REJECT
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

    // VIEW HD FORWARD 
    public function getKlienPelaporanHDForward()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND  status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }
    //VIEW FORWARD IMPLEMENTATOR
    public function getKlienPelaporanImplementator()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.status, pelaporan.handle_by2, forward.subtask, pelaporan.tags
        FROM forward
        LEFT JOIN pelaporan ON forward.pelaporan_id=pelaporan.id_pelaporan
        WHERE forward.user_id=$user_id AND status_ccs='HANDLE 2'";
        return $this->db->query($query)->result_array();
    }

    //DATA PELAPORAN
    public function getDataPelaporanHD()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, keterangan  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_pelaporan($id)
    { 
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, nama, status, status_ccs, kategori, priority, maxday, file  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_comment($id)
    { 
        $query = "SELECT  id_comment, user_id, pelaporan_id, body  FROM comment WHERE id_comment='$id'";
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
