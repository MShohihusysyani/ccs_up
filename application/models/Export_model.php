<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {
	public function view(){
		return $this->db->get('pelaporan')->result(); // Tampilkan semua data yang ada di tabel siswa
	}
}