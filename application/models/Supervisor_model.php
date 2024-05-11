 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor_model extends CI_Model {

    //ALL TICKET
    public function getKlienPelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, impact, maxday, handle_by2, handle_by3, tags  FROM pelaporan ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //ADDED
    public function getKlienPelaporanAdd()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, tags  FROM pelaporan WHERE status_ccs='ADDED' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //ON PROGRESS/HANDLE
    public function getKlienPelaporanOP()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority,maxday, handle_by, impact, handle_by2, handle_by3, tags  FROM pelaporan WHERE status_ccs='HANDLE' OR status_ccs='HANDLE 2' OR status_ccs='ADDED 2'  ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //CLOSE
    public function getKlienPelaporanClose()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, maxday, handle_by, keterangan, maxday, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='CLOSE' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }

    //FINISH
    public function getKlienPelaporanFinish()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT distinct(nama), id_pelaporan,user_id, kategori, perihal, waktu_pelaporan, status_ccs, file, status, no_tiket, priority, handle_by, maxday, waktu_approve, handle_by2, handle_by3, impact, tags  FROM pelaporan WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        return $this->db->query($query)->result_array();
    }


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
        //$query2 = "DELETE FROM barang_temp where user_id = $user_id";
        $this->db->query($query);
    }

    public function updateReject($id_pelaporan, $nama_user){

        $query = "UPDATE pelaporan SET status_ccs='REJECT', status='Return To Helpdesk', handle_by = '$nama_user'  WHERE id_pelaporan=$id_pelaporan" ;
        return $this->db->query($query);
    }

    public function ambil_id_pelaporan($id)
    { 
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, nama, status_ccs, kategori, priority, maxday, impact, file  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    // public function ambil_id_comment($id){
    //     $this->db->select('*');
    //     $this->db->from('comment');
    //     $this->db->where('pelaporan_id', $id);
    //     return $this->db->get()->result();
    // }

    public function ambil_id_comment($id){

        $query = "SELECT  user.nama_user, user.id_user, comment.body, comment.pelaporan_id 
        FROM comment
        LEFT JOIN user ON comment.user_id=user.id_user
        WHERE comment.pelaporan_id='$id'";

        return $this->db->query($query)->result_array();
    }

}




