
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klienpelaporan_model extends CI_Model
{
    public $table = 'pelaporan';

    public function getKlienPelaporanTemp()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.status,
            pelaporan.waktu_pelaporan,
            pelaporan.perihal,
            pelaporan.user_id,
            pelaporan.status_ccs,
            pelaporan.file,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.kategori,
            pelaporan.tags,
            pelaporan.no_tiket,
            pelaporan.rating,
            pelaporan.judul
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    // public function getKlienPelaporanTemp()
    // {
    //     // Retrieve current user data based on the username stored in the session
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    //     // Retrieve the current user's ID from session data
    //     $user_id = $this->session->userdata('id_user');

    //     // Prepare the SQL query with query binding to prevent SQL injection
    //     $sql = "SELECT pelaporan.id_pelaporan, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.perihal, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority, pelaporan.maxday, pelaporan.kategori, pelaporan.tags, pelaporan.no_tiket, pelaporan.rating, pelaporan.judul
    //         FROM pelaporan 
    //         WHERE user_id = ? 
    //         ORDER BY waktu_pelaporan DESC";

    // // Execute the query with the user_id as the bound parameter
    // return $this->db->query($sql, array($user_id))->result_array();
    // }

    public function getKlienPelaporan2()
    {

        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');
        $query = "SELECT category.nama_kategori, pelaporan.status, pelaporan.waktu_pelaporan, pelaporan.deskripsi_masalah, pelaporan.user_id, pelaporan.status_ccs, pelaporan.file, pelaporan.priority
        FROM pelaporan 
        LEFT JOIN category ON pelaporan.category_id=category.id
        LEFT JOIN user ON pelaporan.user_id = user.id
        where user_id = $user_id";
        return $this->db->query($query)->result_array();
    }


    public function getAllData()
    {

        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        // $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order
        $query = $this->db->get(); // Execute the query

        return $query->result(); // Return the result as an array of objects
    }



    // DATA PER USER TEKNISI SUPPORT
    public function getKlienPelaporanSupport()
    {
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by, pelaporan.handle_by2, pelaporan.handle_by3, pelaporan.status, pelaporan.tags, t2_forward.subtask2, t2_forward.tanggal2, t2_forward.judul2
        // FROM t2_forward
        // LEFT JOIN pelaporan ON t2_forward.pelaporan_id=pelaporan.id_pelaporan
        // WHERE t2_forward.user_id=$user_id AND status_ccs='HANDLE 2' ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.kategori,
            pelaporan.id_pelaporan,
            pelaporan.waktu_pelaporan,
            pelaporan.status_ccs,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.judul,
            pelaporan.perihal,
            pelaporan.file,
            pelaporan.nama,
            pelaporan.no_tiket,
            pelaporan.impact,
            pelaporan.handle_by,
            pelaporan.handle_by2,
            pelaporan.handle_by3,
            pelaporan.status,
            pelaporan.tags,
            t2_forward.subtask2,
            t2_forward.tanggal2,
            t2_forward.judul2
        ');
        $this->db->from('t2_forward');
        $this->db->join('pelaporan', 't2_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t2_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLE 2');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    // DATA PELAPORAN SUPPORT FINISH
    public function getDataPelaporanSupport()
    {
        // $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        // $user_id = $this->session->userdata('id_user');
        // $query = "SELECT pelaporan.kategori, pelaporan.id_pelaporan, pelaporan.waktu_pelaporan , pelaporan.status_ccs, pelaporan.priority, pelaporan.maxday, pelaporan.perihal, pelaporan.file, pelaporan.nama, pelaporan.no_tiket, pelaporan.impact, pelaporan.handle_by3, pelaporan.status
        // FROM t2_forward
        // LEFT JOIN pelaporan ON t2_forward.pelaporan_id=pelaporan.id_pelaporan
        // WHERE t2_forward.user_id=$user_id AND  status_ccs='FINISH' ORDER BY waktu_pelaporan DESC";
        // return $this->db->query($query)->result_array();

        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.kategori,
            pelaporan.id_pelaporan,
            pelaporan.waktu_pelaporan,
            pelaporan.status_ccs,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.perihal,
            pelaporan.file,
            pelaporan.nama,
            pelaporan.no_tiket,
            pelaporan.impact,
            pelaporan.handle_by3,
            pelaporan.status
        ');
        $this->db->from('t2_forward');
        $this->db->join('pelaporan', 't2_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t2_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function ambil_id_pelaporan($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, file, handle_by, handle_by2, handle_by3  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_temp($id)
    {
        $query = "SELECT  id_temp, no_tiket, judul, perihal, nama, kategori, tags, file  FROM tiket_temp WHERE id_temp='$id'";
        return $this->db->query($query)->result_array();
    }

    public function get_latest_comments($id)
    {
        $query = "SELECT 
                    user.nama_user, 
                    user.id_user, 
                    comment.body AS comment_body, 
                    comment.pelaporan_id, 
                    comment.created_at,
                    comment.file,
                    comment.id_comment,
                    comment.created_at
                FROM comment
                LEFT JOIN user ON comment.user_id = user.id_user
                WHERE comment.pelaporan_id = '$id' AND comment.parent_id = 0
                ORDER BY comment.created_at DESC";

        return $this->db->query($query, array($id))->result_array();
    }

    public function get_replies_by_pelaporan_id($id)
    {
        $query = "SELECT 
                    user.nama_user, 
                    user.id_user, 
                    reply.body, 
                    reply.pelaporan_id,
                    reply.created_at,
                    reply.file
                FROM reply
                LEFT JOIN user ON reply.user_id = user.id_user
                WHERE reply.pelaporan_id = $id
                ORDER BY reply.created_at DESC";

        return $this->db->query($query, array($id))->result_array();
    }


    //FUNGSI FORWARD KE SUPERVISOR 2
    public function updateForward($id_pelaporan)
    {

        $query = "UPDATE pelaporan SET status_ccs='ADDED 2', status='Forward To Supervisor 2' WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    // RATING KLIEN
    public function tambah_rating()
    {

        $query = "INSERT INTO pelaporan(rating)";
        $this->db->query($query);
    }

    public function updateRate($id_pelaporan, $rating)
    {

        $query = "UPDATE pelaporan SET rating = '$rating'  WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    public function update_data($table, $data, $id_pelaporan)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        return $this->db->update($table, $data);
    }
}
