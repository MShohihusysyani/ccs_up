<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Serverside_model extends CI_Model
{
    private $table = 'pelaporan';
    private $column_order = array(null, 'waktu_pelaporan', 'no_tiket', 'user_id', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'rating');
    private $column_search = array('waktu_pelaporan', 'no_tiket', 'user_id', 'nama', 'perihal', 'tags', 'kategori', 'impact', 'priority', 'maxday', 'status_ccs', 'rating');
    private $order = array('waktu_pelaporan' => 'desc');

    private function _get_datatables_query($filters)
    {
        $this->db->select('pelaporan.*, klien.id_user_klien, klien.nama_klien');
        $this->db->from($this->table);
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        $filter_jenis_tgl = 'pelaporan.waktu_pelaporan';

        if (!empty($filters['filter_jenis_tgl'])) {
            $filter_jenis_tgl = 'pelaporan.' . $filters['filter_jenis_tgl'];
        }

        if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
            $tanggal_akhir_plus = date('Y-m-d', strtotime($filters['tanggal_akhir'] . ' +1 day'));
            $this->db->where($filter_jenis_tgl . ' >=', $filters['tanggal_awal'] . ' 00:00:00');
            $this->db->where($filter_jenis_tgl . ' <', $tanggal_akhir_plus . ' 00:00:00');
        }

        // Filter tanggal (pakai < tanggal_akhir +1 biar full 1 hari terakhir ikut)
        // if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
        //     $tanggal_akhir_plus = date('Y-m-d', strtotime($filters['tanggal_akhir'] . ' +1 day'));
        //     $this->db->where('pelaporan.waktu_pelaporan >=', $filters['tanggal_awal'] . ' 00:00:00');
        //     $this->db->where('pelaporan.waktu_pelaporan <', $tanggal_akhir_plus . ' 00:00:00');
        // }

        if (!empty($filters['nama_klien'])) {
            $this->db->where('klien.id_user_klien', $filters['nama_klien']);
        }

        if (!empty($filters['nama_user'])) {
            $this->db->group_start();
            $this->db->like('pelaporan.handle_by', $filters['nama_user']);
            $this->db->or_like('pelaporan.handle_by2', $filters['nama_user']);
            $this->db->or_like('pelaporan.handle_by3', $filters['nama_user']);
            $this->db->group_end();
        }

        if (!empty($filters['status_ccs'])) {
            $this->db->where('pelaporan.status_ccs', $filters['status_ccs']);
        }

        if (!empty($filters['rating'])) {
            $this->db->where('pelaporan.rating', $filters['rating']);
        }

        // Pencarian global datatable
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

        // Order
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
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
        $this->db->select('pelaporan.*, klien.id_user_klien, klien.nama_klien');
        $this->db->from($this->table);
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        $filter_tgl = 'pelaporan.waktu_pelaporan';

        if (!empty($filters['filter_jenis_tgl'])) {
            $filter_tgl = 'pelaporan.' . $filters['filter_jenis_tgl'];
        }

        if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
            $tanggal_akhir_plus = date('Y-m-d', strtotime($filters['tanggal_akhir'] . ' +1 day'));
            $this->db->where($filter_tgl . ' >=', $filters['tanggal_awal'] . ' 00:00:00');
            $this->db->where($filter_tgl . ' <', $tanggal_akhir_plus . ' 00:00:00');
        }

        // if (!empty($filters['tanggal_awal']) && !empty($filters['tanggal_akhir'])) {
        //     $tanggal_akhir_plus = date('Y-m-d', strtotime($filters['tanggal_akhir'] . ' +1 day'));
        //     $this->db->where('pelaporan.waktu_pelaporan >=', $filters['tanggal_awal'] . ' 00:00:00');
        //     $this->db->where('pelaporan.waktu_pelaporan <', $tanggal_akhir_plus . ' 00:00:00');
        // }

        if (!empty($filters['nama_klien'])) {
            $this->db->where('klien.id_user_klien', $filters['nama_klien']);
        }

        if (!empty($filters['nama_user'])) {
            $this->db->group_start();
            $this->db->like('pelaporan.handle_by', $filters['nama_user']);
            $this->db->or_like('pelaporan.handle_by2', $filters['nama_user']);
            $this->db->or_like('pelaporan.handle_by3', $filters['nama_user']);
            $this->db->group_end();
        }

        if (!empty($filters['status_ccs'])) {
            $this->db->where('pelaporan.status_ccs', $filters['status_ccs']);
        }

        if (!empty($filters['rating'])) {
            $this->db->where('pelaporan.rating', $filters['rating']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function fetch_data($requestData)
    {
        $this->db->select('pelaporan.*, klien.id_user_klien, klien.nama_klien');
        $this->db->from($this->table);
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        $filter_tgl = 'pelaporan.waktu_pelaporan';

        if (!empty($requestData['filter_jenis_tgl'])) {
            $filter_tgl = 'pelaporan.' . $requestData['filter_jenis_tgl'];
        }

        if (!empty($requestData['tanggal_awal']) && !empty($requestData['tanggal_akhir'])) {
            $tanggal_akhir_plus = date('Y-m-d', strtotime($requestData['tanggal_akhir'] . ' +1 day'));
            $this->db->where($filter_tgl . ' >=', $requestData['tanggal_awal'] . ' 00:00:00');
            $this->db->where($filter_tgl . ' <', $tanggal_akhir_plus . ' 00:00:00');
        }

        // if (!empty($requestData['tanggal_awal']) && !empty($requestData['tanggal_akhir'])) {
        //     $tanggal_akhir_plus = date('Y-m-d', strtotime($requestData['tanggal_akhir'] . ' +1 day'));
        //     $this->db->where('pelaporan.waktu_pelaporan >=', $requestData['tanggal_awal'] . ' 00:00:00');
        //     $this->db->where('pelaporan.waktu_pelaporan <', $tanggal_akhir_plus . ' 00:00:00');
        // }

        if (!empty($requestData['nama_klien'])) {
            $this->db->where('klien.id_user_klien', $requestData['nama_klien']);
        }

        if (!empty($requestData['nama_user'])) {
            $this->db->group_start();
            $this->db->like('pelaporan.handle_by', $requestData['nama_user']);
            $this->db->or_like('pelaporan.handle_by2', $requestData['nama_user']);
            $this->db->or_like('pelaporan.handle_by3', $requestData['nama_user']);
            $this->db->group_end();
        }

        if (!empty($requestData['status_ccs'])) {
            $this->db->where('pelaporan.status_ccs', $requestData['status_ccs']);
        }

        if (!empty($requestData['rating'])) {
            $this->db->where('pelaporan.rating', $requestData['rating']);
        }

        $query = $this->db->get();
        return $query->result();
    }
}
