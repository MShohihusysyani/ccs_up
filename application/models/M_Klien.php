<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Klien extends CI_Model
{

    /**
     * Get All Data Siswa
     */
    public function get_all()
    {
        $this->db->select("*");
        $this->db->from("klien");
        $this->db->order_by("id", "DESC");
        return $this->db->get();
    }

    public function getKlienPelaporanAdd()
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

    public function getKlienPelaporanOP()
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
        $this->db->where_in('pelaporan.status_ccs', ['HANDLE', 'HANDLE 2']);
        $this->db->group_by('pelaporan.id_pelaporan');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getKlienPelaporanClose()
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
        $this->db->where('pelaporan.status_ccs', 'CLOSE');
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
        $this->db->where('pelaporan.status_ccs', 'FINISH');
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



    // public function update_rating($id, $rating)
    // {
    //     // Log data received
    //     log_message('info', 'Update Rating - ID: ' . $id . ', Rating: ' . $rating);

    //     $this->db->where('id_pelaporan', $id);
    //     $this->db->update('pelaporan', ['rating' => $rating]);

    //     // Log query executed
    //     log_message('info', 'Executed Query: ' . $this->db->last_query());
    //     // Check affected rows
    //     if ($this->db->affected_rows() > 0) {
    //         log_message('info', 'Rating updated successfully.');
    //     } else {
    //         log_message('error', 'Failed to update rating.');
    //     }
    // }
}
