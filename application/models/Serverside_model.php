<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serverside_model extends CI_Model {

    var $table = 'pelaporan'; // replace with your table name
    var $column_order = array(null, 'waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs'); //set column field database for datatable orderable
    var $column_search = array('waktu_pelaporan', 'no_tiket', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs'); //set column field database for datatable searchable
    var $order = array('waktu_pelaporan' => 'desc'); // default order

    private function _get_datatables_query($filters) {
        $this->db->from($this->table);

        // Required filters
        if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
            $this->db->where('waktu_pelaporan >=', $filters['tanggal_awal']);
            $this->db->where('waktu_pelaporan <=', $filters['tanggal_akhir']);
        }

        // Optional filters
        if (!empty($filters['nama_klien'])) {
            $this->db->like('nama', $filters['nama']);
        }

        if (!empty($filters['tags'])) {
            $this->db->like('tags', $filters['tags']);
        }

        if (!empty($filters['status_ccs'])) {
            $this->db->where('status_ccs', $filters['status_ccs']);
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                if($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($filters) {
        $this->_get_datatables_query($filters);
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($filters) {
        $this->_get_datatables_query($filters);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // FETCH CLIENT
    public function get_clients() {
        $query = $this->db->get('klien'); // Replace 'clients' with your actual table name for clients
        return $query->result_array();
    }
}