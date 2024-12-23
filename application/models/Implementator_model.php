<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Implementator_model extends CI_Model
{
    private $table = 'pelaporan';
    private $column_order = array(null, 'waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3',  't1_forward.pelaporan_id'); // Add the column from forward table
    private $column_search = array('waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 't1_forward.pelaporan_id'); // Add the column from forward table for searching
    private $order = array('waktu_pelaporan' => 'desc');
    // HANDLE
    public function getDataHandled()
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
            t1_forward1.tanggal,
            t1_forward1.judul as forward_judul,
            t1_forward1.id_forward,
            t1_forward1.status as forward_status
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('t1_forward1.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLED 2');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }



    // public function getKlienPelaporanImplementator()
    // {

    //     // Get user data from the session
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');

    //     // Build the query using Query Builder
    //     $this->db->select('
    //         pelaporan.kategori,
    //         pelaporan.id_pelaporan,
    //         pelaporan.waktu_pelaporan,
    //         pelaporan.status_ccs,
    //         pelaporan.priority,
    //         pelaporan.maxday,
    //         pelaporan.judul,
    //         pelaporan.perihal,
    //         pelaporan.file,
    //         pelaporan.nama,
    //         pelaporan.no_tiket,
    //         pelaporan.impact,
    //         pelaporan.handle_by,
    //         pelaporan.handle_by2,
    //         pelaporan.handle_by3,
    //         pelaporan.status,
    //         pelaporan.tags,
    //         t1_forward.subtask,
    //         t1_forward.tanggal,
    //         t1_forward.judul,
    //         t1_forward.id_forward,
    //         t1_forward.status
    //     ');
    //     $this->db->from('t1_forward');
    //     $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
    //     $this->db->where('t1_forward.user_id', $user_id);
    //     $this->db->where('pelaporan.status_ccs', 'HANDLE 2');
    //     $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

    //     // Execute the query and return the result
    //     return $this->db->get()->result_array();
    // }


    // public function getKlienPelaporanImplementator()
    // {
    //     // Get user data from the session
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');

    //     // Build the first query for t1_forward
    //     $query1 = $this->db->select('
    //     pelaporan.kategori,
    //     pelaporan.id_pelaporan,
    //     pelaporan.waktu_pelaporan,
    //     pelaporan.status_ccs,
    //     pelaporan.priority,
    //     pelaporan.maxday,
    //     pelaporan.judul,
    //     pelaporan.perihal,
    //     pelaporan.file,
    //     pelaporan.nama,
    //     pelaporan.no_tiket,
    //     pelaporan.impact,
    //     pelaporan.handle_by,
    //     pelaporan.handle_by2,
    //     pelaporan.handle_by3,
    //     pelaporan.status,
    //     pelaporan.tags,
    //     t1_forward.subtask,
    //     t1_forward.tanggal,
    //     t1_forward.judul as t1_judul
    // ')
    //         ->from('t1_forward')
    //         ->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left')
    //         ->where('t1_forward.user_id', $user_id)
    //         ->where('pelaporan.status_ccs', 'HANDLE 2')
    //         ->get_compiled_select();

    //     // Build the second query for t2_forward
    //     $query2 = $this->db->select('
    //     pelaporan.kategori,
    //     pelaporan.id_pelaporan,
    //     pelaporan.waktu_pelaporan,
    //     pelaporan.status_ccs,
    //     pelaporan.priority,
    //     pelaporan.maxday,
    //     pelaporan.judul,
    //     pelaporan.perihal,
    //     pelaporan.file,
    //     pelaporan.nama,
    //     pelaporan.no_tiket,
    //     pelaporan.impact,
    //     pelaporan.handle_by,
    //     pelaporan.handle_by2,
    //     pelaporan.handle_by3,
    //     pelaporan.status,
    //     pelaporan.tags,
    //     t2_forward.subtask2,
    //     t2_forward.tanggal2,
    //     t2_forward.judul as t2_judul
    // ')
    //         ->from('t2_forward')
    //         ->join('pelaporan', 't2_forward.pelaporan_id = pelaporan.id_pelaporan', 'left')
    //         ->where('t2_forward.user_id', $user_id)
    //         ->where('pelaporan.status_ccs', 'HANDLE 2')
    //         ->get_compiled_select();

    //     // Combine the two queries using UNION
    //     $final_query = $this->db->query($query1 . ' UNION ' . $query2 . ' ORDER BY waktu_pelaporan DESC');

    //     // Execute the final query and return the result
    //     return $final_query->result_array();
    // }


    // CLOSE
    public function getDataClosed()
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
            t1_forward1.tanggal,
            t1_forward1.judul as forward_judul,
            t1_forward1.id_forward,
            t1_forward1.status as forward_status
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('t1_forward1.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'CLOSED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getPelaporanReject()
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
            pelaporan.tags
        ');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'REJECTED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    // FINISH
    public function getDataPelaporanImplementator()
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
            pelaporan.rating
        ');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    // SUBTASK
    public function getSubtask()
    {
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
            t1_forward.subtask,
            t1_forward.tanggal,
            t1_forward.judul,
            t1_forward.id_forward,
            t1_forward.status
        ');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->where('t1_forward.status', 'PENDING');
        $this->db->where('pelaporan.status_ccs', 'HANDLED 2');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        return $this->db->get()->result_array();
    }

    public function ambil_id_pelaporan($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, file, handle_by, handle_by2, handle_by3, tags, catatan_finish, file_finish  FROM pelaporan WHERE id_pelaporan='$id'";
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


    public function updateSubtask($id_forward, $data)
    {
        $this->db->where('id_forward', $id_forward);
        return $this->db->update('t1_forward', $data);
    }

    public function countPendingSubtasks($pelaporan_id)
    {
        $this->db->where('pelaporan_id', $pelaporan_id);
        $this->db->where('status', 'PENDING');
        $this->db->from('t1_forward');
        return $this->db->count_all_results();
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
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLE 2');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }


    // Menghitung jumlah notifikasi
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
        $this->db->join('t1_forward', 'pelaporan.id_pelaporan = t1_forward.pelaporan_id'); // Sesuaikan id join jika berbeda
        $this->db->where('pelaporan.status_ccs', 'HANDLE 2');
        $this->db->where('t1_forward.user_id', $user_id);

        // Menghitung jumlah notifikasi
        return $this->db->count_all_results();
    }

    // get all data pelaporan
    public function getAllData()
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    private function _get_datatables_query($filters)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->from($this->table);
        $this->db->join('t1_forward', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left'); // Join with forward table
        $this->db->where('t1_forward.user_id', $user_id);

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


        $i = 0;
        // Pengecekan untuk 'search'
        if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            foreach ($this->column_search as $item) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
                $i++;
            }
        }

        // Pengecekan untuk 'order'
        if (isset($_POST['order'])) {
            if (isset($_POST['order'][0]['column']) && isset($this->column_order[$_POST['order'][0]['column']])) {
                $this->db->order_by($this->column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            }
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($filters)
    {
        $this->_get_datatables_query($filters);
        $length = isset($_POST['length']) ? $_POST['length'] : -1; // Nilai default -1 jika tidak ada
        $start = isset($_POST['start']) ? $_POST['start'] : 0; // Nilai default 0 jika tidak ada

        if ($length != -1) {
            $this->db->limit($length, $start);
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
        $this->db->join('t1_forward', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left'); // Join with forward table
        $this->db->where('t1_forward.user_id', $user_id);
        return $this->db->count_all_results();
    }

    // MODE FOKUS
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
