<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spv2_model extends CI_Model
{
    private $table = 'pelaporan';
    private $column_order = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
    private $column_search = array('no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3');
    private $order = array('waktu_pelaporan' => 'DESC'); // Default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function getKlienPelaporan()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->distinct();
        $this->db->select('
            nama,
            id_pelaporan,
            user_id,
            kategori,
            perihal,
            waktu_pelaporan,
            status_ccs,
            file,
            status,
            no_tiket,
            priority,
            handle_by,
            handle_by2,
            handle_by3,
            tags,
            maxday
        ');
        $this->db->from('pelaporan');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }


    public function getKlienPelaporanAdd()
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
            pelaporan.judul,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.perihal,
            pelaporan.file,
            pelaporan.nama,
            pelaporan.no_tiket,
            pelaporan.status,
            pelaporan.handle_by,
            pelaporan.impact,
            pelaporan.tags
        ');
        $this->db->from('s_forward');
        $this->db->join('pelaporan', 's_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('s_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'ADDED 2');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }


    public function getKlienPelaporanOP()
    {
        // // Execute the query and return the result
        // return $this->db->get()->result_array();
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
            t1_forward1.tanggal as tanggal,
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->join('s_forward', 's_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('s_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'HANDLED 2');
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }



    public function getKlienPelaporanClose()
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
            t1_forward1.subtask as subtask1,
            t1_forward1.status as status1,
            t1_forward2.subtask as subtask2,
            t1_forward2.status as status2,
            t1_forward3.subtask as subtask3,
            t1_forward3.status as status3,
            t1_forward1.tanggal as tanggal,
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->join('s_forward', 's_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('s_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'CLOSED');
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function ambil_id_pelaporan($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, tags, catatan_finish, file, file_finish, handle_by, handle_by2, handle_by3  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    public function ambil_id_pelaporan_close($id)
    {
        $query = "SELECT  id_pelaporan, no_tiket, waktu_pelaporan, perihal, judul, nama, status_ccs, kategori, priority, maxday, impact, judul, catatan_finish, file_finish, tags  FROM pelaporan WHERE id_pelaporan='$id'";
        return $this->db->query($query)->result_array();
    }

    //FINISH
    public function getKlienPelaporanFinish()
    {
        // Fetch user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

        // Ensure the user is retrieved
        if ($data['user']) {
            // User ID from session
            $user_id = $this->session->userdata('id_user');

            // SQL query to retrieve reports with status_ccs='FINISH'
            $query = "
            SELECT DISTINCT
                nama, 
                id_pelaporan, 
                user_id, 
                kategori,
                judul, 
                perihal, 
                waktu_pelaporan, 
                status_ccs, 
                file, 
                status, 
                no_tiket, 
                priority,
                handle_by, 
                maxday, 
                waktu_approve, 
                handle_by2, 
                handle_by3, 
                impact, 
                tags,
                rating
            FROM 
                pelaporan 
            WHERE 
                status_ccs = 'FINISHED' 
            ORDER BY 
                waktu_pelaporan DESC
        ";

            // Execute the query and return the result as an array
            $result = $this->db->query($query);

            // Check for query execution errors
            if ($result) {
                return $result->result_array();
            } else {
                // Handle the error appropriately (e.g., log the error, return a message)
                log_message('error', 'Query failed: ' . $this->db->last_query());
                return []; // Return an empty array or handle as needed
            }
        } else {
            // Handle case when user data is not found
            log_message('error', 'User not found in session.');
            return []; // Return an empty array or handle as needed
        }
    }


    public function updateForward($id_pelaporan, $nama_user)
    {

        $query = "UPDATE pelaporan SET status_ccs='HANDLED 2',  handle_by2 = '$nama_user',  status='Forward To Teknisi' WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    public function updateTeknisi($id_pelaporan, $nama_user)
    {

        $query = "UPDATE pelaporan SET status_ccs='HANDLED 2', handle_by3 = '$nama_user'  WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    public function tambahTeknisi($id_pelaporan, $nama_user)
    {

        $query = "UPDATE pelaporan SET status_ccs='HANDLED 2', handle_by3 = '$nama_user'  WHERE id_pelaporan=$id_pelaporan";
        return $this->db->query($query);
    }

    public function pembatalanForward($id_pelaporan)
    {

        $query = "UPDATE pelaporan SET status_ccs='HANDLED' WHERE id_pelaporan=$id_pelaporan";
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
        $this->db->from('s_forward');
        $this->db->join('pelaporan', 's_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('s_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'ADDED 2');

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
        $this->db->from('s_forward');
        $this->db->join('pelaporan', 's_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('s_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'ADDED 2');

        // Menghitung jumlah notifikasi
        return $this->db->count_all_results();
    }
}
