<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Klien extends CI_Model {

    /**
     * Get All Data Siswa
     */
    public function get_all()
    {
        $this->db->select("*");
        $this->db->from("klien");
        $this->db->order_by("id", "DESC");
        return $this->db->get();
    }


}




