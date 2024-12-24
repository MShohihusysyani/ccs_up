<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Klien extends CI_Model
{

    /**
     * Get All Data Siswa
     */
    public function getNoKlienByUserId($id)
    {
        $this->db->select('no_klien');
        $this->db->from('klien'); // Nama tabel klien
        $this->db->where('id_user_klien', $id); // Sesuaikan dengan kolom yang ada
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->no_klien; // Mengembalikan no_klien untuk user_id
        } else {
            return null; // Jika tidak ada no_klien
        }
    }
    public function get_all()
    {
        $this->db->select("*");
        $this->db->from("klien");
        $this->db->order_by("id", "DESC");
        return $this->db->get();
    }

    public function getDataAdded()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.nama,
            pelaporan.status,
            pelaporan.waktu_pelaporan,
            pelaporan.perihal,
            pelaporan.user_id,
            pelaporan.status_ccs,
            pelaporan.file,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.kategori,
            pelaporan.tags,
            pelaporan.no_tiket,
            pelaporan.rating,
            pelaporan.judul,
            pelaporan.status
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', ['ADDED', 'ADDED 2']);
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getDataHandled()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.nama,
            pelaporan.status,
            pelaporan.waktu_pelaporan,
            pelaporan.perihal,
            pelaporan.user_id,
            pelaporan.status_ccs,
            pelaporan.file,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.kategori,
            pelaporan.tags,
            pelaporan.no_tiket,
            pelaporan.rating,
            pelaporan.judul,
            pelaporan.status,
            pelaporan.handle_by,
            pelaporan.handle_by2,
            pelaporan.handle_by3,
            pelaporan.impact,
            t1_forward1.subtask as subtask1,
            t1_forward1.status as status1,
            t1_forward2.subtask as subtask2,
            t1_forward2.status as status2,
            t1_forward3.subtask as subtask3,
            t1_forward3.status as status3,
            t1_forward1.tanggal,
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('pelaporan.user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', ['HANDLED', 'HANDLED 2']);
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getDataClosed()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.nama,
            pelaporan.status,
            pelaporan.waktu_pelaporan,
            pelaporan.perihal,
            pelaporan.user_id,
            pelaporan.status_ccs,
            pelaporan.file,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.kategori,
            pelaporan.tags,
            pelaporan.no_tiket,
            pelaporan.rating,
            pelaporan.judul,
            pelaporan.status,
            pelaporan.handle_by,
            pelaporan.handle_by2,
            pelaporan.handle_by3,
            pelaporan.impact,
            t1_forward1.subtask as subtask1,
            t1_forward1.status as status1,
            t1_forward2.subtask as subtask2,
            t1_forward2.status as status2,
            t1_forward3.subtask as subtask3,
            t1_forward3.status as status3,
            t1_forward1.tanggal,
        ');
        $this->db->from('pelaporan');
        $this->db->join('t1_forward as t1_forward1', 't1_forward1.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->join('t1_forward as t1_forward2', 't1_forward2.pelaporan_id = pelaporan.id_pelaporan AND t1_forward2.id_forward != t1_forward1.id_forward', 'left');
        $this->db->join('t1_forward as t1_forward3', 't1_forward3.pelaporan_id = pelaporan.id_pelaporan AND t1_forward3.id_forward != t1_forward1.id_forward AND t1_forward3.id_forward != t1_forward2.id_forward', 'left');
        $this->db->where('pelaporan.user_id', $user_id);
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->where('pelaporan.status_ccs', 'CLOSED');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getKlienPelaporanFinish()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Build the query using Query Builder
        $this->db->select('
            pelaporan.id_pelaporan,
            pelaporan.nama,
            pelaporan.status,
            pelaporan.waktu_pelaporan,
            pelaporan.perihal,
            pelaporan.user_id,
            pelaporan.status_ccs,
            pelaporan.file,
            pelaporan.priority,
            pelaporan.maxday,
            pelaporan.kategori,
            pelaporan.tags,
            pelaporan.no_tiket,
            pelaporan.rating,
            pelaporan.judul,
            pelaporan.status,
            pelaporan.handle_by,
            pelaporan.handle_by2,
            pelaporan.handle_by3,
            pelaporan.impact,
            pelaporan.rating,
            pelaporan.has_rated
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function update_rating($id, $rating)
    {
        $data = [
            'rating' => $rating,
            'has_rated' => TRUE
        ];

        $this->db->where('id_pelaporan', $id);
        $result = $this->db->update('pelaporan', $data);

        if ($result === FALSE) {
            log_message('error', 'Failed to update rating: ' . $this->db->last_query());
        } else {
            log_message('debug', 'Rating updated successfully: ' . $this->db->last_query());
        }

        return $result;
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
        $this->db->from('pelaporan');
        $this->db->where('pelaporan.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->where('pelaporan.rating', 0);

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
        $this->db->where('pelaporan.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->where('pelaporan.rating', 0);


        // Menghitung jumlah notifikasi
        return $this->db->count_all_results();
    }
}
