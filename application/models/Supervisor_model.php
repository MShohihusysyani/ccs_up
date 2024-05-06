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

        $query = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk', handle_by = '$nama_user' WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    // 
    public function updateHD($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='HANDLE', status='Forward To Helpdesk', handle_by = '$nama_user'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }
    public function delete_forward()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "DELETE FROM forward where user_id = $user_id";
        // $query2 = "DELETE FROM barang_temp where user_id = $user_id";
        $this->db->query($query);
    }


    public function updateReject($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='REJECT', status='Return To Helpdesk', handle_by = '$nama_user'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }


    

}




