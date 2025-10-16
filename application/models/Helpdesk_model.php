<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpdesk_model extends CI_Model
{
    private $table = 'pelaporan'; // Replace with your actual table name
    private $column_order = array(null, 'waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'handle_by',  'forward.pelaporan_id'); // Add the column from forward table
    private $column_search = array('waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'handle_by', 'forward.pelaporan_id'); // Add the column from forward table for searching
    private $order = array('waktu_pelaporan' => 'desc'); // Default order

    //DATA PER USER HELPDESK
    public function getKlienPelaporanHD()
    {
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
            pelaporan.status,
            pelaporan.tags,
            pelaporan.mode_fokus
        ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    //DATA HELPDESK FORWARD 

    public function getDataForward()
    {

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
            pelaporan.mode_fokus,
            t1_forward1.subtask as subtask1,
            t1_forward1.status as status1,
            t1_forward2.subtask as subtask2,
            t1_forward2.status as status2,
            t1_forward3.subtask as subtask3,
            t1_forward3.status as status3,
        ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', ['ADDED 2', 'HANDLED 2']);
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getKlienPelaporanHDClose()
    {

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
            t1_forward1.subtask as subtask1,
            t1_forward1.status as status1,
            t1_forward2.subtask as subtask2,
            t1_forward2.status as status2,
            t1_forward3.subtask as subtask3,
            t1_forward3.status as status3,
    ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'CLOSED');
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    //DATA PELAPORAN HELPDESK FINISH
    public function getDataPelaporan()
    {
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
            pelaporan.status_ccs,
            pelaporan.tags,
            pelaporan.rating,
            pelaporan.has_rated
        ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    //DATA HELPDESK REJECT
    public function getKlienPelaporanHDReject()
    {
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
            pelaporan.status,
            pelaporan.tags
        ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'REJECTED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
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


    private function _get_datatables_query($filters)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->from($this->table);
        $this->db->join('forward', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left'); // Join with forward table
        $this->db->where('forward.user_id', $user_id);

        // Apply filters
        if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('waktu_pelaporan >=', $filters['tanggal_awal']);
            $this->db->where('waktu_pelaporan <=', $filters['tanggal_akhir']);
        }

        if (!empty($filters['nama_klien'])) {
            $this->db->like('nama', $filters['nama_klien']);
        }

        if (!empty($filters['tags'])) {
            $this->db->like('tags', $filters['tags']);
        }

        if (!empty($filters['status_ccs'])) {
            $this->db->where('status_ccs', $filters['status_ccs']);
        }

        // Add other conditions or filters as necessary

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($filters)
    {
        $this->_get_datatables_query($filters);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($filters)
    {
        $this->_get_datatables_query($filters);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $user_id = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->join('forward', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left'); // Join with forward table
        $this->db->where('forward.user_id', $user_id);
        return $this->db->count_all_results();
    }

    public function ambil_id_pelaporan($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, file, handle_by, handle_by2, handle_by3, tags, catatan_finish, file_finish  FROM pelaporan WHERE id_pelaporan='$id'";
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

    public function get_notifications()
    {

        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.waktu_pelaporan,
            pelaporan.status_ccs,
            pelaporan.judul,
            pelaporan.nama,
            pelaporan.no_tiket,
        ');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }


    // Menghitung jumlah notifikasi yang belum dibaca
    public function count_unread_notifications()
    {
        // Ambil data user berdasarkan username dari sesi
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Lakukan join dengan tabel forward dan hitung notifikasi yang belum dibaca
        $this->db->select('
        pelaporan.id_pelaporan,
        pelaporan.waktu_pelaporan,
        pelaporan.status_ccs,
        pelaporan.judul,
        pelaporan.nama,
        pelaporan.no_tiket,
    ');
        $this->db->from('pelaporan');
        $this->db->join('forward', 'pelaporan.id_pelaporan = forward.pelaporan_id'); // Sesuaikan id join jika berbeda
        $this->db->where('pelaporan.status_ccs', 'HANDLED');
        $this->db->where('forward.user_id', $user_id);

        // Menghitung jumlah notifikasi
        return $this->db->count_all_results();
    }

    // fungsi add&delete tiket
    public function add_pelaporan()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Set the timezone and get the current date
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        // Retrieve data from tiket_temp for the given user
        $this->db->select('user_id, perihal, file, nama, no_tiket, kategori, tags, judul');
        $this->db->from('tiket_temp');
        $this->db->where('user_id_hd', $user_id);
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

        $query = "DELETE FROM tiket_temp where user_id_hd = $user_id
                    ";
        // $query2 = "DELETE FROM barang_temp where user_id = $user_id";
        $this->db->query($query);
    }

    // fungsi cek klien sudah rating atau belum
    public function has_unrated_finished_tickets($klien_id)
    {
        // Pengecekan apakah ada tiket yang statusnya selesai (FINISH) dan belum diberi rating
        $this->db->where('user_id', $klien_id);
        $this->db->where('status_ccs', 'FINISHED');  // Tiket yang sudah selesai
        $this->db->where('rating', 0);  // Tiket yang belum diberi rating
        $query = $this->db->get('pelaporan');

        return $query->num_rows() > 0;  // Jika ada tiket yang belum diberi rating, kembalikan true
    }

    // Mode fokus
    public function set_mode_fokus($id_pelaporan, $status)
    {
        // Pastikan $task_id valid
        if (!$id_pelaporan) {
            return false;
        }

        // Perbarui status mode_fokus hanya untuk tugas tertentu
        $this->db->where('id_pelaporan', $id_pelaporan);
        return $this->db->update('pelaporan', ['mode_fokus' => $status]);
    }
}
