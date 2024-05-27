<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {
	public function getPelaporan()
    {
        $query = "SELECT *
                    FROM pelaporan";
        return $this->db->query($query)->result_array();
    }
}