<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi_model extends CI_Model {

    public function getDivisi()
    {
        $query = "SELECT divisi.*
                    FROM divisi ORDER BY nama_pegawai ASC
                    ";
        return $this->db->query($query)->result_array();
    }

}