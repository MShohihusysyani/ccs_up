<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serversidehandle_model extends CI_Model
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
        $this->db->from($this->table);
        $this->db->where_in('status_ccs', ['ADDED 2', 'HANDLED 2', 'HANDLED']);

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

        if (!empty($filters['tags'])) {
            $this->db->like('tags', $filters['tags']);
        }


        if (!empty($filters['rating'])) {
            $this->db->where('rating', $filters['rating']);
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

        // Pengecekan untuk 'length' dan 'start'
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

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where_in('status_ccs', ['ADDED 2', 'HANDLED 2', 'HANDLED']);
        return $this->db->count_all_results();
    }
    // private function _get_datatables_query()
    // {
    //     $this->db->from($this->table);
    //     $this->db->where('status_ccs', 'FINISHED');

    //     $i = 0;

    //     foreach ($this->column_search as $item) {
    //         if ($_POST['search']['value']) {
    //             if ($i === 0) {
    //                 $this->db->group_start();
    //                 $this->db->like($item, $_POST['search']['value']);
    //             } else {
    //                 $this->db->or_like($item, $_POST['search']['value']);
    //             }

    //             if (count($this->column_search) - 1 == $i)
    //                 $this->db->group_end();
    //         }
    //         $i++;
    //     }

    //     if (isset($_POST['order'])) {
    //         $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } else if (isset($this->order)) {
    //         $order = $this->order;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }

    // function get_datatables()
    // {
    //     $this->_get_datatables_query();
    //     if ($_POST['length'] != -1)
    //         $this->db->limit($_POST['length'], $_POST['start']);
    //     $query = $this->db->get();
    //     return $query->result();
    // }
}
