<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {

	public function getPelaporan()
    {
		$data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "SELECT *
                    FROM pelaporan";
        return $this->db->query($query)->result_array();
    }

	public function tampil_data(){

		return $this->db->get("pelaporan");
	}

	public function getAll()
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        return $this->db->get();
    }
}