<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serversidehandlespv2_model extends CI_Model
{

    private $table = 'pelaporan';
    private $column_order = array(null, 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
    private $column_search = array('no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
    private $order = array('waktu_pelaporan' => 'DESC'); // Default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($filters)
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
        $this->db->where('pelaporan.status_ccs', 'HANDLED 2');
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');
        // Apply filters
        if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('waktu_pelaporan >=', $filters['tanggal_awal']);
            $this->db->where('waktu_pelaporan <=', $filters['tanggal_akhir']);
        }

        if (!empty($filters['nama_klien'])) {
            $this->db->like('nama', $filters['nama_klien']);
        }

        // Filter nama_user di handle_by, handle_by2, handle_by3
        if (!empty($filters['nama_user'])) {
            $this->db->group_start(); // Mulai group untuk pencarian OR
            $this->db->like('handle_by', $filters['nama_user']);
            $this->db->or_like('handle_by2', $filters['nama_user']);
            $this->db->or_like('handle_by3', $filters['nama_user']);
            $this->db->group_end(); // Akhiri group
        }
        if (!empty($status_ccs)) {
            $status_ccs_array = json_decode($status_ccs, true); // Decode jika perlu
            $this->db->where_in('status_ccs', $status_ccs_array);
        }

        // Search logic
        $i = 0;
        if (isset($_POST['search']) && $_POST['search']['value'] != '') {
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

        // Order logic
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
        $length = isset($_POST['length']) ? $_POST['length'] : -1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;

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

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('pelaporan.status_ccs', 'HANDLED 2');
        return $this->db->count_all_results();
    }
}
