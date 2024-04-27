<?php
class Pelaporan_model extends CI_Model
{
    public function add_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d');



        $query = "INSERT INTO pelaporan ( user_id,waktu_pelaporan, perihal, file, nama, no_tiket, kategori, tags) select  user_id, '$now',perihal, file, nama, no_tiket, kategori, tags
                    from tiket_temp 
                    where user_id = $user_id 
                    ";
        // $query2 = "DELETE FROM barang_temp where user_id = $user_id";

        $this->db->query($query);
        // $this->db->delete($query2);
    }

    public function delete_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "DELETE FROM tiket_temp where user_id = $user_id
                    ";
        // $query2 = "DELETE FROM barang_temp where user_id = $user_id";
        $this->db->query($query);
    }

    function updateCP($id_pelaporan, $data)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan', $data);
    }

    function updateImpact($id_pelaporan, $data)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan', $data);
    }

    // update finish HELPDESK
    function updateHD($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }


    // APPROVE SPV
    function approveSPV($id, $data){
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    // REJECT HD1
    function rejecthd1($id, $data){
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }



    // forward to implementator
    
    function updateForward($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    //FINISH IMPLEMENTATOR
    function updateImplementator($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    //LAPORAN status
    public function getAll()
    {
        $query = "SELECT  pelaporan.no_tiket, pelaporan.waktu_pelaporan, pelaporan.id_pelaporan, pelaporan.kategori , pelaporan.status, pelaporan.status_ccs, pelaporan.priority, pelaporan.perihal, pelaporan.handle_by, pelaporan.nama, pelaporan.user_id, user.nama_user
        FROM pelaporan
       
      
       left JOIN user ON pelaporan.user_id = user.id_user
                    WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC ";
        return $this->db->query($query)->result_array();
    }

    public function getDate($tgla, $tglb, $status_ccs, $nama_klien)
    {
        $query = "SELECT  pelaporan.no_tiket, pelaporan.waktu_pelaporan, pelaporan.id_pelaporan, pelaporan.kategori, pelaporan.status, pelaporan.status_ccs, pelaporan.priority, pelaporan.perihal, pelaporan.handle_by, pelaporan.keterangan, pelaporan.waktu_approve, pelaporan.file, pelaporan.nama, pelaporan.user_id
        FROM pelaporan
      
        where waktu_pelaporan BETWEEN '$tgla' AND '$tglb' AND status_ccs = '$status_ccs' AND nama = '$nama_klien'
                    ";
        return $this->db->query($query)->result_array();
    }

    // LAPORAN KATEGORI

    public function getAllCategory()
    {
       $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' GROUP BY kategori";
       return $this->db->query($query)->result_array();
    }

    public function getDateKategori($tgla, $tglb)
    {
        $query ="SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' AND  waktu_pelaporan  BETWEEN '$tgla' AND '$tglb' GROUP BY kategori  ";
        return $this->db->query($query)->result_array();
    }

    // public function getDateKategori($nama_kategori)
    // {
    //     $query = "SELECT  kategori,  COUNT(*) AS total
    //     FROM pelaporan WHERE kategori='$nama_kategori'";
    //     return $this->db->query($query)->result_array();
    // }


    // public function getDateKategori($tgla, $tglb, $nama_kategori)
    // {
    //     $query = "SELECT  kategori
    //     FROM pelaporan where kategori=$nama_kategori BETWEEN '$tgla' AND '$tglb'  AND kategori = '$nama_kategori' ";
    //     return $this->db->query($query)->result_array();
    // }

    public function getHelpdesk()
    {
        $query ="SELECT handle_by, COUNT(*) AS 'totalH', waktu_approve FROM pelaporan WHERE status_ccs='FINISH' GROUP BY handle_by ";
        return $this->db->query($query)->result_array();
    }

    public function getDateHelpdesk($tgla, $tglb)
    {
        $query ="SELECT handle_by, COUNT(*) AS 'totalH', waktu_approve FROM pelaporan 
        WHERE status_ccs='FINISH' AND waktu_approve BETWEEN '$tgla' AND '$tglb' GROUP BY handle_by  ";
        return $this->db->query($query)->result_array();
    }

    public function getProgres()
    {
        $query ="SELECT status_ccs, COUNT(*) AS 'totalP', waktu_pelaporan FROM pelaporan 
        WHERE status_ccs='FINISH'  OR status_ccs='HANDLE' GROUP BY status_ccs ";
        return $this->db->query($query)->result_array();
    }

    public function getDateProgres($tgla, $tglb, $status_ccs)
    {
        $query ="SELECT status_ccs, COUNT(*) AS 'totalP', waktu_pelaporan FROM pelaporan 
        WHERE waktu_pelaporan 
        BETWEEN '$tgla' AND '$tglb' AND status_ccs='$status_ccs'  GROUP BY status_ccs";
        return $this->db->query($query)->result_array();
    }
}