<?php
class Pelaporan_model extends CI_Model
{
    // public function add_pelaporan()
    // {
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');
    //     date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
    //     $now = date('Y-m-d');



    //     $query = "INSERT INTO pelaporan ( user_id,waktu_pelaporan, perihal, file, nama, no_tiket, kategori, tags, judul) select  user_id, '$now',perihal, file, nama, no_tiket, kategori, tags, judul
    //                 from tiket_temp 
    //                 where user_id = $user_id 
    //                 ";
    //     // $query2 = "DELETE FROM barang_temp where user_id = $user_id";

    //     $this->db->query($query);
    //     // $this->db->delete($query2);
    // }

    public function add_pelaporan()
{
    // Get user data from the session
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $user_id = $this->session->userdata('id_user');

    // Set the timezone and get the current date
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d');

    // Retrieve data from tiket_temp for the given user
    $this->db->select('user_id, perihal, file, nama, no_tiket, kategori, tags, judul');
    $this->db->from('tiket_temp');
    $this->db->where('user_id', $user_id);
    $tiket_temp_data = $this->db->get()->result_array();

    // Insert the retrieved data into pelaporan
    foreach ($tiket_temp_data as $row) {
        $data_to_insert = [
            'user_id' => $row['user_id'],
            'waktu_pelaporan' => $now,
            'perihal' => $row['perihal'],
            'file' => $row['file'],
            'nama' => $row['nama'],
            'no_tiket' => $row['no_tiket'],
            'kategori' => $row['kategori'],
            'tags' => $row['tags'],
            'judul' => $row['judul']
        ];

        $this->db->insert('pelaporan', $data_to_insert);
    }

    // Optionally delete the data from tiket_temp after insertion
    // $this->db->delete('tiket_temp', ['user_id' => $user_id]);
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
        // Build the query using Query Builder
        $this->db->select('
            pelaporan.no_tiket,
            pelaporan.waktu_pelaporan,
            pelaporan.id_pelaporan,
            pelaporan.kategori,
            pelaporan.status,
            pelaporan.status_ccs,
            pelaporan.priority,
            pelaporan.perihal,
            pelaporan.handle_by,
            pelaporan.nama,
            pelaporan.user_id,
            pelaporan.tags,
            user.nama_user,
            pelaporan.maxday,
            pelaporan.impact
        ');
        $this->db->from('pelaporan');
        $this->db->join('user', 'pelaporan.user_id = user.id_user', 'left');
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    // public function getAll()
    // {
    //     $query = "SELECT  pelaporan.no_tiket, pelaporan.waktu_pelaporan, pelaporan.id_pelaporan, pelaporan.kategori , pelaporan.status, pelaporan.status_ccs, pelaporan.priority, pelaporan.perihal, pelaporan.handle_by, pelaporan.nama, pelaporan.user_id, pelaporan.tags, user.nama_user
    //     FROM pelaporan
    //     left JOIN user ON pelaporan.user_id = user.id_user WHERE status_ccs='FINISH' ORDER BY waktu_pelaporan DESC ";
    //     return $this->db->query($query)->result_array();
    // }

    // public function getDate($tgla, $tglb, $status_ccs, $nama_klien, $tags)
    // {
    //     $this->db->select('pelaporan.no_tiket, pelaporan.waktu_pelaporan, pelaporan.id_pelaporan, pelaporan.kategori, pelaporan.status, pelaporan.status_ccs, pelaporan.priority, pelaporan.perihal, pelaporan.handle_by, pelaporan.keterangan, pelaporan.waktu_approve, pelaporan.file, pelaporan.nama, pelaporan.user_id, pelaporan.tags');
    //     $this->db->from('pelaporan');
    //     $this->db->where('waktu_pelaporan >=', $tgla);
    //     $this->db->where('waktu_pelaporan <=', $tglb);
    //     $this->db->where('status_ccs', $status_ccs);
    //     $this->db->where('nama', $nama_klien);
    //     $this->db->where('tags', $tags);

    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags)
    {
        $query = "SELECT  pelaporan.no_tiket, pelaporan.waktu_pelaporan, pelaporan.id_pelaporan, pelaporan.kategori, pelaporan.status_ccs, pelaporan.priority, pelaporan.perihal, pelaporan.handle_by,pelaporan.waktu_approve, pelaporan.file, pelaporan.nama, pelaporan.user_id, pelaporan.tags, pelaporan.impact, pelaporan.maxday
        FROM pelaporan
        where waktu_pelaporan BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_ccs = '$status_ccs' AND nama = '$nama_klien' AND tags= '$tags' ";
        return $this->db->query($query)->result_array();
    }

    // public function getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags)
    // {
    //     // Build the query using Query Builder
    //     $this->db->select('
    //         pelaporan.no_tiket,
    //         pelaporan.waktu_pelaporan,
    //         pelaporan.id_pelaporan,
    //         pelaporan.kategori,
    //         pelaporan.status_ccs,
    //         pelaporan.priority,
    //         pelaporan.perihal,
    //         pelaporan.handle_by,
    //         pelaporan.keterangan,
    //         pelaporan.waktu_approve,
    //         pelaporan.file,
    //         pelaporan.nama,
    //         pelaporan.user_id,
    //         pelaporan.tags,
    //         pelaporan.impact,
    //         pelaporan.maxday
    //     ');
    //     $this->db->from('pelaporan');
    //     $this->db->where('waktu_pelaporan >=', $tanggal_awal);
    //     $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
    //     $this->db->where('status_ccs', $status_ccs);
    //     $this->db->where('nama', $nama_klien);
    //     $this->db->where('tags', $tags);

    //     // Execute the query and return the result
    //     return $this->db->get()->result_array();
    // }


    // LAPORAN KATEGORI

    public function getAllCategory()
    {
        $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' GROUP BY kategori";
        return $this->db->query($query)->result_array();
    }

    public function getDateKategori($tgla, $tglb, $kategori)
    {
        $query ="SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' AND  waktu_pelaporan  BETWEEN '$tgla' AND '$tglb' AND kategori = '$kategori' ";
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