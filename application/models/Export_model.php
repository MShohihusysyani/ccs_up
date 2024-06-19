<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {

	public function getPelaporan1()
    {
		$data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "SELECT * FROM pelaporan
            where status_ccs = 'FINISH'";
        return $this->db->query($query)->result_array();
    }

    public function getPelaporan($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $tags = null)
{
    $this->db->select('*');
    $this->db->from('pelaporan');

    if ($tanggal_awal && $tanggal_akhir) {
        $this->db->where('waktu_pelaporan >=', $tanggal_awal);
        $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
    }
    if ($status_ccs) {
        $this->db->where('status_ccs', $status_ccs);
    }
    if ($nama_klien) {
        $this->db->where('nama', $nama_klien);
    }
    if ($tags) {
        $this->db->where('tags', $tags);
    }

    return $this->db->get()->result_array();
}



public function getPelaporanHD($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $tags = null)
{
    $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

    if ($tanggal_awal && $tanggal_akhir) {
        $this->db->where('waktu_pelaporan >=', $tanggal_awal);
        $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
    }
    if ($status_ccs) {
        $this->db->where('status_ccs', $status_ccs);
    }
    if ($nama_klien) {
        $this->db->where('nama', $nama_klien);
    }
    if ($tags) {
        $this->db->where('tags', $tags);
    }

    return $this->db->get()->result_array();
}


	public function getAll()
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        return $this->db->get();
    }

    public function getCategory()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        
        $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' GROUP BY kategori";
        return $this->db->query($query)->result_array();
    }

    public function getAllPelaporan($status_ccs = null, $nama_klien = null, $tags = null)
{
    $this->db->select('*');
    $this->db->from('pelaporan');
    
    if ($status_ccs) {
        $this->db->where('status_ccs', $status_ccs);
    }
    if ($nama_klien) {
        $this->db->like('nama', $nama_klien);
    }
    if ($tags) {
        $this->db->like('tags', $tags);
    }
    
    $query = $this->db->get();
    return $query->result_array();
}

}