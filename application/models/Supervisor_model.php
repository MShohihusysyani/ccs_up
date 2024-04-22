<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor_model extends CI_Model {
   
    public function getKlien()
    {
        $query = "SELECT nama, COUNT(nama) AS jumlah FROM pelaporan GROUP BY nama ORDER BY jumlah DESC";
        return $this->db->query($query)->result_array();
        
    }

    public function getKategori()
    {
        $query = "SELECT kategori, COUNT(kategori) AS jumlah FROM pelaporan GROUP BY kategori ORDER BY jumlah DESC";
        return $this->db->query($query)->result_array();
        
    }


}




