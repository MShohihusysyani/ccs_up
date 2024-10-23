<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serverside_model extends CI_Model
{

    private $table = 'pelaporan'; // Replace with your actual table name
    private $column_order = array(null, 'waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'rating'); // Set column field database for datatable orderable
    private $column_search = array('waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'rating'); // Set column field database for datatable searchable
    private $order = array('waktu_pelaporan' => 'desc'); // Default order

    private function _get_datatables_query($filters)
    {
        $this->db->from($this->table);

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

        if (!empty($filters['status_ccs'])) {
            $this->db->where('status_ccs', $filters['status_ccs']);
        }

        if (!empty($filters['rating'])) {
            $this->db->where('rating', $filters['rating']);
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_filtered_data($filters)
    {
        $this->db->select('*');
        $this->db->from('your_table_name');

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

        if (!empty($filters['status_ccs'])) {
            $this->db->where('status_ccs', $filters['status_ccs']);
        }

        if (!empty($filters['rating'])) {
            $this->db->where('rating', $filters['rating']);
        }

        $query = $this->db->get();
        return $query->result();
    }


    // Model
    public function fetch_data($requestData)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        // Filter berdasarkan tanggal
        if (!empty($requestData['tanggal_awal']) && !empty($requestData['tanggal_akhir'])) {
            $this->db->where('waktu_pelaporan >=', $requestData['tanggal_awal']);
            $this->db->where('waktu_pelaporan <=', $requestData['tanggal_akhir']);
        }

        // Filter berdasarkan nama klien
        if (!empty($requestData['nama_klien'])) {
            $this->db->like('nama_klien', $requestData['nama_klien']);
        }

        // Filter nama_user di handle_by, handle_by2, handle_by3
        if (!empty($requestData['nama_user'])) {
            $this->db->group_start(); 
            $this->db->like('handle_by', $requestData['nama_user']);
            $this->db->or_like('handle_by2', $requestData['nama_user']);
            $this->db->or_like('handle_by3', $requestData['nama_user']);
            $this->db->group_end(); 
        }

        // Filter berdasarkan tags
        if (!empty($requestData['tags'])) {
            $this->db->like('tags', $requestData['tags']);
        }

        // Filter berdasarkan status CCS
        if (!empty($requestData['status_ccs'])) {
            $this->db->where('status_ccs', $requestData['status_ccs']);
        }

        if (!empty($requestData['rating'])) {
            $this->db->where('rating', $requestData['rating']);
        }

        $query = $this->db->get();
        return $query->result();
    }
}
