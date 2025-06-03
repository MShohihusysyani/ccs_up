<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sla_model extends CI_Model
{

    private $table = 'pelaporan';
    private $column_order = array(null, 'user_id', 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
    private $column_search = array('user_id', 'no_tiket', 'waktu_pelaporan', 'nama', 'perihal', 'impact', 'file', 'kategori', 'tags', 'priority', 'maxday', 'status_ccs', 'handle_by', 'handle_by2', 'handle_by3', 'rating');
    private $order = array('waktu_pelaporan' => 'DESC'); // Default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($bulan, $tahun, $nama_klien, $id_user = null)
    {
        $this->db->from($this->table);
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Jika ada filter user_id (dari client), maka gunakan filter itu.
        if (!empty($id_user)) {
            $this->db->where('user_id', $id_user);
        }

        // Jika tidak ada filter dari parameter, cek session user_id.
        else if ($this->session->userdata('role') == '1') {
            $user_id = $this->session->userdata('id_user');
            $this->db->where('user_id', $user_id);
        }

        if (!empty($bulan) && !empty($tahun)) {
            $this->db->where('MONTH(waktu_pelaporan)', $bulan);
            $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        }

        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
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

    function get_datatables($bulan, $tahun, $nama_klien, $id_user = null)
    {
        $this->_get_datatables_query($bulan, $tahun, $nama_klien, $id_user);

        // Pengecekan untuk 'length' dan 'start'
        $length = isset($_POST['length']) ? $_POST['length'] : -1; // Nilai default -1 jika tidak ada
        $start = isset($_POST['start']) ? $_POST['start'] : 0; // Nilai default 0 jika tidak ada

        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($bulan, $tahun, $nama_klien, $id_user = null)
    {
        $this->_get_datatables_query($bulan, $tahun, $nama_klien, $id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($bulan, $tahun, $nama_klien, $id_user = null)
    {
        $this->db->from($this->table);

        if (!empty($bulan) && !empty($tahun)) {
            $this->db->where('MONTH(waktu_pelaporan)', $bulan);
            $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        }

        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        if (!empty($id_user)) {
            $this->db->where('user_id', $id_user);
        } else if ($this->session->userdata('role') == '1') {
            $user_id = $this->session->userdata('id_user');
            $this->db->where('user_id', $user_id);
        }
        return $this->db->count_all_results();
    }


    // export
    public function get_sla($bulan, $tahun, $nama_klien)
    {
        $this->db->where('MONTH(waktu_pelaporan)', $bulan);
        $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        $this->db->like('nama', $nama_klien);
        $this->db->order_by('waktu_pelaporan', 'ASC'); // Atur urutan sesuai kebutuhan
        return $this->db->get('pelaporan')->result_array();
    }

    public function get_sla_klien($bulan, $tahun, $id_user)
    {

        $this->db->where('MONTH(waktu_pelaporan)', $bulan);
        $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        $this->db->where('user_id', $id_user);
        $this->db->order_by('waktu_pelaporan', 'ASC'); // Atur urutan sesuai kebutuhan
        return $this->db->get('pelaporan')->result_array();
    }
}
