<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {
	public function getPelaporan($tgla, $tglb)
    {
        $query = "SELECT *
                    FROM pelaporan WHERE waktu_pelapaporan BETWEEN '$tgla' AND '$tglb'";
        return $this->db->query($query)->result_array();
    }
}