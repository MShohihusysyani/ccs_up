<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model
{

    public function getPelaporan($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null, $status_ccs = null, $rating = null)
    {
        // $this->db->select('*');
        $this->db->select('no_tiket, waktu_pelaporan, waktu_approve, kategori, status_ccs, priority, maxday, judul, perihal, nama, handle_by, handle_by2, handle_by3, rating');
        $this->db->from('pelaporan');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if ($status_ccs) {
            $this->db->where('status_ccs', $status_ccs);
        }
        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        return $this->db->get()->result_array();
    }

    public function getPelaporanHandled($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null, $status_ccs = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if ($status_ccs) {
            $this->db->where_in('status_ccs', ['HANDLED', 'HANDLED 2']);
        }

        return $this->db->get()->result_array();
    }

    public function getPelaporanHandled2($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null, $status_ccs = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if ($status_ccs) {
            $this->db->where('status_ccs', 'HANDLED 2');
        }

        return $this->db->get()->result_array();
    }

    public function getPelaporanFinished($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null, $status_ccs = null, $rating = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if ($status_ccs) {
            $this->db->where_in('status_ccs', 'FINISHED');
        }

        if ($rating) {
            $this->db->where('rating', $rating);
        }

        return $this->db->get()->result_array();
    }

    public function getAllPelaporan($nama_klien = null, $nama_user = null, $status_ccs = null, $rating = null)
    {
        // $this->db->select('*');
        $this->db->select('no_tiket, waktu_pelaporan, waktu_approve, kategori, status_ccs, priority, maxday, judul, perihal, nama, handle_by, handle_by2, handle_by3, rating');
        $this->db->from('pelaporan');

        if ($status_ccs) {
            $this->db->where('status_ccs', $status_ccs);
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }
        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllHandled($nama_klien = null, $nama_user = null, $status_ccs = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if ($status_ccs) {
            $this->db->where_in('status_ccs', ['HANDLED', 'HANDLED 2']);
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllHandled2($nama_klien = null, $nama_user = null, $status_ccs = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if ($status_ccs) {
            $this->db->where('status_ccs', 'HANDLED 2');
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllFinished($nama_klien = null, $nama_user = null, $status_ccs = null, $rating = null)
    {
        // $this->db->select('*');
        $this->db->select('no_tiket, waktu_pelaporan, waktu_approve, kategori, status_ccs, priority, maxday, judul, perihal, nama, handle_by, handle_by2, handle_by3, rating');
        $this->db->from('pelaporan');

        if ($status_ccs) {
            $this->db->where('status_ccs', 'FINISHED');
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result_array();
    }



    // REKAP PELAPORAN PER HELPDESK
    // public function getPelaporanHD($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $tags = null)
    // {
    //     $user_id = $this->session->userdata('id_user');

    //     $this->db->select('pelaporan.*'); // Select fields from both tables
    //     $this->db->from('forward'); // Specify the base table
    //     $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
    //     $this->db->where('forward.user_id', $user_id);
    //     // $this->db->where('pelaporan.status_ccs', 'FINISH');
    //     $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

    //     if ($tanggal_awal && $tanggal_akhir) {
    //         $this->db->where('waktu_pelaporan >=', $tanggal_awal);
    //         $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
    //     }
    //     if ($status_ccs) {
    //         $this->db->where('status_ccs', $status_ccs);
    //     }
    //     if ($nama_klien) {
    //         $this->db->where('nama', $nama_klien);
    //     }
    //     if ($tags) {
    //         $this->db->where('tags', $tags);
    //     }

    //     return $this->db->get()->result_array();
    // }

    // EXPORT PDF HELPDESK
    public function getPelaporanHD($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $tags = null)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('pelaporan.waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('pelaporan.waktu_pelaporan <=', $tanggal_akhir);
        }
        if (!empty($status_ccs)) {
            $this->db->where('pelaporan.status_ccs', $status_ccs);
        }
        if (!empty($nama_klien)) {
            $this->db->where('pelaporan.nama', $nama_klien);
        }
        if (!empty($tags)) {
            $this->db->where('pelaporan.tags', $tags);
        }

        $query = $this->db->get();
        log_message('debug', 'Query: ' . $this->db->last_query()); // Log the query for debugging
        return $query->result_array();
    }


    public function getAllPelaporanHD($status_ccs = null, $nama_klien = null, $tags = null)
    {

        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        // $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

        if ($status_ccs) {
            $this->db->where('status_ccs', $status_ccs);
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if ($tags) {
            $this->db->like('tags', $tags);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // EXPORT PDF IMPLEMENTATOR

    public function getPelaporanTeknisi($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $tags = null)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        if ($tanggal_awal && $tanggal_akhir) {
            $this->db->where('pelaporan.waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('pelaporan.waktu_pelaporan <=', $tanggal_akhir);
        }
        if (!empty($status_ccs)) {
            $this->db->where('pelaporan.status_ccs', $status_ccs);
        }
        if (!empty($nama_klien)) {
            $this->db->where('pelaporan.nama', $nama_klien);
        }
        if (!empty($tags)) {
            $this->db->where('pelaporan.tags', $tags);
        }

        $query = $this->db->get();
        log_message('debug', 'Query: ' . $this->db->last_query()); // Log the query for debugging
        return $query->result_array();
    }
    public function getAllPelaporanTeknisi($status_ccs = null, $nama_klien = null, $rating = null)
    {

        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('t1_forward'); // Specify the base table
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

        if ($status_ccs) {
            $this->db->where('status_ccs', $status_ccs);
        }
        if ($nama_klien) {
            $this->db->like('nama', $nama_klien);
        }
        if ($rating) {
            $this->db->like('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result_array();
    }


    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        return $this->db->get();
    }

    public function getCategory()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' GROUP BY kategori";
        return $this->db->query($query)->result_array();
    }
}
