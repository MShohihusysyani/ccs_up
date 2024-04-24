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

    public function add_forward()
    {
        $user_id = $this->session->userdata('id_user');
        $query = "INSERT INTO forward(user_id, pelaporan_id) select user_id, pelaporan_id FROM forward where user_id = $user_id " ;

        $this->db->query($query);

    }

    public function updateForward($id_pelaporan, $nama_user){

  
        $query = "UPDATE pelaporan SET status_ccs='HANDLE',  handle_by = '$nama_user', status='Forward To Helpdesk' WHERE id_pelaporan=$id_pelaporan" ;

        return $this->db->query($query);
    }

    function updateCP($id_pelaporan, $data)
    {
        $this->db->where('pelaporan_id', $id_pelaporan);
        $this->db->update('forward', $data);
    }


}




