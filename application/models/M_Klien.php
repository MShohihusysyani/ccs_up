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
            pelaporan.impact
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', ['HANDLE', 'HANDLE 2']);
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
            pelaporan.impact
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
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
            pelaporan.impact
        ');
        $this->db->from('pelaporan');
        $this->db->where('user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISH');
        $this->db->order_by('waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }
}
