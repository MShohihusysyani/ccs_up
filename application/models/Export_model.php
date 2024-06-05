<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {

	public function getPelaporan()
    {
		$data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "SELECT * FROM pelaporan
            where status_ccs = 'FINISH'";
        return $this->db->query($query)->result_array();
    }

    public function get_data_by_date_range($start_date, $end_date) {
        $this->db->where('waktu_pelaporan ', $start_date);
        $this->db->where('waktu_pelaporan ', $end_date);
        $query = $this->db->get('pelaporan');
        return $query->result();
    }

    public function getPelaporan_data($tgla, $tglb)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');
        $this->db->where('status_ccs', 'FINISH');
        $this->db->where('waktu_pelaporan >=', $tgla);
        $this->db->where('waktu_pelaporan <=', $tglb);
        $query = $this->db->get();
        return $query->result_array();
    }


	public function view_all(){
		return $this->db->get('pelaporan')->result(); // Tampilkan semua data transaksi
	}

    public function view_by_date($tgla, $tglb){
        $tgla = $this->db->escape($tgla);
        $tglb = $this->db->escape($tglb);

        $this->db->where('DATE(waktu_pelaporan) BETWEEN '.$tgla.' AND '.$tglb); // Tambahkan where tanggal nya

		return $this->db->get('pelaporan')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
	}

    function toExcelAll() {
        $this->db->select("id_pelaporan, nama, kategori, waktu_pelaporan, tags, judul, perihal, impact, maxday, handle_by, status_ccs ");
        $this->db->from("pelaporan");
        $this->db->where('waktu_pelaporan >=', $this->input->post('tgla')); //Nama table nya saya asumsikan tanggal_awal yaa gan hehe
        $this->db->where('waktu_pelaporan <=', $this->input->post('tgla'));
        $getData = $this->db->get();
        if($getData->num_rows() > 0)
        return $getData->result_array();
        else
        return null;
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
}